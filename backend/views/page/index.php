<?php

use common\models\Tools;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = is_object($pageType) ? $pageType->name_plural : 'Pages ' . ' | ' . Yii::$app->name;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="page-index">

        <h4><?= Html::encode($this->title) ?></h4>

        <p>
           <?= Html::a('Add ' . (is_object($pageType) ? $pageType->name_singular : 'Page '), ['add'], ['class' => 'btn btn-success']); ?>
        </p>

        <?php Pjax::begin([
            'id' => 'pjax-pages',
            'timeout' => 0,
        ]); ?>

        <div class="table-responsive">
            <div class="dataTable-wrapper">
                <div class="dataTable-container">

                    <?= GridView::widget([
                        'id' => 'gridview-pages',
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'tableOptions' => ['class' => 'table table-striped dataTable-table table-sortable'],
                        'columns' => [
                            [
                                'format' => 'raw',
                                'value' => function ($model) {

                                    $return = '';

                                    $image_src = $model->featuredImage;
                                    if (empty($image_src)) {
                                        $image_src = Tools::adminNoImageSrc();
                                    }

                                    $return .= Html::a(Html::img($image_src, ['width' => '40', 'height' => '40']), [$model->type . '/edit', 'id' => $model->id],  ['data-pjax' => 0, 'target' =>  '_blank', 'title' => 'Edit page']);

                                    return $return;
                                },
                                'contentOptions' => ['class' => 'td-image'],
                                'headerOptions' => ['class' => 'th-image'],
                            ],

                            [
                                'attribute' => 'title',
                                'format' => 'raw',
                                'value' => function ($model) {

                                    $return = Html::tag('h6', Html::a($model->title, [$model->type . '/edit', 'id' => $model->id]));

                                    if($model->isFrontPage()) {

                                        $return .= '<span class="badge badge-success badge-sm">Front page</span>';
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

                                    $return .= Html::activeInput('text', $model, 'meta_title', ['class' => 'form-control update_attribute_ajax', 'data-id' => $model->id, 'data-url' => Url::toRoute($model->type . '/update-attribute'), 'data-attr' => 'meta_title']);

                                    $return .= Html::endTag('div');

                                    return $return;
                                },
                            ],
                            [
                                'attribute' => 'meta_desc',
                                'format' => 'raw',
                                'value' => function ($model) {

                                    $return = Html::beginTag('div', ['class' => 'input-group']);

                                    $return .= Html::activeTextarea($model, 'meta_desc', ['class' => 'form-control update_attribute_ajax', 'data-id' => $model->id, 'data-url' => Url::toRoute($model->type . '/update-attribute'), 'data-attr' => 'meta_desc']);

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

                                    if ($model->status !== 'trash') {

                                        unset($statusListChangeable['trash']);
                                    }

                                    return Html::dropDownList('status', $model->status,  $statusListChangeable, ['class' => 'form-control update_attribute_ajax', 'data-id' => $model->id, 'data-url' => Url::toRoute($model->type . '/update-attribute'), 'data-attr' => 'status']);
                                },
                            ],

                            [
                                'class' => ActionColumn::class,
                                'template' => '{view} {edit} {duplicate} {trash}',
                                'contentOptions' => ['class' => 'text-right'],
                                'headerOptions' => ['style' => 'width: 50px;'],
                                'buttons' => [

                                    'view' => function ($url, $model) {


                                        return Html::a('<i class="material-icons text-success position-relative text-lg">visibility</i></i>', '/' . $model->slug, [
                                            'title' => "View on site",
                                            'target' => '_blank',
                                            'data-pjax' => 0,
                                        ]);
                                    },

                                    'edit' => function ($url, $model) {


                                        return Html::a('<i class="material-icons text-info position-relative text-lg">drive_file_rename_outline</i></i>', [$model->type . '/edit', 'id' => $model->id], [
                                            'title' => "Edit",
                                            'class' => 'ms-3',
                                            'data-pjax' => 0,
                                        ]);
                                    },


                                    'duplicate' => function ($url, $model) {


                                        return Html::a('<i class="material-icons text-warning position-relative text-lg">copy</i></i>', [$model->type . '/duplicate', 'id' => $model->id], [
                                            'title' => "Duplicate",
                                            'class' => 'mx-3',
                                            'data' => [
                                                'method' => 'post',
                                                'confirm' => 'Please confirm the duplication of "' . $model->title . '" page.',
                                                'pjax' => 0,
                                            ]
                                        ]);
                                    },

                                    'trash' => function ($url, $model) {

                                        if ($model->status === 'trash') {
                                            $confirm = 'Are you sure? This page will be permanently deleted from the database. You can not undo this action!';
                                        } else {
                                            $confirm = 'Do you want to move this page to trash?';
                                        }

                                        return Html::a('<i class="material-icons text-danger position-relative text-lg">delete</i></i>', $url, [
                                            'title' => "Delete",
                                            'class' => 'btn_delete_page',
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


<script>

$(document).ready(function () {


       sortablePages();


        $(document).on('pjax:success', '#pjax-pages', function (e) {


            sortablePages();
            

        });
        


        function sortablePages() {

            var element = $('#gridview-pages tbody');

            if ($(element).length) {
                
                $(element).sortable({

                    update: function (event, ui) { 

                        var target_obj = $(event.target);

                        var ids = target_obj.find('tr').map(function() {

                            return $(this).data('key');

                        }).get();
                        
                        $.ajax({
                            type: "POST",
                            url: "<?= Url::to([$this->context->id . '/change-sort']); ?>",
                            data: {
                                ids: ids
                            },
                            success: function (response) {
                                
                                if(response.status !== 'success') {

                                    return alert(response.message);

                                } else {

                                    return response.sorted;
                                }
                            }
                        });

                    }
                });
            }
            return false;
        }

});

</script>