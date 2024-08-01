<?php 


use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;

$this->title = 'Global Sections | ' . Yii::$app->name;
?>

<div class="container-fluid my-3 py-3">
    <div class="row mb-5">

        <div class="col-lg-12 mt-lg-0 mt-4">
            
            <div class="card">
                <div class="card-header">
                    <h5>Global Sections (widgets)</h5>

                    <div class="row mt-4">
                        <div class="col align-self-end">

                            <a href="<?= Url::to(['global-section/add']); ?>" class="btn btn-success btn-sm mb-0"><i class="fas fa-plus"></i>&nbsp;&nbsp;Add</a>
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
                                            'attribute' => 'name',
                                            'format' => 'raw',
                                            'value' => function($model) {

                                                return Html::a($model->name, ['edit', 'id' => $model->id], ['data-pjax' => 0]);
                                            }
                                        ],
                                        [
                                            'attribute' => 'created_at',
                                            'value' => function($model) {

                                                return date('d-m-Y H:i', strtotime($model->created_at));
                                            }
                                        ],
                                        [
                                            'attribute' => 'updated_at',
                                            'value' => function($model) {

                                                return date('d-m-Y H:i', strtotime($model->created_at));
                                            }
                                        ],
                                        [
                                            'filter' => $searchModel->statusList,
                                            'attribute' => 'status',
                                            'format' => 'raw',
                                            'value' => function($model) {

                                                return Html::dropDownList('status', $model->status,  $model->statusList, ['class' => 'form-control update_attribute_ajax', 'data-id' => $model->id, 'data-url' => Url::toRoute('global-section/update-attribute'), 'data-attr' => 'status']);
                                            }
                                        ],
                                        [
                                            'class' => ActionColumn::class,
                                            'template' => '{edit} {delete}',
                                            'contentOptions' => ['class' => 'text-right'],
                                            'headerOptions' => ['style' => 'width: 50px;'],
                                            'buttons' => [

                                                'delete' => function ($url, $model) {
                                                    
                                                    $confirm = 'Are you sure? You can not undo this action!';

                                                    return Html::a('<i class="material-icons text-danger position-relative text-lg">delete</i></i>', ['global-section/delete', 'id' => $model->id], [
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