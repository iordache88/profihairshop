<?php 

use yii\helpers\Url;

?>
<form method="POST" class="uploadLayout" enctype="multipart/form-data" action="<?= Url::to(['builder/uploadlayout']); ?>">
    <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>" />
    <input type="hidden" name="action" value="upload" />
    <input type="hidden" name="page" value="<?= $post['page'] ?>" />

    <div class="modal-header">
        <h4 class="modal-title text-center w-100">Upload layout from JSON file</h4>
    </div>

    <div class="modal-body">
        <input type="file" class="p-5" required="" name="fileToUpload" />
    </div>

    <div class="modal-footer">

        <button type="button" data-dismiss="modal" class="btn btn-sm btn-secondary">Close</button>
        <button type="submit" class="btn btn-sm btn-primary">Upload</button>

    </div>

</form>