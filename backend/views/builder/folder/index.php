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
					<label for="folder">Folder</label>
					<div class="form-group">
						<select name="folderID" class="form-control" style="text-transform: capitalize;">
							<option value="">-Choose folder-</option>
							<?php 

								$media = new backend\models\Media;

								$folders = $media->findAll(['ID_parent' => 0]);

								foreach ($folders as $folder) {
									
									$selected = $folder->ID == $data['folderID'] ? ' selected' : '';
									echo '<option value="'.$folder->ID.'"'.$selected.'>'.str_replace('-', ' ', $folder->url).'</option>';

								}							
							
							 ?>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<label for="folder">Type</label>
					<div class="form-group">
						<select name="type" class="form-control">
							<option value="mixed"<?= $data['type'] == 'mixed' ? ' selected' : ''?>>Mixed</option>
							<option value="images_only"<?= $data['type'] == 'images_only' ? ' selected' : ''?>>Images Only</option>
							<option value="pdf_only"<?= $data['type'] == 'pdf_only' ? ' selected' : ''?>>PDF Only</option>
							<option value="video_only"<?= $data['type'] == 'video_only' ? ' selected' : ''?> disabled>Video Only (soon)</option>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<label for="folder">Order by</label>
					<div class="form-group">
						<select name="order" class="form-control">
							<option value="rand"<?= $data['order'] == 'rand' ? ' selected' : ''?>>Random</option>
							<option value="title"<?= $data['order'] == 'title' ? ' selected' : ''?>>Title</option>
							<option value="created_at"<?= $data['order'] == 'created_at' ? ' selected' : ''?>>Date added</option>
							<option value="url"<?= $data['order'] == 'url' ? ' selected' : ''?>>Slug</option>
							<option value="alt_title"<?= $data['order'] == 'alt_title' ? ' selected' : ''?>>Alt title</option>
							<option value="ID"<?= $data['order'] == 'ID' ? ' selected' : ''?>>Media ID</option>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<label for="folder">Direction</label> <small>(has no effect if you choose "random")</small>
					<div class="form-group">
						<select name="sort" class="form-control">
							<option value="asc"<?= $data['sort'] == 'asc' ? ' selected' : ''?>>Ascendent</option>
							<option value="desc"<?= $data['sort'] == 'desc' ? ' selected' : ''?>>Descendent</option>
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