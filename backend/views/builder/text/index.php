<?php 

use yii\helpers\Url;
?>
<!-- Modal content-->
<form method="POST" action="<?= Url::to(['builder/savemodule']); ?>">
    <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
    <input type="hidden" name="action" value="<?= $action ?>">
    <input type="hidden" name="page" value="<?= $page ?>">
    <input type="hidden" name="item" value="<?= $item ?>">
    <input type="hidden" name="column" value="<?= $column ?>">
    <input type="hidden" name="module" value="<?= $module ?>">

	<div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title text-center"><?= $info['title'] ?></h4>
		</div>
		<div class="modal-body">

		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label>ID</label>
					<input type="text" name="_id" class="form-control" value="<?= $data['_id'] ?>" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Class</label>
					<input type="text" name="_class" class="form-control" value="<?= $data['_class'] ?>" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group color-picker">
					<label>Color</label>
					<span class="colorpicker-input colorpicker-input--position-right">
			            <input id="dc-ex-module<?= $item ?><?= $column ?><?= $module ?>" name="color" type="text" value="<?= $data['color'] ?>" class="form-control color-input input input_color">
			            <span id="dc-ex-module<?= $item ?><?= $column ?><?= $module ?>-anchor" class="colorpicker-custom-anchor colorpicker-circle-anchor">
			              <span class="colorpicker-circle-anchor__color" data-color></span>
			            </span>
			        </span>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label>Text</label>
					<textarea name="bodyContent" class="form-control" id="ckeditor"><?= $bodyContent ?></textarea>
				</div>
			</div>
		</div>

		<div class="modal-footer">
        	<button type="submit" class="btn btn-info btn-sm btn-submit-column"><i class="fas fa-check"></i> Update</button>
        </div>
	</div>
</form>