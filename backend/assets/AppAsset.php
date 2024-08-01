<?php

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'theme/css/nucleo-icons.css',
        'theme/css/nucleo-svg.css',
        'theme/css/material-dashboard.min.css',
        'css/default-picker.css',
        'css/builder.css',
        'css/media.css',
        'css/site.css',
    ];
    public $js = [
        'js/jquery-ui.js',
        'js/default-picker.min.js',
        'theme/js/core/bootstrap.bundle.min.js',
        'theme/js/plugins/chartjs.min.js',
        'theme/js/plugins/countup.min.js',
        'theme/js/plugins/choices.min.js',
        'theme/js/plugins/quill.min.js',
        'theme/js/plugins/moment.min.js',
        'theme/js/plugins/datatables.js',
        'theme/js/plugins/perfect-scrollbar.min.js',
        'theme/js/plugins/dropzone.min.js',
        'theme/js/plugins/sweetalert.min.js',
        ['theme/js/material-dashboard.min.js', 'position' => View::POS_END],
        ['js/builder.js', 'position' => View::POS_END],
        ['js/media.js', 'position' => View::POS_END],
        ['js/custom.js', 'position' => View::POS_END],
    ];
    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
