<?php

use yii\widgets\Pjax;
use yii\grid\GridView;
use common\models\User;
use common\models\Tools;
use common\models\Page;
use common\models\Product;
use common\models\Category;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Menu | ' . Yii::$app->name;
?>

<div class="container-fluid my-3 py-3">
    <div class="row mb-5">

        <div class="col-lg-12 mt-lg-0 mt-4">

            <div class="card">
                <div class="card-header">

                    <div class="row">
                        <div class="col align-self-end">

                            <h5>Menu Items</h5>

                            <?php
                            ActiveForm::begin(['id' => 'form-add-new-menu', 'action' => 'add-new-menu']);
                            ?>

                            <div class="row mt-4">
                                <div class="col align-self-end" style="max-width: 240px;">

                                    <div class="input-group input-group-dynamic">
                                        <label class="form-label">Add new menu group</label>
                                        <input type="text" class="form-control" name="title">
                                    </div>
                                </div>
                                <div class="col align-self-end">

                                    <button type="submit" class="btn btn-success btn-sm mb-0"><i class="fas fa-plus"></i>&nbsp;&nbsp;Add</button>
                                </div>
                            </div>

                            <?php
                            ActiveForm::end();
                            ?>

                        </div>


                        <div class="col align-self-end text-end">

                            <button type="button" class="btn btn-success btn-sm btn_add_menu_item mb-0" title="Add menu item"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>



                </div>
                <div class="card-body pt-0">

                    <div class="table-responsive">
                        <div class="dataTable-wrapper">

                            <div class="dataTable-container">
                                <?php Pjax::begin(['id' => 'pjax-menu-items']); ?>

                                <?php

                                if (!empty($searchModel->parent_id)) {

                                    $summary = 'Showing items from "<strong>' . $searchModel::findOne($searchModel->parent_id)->title . '</strong>" menu. <button class="btn btn-danger btn-sm btn_delete_menu_group" data-id="' . $searchModel->parent_id . '"><i class="fas fa-trash"></i>&nbsp;&nbsp;Delete</button>';
                                } else {
                                    $summary = 'Showing items from all menu groups. Select one group in the first left column "MENU".';
                                }
                                ?>

                                <?= GridView::widget([
                                    'id' => 'gridview-menu-items',
                                    'summary' => $summary,
                                    'dataProvider' => $dataProvider,
                                    'filterModel' => $searchModel,
                                    'tableOptions' => ['class' => 'table table-striped table-flush dataTable-table'],
                                    'columns' => [
                                        [
                                            'filter' => ArrayHelper::map($searchModel->find()->andWhere(['parent_id' => 0, 'status' => 10])->orderBy('title asc')->asArray()->all(), 'id', 'title'),
                                            'attribute' => 'parent_id',
                                            'label' => 'Menu',
                                            'format' => 'raw',
                                            'contentOptions' => ['class' => 'td-media-image'],
                                            'value' => function ($model) {

                                                $no_image_src       = \common\models\Tools::adminNoImageSrc();
                                                $uploaded_image_src = \common\models\Media::showImg($model->media_id);

                                                if (empty($uploaded_image_src)) {
                                                    $image_src = $no_image_src;
                                                } else {
                                                    $image_src = $uploaded_image_src;
                                                }

                                                $return = '';

                                                if(!empty($model->media_id)) {

                                                   $return .= '<button class="btn px-1 py-0 text-danger btn_menu_item_remove_media" data-id="' . $model->id . '" title="Remove"><i class="fas fa-times"></i></button>';
                                                }

                                                $return .= '
                                                <div class="upload-image-box">

                                                    <a href="#" data-bs-toggle="modal-multiple" data-bs-target="#modalMedia" data-trigger="menu_item_' . $model->id . '">
                                                        
                                                        <img src="' . $image_src . '" class="img-fluid" />
                                                    </a>
                                                    <div class="upload-image-overlay"><span><i class="fas fa-' . (!empty($model->media_id) ? 'edit' : 'plus' ) . '"></i></span></div>
                                                </div>';

                                                return $return;
                                            }

                                        ],
                                        [
                                            'attribute' => 'title',
                                            'format' => 'raw',
                                            'value' => function ($model) {

                                                $return = Html::beginTag('div', ['class' => 'input-group']);

                                                $return .= Html::activeInput('text', $model, 'title', ['class' => 'form-control update_attribute_ajax', 'data-id' => $model->id, 'data-url' => Url::toRoute('menu/update-attribute'), 'data-attr' => 'title']);

                                                $return .= Html::endTag('div');

                                                return $return;
                                            },
                                        ],

                                        [
                                            'attribute' => 'type',
                                            'filter' => $searchModel->types,
                                            'format' => 'raw',
                                            'value' => function ($model) {

                                                return Html::dropDownList('type', $model->type,  $model->types, ['class' => 'form-control update_attribute_ajax', 'data-id' => $model->id, 'data-url' => Url::toRoute('menu/update-attribute'), 'data-attr' => 'type']);
                                            },
                                        ],

                                        [
                                            'label' => 'Location',
                                            'format' => 'raw',
                                            'value' => function ($model) {

                                                if($model->type === 'url') {

                                                    $return = Html::beginTag('div', ['class' => 'input-group']);

                                                    $return .= Html::activeInput('text', $model, 'url', ['class' => 'form-control update_attribute_ajax', 'data-id' => $model->id, 'data-url' => Url::toRoute('menu/update-attribute'), 'data-attr' => 'url']);

                                                    $return .= Html::endTag('div');
                                                    return $return;

                                                } else {

                                                    if($model->type === 'page') {

                                                        $drop_down_list = ArrayHelper::map(Page::find()->andWhere(['status' => 'public'])->asArray()->all(), 'id', 'title');
                                                    }

                                                    $return = Html::beginTag('div', ['class' => 'input-group']);

                                                    $return .= Html::dropDownList('page', $model->type_id, $drop_down_list, ['class' => 'form-control update_attribute_ajax', 'data-id' => $model->id, 'data-url' => Url::toRoute('menu/update-attribute'), 'data-attr' => 'type_id']);

                                                    $return .= Html::endTag('div');
                                                    return $return;
                                                }

                                            },
                                        ],


                                        [
                                            'attribute' => 'target',
                                            'label' => 'Open in',
                                            'filter' => ['_self' => 'Same window', '_blank' => 'New tab'],
                                            'format' => 'raw',
                                            'value' => function ($model) {



                                                return Html::dropDownList('target', $model->target,  ['_self' => 'Same window', '_blank' => 'New tab'], ['class' => 'form-control update_attribute_ajax', 'data-id' => $model->id, 'data-url' => Url::toRoute('menu/update-attribute'), 'data-attr' => 'target']);
                                            },
                                        ],


                                        [
                                            'attribute' => 'description',
                                            'format' => 'raw',
                                            'value' => function ($model) {

                                                $return = Html::beginTag('div', ['class' => 'input-group']);

                                                $return .= Html::activeTextarea($model, 'description', ['class' => 'form-control update_attribute_ajax', 'data-id' => $model->id, 'data-url' => Url::toRoute('menu/update-attribute'), 'data-attr' => 'description']);

                                                $return .= Html::endTag('div');

                                                return $return;
                                            },
                                        ],


                                        // [
                                        //     'attribute' => 'created_at',
                                        //     'value' => function ($model) {

                                        //         return date('d-m-Y H:i', strtotime($model->created_at));
                                        //     }
                                        // ],
                                        [
                                            'attribute' => 'status',
                                            'filter' => ['9' => 'Hidden', '10' => 'Visible'],
                                            'format' => 'raw',
                                            'value' => function ($model) {

                                                return Html::dropDownList('status', $model->status,  ['9' => 'Hidden', '10' => 'Visible'], ['class' => 'form-control update_attribute_ajax', 'data-id' => $model->id, 'data-url' => Url::toRoute('menu/update-attribute'), 'data-attr' => 'status']);
                                            }
                                        ],

                                        [
                                            'attribute' => 'updated_at',
                                            'filter' => false,
                                            'contentOptions' => ['style' => 'font-size: 13px;'],
                                            'value' => function ($model) {

                                                return date('d-m-Y H:i', strtotime($model->updated_at));
                                            }
                                        ],

                                        [
                                            'class' => 'yii\grid\ActionColumn',
                                            'template' => '{delete}',
                                            'contentOptions' => ['class' => 'text-right'],
                                            'headerOptions' => ['style' => 'width: 55px;'],
                                            'buttons' => [

                                                'delete' => function ($url, $model) {

                                                    return Html::a('<i class="fas fa-trash"></i>', $url, [
                                                        'title' => "Delete",
                                                        'class' => 'btn btn-icon btn-sm btn-danger m-1 btn_delete_menu_item',
                                                        'data' => [
                                                            'pjax' => 0,
                                                            'id' => $model->id,
                                                        ],
                                                    ]);
                                                }
                                            ],
                                        ]
                                    ]
                                ]);
                                ?>


                                <?php Pjax::end(); ?>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        $(document).on('click', '.btn_add_menu_item', function(e) {


            e.preventDefault();

            $.ajax({
                type: "POST",
                url: "<?= Url::to(['menu/add-menu-item']); ?>",
                cache: false,
                data: {
                    '_csrf-backend': $('[name="csrf-token"]').attr('content'),
                    Menu: {
                        parent_id: "<?= Yii::$app->request->queryParams['Menu']['parent_id']; ?>"
                    }
                },
                success: function(response) {

                    if (response.status === 'success') {

                        $.pjax.reload('#pjax-menu-items');

                    } else {
                        alert(response.message);
                    }
                }
            });

            return false;
        });



        $(document).on('click', '.btn_delete_menu_group', function(e) {

            e.preventDefault();

            var id = $(this).data('id')


            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn bg-gradient-success',
                    cancelButton: 'btn bg-gradient-danger'
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: 'Are you sure',
                text: "The menu will be deleted!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete!',
                cancelButtonText: 'No, cancel...',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {

                    var id = $(this).data('id');

                    $.ajax({
                        type: "post",
                        url: "<?= Url::to(['menu/delete-group']); ?>",
                        data: {
                            id: id,
                        },

                        beforeSend: function() {

                            $('.loading').show();
                        },
                        success: function(response) {

                            $('.loading').hide();

                            if (response.status == 'success') {

                                window.location = response.url;
                            } else {
                                alert(response.message);
                            }
                        }
                    });
                }

            });


            return false;
        });


        $(document).on('click', '.btn_delete_menu_item', function(e) {

            e.preventDefault();

            var id = $(this).data('id')


            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn bg-gradient-success',
                    cancelButton: 'btn bg-gradient-danger'
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: 'Are you sure',
                text: "The menu item will be deleted!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete!',
                cancelButtonText: 'No, cancel...',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {

                    var id = $(this).data('id');

                    $.ajax({
                        type: "post",
                        url: "<?= Url::to(['menu/delete-item']); ?>",
                        data: {
                            id: id,
                        },

                        beforeSend: function() {

                            $('.loading').show();
                        },
                        success: function(response) {

                            $('.loading').hide();

                            if (response.status == 'success') {

                                $.pjax.reload('#pjax-menu-items');


                            } else {
                                alert(response.message);
                            }
                        }
                    });
                }

            });


            return false;
        });



        $(document).on('click', '.btn_menu_item_remove_media', function(e) {

            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                type: "POST",
                url: "<?= Url::to(['menu/remove-media']); ?>",
                data: {
                    id: id,
                },
                beforeSend: function() {

                    $('.loading').show();
                },
                success: function(response) {

                    $('.loading').hide();

                    if (response.status == 'success') {

                        $.pjax.reload('#pjax-menu-items');

                    } else {
                        alert(response.message);
                    }
                }
            });

        });


        sortableMenu();


        $(document).on('pjax:success', '#pjax-menu-items', function (e) {


            sortableMenu();
            

        });
        


        function sortableMenu() {

            var element = $('#gridview-menu-items tbody');

            if ($(element).length) {
                
                $(element).sortable({

                    update: function (event, ui) { 

                        var target_obj = $(event.target);

                        var ids = target_obj.find('tr').map(function() {

                            return $(this).data('key');

                        }).get();
                        
                        $.ajax({
                            type: "POST",
                            url: "<?= Url::to(['menu/change-sort']); ?>",
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