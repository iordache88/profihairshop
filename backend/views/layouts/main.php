<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use common\widgets\Alert;
use common\models\PageType;
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <link rel="apple-touch-icon" sizes="76x76" href="/backend/web/theme/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/backend/web/theme/img/favicon.png">

    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<?php
$user_details = Yii::$app->user->identity->details;

$admin_settings = json_decode($user_details->admin_settings, true);

if (isset($admin_settings['theme'])) {

    $admin_theme_settings = $admin_settings['theme'];
} else {
    $admin_theme_settings = [];
}

if (isset($admin_theme_settings['sidebar_color'])) {
    $sidebar_color = $admin_theme_settings['sidebar_color'];
} else {
    $sidebar_color = '';
}

if (isset($admin_theme_settings['sidebar_type'])) {
    $sidebar_type = $admin_theme_settings['sidebar_type'];
} else {
    $sidebar_type = '';
}

if (isset($admin_theme_settings['navbar_fixed'])) {
    $navbar_fixed = $admin_theme_settings['navbar_fixed'];
} else {
    $navbar_fixed = 0;
}

if (isset($admin_theme_settings['navbar_minimize'])) {
    $navbar_minimize = $admin_theme_settings['navbar_minimize'];
} else {
    $navbar_minimize = 0;
}

if (isset($admin_theme_settings['dark_mode'])) {
    $dark_mode = $admin_theme_settings['dark_mode'];
} else {
    $dark_mode = 0;
}

$page_types = PageType::find()->andWhere(['status' => 10])->all();
?>


<body class="g-sidenav-show  bg-gray-100 <?= $dark_mode ? 'dark-version' : ''; ?> <?= $navbar_minimize ? 'g-sidenav-hidden' : ''; ?>">
    <?php $this->beginBody() ?>

    <?= $this->render('_sidebar', ['sidebar_color' => $sidebar_color, 'sidebar_type' => $sidebar_type, 'navbar_fixed' => $navbar_fixed, 'navbar_minimize' => $navbar_minimize, 'dark_mode' => $dark_mode, 'page_types' => $page_types]); ?>

    <div class="main-content position-relative max-height-vh-100 h-100">


        <?= $this->render('_navbar', ['sidebar_color' => $sidebar_color, 'sidebar_type' => $sidebar_type, 'navbar_fixed' => $navbar_fixed, 'navbar_minimize' => $navbar_minimize, 'dark_mode' => $dark_mode]); ?>

        <div class="container-fluid alert-container">
            <?= Alert::widget(); ?>
        </div>

        <?= $content; ?>


        <footer class="py-4">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6 mb-lg-0 mb-4">
                        <div class="copyright text-center text-sm text-muted text-lg-start">
                            © <?= date('Y'); ?>,
                            created by
                            <a href="https://magic5.ro" class="font-weight-bold" target="_blank">Magic 5</a>
                            for <?= Yii::$app->name; ?>.
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                            <li class="nav-item">
                                <a href="/" class="nav-link text-muted" target="_blank">Home</a>
                            </li>
                            <li class="nav-item">
                                <a href="/despre-noi" class="nav-link text-muted" target="_blank">About us</a>
                            </li>
                            <li class="nav-item">
                                <a href="/contact" class="nav-link text-muted" target="_blank">Contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>

    </div>


    <?= $this->render('_fixed-plugin', ['sidebar_color' => $sidebar_color, 'sidebar_type' => $sidebar_type, 'navbar_fixed' => $navbar_fixed, 'navbar_minimize' => $navbar_minimize, 'dark_mode' => $dark_mode]); ?>

    <!-- Modal media -->
    <div class="modal fade" id="modalMedia" tabindex="-1" role="dialog" data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <?= $this->render('../media/_modal-content'); ?>
            </div>
        </div>
    </div>

    <!-- Modal Add folder -->
    <div id="addFolder" tabindex="-1" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <?php
                ActiveForm::begin([
                    'id' => 'form-add-media',
                    'action' => ['media/add-folder-ajax'],
                ])
                ?>

                <div class="modal-body">
                    <div class="card card-plain">
                        <div class="card-header pb-0 text-left">
                            <h5 class="modal-title font-weight-normal">Add folder</h5>
                        </div>
                        <div class="card-body pb-3">
                            <div class="input-group input-group-outline my-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="folder_name" class="form-control" value="" placeholder="Write the folder name..." />
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary w-100 btn_create_media_folder_ajax">Create</button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>

        </div>

    </div>

    <div id="modal_builder" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">

        </div>
    </div>

    <div id="modalLayout" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

            </div>
        </div>
    </div>

    <div id="modalGeneral" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

            </div>
        </div>
    </div>

    <div class="loading" style="display: none;">
        <div class="loading-inner">
            <div class="loading-icon"></div>
        </div>
    </div>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
