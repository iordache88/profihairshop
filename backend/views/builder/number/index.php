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
				<div class="col-md-6">
					<div class="form-group">
						<label>Number</label>
                        <input type="number" min="1" max="1000000" name="number" class="form-control" value="<?= $data['number'] ?>" >
					</div>
				</div>
                <div class="col-md-3">
					<div class="form-group mb-3">
						<label>Show percent</label>
                        <select name="percent" class="form-control">
                            <option value="0"<?= $data['percent'] == '0' ? ' selected' : '' ?>>No</option>
                            <option value="1"<?= $data['percent'] == '1' ? ' selected' : '' ?>>Yes</option>
                        </select>
					</div>
				</div>
                <div class="col-md-3">
                    <div class="form-group">
						<label>Count</label>
                        <select name="count" class="form-control">
                            <option value="1"<?= $data['count'] == '1' ? ' selected' : '' ?>>Yes</option>
                            <option value="0"<?= $data['count'] == '0' ? ' selected' : '' ?>>No</option>
                        </select>
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