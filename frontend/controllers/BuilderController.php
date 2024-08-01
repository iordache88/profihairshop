<?php

namespace frontend\controllers;

use common\models\GlobalSection;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\db\Expression;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use common\models\Settings;

class BuilderController extends Controller
{



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



    public function actionContact($id)
    {
        $route = $this->route('contact');
        $form = ContactForm::find()->where(['ID' => $id])->one();
        if (isset($form)) {
            return $this->renderPartial($route, ['id' => $id, 'form' => $form]);
        } else {
            return '{{contact ' . $id . '}}';
        }
    }

    public function actionText($color, $_bodyContent, $_id, $_class)
    {
        return $this->renderPartial('text/index', ['color' => $color, '_bodyContent' => $_bodyContent, '_id' => $_id, '_class' => $_class]);
    }

    public function actionImage($image, $open, $url, $target, $title, $_id, $_class)
    {
        return $this->renderPartial('image/index', ['image' => $image, 'open' => $open, 'url' => $url, 'target' => $target, 'title' => $title, '_id' => $_id, '_class' => $_class]);
    }

    public function actionCode($_bodyContent, $_id, $_class)
    {
        return $this->renderPartial('code/index', ['_bodyContent' => $_bodyContent, '_id' => $_id, '_class' => $_class]);
    }

    public function actionGallery($gallery, $title, $meta, $_id, $_class, $_row, $_col, $_idModule)
    {
        return $this->renderPartial('gallery/index', ['gallery' => $gallery, 'title' => $title, 'meta' => $meta, '_id' => $_id, '_class' => $_class, '_row' => $_row, '_col' => $_col, '_idModule' => $_idModule]);
    }

    public function actionVideo($_id, $_class, $type, $video, $url, $thumb, $controls, $autoplay, $loop)
    {
        return $this->renderPartial('video/index', ['_id' => $_id, '_class' => $_class, 'type' => $type, 'video' => $video, 'url' => $url, 'thumb' => $thumb, 'controls' => $controls, 'autoplay' => $autoplay, 'loop' => $loop]);
    }

    public function actionButton($_id, $_class, $type, $link, $text, $target)
    {
        return $this->renderPartial('button/index', ['_id' => $_id, '_class' => $_class, 'type' => $type, 'link' => $link, 'text' => $text, 'target' => $target]);
    }

    public function actionWidget($_id, $_class, $widget)
    {
        $global_section = GlobalSection::findOne($widget);
        return $this->renderPartial('widget/index', ['_id' => $_id, '_class' => $_class, 'global_section' => $global_section]);
    }

    public function actionNumber($_id, $_class, $number, $percent, $count)
    {
        return $this->renderPartial('number/index', ['_id' => $_id, '_class' => $_class, 'number' => $number, 'percent' => $percent, 'count' => $count]);
    }

    // public function actionSlider($_id, $_class, $slider, $type, $autoplay, $delay)
    // {
    //     $route = $this->route('slider');
    //     $slider = Slides::findOne($slider);
    //     return $this->renderPartial($route, ['_id'=>$_id, '_class'=>$_class, 'slider'=>$slider, 'type'=>$type, 'autoplay'=>$autoplay, 'delay'=>(int)$delay]);
    // }

    public function categoryRecursiveChilds($category, $tempArray = false)
    {
        if ($tempArray == null) {
            $tempArray = [];
        }
        foreach ($category->childs as $child) {
            foreach ($child->relations as $rel) {
                array_push($tempArray, $rel->ID_item);
            }
            if (isset($child->childs)) {
                $tempArray = array_merge($this->categoryRecursiveChilds($child), $tempArray);
            }
        }

        return $tempArray;
    }

    public function actionCategory($_id, $_class, $category, $show, $colsize, $order, $limit, $direction, $type, $exclude = false, $pagination = false, $ajaxload = false)
    {
        return;
        $route = $this->route('category');

        switch ($show) {
            default:
            case 'subcategories':

                $category_model = Categories::findOne($category);

                $subcategories = $category_model->childs;

                return $this->renderPartial($route, [

                    '_id'           => $_id,
                    '_class'        => $_class,
                    'type'          => $type,
                    'colsize'       => $colsize,
                    'limit'         => $limit,
                    'direction'     => $direction,
                    'subcategories' => $subcategories
                ]);
                break;



            case 'pages':

                $page_IDs = [];

                $checkPagination = array_keys($_GET);
                $checkPagination = array_search('page', $checkPagination);

                if (count($_GET) > 1 && $checkPagination != 1 && $exclude == null) {
                    $page_IDs = Yii::$app->runAction('requests/filter-products', ['params' => json_encode($_GET)]);
                } else {
                    if ($category == 'all') {
                        $categories = Categories::find()->where(['target' => $type, 'status' => 1])->all();
                        foreach ($categories as $category) {
                            foreach ($category->relations as $rel) {
                                if ($rel->ID_item != $exclude) {
                                    array_push($page_IDs, $rel->ID_item);
                                }
                            }
                        }
                    } else {
                        $category = Categories::findOne($category);
                        if (!empty($category->relations)) {
                            foreach ($category->relations as $rel) {
                                if ($rel->ID_item != $exclude) {
                                    array_push($page_IDs, $rel->ID_item);
                                }
                            }
                        }
                    }
                }

                if ($limit == null) {
                    $limit = 4;
                }

                $order_field_check = Customfield::findOne(['target' => $type, 'slug' => $order]);
                $pages = Pages::find();
                if ($order_field_check != NULL) {
                    $pages->joinWith(['relations CFR' => function ($query) use ($order_field_check) {

                        if (is_object($order_field_check)) {
                            $query->andWhere(['ID_field' => $order_field_check->ID]);
                        }
                    }]);
                    $pages->andWhere(['pages.ID' => $page_IDs, 'status' => 'public', 'lang' => Yii::$app->language]);
                } else {
                    $pages->andWhere(['ID' => $page_IDs, 'status' => 'public', 'lang' => Yii::$app->language]);
                }


                if (is_object($order_field_check)) {

                    $pages->orderBy("CAST(CFR.value AS UNSIGNED) {$direction}");
                } else {

                    if ($direction == 'asc') {
                        $pages->orderBy([$order => SORT_ASC]);
                    } else {
                        $pages->orderBy([$order => SORT_DESC]);
                    }
                }


                if ($pagination == 1) {
                    $routePage = $_GET['slug'];

                    if ($ajaxload == 1) {
                        $routePage = '/';
                    }

                    $params = $_GET;
                    unset($params['slug']);
                    $count = $pages->count();
                    $paginate = new Pagination([
                        'pageSizeParam' => 'per_page',
                        'totalCount' => $count,
                        'pageSize' => $limit,
                        'route' => $routePage,
                        'params' => $params
                    ]);

                    $pages = $pages->offset($paginate->offset)
                        ->limit($paginate->limit);
                } else {
                    $pages->limit($limit);
                }

                return $this->renderPartial($route, [

                    '_id'           => $_id,
                    '_class'        => $_class,
                    'type'          => $type,
                    'colsize'       => $colsize,
                    'limit'         => $limit,
                    'direction'     => $direction,
                    'pages'         => $pages->all(),
                    'paginate'      => $paginate,
                    'ajaxload'      => $ajaxload,
                    'page_IDs'      => $page_IDs
                ]);
                break;
        }
    }

    public function actionField($_id, $_class, $field_id, $value_options, $colsize, $order, $limit, $direction, $type, $pagination = false)
    {
        $value_options_arr      = json_decode($value_options, true);
        $field                  = Customfield::findOne($field_id);


        if (empty($value_options_arr) || empty($value_options_arr[0])) {
            $match_condition = [];
        } else {

            if ($field->type == 'textarea') {

                $match_condition = ['like', 'value', $value_options_arr[0]];
            } else {

                $match_condition = ['in', 'value', $value_options_arr];
            }
        }


        $field_relations   = Customfieldrelations::find()->andWhere(['ID_field' => $field_id])->andWhere($match_condition)->asArray()->all();
        $pages_query       = Pages::find();
        $order_field_check = Customfield::findOne(['target' => $type, 'slug' => $order]);


        $pages_query->joinWith(['relations CFR' => function ($query) use ($order_field_check) {

            if (is_object($order_field_check)) {
                $query->andWhere(['CFR.ID_field' => $order_field_check->ID]);
            }
        }]);


        $pages_query->andWhere(['in', 'pages.ID', ArrayHelper::map($field_relations, 'ID_page', 'ID_page')]);
        $pages_query->andWhere(['type' => $type, 'status' => 'public']);


        if ($pagination == 0) {
            $pages_query->limit($limit);
        } else {

            $routePage = $_GET['slug'];
            $params = $_GET;
            unset($params['slug']);
            $count = $pages_query->count();

            $paginate = new Pagination([
                'pageSizeParam' => 'per_page',
                'totalCount' => $count,
                'pageSize' => $limit,
                'route' => $routePage,
                'params' => $params
            ]);

            $pages_query->offset($paginate->offset);
            $pages_query->limit($paginate->limit);
        }


        if (is_object($order_field_check) && !empty($direction)) {

            $pages_query->orderBy("CAST(CFR.value AS UNSIGNED) {$direction}");
        } elseif (!empty($order) && !empty($direction)) {

            $pages_query->orderBy("{$order} {$direction}");
        }

        $pages = $pages_query->all();

        $route = $this->route('field');
        return $this->renderPartial($route, [

            '_id'           => $_id,
            '_class'        => $_class,
            'type'          => $type,
            'colsize'       => $colsize,
            'limit'         => $limit,
            'direction'     => $direction,
            'pages'         => $pages,
            'paginate'      => $paginate,
        ]);
    }

    public function actionFolder($_id, $_class, $folderID, $type, $order, $sort)
    {
        $route = $this->route('folder');
        $orderBy = 'rand' == $order ? new Expression('rand()') : $order . ' ' . $sort;
        $folder = Media::findOne($folderID);
        $media = Media::find()->where(['ID_parent' => $folderID])->orderBy($orderBy)->all();
        return $this->renderPartial($route, ['_id' => $_id, '_class' => $_class,  'folder' => $folder->url, 'media' => $media, 'type' => $type]);
    }

    public function actionCategories($type)
    {
        $route = $this->route('categories');
        $categories = Categories::find()->where(['target' => $type, 'ID_parent' => NULL])->orderBy(['ord' => SORT_ASC])->all();
        return $this->renderPartial($route, ['categories' => $categories]);
    }

    public function actionSocial($_id, $_class, $show)
    {
        $social_media = Settings::findOptionValueAsArray('social_media');

        return $this->renderPartial('social/index', ['_id' => $_id, '_class' => $_class, 'show' => $show, 'social_media' => $social_media]);
    }

    public function actionFickle($_id, $_class, $title_html_tag, $title_text, $subtitle_html_tag, $subtitle_text, $text_content, $additional_html_code, $view_type, $image, $background_image, $icon, $link, $link_target)
    {
        switch ($view_type) {
            case '1':
            default:
                $view = 'basic';
                break;

            case '2':
                $view = 'inline';
                break;
        }

        return $this->renderPartial("fickle/$view", [

            '_id'                  => $_id,
            '_class'               => $_class,
            'title_html_tag'       => $title_html_tag,
            'title_text'           => $title_text,
            'subtitle_html_tag'    => $subtitle_html_tag,
            'subtitle_text'        => $subtitle_text,
            'text_content'         => $text_content,
            'additional_html_code' => $additional_html_code,
            'view_type'            => $view_type,
            'image_id'             => $image,
            'background_image_id'  => $background_image,
            'icon'                 => $icon,
            'link'                 => $link,
            'link_target'          => $link_target,

        ]);
    }



    public function actionCfinput($_id, $_class, $label, $placeholder, $maxlength, $required, $_row, $_col, $_idModule)
    {
        return $this->renderPartial('cfinput/index', ['_id' => $_id, '_class' => $_class, 'label' => $label, 'placeholder' => $placeholder, 'maxlength' => $maxlength, 'required' => $required, '_row' => $_row, '_col' => $_col, '_idModule' => $_idModule]);
    }

    public function actionCftextarea($_id, $_class, $label, $maxlength, $required, $_row, $_col, $_idModule)
    {
        return $this->renderPartial('cftextarea/index', ['_id' => $_id, '_class' => $_class, 'label' => $label, 'maxlength' => $maxlength, 'required' => $required, '_row' => $_row, '_col' => $_col, '_idModule' => $_idModule]);
    }

    public function actionCfemail($_id, $_class, $label, $placeholder, $maxlength, $required, $_row, $_col, $_idModule)
    {
        return $this->renderPartial('cfemail/index', ['_id' => $_id, '_class' => $_class, 'label' => $label, 'placeholder' => $placeholder, 'maxlength' => $maxlength, 'required' => $required, '_row' => $_row, '_col' => $_col, '_idModule' => $_idModule]);
    }

    public function actionCfcheck($_id, $_class, $label, $options, $required, $_row, $_col, $_idModule)
    {
        return $this->renderPartial('cfcheck/index', ['_id' => $_id, '_class' => $_class, 'label' => $label, 'options' => $options, 'required' => $required, '_row' => $_row, '_col' => $_col, '_idModule' => $_idModule]);
    }

    public function actionCfradio($_id, $_class, $label, $options, $required, $_row, $_col, $_idModule)
    {
        return $this->renderPartial('cfradio/index', ['_id' => $_id, '_class' => $_class, 'label' => $label, 'options' => $options, 'required' => $required, '_row' => $_row, '_col' => $_col, '_idModule' => $_idModule]);
    }

    public function actionCfselect($_id, $_class, $label, $options, $multiple, $required, $_row, $_col, $_idModule)
    {
        return $this->renderPartial('cfselect/index', ['_id' => $_id, '_class' => $_class, 'label' => $label, 'options' => $options, 'multiple' => $multiple, 'required' => $required, '_row' => $_row, '_col' => $_col, '_idModule' => $_idModule]);
    }

    public function actionCffile($_id, $_class, $label, $maxsize, $required, $_row, $_col, $_idModule)
    {
        return $this->renderPartial('cffile/index', ['_id' => $_id, '_class' => $_class, 'label' => $label, 'maxsize' => $maxsize, 'required' => $required, '_row' => $_row, '_col' => $_col, '_idModule' => $_idModule]);
    }

    public function actionNewsletter($_id, $_class, $contentalign, $title, $subtitle, $buttontext, $buttonbgcolor, $buttontextcolor)
    {

        return $this->renderPartial('newsletter/index', ['_id' => $_id, '_class' => $_class, 'contentalign' => $contentalign, 'title' => $title, 'subtitle' => $subtitle, 'buttontext' => $buttontext, 'buttonbgcolor' => $buttonbgcolor, 'buttontextcolor' => $buttontextcolor]);
    }

    public function actionStartwrap($_id, $_class, $attributes, $element)
    {
        if (!empty($_id)) {
            $add_id = ' id="' . $_id . '"';
        } else {
            $add_id = '';
        }

        if (!empty($_class)) {
            $add_class = ' class="modules-wrapper ' . $_class . '"';
        } else {
            $add_class = ' class="modules-wrapper"';
        }

        if (!empty($attributes)) {
            $add_attributes = ' ' . $attributes;
        } else {
            $add_attributes = '';
        }

        return "<{$element}{$add_id}{$add_class}{$add_attributes}>";
    }

    public function actionEndwrap($element)
    {
        return "</{$element}>";
    }
}
