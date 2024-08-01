<?php

namespace backend\controllers;

use Yii;
use common\models\Settings;
use common\models\Page;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Settings controller
 */
class SettingsController extends Controller
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
                        'actions' => ['general', 'front-page', 'footer', 'header', 'code-scripts', 'custom-css', 'custom-js'],
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



    public function actionGeneral()
    {
        $model = new Settings();

        if(Yii::$app->request->isPost) {

            $post_data = Yii::$app->request->post();

            if(!is_null($post_data['meta_title'])) {

                $option = $model->findOption('meta_title');
                $option->updateAttributes(['option_value' => $post_data['meta_title']]);
            }

            if(!is_null($post_data['meta_desc'])) {

                $option = $model->findOption('meta_desc');
                $option->updateAttributes(['option_value' => $post_data['meta_desc']]);
            }


            if(!is_null($post_data['logo'])) {

                $option = $model->findOption('logo');

                if(empty($post_data['logo'])) {
                    $option->option_value = null;
                } else {
                    $option->option_value = $post_data['logo'];
                }
                $option->save();
            }

            if(!is_null($post_data['logo_b'])) {

                $option = $model->findOption('logo_b');

                if(empty($post_data['logo_b'])) {
                    $option->option_value = null;
                } else {
                    $option->option_value = $post_data['logo_b'];
                }
                $option->save();
            }


            if(!is_null($post_data['favicon'])) {

                $option = $model->findOption('favicon');

                if(empty($post_data['favicon'])) {
                    $option->option_value = null;
                } else {
                    $option->option_value = $post_data['favicon'];
                }
                $option->save();
            }


            Yii::$app->session->setFlash('success', 'Setarile au fost salvate');
            return $this->redirect(['settings/general']);
        }

        return $this->render('general', ['model' => $model]);
    }



    public function actionFrontPage()
    {
        $model = new Settings();

        if(Yii::$app->request->isPost) {

            $post_data = Yii::$app->request->post();

            if(!is_null($post_data['homepage_id'])) {

                $option = $model->findOption('homepage_id');
                $option->updateAttributes(['option_value' => $post_data['homepage_id']]);
            }

            Yii::$app->session->setFlash('success', 'Setarile au fost salvate');
            return $this->redirect(['settings/front-page']);
        }

        $pages = ArrayHelper::map(Page::find()->where(['type' => 'page', 'status' => 'public'])->asArray()->all(), 'id', 'title');

        return $this->render('front-page', ['model' => $model, 'pages' => $pages]);
    }




    public function actionFooter()
    {
        $layout_key  = 'layoutf11';

        // save
        if(Yii::$app->request->isPost) {


            $footer_settings                              = Settings::findOption('footer');

            $footer_settings_value_arr_all_langs          = json_decode($footer_settings->option_value, true);

            $footer_settings_value_arr_all_langs['ro-RO'] = Yii::$app->session->get($layout_key);

            $footer_settings->option_value                = json_encode($footer_settings_value_arr_all_langs, JSON_FORCE_OBJECT);


            if($footer_settings->save()) {

                Yii::$app->session->setFlash('success', 'Footer saved!');
                return $this->redirect(['settings/footer']);

            } else {

                Yii::$app->session->setFlash('error', 'Footer not saved.');
                return $this->redirect(['settings/footer']);
            }
        }
        //


        // view
        $footer_data_all_langs = Settings::findOptionValueAsArray('footer');
        $footer_data           = $footer_data_all_langs['ro-RO'];

        if(in_array($footer_data, [null, 'null', ''])) {

            Yii::$app->session->set($layout_key, []);

        } else {

            Yii::$app->session->set($layout_key, $footer_data);
        }

        $footer       = new \stdClass();
        $footer->id   = 11;
        $footer->data = json_encode(Yii::$app->session->get($layout_key));

        return $this->render('footer', ['footer' => $footer]);
        //
    }




    public function actionHeader()
    {
        $layout_key  = 'layouth12';

        // save
        if(Yii::$app->request->isPost) {


            $header_settings                              = Settings::findOption('header');

            $header_settings_value_arr_all_langs          = json_decode($header_settings->option_value, true);

            $header_settings_value_arr_all_langs['ro-RO'] = Yii::$app->session->get($layout_key);

            $header_settings->option_value                = json_encode($header_settings_value_arr_all_langs, JSON_FORCE_OBJECT);


            if($header_settings->save()) {

                Yii::$app->session->setFlash('success', 'Header saved!');
                return $this->redirect(['settings/header']);

            } else {

                Yii::$app->session->setFlash('error', 'Header not saved.');
                return $this->redirect(['settings/header']);
            }
        }
        //


        // view
        $header_data_all_langs = Settings::findOptionValueAsArray('header');
        $header_data           = $header_data_all_langs['ro-RO'];

        if(in_array($header_data, [null, 'null', ''])) {

            Yii::$app->session->set($layout_key, []);

        } else {

            Yii::$app->session->set($layout_key, $header_data);
        }

        $header       = new \stdClass();
        $header->id   = 12;
        $header->data = json_encode(Yii::$app->session->get($layout_key));

        return $this->render('header', ['header' => $header]);
        //
    }



    public function actionCodeScripts()
    {

        if(Yii::$app->request->isPost) {


            $head_script_code                 = Yii::$app->request->post('head_script');
            $head_script_option               = Settings::findOption('head_script');
            $head_script_option->option_value = ($head_script_code);
            $head_script_option_save          = $head_script_option->save();

            $body_script_code                 = Yii::$app->request->post('body_script');
            $body_script_option               = Settings::findOption('body_script');
            $body_script_option->option_value = ($body_script_code);
            $body_script_option_save          = $body_script_option->save();

            if($head_script_option_save && $body_script_option_save) {

                Yii::$app->session->setFlash('success', 'Scripts saved!');
                return $this->redirect(['settings/code-scripts']);

            } else {

                Yii::$app->session->setFlash('error', 'Scripts not saved.');
                return $this->redirect(['settings/code-scripts']);
            }
        }

        $head_script = Settings::findOptionValue('head_script');
        $body_script = Settings::findOptionValue('body_script');

        return $this->render('code-scripts', ['head_script' => $head_script, 'body_script' => $body_script]);
    }



    public function actionCustomCss()
    {
        if(Yii::$app->request->isPost) {

            $code                 = Yii::$app->request->post('custom_css');
            $option               = Settings::findOption('custom_css');
            $option->option_value = ($code);

            if($option->save()) {

                Yii::$app->session->setFlash('success', 'CSS saved!');
                return $this->redirect(['settings/custom-css']);

            } else {

                Yii::$app->session->setFlash('error', 'CSS not saved.');
                return $this->redirect(['settings/custom-css']);
            }
        }

        $custom_css = Settings::findOptionValue('custom_css');

        return $this->render('custom-css', ['custom_css' => $custom_css]);
    }

    public function actionCustomJs()
    {
        if(Yii::$app->request->isPost) {

            $code                 = Yii::$app->request->post('custom_js');
            $option               = Settings::findOption('custom_js');
            $option->option_value = ($code);

            if($option->save()) {

                Yii::$app->session->setFlash('success', 'JS saved!');
                return $this->redirect(['settings/custom-js']);

            } else {

                Yii::$app->session->setFlash('error', 'JS not saved.');
                return $this->redirect(['settings/custom-js']);
            }
        }

        $custom_js = Settings::findOptionValue('custom_js');

        return $this->render('custom-js', ['custom_js' => $custom_js]);
    }
}