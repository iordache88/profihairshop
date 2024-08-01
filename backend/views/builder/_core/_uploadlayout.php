<form method="POST" class="uploadLayout" enctype="multipart/form-data" action="/backend/web/index.php?r=builder/uploadlayout">
    <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>" />
    <input type="hidden" name="action" value="upload" />
    <input type="hidden" name="page" value="<?= $post['page'] ?>" />

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Upload layout from JSON file</h4>
    </div>

    <div class="modal-body">
        <input type="file" class="p-5" required="" name="fileToUpload" />
    </div>

    <div class="modal-footer">

        <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
        <button type="submit" class="btn btn-primary">Upload</button>

    </div>

</form>