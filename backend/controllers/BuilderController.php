<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Page;
use common\models\Layout;


class BuilderController extends Controller
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
                        'actions' => ['index', 'content', 'modal', 'addlayoutelement', 'row', 'column', 'module', 'getmodule', 'savemodule', 'actionmodule', 'sort', 'generatevideothumb', 'layout', 'uploadlayout', 'convert', 'modulecategory', 'modulefield', 'modulefield-valueoptions', 'checksession', 'exportlayout', 'savetolibrary'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if (Yii::$app->user->identity['role'] == 'guest') {
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
                    'addlayoutelement' => ['post'],
                    'convert' => ['post'],
                    'modulecategory' => ['post'],
                    'uploadlayout' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        return parent::beforeAction($action);
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function listModules($item = false, $type = false)
    {
        $modules = [
            'text' => [
                'title' => 'Text',
                'icon' => 'fa-paragraph',
            ],
            'image' => [
                'title' => 'Image',
                'icon' => 'fa-picture-o'
            ],
            'gallery' => [
                'title' => 'Gallery',
                'icon' => 'fa-picture-o'
            ],
            'video' => [
                'title' => 'Video',
                'icon' => 'fa-video-camera'
            ],
            'code' => [
                'title' => 'Code',
                'icon' => 'fa-code'
            ],
            'button' => [
                'title' => 'Button',
                'icon' => 'fa-hand-pointer-o'
            ],
            'widget' => [
                'title' => 'Widget',
                'icon' => 'fa-puzzle-piece'
            ],
            'number' => [
                'title' => 'Number',
                'icon' => 'fa-bar-chart'
            ],
            'slider' => [
                'title' => 'Slider',
                'icon' => 'fa-sliders'
            ],
            'category' => [
                'title' => 'Category',
                'icon' => 'fa-list-alt'
            ],
            'field' => [
                'title' => 'Field',
                'icon' => 'fa-check'
            ],
            'fickle' => [
                'title' => 'Fickle',
                'icon' => 'fa-birthday-cake'
            ],
            'folder' => [
                'title' => 'Folder',
                'icon' => 'fa-folder'
            ],
            'social' => [
                'title' => 'Social',
                'icon' => 'fa-link'
            ],
            'newsletter' => [
                'title' => 'Newsletter',
                'icon' => 'fa-envelope'
            ],
            'startwrap' => [
                'title' => 'Start Wrap',
                'icon' => ' fa-code'
            ],
            'endwrap' => [
                'title' => 'End Wrap',
                'icon' => ' fa-code'
            ],
        ];

        if ($type != null) {
            $modules['contactform'] = [
                'text' => [
                    'title' => 'Text',
                    'icon' => 'fa-paragraph',
                ],
                'cfinput' => [
                    'title' => 'Input',
                    'icon' => 'fa-i-cursor'
                ],
                'cftextarea' => [
                    'title' => 'Textarea',
                    'icon' => 'fa-commenting'
                ],
                'cfemail' => [
                    'title' => 'Email',
                    'icon' => 'fa-envelope'
                ],
                'cfcheck' => [
                    'title' => 'Checkbox',
                    'icon' => 'fa-check-square'
                ],
                'cfradio' => [
                    'title' => 'Radio',
                    'icon' => 'fa-check-circle-o'
                ],
                'cfselect' => [
                    'title' => 'Select',
                    'icon' => 'fa-caret-square-o-down'
                ],
                'cffile' => [
                    'title' => 'File',
                    'icon' => 'fa-file'
                ],
            ];

            if ($type == 'header') {

                $modules['header'] = $modules;
                unset($modules['header']['contactform']);
            } elseif ($type == 'globalsection') {

                $modules['globalsection'] = $modules;
                unset($modules['globalsection']['contactform']);
            } else {

                $modules['footer'] = $modules;
                unset($modules['footer']['contactform']);
            }


            $modules = $modules[$type];
        }

        if (!empty($item)) {
            return $modules[$item];
        }

        return $modules;
    }

    public function actionIndex($page = false, $type = false, $id = false)
    {
        return $this->renderPartial('index', ['page' => $page, 'type' => $type, 'id' => $id]);
    }

    public function actionContent($content)
    {
        return $this->renderPartial('_core/builder', ['content' => $content]);
    }


    // LOAD MODAL //
    public function actionModal()
    {
        $request = Yii::$app->request->bodyParams;
        // return json_encode($request);
        $view = $request['view'];
        $action = $request['action'];
        $page = $request['page'];
        $item = $request['item'];
        $type = $request['type'];
        $column = $request['column'];

        if (!empty($view)) {
            $route = '_core/' . $view;
            return $this->renderPartial(
                $route,
                [
                    'action' => $action,
                    'view' => $view,
                    'page' => $page,
                    'item' => $item,
                    'type' => $type,
                    'column' => $column,
                ]
            );
        }

        return 'Modal content not exist! Please set a "view".';
    }


    // ROW //
    public function actionRow()
    {
        $request = Yii::$app->request->bodyParams;
        $action = $request['action'];
        $page = $request['page'];
        $item = $request['item'];
        $type = $request['type'];

        if (!isset($request['background_type']) || $request['background_type'] == 'none') {
            $background_info = '';
        } else {
            $background_info = $request['background_info'];
        }

        // print_r($request);
        // exit;


        if ($action == 'add') {
            array_push(
                $_SESSION['layout' . $page],
                ['opt' => array(
                    'background_type' => $request['background_type'],
                    'background_info' => $background_info,
                    'id' => $request['id'],
                    'class' => $request['class'],
                    'container' => $request['container']
                )]
            );
        } elseif ($action == 'edit') {
            $_SESSION['layout' . $page][$item]['opt'] = array(
                'background_type' => $request['background_type'],
                'background_info' => $background_info,
                'id' => $request['id'],
                'class' => $request['class'],
                'container' => $request['container']
            );
        } elseif ($action == 'remove') {
            unset($_SESSION['layout' . $page][$item]);
        } elseif ($action == 'clone') {
            $toCopy = $_SESSION['layout' . $page][$item];
            $_SESSION['layout' . $page][] = $toCopy;
        }

        return $this->renderPartial('_core/builder', ['content' => json_encode($_SESSION['layout' . $page], false), 'pageID' => $page, 'type' => $type]);
    }

    // COLUMN //
    public function actionColumn()
    {
        $request = Yii::$app->request->bodyParams;
        $action = $request['action'];
        $page = $request['page'];
        $item = $request['item'];
        $column = $request['column'];
        $type = $request['type'];

        if (!isset($request['background_type']) || $request['background_type'] == 'none') {
            $background_info = '';
        } else {
            $background_info = $request['background_info'];
        }

        if ($action == 'add') {
            if ($request['size'] == NULL) {
                $size = 'col-lg-12';
            } else {
                $size = $request['size'];
            }

            array_push(
                $_SESSION['layout' . $page][$item],
                array(
                    'size' => $size,
                    'class' => $request['class'],
                    'content' => [],
                    'background_type' => $request['background_type'],
                    'background_info' => $background_info,
                    'color' => $request['color'],
                    'id' => $request['id']
                )
            );
        } elseif ($action == 'edit') {
            if ($request['size'] == NULL) {
                $size = 'col-lg-12';
            } else {
                $size = $request['size'];
            }

            $_SESSION['layout' . $page][$item][$column]['size'] = $size;
            $_SESSION['layout' . $page][$item][$column]['class'] = $request['class'];
            $_SESSION['layout' . $page][$item][$column]['background_type'] = $request['background_type'];
            $_SESSION['layout' . $page][$item][$column]['background_info'] = $request['background_info'];
            $_SESSION['layout' . $page][$item][$column]['color'] = $request['color'];
            $_SESSION['layout' . $page][$item][$column]['id'] = $request['id'];
        } elseif ($action == 'remove') {
            unset($_SESSION['layout' . $page][$item][$column]);
        } elseif ($action == 'clone') {
            $toCopy = $_SESSION['layout' . $page][$item][$column];
            $_SESSION['layout' . $page][$item][] = $toCopy;
        }

        return $this->renderPartial('_core/builder', ['content' => json_encode($_SESSION['layout' . $page], false), 'pageID' => $page, 'type' => $type]);
    }


    // MODULE //
    public function actionModule()
    {
        $request = Yii::$app->request->bodyParams;
        $action = $request['action'];
        $page = $request['page'];
        $item = $request['item'];
        $column = $request['column'];
        $module = $request['module'];
        $typeBuilder = $request['type'];
        $shortcode = '{{' . $module;

        $initModule = include(Yii::getAlias('@app') . '/views/builder/' . $module . '/init.php');
        foreach ($initModule as $init => $type) {
            $shortcode .= ' ' . $init . '=';
        }
        $shortcode .= '}}{{/' . $module . '}}';
        $shortcode = htmlentities($shortcode);

        array_push($_SESSION['layout' . $page][$item][$column]['content'], $shortcode);

        return $this->renderPartial('_core/builder', ['content' => json_encode($_SESSION['layout' . $page], false), 'pageID' => $page, 'type' => $typeBuilder]);
    }

    public function actionGetmodule()
    {
        $request = Yii::$app->request->bodyParams;
        $action = $request['action'];
        $info = $this->listModules($action, $request['type']);
        $page = $request['page'];
        $item = $request['item'];
        $column = $request['column'];
        $module = $request['module'];
        $route = $action . '/index';
        $typeBuilder = $request['type'];
        $dataShortcode = $_SESSION['layout' . $page][$item][$column]['content'][$module];

        // GET CONTENT FROM SHORTCODE TAG
        $bodyContent = '';
        if (preg_match_all("/(?<=}}).*?(?={{)/", $dataShortcode, $content)) {
            $bodyContent = $content[0][0];
        }

        // GET DATA INFO FROM SHORTCODE TAG
        $data = [];
        if (preg_match_all("/(?<={{).*?(?=}})/", $dataShortcode, $match)) {
            foreach ($match[0] as $m) {
                # code...
                $syntax = explode(' ', $m);
                $moduleName = $syntax[0];
                array_shift($syntax);
                $beforeParams = $syntax;

                foreach ($beforeParams as $param) {
                    $attr = explode('=', $param);
                    $data[$attr[0]] = urldecode($attr[1]);
                }
            }
        }

        return $this->renderPartial(
            $route,
            [
                'info' => $info,
                'data' => $data,
                'bodyContent' => html_entity_decode(htmlspecialchars_decode(urldecode($bodyContent))),
                'action' => $action,
                'page' => $page,
                'item' => $item,
                'column' => $column,
                'module' => $module,
                'type' => $typeBuilder
            ]
        );
    }

    public function actionSavemodule()
    {
        $request = Yii::$app->request->bodyParams;
        $action = $request['action'];
        $page = $request['page'];
        $item = $request['item'];
        $column = $request['column'];
        $module = $request['module'];
        $typeBuilder = $request['type'] ?? null;
        $shortcode = '{{' . $action;

        $initModule = include(Yii::getAlias('@app') . '/views/builder/' . $action . '/init.php');
        foreach ($initModule as $init => $type) {
            $value = $request[$init];
            if ($type == 'array') {
                $value = json_encode($request[$init]);
            }

            $shortcode .= ' ' . $init . '=' . urlencode($value);
        }
        $shortcode .= '}}' . htmlentities(htmlspecialchars(urlencode($request['bodyContent']))) . '{{/' . $action . '}}';
        $shortcode = htmlentities($shortcode);

        $_SESSION['layout' . $page][$item][$column]['content'][$module] = $shortcode;

        return $this->renderPartial('_core/builder', ['content' => json_encode($_SESSION['layout' . $page], false), 'pageID' => $page, 'type' => $typeBuilder]);
    }

    public function actionActionmodule()
    {
        $request = Yii::$app->request->bodyParams;
        $action = $request['action'];
        $page = $request['page'];
        $item = $request['item'];
        $column = $request['column'];
        $module = $request['module'];
        $confirm = $request['confirm'];

        if ($confirm == 0) {
            return $this->renderPartial('_core/module_actions', ['action' => $action, 'page' => $page, 'item' => $item, 'column' => $column, 'module' => $module]);
        }

        if ($action == 'remove' && $confirm == 1) {
            unset($_SESSION['layout' . $page][$item][$column]['content'][$module]);
        } elseif ($action == 'clone' && $confirm == 1) {
            $toCopy = $_SESSION['layout' . $page][$item][$column]['content'][$module];
            $_SESSION['layout' . $page][$item][$column]['content'][] = $toCopy;
        }

        return $this->renderPartial('_core/builder', ['content' => json_encode($_SESSION['layout' . $page], false), 'pageID' => $page]);
    }

    public function actionSort()
    {
        $request = Yii::$app->request->bodyParams;
        $target = $request['target'];
        $page = $request['page'];
        $sort = $request['sort'];
        $parents = $request['parents'];
        $parentRow = $parents[0];
        $parentColumn = $parents[1];

        $oldItems = $_SESSION['layout' . $page];
        $newItems = [];

        if ($target == 'row') {
            foreach ($sort as $key => $itemPos) {
                $newItems[$key] = $oldItems[$itemPos];
            }
            $_SESSION['layout' . $page] = $newItems;
        }
        if ($target == 'col') {
            $newItems['opt'] = $oldItems[$parentRow]['opt'];
            foreach ($sort as $key => $itemPos) {
                $newItems[$key] = $oldItems[$parentRow][$itemPos];
            }
            $_SESSION['layout' . $page][$parentRow] = $newItems;
        }
        if ($target == 'module') {
            foreach ($sort as $key => $itemPos) {
                $newItems[$key] = $oldItems[$parentRow][$parentColumn]['content'][$itemPos];
            }
            $_SESSION['layout' . $page][$parentRow][$parentColumn]['content'] = $newItems;
        }

        return $this->renderPartial('_core/builder', ['content' => json_encode($_SESSION['layout' . $page], false), 'pageID' => $page]);
    }

    public function actionGeneratevideothumb()
    {
        $videoUrl = $_POST['videoUrl'];
        $videoUrl = explode('?v=', $videoUrl);
        $videoID = $videoUrl[1];
        $thumbUrl = 'https://img.youtube.com/vi/' . $videoID . '/maxresdefault.jpg';
        return '<img src="' . $thumbUrl . '" />';
    }

    public function actionLayout()
    {
        $request = Yii::$app->request->bodyParams;
        $action = $request['action'];
        $page = $request['page'];
        $item = $request['item'];
        $column = $request['column'];
        $module = $request['module'];

        if ($action == 'load') {
            $layout = Layout::find()->where(['id' => $request['layout']])->one();

            if ($layout->render == 'page') {
                $pageLayout = json_decode($layout->data, true);
                $_SESSION['layout' . $page] = $pageLayout;
            }
            if ($layout->render == 'section') {
                $section = json_decode($layout->data, true);
                array_push($_SESSION['layout' . $page], $section[0]);
            }
            return $this->renderPartial('_core/builder', ['content' => json_encode($_SESSION['layout' . $page], false), 'pageID' => $page]);
        } else {

            $layouts = Layout::find()->all();
        }


        return $this->renderPartial('_core/layout', ['layouts' => $layouts, 'page' => $page, 'action' => 'load', 'item' => $item, 'column' => $column, 'module' => $module]);
    }


    public function actionUploadlayout()
    {
        $post = Yii::$app->request->post();

        if ($post['action'] == 'upload') {
            $extension = pathinfo(basename($_FILES["fileToUpload"]["name"]), PATHINFO_EXTENSION);
            if ($extension == 'json') {
                $fileContent = file_get_contents($_FILES["fileToUpload"]["tmp_name"]);

                $page = Page::findOne($post['page']);
                $page->content = $fileContent;
                $page->save();

                Yii::$app->session->setFlash('success', 'Your layout was uploaded.');
            } else {
                Yii::$app->session->setFlash('danger', 'Your file is not a JSON file.');
            }

            return $this->redirect([$page->type . '/edit', 'id' => $post['page']]);
        }

        $render = $this->renderPartial('_core/_uploadlayout', ['post' => $post]);
        return json_encode([
            'render' => $render
        ]);
    }


    public function actionSavetolibrary($item, $type, $action, $page, $elementTitle = false)
    {
        if ($action == 'show') {

            return $this->renderPartial('_core/_savetolibrary', ['item' => $item, 'page' => $page, 'type' => $type]);

        } elseif ($action == 'save') {

            if ($type == 'section') {

                $_SESSION['savetolibrary'] = [];
                $_SESSION['savetolibrary'][] = $_SESSION['layout' . $page][$item];

            } else {

                $_SESSION['savetolibrary'] = $_SESSION['layout' . $page];
            }

            $section = new Layout();
            $section->title = $elementTitle;
            $section->data = json_encode($_SESSION['savetolibrary'], JSON_FORCE_OBJECT);
            $section->render = $type;

            if ($section->save()) {
                
                return '<div class="modal-body text-center">Success! The <b>' . $elementTitle . '</b> ' . $type . ' was saved to library</div>';
            } else {
                return '<div class="modal-body text-center">Failed. ' . json_encode($section->errors) . '</div>';
            }
        }
        return;
    }


    public function checkBuilder($data)
    {
        $toConvert = 0;

        if (empty(get_object_vars($data))) {
            $toConvert = 1;
        }
        foreach ($data as $idRow => $row) {
            foreach ($row as $idCol => $col) {
                if ($idCol != 'opt') {
                    if (is_object($col->content) || is_array($col->content)) {
                        $toConvert = 1;
                    }
                }
            }
            break;
        }
        return $toConvert;
    }

    public function actionConvert()
    {
        $post = Yii::$app->request->post();
        $data = $_SESSION['layout' . $post['idPage']];

        foreach ($data as $idRow => $row) {
            foreach ($row as $idCol => $col) {
                if ($idCol !== 'opt') {
                    $module = 'code';
                    $shortcode = '{{' . $module;
                    $initModule = include(Yii::getAlias('@app') . '/views/builder/' . $module . '/init.php');

                    foreach ($initModule as $init => $type) {
                        $shortcode .= ' ' . $init . '=';
                    }

                    $shortcode .= '}}' . htmlentities(htmlspecialchars(urlencode($col['content']))) . '{{/' . $module . '}}';
                    $shortcode = htmlentities($shortcode);

                    $_SESSION['layout' . $post['idPage']][$idRow][$idCol]['content'] = [];

                    if ($col['content'] != null) {
                        $_SESSION['layout' . $post['idPage']][$idRow][$idCol]['content'][] = $shortcode;
                    }
                }
            }
        }

        return $this->renderPartial('_core/builder', ['content' => json_encode($_SESSION['layout' . $post['idPage']], false), 'pageID' => $post['idPage']]);
    }



    public function actionChecksession()
    {
        $post = Yii::$app->request->post();
        $maxlifetime = ini_get("session.gc_maxlifetime");
        $sessionStart = $_SESSION['layoutStartTime' . $post['item']];
        $endTime = $sessionStart + $maxlifetime;
        $endTime = $endTime - 500;

        if (time() >= $endTime) {
            $_SESSION['layoutStartTime' . $item] = time();
            $_SESSION['layout' . $item] = $_SESSION['layout' . $item];
            $_SESSION['layoutOld' . $item] = $_SESSION['layoutOld' . $item];
            $_SESSION['layout_render' . $item] = $_SESSION['layout_render' . $item];
            return 'renewed';
        }

        return date('H:i:s', time()) . ' = ' . date('H:i:s', $endTime);
    }


    // IMPORT/EXPORT LAYOUTS

    public function actionExportlayout($page = false)
    {
        $post = Yii::$app->request->post();
        $pageData = Pages::findOne($page);

        $filename = 'template-' . $_SERVER['HTTP_HOST'] . '-' . $pageData->slug;
        $json = json_encode($_SESSION['layout' . $page]);

        header('Content-disposition: attachment; filename=' . $filename . '.json');
        header('Content-type: application/json');

        echo $json;
        exit;
    }
}
