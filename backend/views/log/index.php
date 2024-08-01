<?php 


use yii\widgets\Pjax;
use yii\grid\GridView;
use common\models\User;
use yii\helpers\ArrayHelper;
?>

<div class="container-fluid my-3 py-3">
    <div class="row mb-5">

        <div class="col-lg-12 mt-lg-0 mt-4">
            
            <div class="card">
                <div class="card-header">
                    <h5>Logs</h5>
                </div>
                <div class="card-body pt-0">
                    

                    <?php Pjax::begin(['id' => 'pjax-logs']); ?>

                    <?= GridView::widget([
                        'id' => 'gridview-logs',
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'tableOptions' => ['class' => 'table table-striped table-flush dataTable-table'],
                        'columns' => [
                            [
                                'attribute' => 'title',
                            ],
                            [
                                'filter' => $searchModel->categories,
                                'attribute' => 'category',
                            ],
                            [
                                'filter' => $searchModel->types,
                                'attribute' => 'type',
                            ],
                            [
                                'filter' => ArrayHelper::map(User::find()->andWhere(['is_admin' =>  1, 'status' => 10])->asArray()->all(), 'id', 'username'),
                                'attribute' => 'user_id',
                                'value' => function($model) {

                                    return $model->user->name;
                                }
                            ],
                            [
                                'attribute' => 'created_at',
                                'value' => function($model) {

                                    return date('d-m-Y H:i', strtotime($model->created_at));
                                }
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