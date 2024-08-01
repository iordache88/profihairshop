<?php

namespace backend\controllers;

use Yii;
use common\models\Log;
use common\models\Menu;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
/**
 * Menu controller
 */
class MenuController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index', 'add-new-menu', 'add-menu-item', 'update-attribute', 'delete-group', 'delete-item', 'remove-media', 'change-sort'],
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
                    'add-new-menu' => ['POST'],
                    'add-menu-item' => ['POST'],
                    'update-attribute' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }


    public function actionIndex()
    {
        $model = new Menu();
        $dataProvider = $model->search(Yii::$app->request->queryParams);

        return $this->render('index', ['searchModel' => $model, 'dataProvider' => $dataProvider]);
    }


    public function actionAddNewMenu()
    {
        $menu = new Menu();
        $menu->title = Yii::$app->request->post('title');

        if($menu->save()) {

            Yii::$app->session->setFlash('success', "Menu \"{$menu->title}\" added!");
            return $this->redirect(['menu/index', 'parent_id' => $menu->id]);
        } else {

            Yii::$app->session->setFlash('error', "Menu could not be added. " . json_encode($menu->errors));
            return $this->redirect(['menu/index']);
        }
    }



    public function actionAddMenuItem()
    {
        $parent_id = Yii::$app->request->post('Menu')['parent_id'] ?? null;


        if(empty($parent_id)) {

            $response = [
                'status' => 'error',
                'message' => 'Menu group was not identified. Please select menu first.',
            ];
            return $this->asJson($response);
        }


        $menu_item            = new Menu();
        $menu_item->parent_id = $parent_id;
        $menu_item->title     = 'Title ' . time();
        $menu_item->status    = 9;

        if($menu_item->save()) {

            $response = [
                'status' => 'success',
                'message' => 'Menu item created!',
            ];
            return $this->asJson($response);

        } else {
            $response = [
                'status' => 'error',
                'message' => 'Menu item was not created. ' . json_encode($menu_item->errors),
            ];
            return $this->asJson($response);
        }
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
        if (($model = Menu::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested menu item does not exist.');
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
                'message' => 'Menu item not found.' ,
            ];
            return $this->asJson($response);
        }
    }

    public function actionDeleteGroup()
    {
        $menu_item_parent = Menu::findOne(Yii::$app->request->post('id'));
        
        if(is_object($menu_item_parent)) {

            $menu_item_parent->status = 0;
            if($menu_item_parent->save()) {

                $menu_items = $menu_item_parent->childs;

                foreach($menu_items as $menu_item) {

                    $menu_item->status = 0;
                    $menu_item->save();
                }


                $parent_id_sql  = "SELECT * FROM menu WHERE parent_id = 0 AND status != 0 ORDER BY parent_id ASC";
                $menu           = Menu::findBySql($parent_id_sql)->one();

                if(!empty($menu->id)) {

                    $url           = Url::to(['menu/index', 'Menu' => ['parent_id' => $menu->id]]);
                } else {
                    $url           = Url::to(['menu/index']);
                }
                
                $response = [
                    'status' => 'success',
                    'message' => 'Menu deleted.' ,
                    'url' => $url,
                ];
                return $this->asJson($response);



            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Menu not deleted. ' . json_encode($menu_item_parent->errors),
                ];
                return $this->asJson($response);
            }

        } else {
            $response = [
                'status' => 'error',
                'message' => 'Menu not found.' ,
            ];
            return $this->asJson($response);
        }
    }


    public function actionDeleteItem()
    {
        $menu_item = Menu::findOne(Yii::$app->request->post('id'));
        
        if(is_object($menu_item)) {

            if($menu_item->delete()) {

                $response = [
                    'status' => 'success',
                    'message' => 'Menu item deleted.' ,
                ];
                return $this->asJson($response);


            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Menu not deleted. ' . json_encode($menu_item->errors),
                ];
                return $this->asJson($response);
            }

        } else {
            $response = [
                'status' => 'error',
                'message' => 'Menu not found.' ,
            ];
            return $this->asJson($response);
        }
    }


    public function actionRemoveMedia()
    {
        $menu_item = Menu::findOne(Yii::$app->request->post('id'));
        
        if(is_object($menu_item)) {

            $menu_item->media_id = null;

            if($menu_item->save()) {

                $response = [
                    'status' => 'success',
                    'message' => 'Menu item image removed.' ,
                ];
                return $this->asJson($response);


            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Menu not saved. ' . json_encode($menu_item->errors),
                ];
                return $this->asJson($response);
            }

        } else {
            $response = [
                'status' => 'error',
                'message' => 'Menu not found.' ,
            ];
            return $this->asJson($response);
        }
    }



    public function actionChangeSort()
    {
        $ids = Yii::$app->request->post('ids');

        $menu_items = Menu::find()->andWhere(['in', 'id', $ids])->all();
        $sorted = [];

        $ids_sort = array_flip($ids);

        foreach($menu_items as $menu_item) {

            $sort_value = $ids_sort[$menu_item->id];

            if($menu_item->updateAttributes(['sort' => $sort_value])) {

                $sorted[$sort_value] = $menu_item->id;
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
