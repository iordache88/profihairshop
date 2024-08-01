<?php

namespace backend\controllers;

use Yii;
use common\models\Log;
use common\models\PageType;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * PageType controller
 */
class PageTypeController extends Controller
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
                        'actions' => ['index', 'open-add-modal', 'open-edit-modal', 'add', 'edit', 'delete'],
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
                    'open-add-modal'  => ['POST'],
                    'open-edit-modal' => ['POST'],
                    'add'             => ['POST'],
                    'edit'            => ['POST'],
                    'delete'          => ['POST'],
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
        $model = new PageType();
        $dataProvider = $model->search(Yii::$app->request->queryParams);

        return $this->render('index', ['searchModel' => $model, 'dataProvider' => $dataProvider]);
    }



    public function actionOpenAddModal()
    {
        $model = new PageType();

        return $this->renderAjax('_add-modal-content', ['model' => $model]);
    }


    public function actionOpenEditModal($id)
    {
        $model = PageType::findOne($id);

        return $this->renderAjax('_edit-modal-content', ['model' => $model]);
    }


    public function actionAdd()
    {
        $model = new PageType();
        $model->load(Yii::$app->request->post());
        $model->type = strtolower($model->type);

        return $this->asJson($model->saveAndCreateFiles());

    }

    public function actionEdit($id)
    {
        $model = PageType::findOne($id);
        $model->load(Yii::$app->request->post());
        $model->save();

        return $this->redirect(['page-type/index']);

    }


    public function actionDelete($id)
    {
        $model = PageType::findOne($id);
        $model->status = 0;
        $model->save();

        return $this->redirect(['page-type/index']);

    }
}