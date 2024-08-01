<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Category $model */

$this->title = 'Create Category';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index', 'target' => $model->target]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">

    <div class="category-create">

        <h4><?= Html::encode($this->title) ?></h4>

        <?= $this->render('_form', [
            'model' => $model,
            'categories' => $categories,
        ]) ?>

    </div>
</div>

