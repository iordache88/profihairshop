<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;

ActiveForm::begin([
    'action' => ['builder/savetolibrary', 'item' => $item, 'type' => $type, 'action' => 'save'],
]);

?>

<div class="modal-header">

    <h4 class="modal-title text-center w-100">Save to library or export</h4>
    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
	
</div>
<div class="modal-body">

    <div class="form-group required">
        <label>Title of <?php echo $type; ?></label>
        <div class="input-group input-group-dynamic">
            <input type="text" class="form-control" name="elementTitle">
        </div>
    </div>

</div>
<div class="modal-footer">
    <a href="<?= Url::to(['builder/exportlayout', 'page' => $page]); ?>" target="_blank" class="btn btn-info">Export file</a>
    <button type="submit" class="btn btn-primary">Save</button>
</div>

<?php ActiveForm::end(); ?>