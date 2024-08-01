<?php

use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'ADMIN ' . Yii::$app->name;
?>

<div class="site-index">

    <div class="container-fluid py-4">

        <div class="row">

            <div class="col-md-3">

                <?= $this->render('_count-orders-card', ['orders' => $orders]); ?>
            </div>

            <div class="col-md-3">

                <?= $this->render('_count-products-card', ['products' => $products]); ?>
            </div>

            <div class="col-md-3">

                <?= $this->render('_count-pages-card', ['pages' => $pages]); ?>
            </div>

            <div class="col-md-3">

                <?= $this->render('_count-media-card', ['media_items' => $media_items]); ?>
            </div>

        </div>

        <div class="row">

            <div class="col-md-3">
                
            </div>

            <div class="col-md-3">

                <?= $this->render('_users', ['users' => $users]); ?>

            </div>

            <div class="col-md-6 position-relative z-index-2">

                <?= $this->render('_logs', ['logs' => $logs]); ?>

            </div>
        </div>
    </div>
</div>