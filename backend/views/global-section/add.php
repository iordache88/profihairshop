<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\GlobalSection $model */

$this->title = 'Add global section';
$this->params['breadcrumbs'][] = ['label' => 'Global sections', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">

    <div class="global-section-create">

        <h4><?= Html::encode($this->title) ?></h4>

        <?= $this->render('_form', [
            'model' => $model,
            'idLayout' => $idLayout,
        ]); ?>

    </div>
</div>

