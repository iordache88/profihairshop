<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Page $model */

$this->title = 'Edit ' . $model->getNameSingular() . ': ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => $model->getNamePlural(), 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Edit';

?>


<div class="container-fluid">

    <div class="page-update">

        <div class="row">
            <div class="col-md-9">

                <div class="row justify-content-between">
                    <div class="col align-self-center">

                        <h4><?= Html::encode($this->title) ?></h4>
                    </div>

                    <div class="col align-self-center text-md-end">

                        <button type="button" data-bs-toggle="modal" data-bs-target="#modalLayout" class="btn btn-sm btn-outline-danger" title="Add to library" onclick="savetolibrary('0', 'page','show')"><i class="fas fa-plus"></i> add to library</button>

                        <a class="btn btn-sm btn-outline-info" href="/<?= $model->slug; ?>" target="_blank"><i class="fas fa-eye"></i>&nbsp;View</a>
                    </div>
                </div>
            </div>
        </div>

        <?php
        unset($_SESSION['layout' . $model->id]);
        unset($_SESSION['layout_render' . $model->id]);

        $_SESSION['layoutStartTime' . $model->id] = time();
        $_SESSION['layout' . $model->id]          = json_decode($model->content, true);
        $_SESSION['layout_render' . $model->id]   = $model->type;

        ?>

        <?= $this->render('_form', [
            'model' => $model,
            'categories' => $categories,
        ]) ?>

    </div>

</div>