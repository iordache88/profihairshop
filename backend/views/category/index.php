<?php

use common\models\Tools;
use common\models\Media;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="page-index">

        <h4><?= Html::encode($this->title) ?></h4>

        <p>
            <?= Html::a('Add Category', ['add', 'target' => Yii::$app->request->get('target')], ['class' => 'btn btn-success']) ?>
        </p>

        <?php Pjax::begin([
            'id' => 'pjax-categories',
            'timeout' => 0,
        ]); ?>

        <div class="table-responsive">
            <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">

                <div class="dataTable-container">

                    <?= GridView::widget([
                        'id' => 'gridview-categories',
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'tableOptions' => ['class' => 'table table-striped table-flush dataTable-table'],
                        'columns' => [
                            [
                                'attribute' => 'id',
                                'format' => 'raw',
                                'value' => function ($model) {

                                    $return = '';
                                    $return .= '<strong>#' . $model->id . '</strong>' . '&nbsp';

                                    $image_src = $model->featuredImage;
                                    if (empty($image_src)) {
                                        $image_src = Tools::adminNoImageSrc();
                                    }

                                    $return .= Html::a(Html::img($image_src, ['width' => '40', 'height' => '40']), ['category/edit', 'id' => $model->id],  ['data-pjax' => 0, 'title' => 'Edit category']);

                                    return $return;
                                },
                                'contentOptions' => ['class' => 'position-relative'],
                                'headerOptions' => ['style' => 'width: 83px;'],
                            ],

                            [
                                'attribute' => 'title',
                                'format' => 'raw',
                                'value' => function ($model) {

                                    $return = Html::tag('h6', Html::a($model->title, ['category/edit', 'id' => $model->id]));

                                    if(!empty($model->subcategories)) {

                                        $return .= $this->render('_subcategories-part', ['subcategories'=> $model->subcategories, 'level' => 1]);
                                    }
                                    return $return;
                                    
                                },
                                'contentOptions' => ['class' => 'position-relative'],
                            ],
                            [
                                'attribute' => 'meta_title',
                                'format' => 'raw',
                                'value' => function ($model) {

                                    $return = Html::beginTag('div', ['class' => 'input-group']);

                                    $return .= Html::activeInput('text', $model, 'meta_title', ['class' => 'form-control update_attribute_ajax', 'data-id' => $model->id, 'data-url' => Url::toRoute('category/update-attribute'), 'data-attr' => 'meta_title']);

                                    $return .= Html::endTag('div');

                                    return $return;
                                },
                            ],
                            [
                                'attribute' => 'meta_desc',
                                'format' => 'raw',
                                'value' => function ($model) {

                                    $return = Html::beginTag('div', ['class' => 'input-group']);

                                    $return .= Html::activeTextarea($model, 'meta_desc', ['class' => 'form-control update_attribute_ajax', 'data-id' => $model->id, 'data-url' => Url::toRoute('category/update-attribute'), 'data-attr' => 'meta_desc']);

                                    $return .= Html::endTag('div');

                                    return $return;
                                },
                            ],

                            [
                                'attribute' => 'status',
                                'filter' => $searchModel->statusList,
                                'format' => 'raw',
                                'value' => function ($model) {

                                    $statusListChangeable = $model->statusList;

                                    return Html::dropDownList('status', $model->status,  $statusListChangeable, ['class' => 'form-control update_attribute_ajax', 'data-id' => $model->id, 'data-url' => Url::toRoute('category/update-attribute'), 'data-attr' => 'status']);
                                },
                            ],

                            [
                                'class' => ActionColumn::class,
                                'template' => '{edit} {delete}',
                                'contentOptions' => ['class' => 'text-right'],
                                'headerOptions' => ['style' => 'width: 50px;'],
                                'buttons' => [

                                    'edit' => function ($url, $model) {


                                        return Html::a('<i class="material-icons text-info position-relative text-lg">drive_file_rename_outline</i></i>', ['category/edit', 'id' => $model->id], [
                                            'title' => "Edit",
                                            'class' => '',
                                            'data-pjax' => 0,
                                        ]);
                                    },

                                    'delete' => function ($url, $model) {

                                        $confirm = 'Do you want to delete this category?';

                                        return Html::a('<i class="material-icons text-danger position-relative text-lg">delete</i></i>', $url, [
                                            'title' => "Delete",
                                            'class' => 'btn_delete_category',
                                            'data' => [
                                                'method' => 'post',
                                                'confirm' => $confirm,
                                                'pjax' => 0,
                                            ],
                                        ]);
                                    }
                                ],
                            ],
                        ]
                    ]); ?>

                </div>
            </div>
        </div>


        <?php Pjax::end(); ?>

    </div>

</div>