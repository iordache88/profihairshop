<?php
use common\models\Tools;
use common\models\Media;
use yii\helpers\Url;

$titleRow = 'Add section';
$idRow = '';
$classRow = '';
$bgTypeRow = '';
$bgInfoRow = '';
$containerRow = '';
$bgColor = '#FFFFFF';
$bgImage = '';

if ($action == 'edit') {
    $data = $_SESSION['layout' . $page][$item];
    $titleRow = 'Edit section ' . $item;
    $idRow = $data['opt']['id'];
    $classRow = $data['opt']['class'];
    $bgTypeRow = $data['opt']['background_type'];
    $bgInfoRow = $data['opt']['background_info'];
    $containerRow = $data['opt']['container'];

    if ($bgTypeRow == 'color') {
        $bgColor = $bgInfoRow;
    } elseif ($bgTypeRow == 'image') {
        $bgImage = $bgInfoRow;
    }
}
?>


<form method="POST" action="<?= Url::to(['builder/row']); ?>">
    <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
    <input type="hidden" name="action" value="<?= $action ?>">
    <input type="hidden" name="page" value="<?= $page ?>">
    <input type="hidden" name="item" value="<?= $item ?>">
    <input type="hidden" name="type" value="<?= $type ?>">

    <?php if ($action != 'remove' && $action != 'clone') : ?>

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center"><?= $titleRow ?></h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group input-group input-group-outline">
                            <label class="w-100">ID</label>
                            <input type="text" name="id" class="form-control" value="<?= $idRow ?>">
                        </div>
                        <div class="form-group input-group input-group-outline">
                            <label class="w-100">Class</label>
                            <input type="text" name="class" class="form-control" value="<?= $classRow ?>">
                        </div>
                        <div class="form-group input-group input-group-outline">
                            <label class="w-100">Container</label>
                            <select class="form-control" name="container">
                                <option value="boxed" <?php if ($containerRow == 'boxed') {
                                                            echo 'selected=""';
                                                        } ?>>Boxed</option>
                                <option value="fullwidth" <?php if ($containerRow == 'fullwidth') {
                                                                echo 'selected=""';
                                                            } ?>>Full width</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group input-group input-group-outline">
                            <label class="w-100">Background type</label>
                            <select class="form-control" name="background_type">
                                <option value="none" <?php if ($bgTypeRow == 'none') {
                                                            echo 'selected=""';
                                                        } ?>>None</option>
                                <option value="color" <?php if ($bgTypeRow == 'color') {
                                                            echo 'selected=""';
                                                        } ?>>color</option>
                                <option value="image" <?php if ($bgTypeRow == 'image') {
                                                            echo 'selected=""';
                                                        } ?>>image</option>
                            </select>
                        </div>

                        <div class="form-group input-group input-group-outline set set-color color-picker hide">
                            <label class="w-100">Background color</label>
                            <span class="colorpicker-input colorpicker-input--position-right">
                                <input id="dc-ex-row<?= $item ?>" name="" type="text" value="<?= $bgColor ?>" class="form-control color-input input input_color">
                                <span id="dc-ex-row<?= $item ?>-anchor" class="colorpicker-custom-anchor colorpicker-circle-anchor">
                                    <span class="colorpicker-circle-anchor__color" data-color></span>
                                </span>
                            </span>
                        </div>

                        <div class="input-group input-group-outline" data-bs-toggle="modal" data-bs-target="#modalMedia" data-trigger="row_<?= $page . $item; ?>">
                            <label class="w-100">Background image url</label>
                            <?php 
                            $no_image_src       = Tools::adminNoImageSrc();
                            $uploaded_image_src = Media::showImg($bgImage);

                            if(empty($uploaded_image_src)) {
                                $image_src = $no_image_src;
                            } else {
                                $image_src = $uploaded_image_src;
                            }
                            ?>
                            <input type="hidden" name="" class="form-control input input_image" value="<?= $bgImage ?>">
                            <div class="featured_preview"><img src="<?= $image_src; ?>"></div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info btn-sm btn-submit"><i class="fas fa-check"></i> <?= $action ?></button>
            </div>
        </div>

    <?php elseif ($action == 'clone') : ?>
        <?php include('_cloneconfirmation.php'); ?>
    <?php else : ?>
        <?php include('_confirmation.php'); ?>
    <?php endif; ?>

</form>