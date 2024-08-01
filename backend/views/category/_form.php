<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\Tools;

/** @var yii\web\View $this */
/** @var common\models\Page $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="category-form">

    <?php $form = ActiveForm::begin([
        'id' => 'form-edit-category',
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


                    <div class="row">
                        <div class="col-12">

                            <div style="display: none;">
                                <?= $form->field($model, 'description')->label(false); ?>
                            </div>

                            <div id="description-editor" style="height: 200px; margin-bottom: 50px;">
                                <?= html_entity_decode($model->description); ?>
                            </div>

                            <script>
                                var quill = new Quill('#description-editor', {
                                    modules: {
                                        toolbar: [
                                        ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
                                        ['blockquote', 'code-block'],
                                        ['link', 'image', 'video', 'formula'],

                                        [{ 'header': 1 }, { 'header': 2 }],               // custom button values
                                        [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
                                        [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
                                        [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
                                        [{ 'direction': 'rtl' }],                         // text direction

                                        [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
                                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

                                        [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
                                        [{ 'font': [] }],
                                        [{ 'align': [] }],

                                        ['clean']                                         // remove formatting button
                                        ],
                                    },
                                    theme: 'snow'
                                });

                                var form = document.getElementById('form-edit-category');

                                form.onsubmit = function() {

                                    var content = document.getElementById('category-description');

                                    content.value = quill.root.innerHTML;
                                };
                            </script>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">

                            <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]); ?>
                        </div>
                        <div class="col-12">

                            <?= $form->field($model, 'meta_desc')->textarea(['maxlength' => true, 'placeholder' => 'Meta description'])->label(false); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">

                            <?= $form->field($model, 'target', ['labelOptions' => ['class' => ''], 'template' => "<div class=\"input-group input-group-static\">{label}\n{input}\n{error}</div>"])->dropDownList($model->targets, ['prompt' => '']); ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'parent_id', ['labelOptions' => ['class' => ''], 'template' => "<div class=\"input-group input-group-static\">{label}\n{input}\n{error}</div>"])->dropDownList(ArrayHelper::map($categories, 'id', 'title'), ['prompt' => '']); ?>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="col-md-3">

            <div class="card">
                <div class="card-body">
                    <?= $form->field($model, 'status', ['labelOptions' => ['class' => ''], 'template' => "<div class=\"input-group input-group-static\">{label}\n{input}\n{error}</div>"])->dropDownList($model->statusList); ?>

                    <div class="upload-image-box mb-4">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalMedia" data-trigger="category_featured_image">
                            <?php
                            $no_image_src       = Tools::adminNoImageSrc();
                            $uploaded_image_src = $model->getFeaturedImage();

                            if (empty($uploaded_image_src)) {
                                $image_src = $no_image_src;
                            } else {
                                $image_src = $uploaded_image_src;
                            }
                            ?>
                            <img src="<?= $image_src; ?>" class="img-fluid" />
                        </a>
                        <?= $form->field($model, 'media_id', ['template' => "{input}"])->hiddenInput(['maxlength' => true]); ?>
                        <div class="upload-image-overlay"><span><i class="fas fa-edit"></i>&nbsp;Change...</span></div>
                    </div>

                    <?= Html::submitButton('Save', ['class' => 'btn btn-success w-100']) ?>
                </div>
            </div>
        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>