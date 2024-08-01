<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\models\Tools;
use common\models\Settings;
use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;

AppAsset::register($this);

$custom_js = Settings::findOptionValue('custom_js');

if(!empty($custom_js)) {

    $this->registerJs($custom_js, $this::POS_END);
}


$custom_css = Settings::findOptionValue('custom_css');

if(!empty($custom_css)) {

    $this->registerCss($custom_css);
}
?>


<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">


<head>
    <meta charset="<?= Yii::$app->charset; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php $this->registerCsrfMetaTags(); ?>

    <title><?= Html::encode($this->title); ?></title>

    <?php $this->head(); ?>

    <meta property="og:title" content="<?= Html::encode($this->title); ?>" />
    <meta property="og:url" content="<?= $this->params['url']; ?>" />
    <meta property="og:image" content="<?= $this->params['image']; ?>" />
    <meta property="og:type" content="<?= $this->params['og_type']; ?>" />
    <meta property="og:description" content="<?= $this->params['meta_desc']; ?>" />

    <?= Settings::findOptionValue('head_script'); ?>
</head>


<body 

class="d-flex flex-column h-100  <?= $this->params['is_homepage'] ? 'homepage' : 'interiorpage'; ?> 

page-id-<?= isset($this->params['page_id']) ? $this->params['page_id'] : '0'; ?> 
page-slug-<?= isset($this->params['page_slug']) ? $this->params['page_slug'] : 'none'; ?>

">

    <?= htmlspecialchars_decode(Settings::findOptionValue('body_script')); ?>
    <?php $this->beginBody() ?>


    <header id="header" class="fixed-top">

        <?= Tools::renderBuilder(json_decode(Settings::findOptionValue('header'))->{'ro-RO'}); ?>

    </header>


    <main role="main" class="flex-shrink-0">

        <?php 
        /*
        Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]); 
        */
        ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </main>


    <footer class="bg-dark text-white">
        
        <?= Tools::renderBuilder(json_decode(Settings::findOptionValue('footer'))->{'ro-RO'}); ?>

    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
