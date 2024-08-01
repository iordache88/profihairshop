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
						<label>Link</label>
                        <input type="text" name="link" class="form-control" value="<?= $data['link'] ?>" >
					</div>
				</div>
                <div class="col-md-6">
					<div class="form-group">
						<label>Text</label>
                        <input type="text" name="text" class="form-control" value="<?= $data['text'] ?>">
					</div>
				</div>
                <div class="col-md-6">
					<div class="form-group">
						<label>Type</label>
                        <select name="type" class="form-control">
                            <option value="initial"<?= $data['type'] == 'initial' ? ' selected' : '' ?>>Not set</option>
                            <option value="primary"<?= $data['type'] == 'primary' ? ' selected' : '' ?>>Primary</option>
                            <option value="secondary"<?= $data['type'] == 'secondary' ? ' selected' : '' ?>>Secondary</option>
                        </select>
					</div>
				</div>
                <div class="col-md-6">
					<div class="form-group">
						<label>Open in</label>
                        <select name="target" class="form-control">
                            <option value="initial"<?= $data['target'] == 'initial' ? ' selected' : '' ?>>Same window</option>
                            <option value="_blank"<?= $data['target'] == '_blank' ? ' selected' : '' ?>>New tab</option>
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