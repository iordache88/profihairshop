<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\grid\ActionColumn;

$this->title = 'Page Types | ' . Yii::$app->name;
?>

<div class="container-fluid my-3 py-3">
    <div class="row mb-5">

        <div class="col-lg-12 mt-lg-0 mt-4">

            <div class="card">
                <div class="card-header">

                    <h5>Page types</h5>

                    <div class="row mt-4 justify-content-end">
                        <div class="col align-self-end">

                            <button type="submit" class="btn btn-success btn-sm mb-0 btn_modal_add_page_type"><i class="fas fa-plus"></i>&nbsp;&nbsp;Add</button>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">

                    <div class="table-responsive">
                        <div class="dataTable-wrapper">

                            <div class="dataTable-container">
                                <?php Pjax::begin(['id' => 'pjax-logs']); ?>

                                <?= GridView::widget([
                                    'id' => 'gridview-logs',
                                    'dataProvider' => $dataProvider,
                                    'filterModel' => $searchModel,
                                    'tableOptions' => ['class' => 'table table-striped table-flush dataTable-table'],
                                    'columns' => [
                                        [
                                            'attribute' => 'id',
                                        ],
                                        [
                                            'attribute' => 'name_singular',
                                        ],
                                        [
                                            'attribute' => 'name_plural',
                                        ],
                                        [
                                            'attribute' => 'type',
                                        ],
                                        [
                                            'attribute' => 'icon',
                                        ],
                                        [
                                            'attribute' => 'status',
                                            'value' => function($model) {
                                                return $model->statusList[$model->status];
                                            }
                                        ],
                                        [
                                            'class' => ActionColumn::class,
                                            'template' => '{edit} {delete}',
                                            'contentOptions' => ['class' => 'text-right'],
                                            'headerOptions' => ['style' => 'width: 50px;'],
                                            'buttons' => [



                                                'edit' => function ($url, $model) {


                                                    return Html::a('<i class="material-icons text-info position-relative text-lg">drive_file_rename_outline</i></i>', ['page-type/open-edit-modal', 'id' => $model->id], [
                                                        'title' => "Edit",
                                                        'class' => 'me-3 btn_modal_edit_page_type',
                                                        'data-pjax' => 0,
                                                    ]);
                                                },


                                                'delete' => function ($url, $model) {

                                                    
                                                    $confirm = 'Are you sure? You can not undo this action!';

                                                    return Html::a('<i class="material-icons text-danger position-relative text-lg">delete</i></i>', ['page-type/delete', 'id' => $model->id], [
                                                        'title' => "Delete",
                                                        'class' => '',
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
    
$(document).ready(function () {
    
    $(document).on('click', '.btn_modal_add_page_type', function (e) {

        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "<?= Url::to(['page-type/open-add-modal']) ;?>",
            cache: false,
            processData: false,
            beforeSend: function() {

                $('.loading').show();
            },
            success: function (response) {


                $('.loading').hide();
                
                $('#modalGeneral .modal-content').html(response);
                $('#modalGeneral').modal('show');
            }
        });
        
        return false;
    });


    $(document).on('click', '.btn_modal_edit_page_type', function (e) {

        e.preventDefault();
        var url = $(this).attr('href');

        $.ajax({
            type: "POST",
            url: url,
            cache: false,
            processData: false,
            beforeSend: function() {

                $('.loading').show();
            },
            success: function (response) {


                $('.loading').hide();
                
                $('#modalGeneral .modal-content').html(response);
                $('#modalGeneral').modal('show');
            }
        });
        
        return false;
    });



    $(document).on('click', '.btn-select-material-icon', function (e) {

        e.preventDefault();
        var val = $(this).data('icon');

        $('#pagetype-icon').val(val).attr('value', val);
        return false;
    });



    $(document).on('click', '.btn_save_page_type_and_create_files', function (e) {

        e.preventDefault();
        var form = $('#form-add-page-type');

        if(!form.length) {
            return false;
        }

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn bg-gradient-success',
                cancelButton: 'btn bg-gradient-danger'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: 'Confirm...',
            text: "Please make sure that all the fields are right, then click \"Create\".",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Create',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {

            if (result.value) {

                var fd = new FormData(form[0]);

                $.ajax({
                    type: "post",
                    url: "<?= Url::to(['page-type/add']); ?>",
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {

                        $('.loading').show();
                    },
                    success: function (response) {

                        console.log(response);
                        $('.loading').hide();

                        if(response.status === 'success') {
                            window.location.reload(true);
                        } else {
                            alert(response.message);
                        }

                    }
                });
            }

        });

    });



});

</script>