<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Page;
use common\models\Settings;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;


class PageController extends Controller
{
    public function actionView($slug)
    {
        $page = Page::find()->andWhere(['slug' => $slug, 'status' => 'public'])->one();

        if (!is_object($page)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if($page->isFrontPage()) {
            return $this->redirect('/');
        }

        $base_url = Url::base(true);

        $meta_title = empty($page->meta_title) ? Settings::findOptionValue('meta_title') : $page->meta_title;
        $meta_desc  = empty($page->meta_desc) ? Settings::findOptionValue('meta_desc') : $page->meta_desc;

        $this->view->title = $meta_title;

        $this->view->params['page']        = $page;
        $this->view->params['page_id']     = $page->id;
        $this->view->params['page_slug']   = $page->slug;
        $this->view->params['image']       = $base_url . $page->getFeaturedImage();
        $this->view->params['url']         = $base_url . $page->slug;
        $this->view->params['is_homepage'] = false;
        $this->view->params['meta_title']  = $meta_title;
        $this->view->params['meta_desc']   = $meta_desc;
        $this->view->params['og_type']     = 'website';

        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => $meta_desc,
        ]);

        
        return $this->render('view', [
            'page' => $page,
        ]);

    }
}