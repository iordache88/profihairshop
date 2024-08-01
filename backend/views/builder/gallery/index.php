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
						<label>Show image title</label>
						<select name="title" class="form-control">
							<option value="1" <?php if($data['title'] == 1) { echo 'selected=""'; } ?> >Yes</option>
							<option value="0" <?php if($data['title'] == 0) { echo 'selected=""'; } ?>>No</option>
						</select>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label>Show numbers of images</label>
						<select name="meta" class="form-control">
							<option value="1" <?php if($data['meta'] == 1) { echo 'selected=""'; } ?>>Yes</option>
							<option value="0" <?php if($data['meta'] == 0) { echo 'selected=""'; } ?>>No</option>
						</select>
					</div>
				</div>

			</div>

			<hr/>

			<div class="form-group gallery-w-20">
				<div class="sortable-gallery gallery-<?= $column ?><?= $module ?> static showElement" style="display: inline">
					
					<?php
						if(!empty(json_decode($data['gallery'])))
						{
							foreach(json_decode($data['gallery'], true) as $i=>$image)
							{
								echo '<div id="modal_gallery'.$i.'" class="form-group gallery gallery-item">';
						            echo '<input type="hidden" class="form-control input input_image" name="gallery[]" value="'.$image.'">';
						            
						            echo '<div class="featured_preview">';
						            
						            echo '<button type="button" class="btn remove_gallery'.$i.' btn-link btn-simple btn-remove" onclick="removeImg(\''.$column.$module.'\',\'_gallery'.$i.'\')"><i class="fas fa-times-circle"></i></button>';

						        	echo '<img src="'.Yii::$app->media->showImg($image).'"/>';
						       		echo '</div>';

						       	echo '</div>';
							}
						}

					?>

				</div>

				<div class="form-group gallery" style="margin-right: 0" data-toggle="modal" data-target="#modalMedia" onclick="addImg('<?= $column ?><?= $module ?>');"><div class="featured_preview"><i class="fas fa-plus-circle"></i></div></div>
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