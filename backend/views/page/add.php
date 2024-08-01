<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Page $model */

$this->title = 'Add ' . $model->getNameSingular();
$this->params['breadcrumbs'][] = ['label' => $model->getNamePlural(), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">

    <div class="page-create">

        <h4><?= Html::encode($this->title) ?></h4>

        <?= $this->render('_form', [
            'model' => $model,
            'categories' => $categories,
        ]) ?>

    </div>
</div>

