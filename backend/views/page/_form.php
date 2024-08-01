<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\Tools;

/** @var yii\web\View $this */
/** @var common\models\Page $model */
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

    <div class="row">

        <div class="col-md-9">
            
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">

                            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-6">

                            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>

                    <div class="builder-box">

                        <label>Builder</label>

                        <?php

                        if(!empty($model->id) && $this->context->action->id === 'edit') {

                            echo Yii::$app->runAction('builder/index', ['page' => $model]);
                            
                        } else {

                            echo Yii::$app->runAction('builder/index');
                        }
                        ?>
                    </div>

                    <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]); ?>
                    <?= $form->field($model, 'meta_desc')->textarea(['maxlength' => true, 'placeholder' => 'Meta description'])->label(false); ?>
                </div>
            </div>

        </div>

        <div class="col-md-3">

            <div class="card">
                <div class="card-body">
                    <?= $form->field($model, 'status', ['labelOptions' => ['class' => ''], 'template' => "<div class=\"input-group input-group-static\">{label}\n{input}\n{error}</div>"])->dropDownList($model->statusList); ?>

                    <div class="upload-image-box mb-4">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalMedia" data-trigger="page_featured_image">
                            <?php 
                            $no_image_src       = Tools::adminNoImageSrc();
                            $uploaded_image_src = $model->getFeaturedImage();

                            if(empty($uploaded_image_src)) {
                                $image_src = $no_image_src;
                            } else {
                                $image_src = $uploaded_image_src;
                            }
                            ?>
                            <img src="<?= $image_src; ?>" class="img-fluid" />
                        </a>
                        <?= $form->field($model, 'featured_image', ['template' => "{input}"])->hiddenInput(['maxlength' => true]); ?>
                        <div class="upload-image-overlay"><span><i class="fas fa-edit"></i>&nbsp;Change...</span></div>
                    </div>

                    <?php 
                    if(!empty($categories)) {
                        ?>
                        <div class="form-group">
                            <label>Categories</label>
                            <?php 
                            foreach($categories as $category) {
                                ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="category_ids[]" value="<?= $category->id; ?>" <?= in_array($category->id, ArrayHelper::map($model->categories, 'id', 'id')) ? 'checked' : ''; ?>>
                                    <label class="custom-control-label"><?= $category->title; ?></label>
                                </div>
                                <?php

                                if(!empty($category->subcategories)) {

                                    echo $this->render('_subcategories-part', ['model' => $model, 'subcategories' => $category->subcategories, 'level'=> 1]);
                                }
                            }
                            ?>
                        </div>
                        <?php
                    }
                     ?>

                    <?= Html::submitButton('Save', ['class' => 'btn btn-success w-100']) ?>
                </div>
            </div>

        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
