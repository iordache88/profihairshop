<?php

namespace backend\controllers;

use Yii;
use common\models\GlobalSection;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * GlobalSection controller
 */
class GlobalSectionController extends Controller
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
        $model = new GlobalSection();
        $dataProvider = $model->search(Yii::$app->request->queryParams);

        return $this->render('index', ['searchModel' => $model, 'dataProvider' => $dataProvider]);
    }
    


    public function actionAdd()
    {
        $model = new GlobalSection();

        if ($this->request->isPost) {

            $model->load($this->request->post());
            $model->content = json_encode(Yii::$app->session->get('layout' . $this->request->post('layout')), JSON_FORCE_OBJECT);

            if($model->save()) {

                return $this->redirect(['edit', 'id' => $model->id]);
                
            } else {

                $model->loadDefaultValues();
            }
            
        } else {

            $idLayout = time();
            Yii::$app->session->set('layout'. $idLayout, []);
        }

        return $this->render('add', [
            'model' => $model,
            'idLayout' => $idLayout,
        ]);
    }




    public function actionEdit($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost ) {

            $model->load($this->request->post());
            $model->content = json_encode(Yii::$app->session->get('layoutgs'. $model->id), JSON_FORCE_OBJECT);

            if($model->save()) {

                return $this->redirect(['edit', 'id' => $model->id]);
            }
        } else {

            Yii::$app->session->set('layoutgs' . $model->id, json_decode($model->content, true));
        }


        return $this->render('edit', [
            'model' => $model,
        ]);
    }


    protected function findModel($id)
    {
        if (($model = GlobalSection::findOne(['id' => $id])) !== null) {
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
                'message' => 'Menu item not found.' ,
            ];
            return $this->asJson($response);
        }
    }



    public function actionDelete($id)
    {
        $model = GlobalSection::findOne($id);
        $model->status = 0;
        $model->save();

        return $this->redirect(['global-section/index']);

    }
}