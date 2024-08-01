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
			
				<div class="form-group">
					<label>Class</label>
					<input type="text" name="_class" class="form-control" value="<?= $data['_class'] ?>" />
				</div>

				<div class="form-group">
					<label>Controls</label>
					<select class="form-control" name="controls">
						<option value="1" <?php if($data['controls']=='1'){ echo 'selected=""'; } ?>>Yes</option>
						<option value="0" <?php if($data['controls']=='0'){ echo 'selected=""'; } ?>>No</option>
					</select>
				</div>

				<div class="form-group">
					<label>Autoplay</label>
					<select class="form-control" name="autoplay">
						<option value="1" <?php if($data['autoplay']=='1'){ echo 'selected=""'; } ?>>Yes</option>
						<option value="0" <?php if($data['autoplay']=='0'){ echo 'selected=""'; } ?>>No</option>
					</select>
				</div>

				<div class="form-group">
					<label>Loop</label>
					<select class="form-control" name="loop">
						<option value="1" <?php if($data['loop']=='1'){ echo 'selected=""'; } ?>>Yes</option>
						<option value="0" <?php if($data['loop']=='0'){ echo 'selected=""'; } ?>>No</option>
					</select>
				</div>
			</div>

			<div class="col-md-8">
				<div class="form-group">
					<label>Source type</label>
					<select name="type" class="form-control" data-show="type">
						<option value=""></option>
						<option value="upload" <?php if($data['type']=='upload'){ echo 'selected=""'; } ?>>Upload</option>
						<option value="url" <?php if($data['type']=='url'){ echo 'selected=""'; } ?>>Url</option>
					</select>
				</div>
			

				<div class="form-group video <?php if($data['type'] != 'upload') { echo 'hide'; } ?> type hs-upload" data-toggle="modal" data-target="#modalMedia" onclick="setupModal('video')">
					<label>Upload video</label>
					<input type="hidden" class="form-control input input_image" name="video" value="<? echo $data['video']; ?>"/>
		        	<div class="video_title"><input type="text" name="" class="form-control" value="<?= Yii::$app->media->showImg($data['video']) ?>"/></div>
				</div>


				<div class="form-group <?php if($data['type'] != 'url') { echo 'hide'; } ?> type hs-url">
					<label>Url of video (Youtube, Vimeo, etc)</label>
					<input type="text" class="form-control" name="url" value="<?= $data['url'] ?>" />
				</div>

			
				<div class="form-group multi" data-toggle="modal" data-target="#modalMedia" onclick="setupModal('multi')">
					<label>Video thumb</label>
					<input type="hidden" class="form-control input input_image" name="thumb" value="<? echo $data['thumb']; ?>"/>
		        	<div class="featured_preview"><img src="<?= Yii::$app->media->showImg($data['thumb']) ?>"/></div>
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

		<div class="modal-footer">
        	<button type="submit" class="btn btn-info btn-sm btn-submit-column"><i class="fas fa-check"></i> Update</button>
        </div>
	</div>
</form>