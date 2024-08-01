<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\GlobalSection $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="page-form">

    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => "<div class=\"input-group input-group-dynamic\">{label}\n{input}\n{error}</div>",
            'labelOptions' => ['class' => 'form-label'],
            'inputOptions' => ['class' => 'form-control'],
        ],
    ]); ?>

    <input type="hidden" name="layout" value="<?= $idLayout ?>" />

    <div class="row">

        <div class="col-md-9">
            
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">

                            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>

                    <div class="builder-box">

                        <?php

                        if(!empty($model->id) && $this->context->action->id === 'edit') {

                            echo Yii::$app->runAction('builder/index', ['page' => $model, 'type'=>'globalsection']);
                            
                        } else {

                            echo Yii::$app->runAction('builder/index', ['page'=>null, 'type'=>'globalsection', 'id'=>$idLayout]);
                        }
                        ?>
                    </div>

                </div>
            </div>

        </div>

        <div class="col-md-3">

            <div class="card">
                <div class="card-body">
                    <?= $form->field($model, 'status', ['labelOptions' => ['class' => ''], 'template' => "<div class=\"input-group input-group-static\">{label}\n{input}\n{error}</div>"])->dropDownList($model->statusList); ?>

                    <?= Html::submitButton('Save', ['class' => 'btn btn-success w-100']) ?>
                </div>
            </div>

        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
