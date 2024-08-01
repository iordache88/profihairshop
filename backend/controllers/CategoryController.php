<?php

namespace backend\controllers;

use common\models\Category;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
                            'actions' => ['index', 'add', 'edit', 'delete', 'update-attribute'],
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
                        'delete' => ['POST'],
                        'update-attribute' => ['POST'],
                    ],
                ],
            ]
        );
    }


    /**
     * @param string $target eg. for 'page', or 'product',
     * @return string
     */
    public function actionIndex($target)
    {
        $model = new Category();

        $query = $model->find()->andWhere(['<>', 'status', 0])->andWhere(['parent_id' => 0, 'target' => $target]);

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
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $model,
        ]);
    }



    public function actionAdd($target = null)
    {
        $model = new Category();
        $model->target = $target;

        if ($this->request->isPost) {

            $model->load($this->request->post());
            $model->description = htmlentities($model->description);

            if($model->save()) {
                return $this->redirect(['edit', 'id' => $model->id]);
            } else {
                $model->loadDefaultValues();
            }
        }
        $categories = $model->find()->andWhere(['<>', 'status', 0])->andWhere(['target' => $model->target])->orderBy('title asc')->asArray()->all();

        return $this->render('add', [
            'model' => $model,
            'categories' => $categories,
        ]);
    }





    public function actionEdit($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost ) {

            $model->load($this->request->post());
            $model->description = htmlentities($model->description);

            if($model->save()) {

                return $this->redirect(['edit', 'id' => $model->id]);
            }
        }
        $categories = $model->find()->andWhere(['<>', 'status', 0])->andWhere(['<>', 'id', $model->id])->andWhere(['target' => $model->target])->orderBy('title asc')->asArray()->all();

        return $this->render('edit', [
            'model' => $model,
            'categories' => $categories,
        ]);
    }







    /**
     * If successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $model->status = 0;
        $model->save();

        return $this->redirect(['index', 'target' => $model->target]);
    }






    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
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

}
