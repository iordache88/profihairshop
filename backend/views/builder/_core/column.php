<?php

use common\models\Tools;
use common\models\Media;
use yii\helpers\Url;

$titleColumn = 'Add column';
$idRow = $item;
$bgTypeColumn = '';
$bgInfoColumn = '';
$bgImgColumn = '';
$colorColumn = '';
$sizeColumn = '';
$idColumn = '';
$classColumn = '';
$bgColor = '#FFFFFF';
$bgImage = '';

if ($action == 'edit') {
    $data = $_SESSION['layout' . $page][$item][$column];
    $titleColumn = 'Edit column ' . $column . ' from row ' . $item;
    $bgTypeColumn = $data['background_type'];
    $bgInfoColumn = $data['background_info'];
    $colorColumn = $data['color'];
    $sizeColumn = $data['size'];
    $idColumn = $data['id'];
    $classColumn = $data['class'];

    if ($bgTypeColumn == 'color') {
        $bgColor = $bgInfoColumn;
    } elseif ($bgTypeColumn == 'image') {
        $bgImage = $bgInfoColumn;
    }
}
?>

<form method="POST" action="<?= Url::to(['builder/column']); ?>">
    <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
    <input type="hidden" name="action" value="<?= $action ?>">
    <input type="hidden" name="page" value="<?= $page ?>">
    <input type="hidden" name="item" value="<?= $item ?>">
    <input type="hidden" name="column" value="<?= $column ?>">
    <input type="hidden" name="type" value="<?= $type ?>">

    <?php if ($action != 'remove' && $action != 'clone') : ?>

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center"><?= $titleColumn ?></h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group input-group input-group-outline">
                            <label class="w-100">ID</label>
                            <input type="text" name="id" class="form-control" value="<?= $idColumn ?>">
                        </div>
                        <div class="form-group input-group input-group-outline">
                            <label class="w-100">Class</label>
                            <input type="text" name="class" class="form-control" value="<?= $classColumn ?>">
                        </div>
                        <div class="form-group  input-group input-group-outline color-picker">
                            <label class="w-100">Text color</label>
                            <span class="colorpicker-input colorpicker-input--position-right">
                                <input id="dc-ex<?= $idRow ?>-02" name="color" type="text" value="<?= $colorColumn ?>" class="form-control color-input">
                                <span id="dc-ex<?= $idRow ?>-02-anchor" class="colorpicker-custom-anchor colorpicker-circle-anchor">
                                    <span class="colorpicker-circle-anchor__color" data-color></span>
                                </span>
                            </span>
                        </div>
                        <div class="form-group input-group input-group-outline">
                            <label class="w-100">Size</label>
                            <select class="form-control" name="size">
                                <?php
                                for ($c = 1; $c <= 12; $c++) {

                                    $selected = '';
                                    if ('col-lg-' . $c == $sizeColumn || empty($sizeColumn) && $c == 12) {
                                        $selected = 'selected=""';
                                    }
                                    echo '<option value="col-lg-' . $c . '" ' . $selected . '>col ' . $c . '/12</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group input-group input-group-outline">
                            <label class="w-100">Background type</label>
                            <select class="form-control" name="background_type">
                                <option value="none" <?php if ($bgTypeColumn == 'none') {
                                                            echo 'selected=""';
                                                        } ?>>None</option>
                                <option value="color" <?php if ($bgTypeColumn == 'color') {
                                                            echo 'selected=""';
                                                        } ?>>color</option>
                                <option value="image" <?php if ($bgTypeColumn == 'image') {
                                                            echo 'selected=""';
                                                        } ?>>image</option>
                            </select>
                        </div>

                        <div class="form-group  input-group input-group-outline set set-color color-picker hide">
                            <label class="w-100">Background color</label>
                            <span class="colorpicker-input colorpicker-input--position-right">
                                <input id="dc-ex<?= $idRow ?>-01" name="" type="text" value="<?= $bgColor ?>" class="form-control color-input input input_color">
                                <span id="dc-ex<?= $idRow ?>-01-anchor" class="colorpicker-custom-anchor colorpicker-circle-anchor">
                                    <span class="colorpicker-circle-anchor__color" data-color></span>
                                </span>
                            </span>
                        </div>

                        <div class="form-group  input-group input-group-outline set set-image multi hide" data-bs-toggle="modal" data-bs-target="#modalMedia" onclick="setupModal('multi');">
                            <label class="w-100">Background image url</label>
                            <?php
                            $no_image_src       = Tools::adminNoImageSrc();
                            $uploaded_image_src = Media::showImg($bgImage);

                            if (empty($uploaded_image_src)) {
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
                <button type="submit" class="btn btn-info btn-sm btn-submit-column"><i class="fas fa-check"></i> <?= $action ?></button>
            </div>
        </div>

    <?php elseif ($action == 'clone') : ?>
        <?php include('_cloneconfirmation.php'); ?>
    <?php else : ?>
        <?php include('_confirmation.php'); ?>
    <?php endif; ?>

</form>