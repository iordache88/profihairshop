<?php

namespace backend\controllers;

use common\models\Page;
use common\models\PageType;
use common\models\Category;
use common\models\PageCategory;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['login', 'error'],
                            'allow' => true,
                        ],
                        [
                            'actions' => ['index', 'add', 'edit', 'trash', 'duplicate', 'update-attribute', 'change-sort'],
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {

                                if (Yii::$app->user->identity->is_admin !== 1) {
                                    return $this->redirect('/');
                                }
                                return true;
                            }
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'trash' => ['POST'],
                        'update-attribute' => ['POST'],
                        'duplicate' => ['POST'],
                    ],
                ],
            ]
        );
    }


    /**
     * Lists all Page models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new Page();
        $query = $model->find()->andWhere(['type' => $this->id]);

        $model->load(Yii::$app->request->queryParams);

        $query->andFilterWhere(['=', 'id', $model->id]);
        $query->andFilterWhere(['like', 'title', $model->title]);
        $query->andFilterWhere(['like', 'meta_title', $model->meta_title]);
        $query->andFilterWhere(['like', 'meta_desc', $model->meta_desc]);
        $query->andFilterWhere(['=', 'status', $model->status]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'sort' => SORT_ASC,
                ]
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $model,
            'pageType' => $this->getPageType(),
        ]);
    }



    /**
     * Creates a new Page model.
     * If creation is successful, the browser will be redirected to the 'edit' page.
     * @return string|\yii\web\Response
     */
    public function actionAdd()
    {
        $model = new Page();
        $model->type = $this->id;

        if ($this->request->isPost) {

            $model->load($this->request->post());

            $model->content = json_encode(Yii::$app->session->get('layout0'), JSON_FORCE_OBJECT);

            if($model->save()) {

                $category_ids = $this->request->post('category_ids');
                if(!empty($category_ids)) {
                    foreach($category_ids as $category_id) {

                        $page_category              = new PageCategory();
                        $page_category->category_id = $category_id;
                        $page_category->page_id     = $model->id;
                        $page_category->save();
                    }
                }

                return $this->redirect(['edit', 'id' => $model->id]);
                
            } else {

                $model->loadDefaultValues();
            }
            
        } else {

            Yii::$app->session->set('layout0', []);
        }

        $categories = Category::find()->andWhere(['target' => $this->id, 'parent_id' => 0, 'status' => 10])->all();

        return $this->render('add', [
            'model' => $model,
            'categories' => $categories,
        ]);
    }



    /**
     * Updates an existing Page model.
     * If update is successful, the browser will be redirected to the 'edit' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionEdit($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost ) {

            $model->load($this->request->post());
            $model->content = json_encode(Yii::$app->session->get('layout'. $model->id), JSON_FORCE_OBJECT);

            if($model->save()) {

                $category_ids = $this->request->post('category_ids');

                if(!empty($category_ids)) {

                    foreach($category_ids as $category_id) {

                        $page_category_check = PageCategory::find()->andWhere(['page_id' => $model->id, 'category_id' => $category_id])->one();

                        if(!is_object($page_category_check)) {

                            $page_category              = new PageCategory();
                            $page_category->category_id = $category_id;
                            $page_category->page_id     = $model->id;
                            $page_category->save();
                        }
                    }

                    $page_category_relations_to_delete = PageCategory::find()->andWhere(['page_id' => $model->id])->andWhere(['not in', 'category_id', $category_ids])->all();

                    foreach($page_category_relations_to_delete as $page_category_relation_to_delete) {

                        $page_category_relation_to_delete->delete();
                    }

                } else {

                    $page_category_relations = PageCategory::find()->andWhere(['page_id' => $model->id])->all();
                    if(!empty($page_category_relations)) {
                        foreach($page_category_relations as $page_category) {
                            $page_category->delete();
                        }
                    }
                }


                return $this->redirect(['edit', 'id' => $model->id]);
            }
        } else {

            Yii::$app->session->set('layoutOld-'.$model->id, $model->content);
        }


        $categories = Category::find()->andWhere(['target' => $model->type, 'parent_id' => 0, 'status' => 10])->all();

        return $this->render('edit', [
            'model' => $model,
            'categories' => $categories,
        ]);
    }



    /**
     * Updates an existing Page model status to "trash".
     * If successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionTrash($id)
    {
        $model = $this->findModel($id);

        if($model->isFrontPage()) {

            Yii::$app->session->setFlash('error', 'Choose another front page first.');
            return $this->redirect(['index']);
        }

        if($model->status === 'trash') {
            $model->delete();
        } else {
            $model->status = 'trash';
            $model->save();
        }

        return $this->redirect(['index']);
    }




    /**
     * Duplicates an existing Page model.
     * If successful, the browser will be redirected to the 'edit' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDuplicate($id)
    {
        $model = $this->findModel($id);

        $new_model             = new Page();
        $new_model->attributes = $model->attributes;
        $new_model->slug       = null;
        $new_model->title      = $new_model->title . ' copy';


        if($new_model->save()) {

            return $this->redirect(['edit', 'id' => $new_model->id]);
        }

        return $this->redirect(['index']);
    }




    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Page::findOne(['id' => $id, 'type' => $this->id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }





    public function getPageType()
    {
        return PageType::findOne(['type' => $this->id]);
    }





    public function actionUpdateAttribute()
    {
        $post_data = Yii::$app->request->post();
        $id        = $post_data['id'];
        $attr      = $post_data['attr'];
        $value     = $post_data['value'];

        $model = $this->findModel($id);

        if(is_object($model)) {

            if($model->hasAttribute($attr)) {

                $model->$attr = $value;

                if($model->save()) {

                    $response = [
                        'status' => 'success',
                        'message' => 'Saved!',
                    ];
                    return $this->asJson($response);

                } else {

                    $response = [
                        'status' => 'erorr',
                        'message' => 'Can\'t save. Please try again.',
                    ];
                    return $this->asJson($response);
                }

            } else {

                $response = [
                    'status' => 'error',
                    'message' => 'Can\'t update. Attribute not found.',
                ];
                return $this->asJson($response);
            }

        } else {
            $response = [
                'status' => 'error',
                'message' => 'Page not found.' ,
            ];
            return $this->asJson($response);
        }
    }





    public function actionChangeSort()
    {
        $ids = Yii::$app->request->post('ids');

        $pages = Page::find()->andWhere(['in', 'id', $ids])->all();
        $sorted = [];

        $ids_sort = array_flip($ids);

        foreach($pages as $page) {

            $sort_value = $ids_sort[$page->id];

            if($page->updateAttributes(['sort' => $sort_value])) {

                $sorted[$sort_value] = $page->id;
            }
        }

        if(empty($sorted)) {

            $response = [
                'status' => 'error',
                'message' => 'Nothing sorted',
            ];
            return $this->asJson($response);

        } else {
            $response = [
                'status' => 'success',
                'message' => 'Sorted!',
                'sorted' => $sorted,
            ];
            return $this->asJson($response);
        }
    }

}
