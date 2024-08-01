<?php

use yii\helpers\Url;

?>

<div class="card mb-4">
    <div class="card-header p-3 pt-2">
        <div class="icon icon-lg icon-shape bg-gradient-dark shadow text-center border-radius-md mt-n4 position-absolute">
            <i class="material-icons opacity-10">perm_media</i>
        </div>
        <div class="text-end pt-1">
            <p class="text-sm mb-0 text-capitalize">Media</p>
            <h5 class="mb-0">
                <?= @count($media_items); ?>
            </h5>
        </div>
    </div>
    <hr class="dark horizontal my-0">
    <div class="card-footer p-3">
        <p class="mb-0"><a href="<?= Url::to(['media/index']); ?>"><i class="fa fa-eye" aria-hidden="true"></i> View library</a></p>
    </div>
</div>