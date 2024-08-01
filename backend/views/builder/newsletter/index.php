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
				<div class="col-md-6">
					<div class="form-group">
						<label>ID</label>
						<input type="text" name="_id" class="form-control" value="<?= $data['_id'] ?>" />
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Class</label>
						<input type="text" name="_class" class="form-control" value="<?= $data['_class'] ?>" />
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Content align</label>
						<select name="contentalign" class="form-control">
							<option value="left" <?php if($data['contentalign'] == 'left') { echo 'selected=""'; } ?>>Left</option>
							<option value="center" <?php if($data['contentalign'] == 'center') { echo 'selected=""'; } ?>>Center</option>
							<option value="right" <?php if($data['contentalign'] == 'right') { echo 'selected=""'; } ?>>Right</option>
						</select>
					</div>
				</div>

				<div class="col-md-12">
					<div class="form-group">
						<label>Title</label>
						<input name="title" class="form-control" value="<?= $data['title'] ?>"></input>
					</div>
				</div>

				<div class="col-md-12">
					<div class="form-group">
						<label>Subtitle</label>
						<textarea name="subtitle" class="form-control"><?= $data['subtitle'] ?></textarea>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Button text</label>
						<input name="buttontext" class="form-control" value="<?= $data['buttontext'] ?>" />
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group color-picker">
						<label>Button background color</label>
						<span class="colorpicker-input colorpicker-input--position-right">
							<input id="dc-ex-module<?= $item ?><?= $column ?><?= $module ?>bg" name="buttonbgcolor" type="text" value="<?= $data['buttonbgcolor'] ?>" class="form-control color-input input input_color">
							<span id="dc-ex-module<?= $item ?><?= $column ?><?= $module ?>bg-anchor" class="colorpicker-custom-anchor colorpicker-circle-anchor">
							<span class="colorpicker-circle-anchor__color" data-color></span>
							</span>
						</span>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group color-picker">
						<label>Button text color</label>
						<span class="colorpicker-input colorpicker-input--position-right">
							<input id="dc-ex-module<?= $item ?><?= $column ?><?= $module ?>txt" name="buttontextcolor" type="text" value="<?= $data['buttontextcolor'] ?>" class="form-control color-input input input_color">
							<span id="dc-ex-module<?= $item ?><?= $column ?><?= $module ?>txt-anchor" class="colorpicker-custom-anchor colorpicker-circle-anchor">
							<span class="colorpicker-circle-anchor__color" data-color></span>
							</span>
						</span>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Admin label</label>
						<input type="text" name="_label" class="form-control" value="<?= $data['_label'] ?>" />
					</div>
				</div>
			</div>

		</div>

		<div class="modal-footer">
        	<button type="submit" class="btn btn-info btn-sm btn-submit-column"><i class="fas fa-check"></i> Update</button>
        </div>
	</div>
</form>