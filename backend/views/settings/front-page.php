<?php 


use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Settings | ' . Yii::$app->name;
 ?>

<div class="container-fluid my-3 py-3">
    <div class="row mb-5">
        <div class="col-lg-3">
            <div class="card position-sticky top-1">
                <?= $this->render('_nav'); ?>
            </div>
        </div>
        <div class="col-lg-9 mt-lg-0 mt-4">
            
            <?php ActiveForm::begin(['id' => 'form-settings']); ?>

            <div class="card">
                <div class="card-header">
                    <h5>Front page settings</h5>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="input-group input-group-static">
                                    <label>Choose front page</label>

                                    <?= Html::dropDownList('homepage_id', $model->findOptionValue('homepage_id'), $pages, ['class' => 'form-control', 'prompt' => '']); ?>
                                </div>
                            </div>
                        </div>
                       
                    </div>

                    
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Salveaza</button>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>