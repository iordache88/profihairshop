<?php 


use yii\widgets\ActiveForm;
use common\models\Tools;
use common\models\Media;

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
                    <h5>General settings</h5>
                </div>
                <div class="card-body pt-0">

                    <div class="row">

                        <div class="col-md-4">

                            <label>Logo</label>
                            <div id="upload-image-box-logo" class="upload-image-box mb-4">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#modalMedia" data-trigger="logo">
                                    <?php 
                                    $logo_id            = $model->findOptionValue('logo');
                                    $no_image_src       = Tools::adminNoImageSrc();
                                    $uploaded_image_src = Media::showImg($logo_id);

                                    if(empty($uploaded_image_src)) {
                                        $image_src = $no_image_src;
                                    } else {
                                        $image_src = $uploaded_image_src;
                                    }
                                    ?>
                                    <img src="<?= $image_src; ?>" data-no-image-src="<?= $no_image_src; ?>" class="img-fluid" />
                                </a>
                                <input type="hidden" class="form-control input_image" name="logo" value="<?= $logo_id; ?>"/>
                                <div class="upload-image-overlay"><span><i class="fas fa-edit"></i>&nbsp;Change...</span></div>
                                <?php 
                                if(!empty($logo_id)) {
                                    ?>
                                    <button type="button" class="btn btn-sm btn-danger btn_remove_uploaded_media_item"><i class="fas fa-times"></i></button>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

                        <div class="col-md-4">

                            <label>Logo B (optional)</label>
                            <div id="upload-image-box-logo-b" class="upload-image-box mb-4">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#modalMedia" data-trigger="logo_b">
                                    <?php 
                                    $logo_b_id          = $model->findOptionValue('logo_b');
                                    $no_image_src       = Tools::adminNoImageSrc();
                                    $uploaded_image_src = Media::showImg($logo_b_id);

                                    if(empty($uploaded_image_src)) {
                                        $image_src = $no_image_src;
                                    } else {
                                        $image_src = $uploaded_image_src;
                                    }
                                    ?>
                                    <img src="<?= $image_src; ?>" data-no-image-src="<?= $no_image_src; ?>" class="img-fluid" />
                                </a>
                                <input type="hidden" class="form-control input_image" name="logo_b" value="<?= $logo_b_id; ?>"/>
                                <div class="upload-image-overlay"><span><i class="fas fa-edit"></i>&nbsp;Change...</span></div>
                                <?php 
                                if(!empty($logo_b_id)) {
                                    ?>
                                    <button type="button" class="btn btn-sm btn-danger btn_remove_uploaded_media_item"><i class="fas fa-times"></i></button>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            
                            <label>Favicon</label>
                            <div id="upload-image-box-favicon" class="upload-image-box mb-4">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#modalMedia" data-trigger="favicon">
                                    <?php 
                                    $favicon_id         = $model->findOptionValue('favicon');
                                    $no_image_src       = Tools::adminNoImageSrc();
                                    $uploaded_image_src = Media::showImg($favicon_id);

                                    if(empty($uploaded_image_src)) {
                                        $image_src = $no_image_src;
                                    } else {
                                        $image_src = $uploaded_image_src;
                                    }
                                    ?>
                                    <img src="<?= $image_src; ?>" data-no-image-src="<?= $no_image_src; ?>" class="img-fluid" />
                                </a>
                                <input type="hidden" class="form-control input_image" name="favicon" value="<?= $favicon_id; ?>"/>
                                <div class="upload-image-overlay"><span><i class="fas fa-edit"></i>&nbsp;Change...</span></div>
                                <?php 
                                if(!empty($favicon_id)) {
                                    ?>
                                    <button type="button" class="btn btn-sm btn-danger btn_remove_uploaded_media_item"><i class="fas fa-times"></i></button>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="input-group input-group-static">
                                    <label>Meta title</label>
                                    <input type="text" class="form-control" placeholder="..." onfocus="focused(this)" onfocusout="defocused(this)" name="meta_title" value="<?= $model->findOptionValue('meta_title'); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group input-group-static">
                                <label>Meta description</label>
                                <textarea onfocus="focused(this)" onfocusout="defocused(this)" class="form-control" placeholder="Scrie descriere pentru SEO..." name="meta_desc"><?= $model->findOptionValue('meta_desc'); ?></textarea>
                            </div>
                        </div>
                    </div>

                    
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>