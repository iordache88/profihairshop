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
    <input type="hidden" name="type" value="<?= $type ?>">

	<div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title text-center"><?= $info['title'] ?></h4>
		</div>
		<div class="modal-body">

		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label>Label title</label>
					<input type="text" name="label" class="form-control" value="<?= $data['label'] ?>" />
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label>ID</label>
					<input type="text" name="_id" class="form-control" value="<?= $data['_id'] ?>" />
				</div>
			
				<div class="form-group">
					<label>Class</label>
					<input type="text" name="_class" class="form-control" value="<?= $data['_class'] ?>" />
				</div>

				<div class="form-group">
					<label>Multiple select</label>
					<select name="multiple" class="form-control">
						<option value="1" <?php if($data['multiple'] == 1) { echo 'selected=""'; } ?>>Yes</option>
						<option value="0" <?php if($data['multiple'] == 0) { echo 'selected=""'; } ?>>No</option>
					</select>
				</div>
			
				<div class="form-group">
					<label>Required</label>
					<select name="required" class="form-control">
						<option value="1" <?php if($data['required'] == 1) { echo 'selected=""'; } ?>>Yes</option>
						<option value="0" <?php if($data['required'] == 0) { echo 'selected=""'; } ?>>No</option>
					</select>
				</div>
			</div>
		
			<div class="col-md-8">
				<div id="sortable-options" class="form-group options">
					<label>Options</label>
					<?php
						if(!empty($data['options']))
						{
							foreach(json_decode($data['options'], true) as $i=>$option)
							{
								echo '<p id="opt-' . $i . '"><span class="handle"><i class="fa fa-arrows"></i></span><input type="text" name="options[]" class="form-control" value="' . $option . '" /><button type="button" data-id="' . $i . '" class="btn btn-simple btn-link nomargin btn-sm btn-danger delOpt"><i class="fa fa-times"></i></button></p>';
							}
						}
					?>
				</div>
				<div class="form-group text-center">
					<button type="button" class="btn btn-simple btn-link btn-sm btn-info addOpt"><i class="fa fa-plus"></i></button>
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