<?php

use yii\widgets\ActiveForm;

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
                    <h5>Header</h5>
                </div>
                <div class="card-body pt-0">

                    <?php 

                    echo Yii::$app->runAction('builder/index', ['page'=>$header, 'type'=>'header']);
                    ?>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>