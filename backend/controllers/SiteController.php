<?php

namespace backend\controllers;

use common\models\LoginForm;
use common\models\User;
use common\models\Log;
use common\models\Page;
use common\models\Product;
use common\models\Media;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
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
                        'actions' => ['logout', 'index', 'update-theme-settings'],
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
                    'logout' => ['post'],
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $logs = Log::find()->orderBy('created_at desc')->limit(20)->all();

        $users = User::find()->andWhere(['status' => 10])->all();

        $pages = Page::find()->all();
        $products = Product::find()->all();
        // $orders = Order::find()->all();
        $orders = array();
        $media_items = Media::find()->andWhere(['<>', 'parent_id', 0])->all();

        return $this->render('index', ['logs' => $logs, 'users' => $users, 'pages' => $pages, 'products' => $products, 'orders' => $orders, 'media_items' => $media_items ]);
    }


    public function actionUpdateThemeSettings()
    {
        $post_data = Yii::$app->request->post();
        unset($post_data['_csrf-backend']);

        
        $user_model           = User::findOne(Yii::$app->user->identity->id);
        $user_details         = $user_model->details;

        $admin_settings = json_decode($user_details->admin_settings, true);

        if(empty($admin_settings)) {

            $admin_settings = [];
        }

        $admin_settings['theme'] = [];
        foreach($post_data as $key => $value) {
            $admin_settings['theme'][$key] = $value;
        }

        $user_details->admin_settings = json_encode($admin_settings);

        if($user_details->save()) {

            $response = [
                'status' => 'success',
                'message' => 'Theme settings saved!',
            ];
            return $this->asJson($response);
        } else {
            $response  = [
                'status' => 'error',
                'message' => 'Settings not saved.',
            ];
            return $this->asJson($response);
        }


        
    }


    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
