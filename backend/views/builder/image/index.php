<?php 

use common\models\Media;
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
					<div class="form-group">
						<label>Class</label>
						<input type="text" name="_class" class="form-control" value="<?= $data['_class'] ?>" />
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Open action</label>
						<select name="open" class="form-control" data-show="open">
							<option value="none" <?php if($data['open'] == 'none') { echo 'selected=""'; } ?>>None</option>
							<option value="lightbox" <?php if($data['open'] == 'lightbox') { echo 'selected=""'; } ?>>Lightbox</option>
							<option value="link" <?php if($data['open'] == 'link') { echo 'selected=""'; } ?>>Link</option>
						</select>
					</div>

					<div class="form-group <?php if($data['open'] != 'lightbox') { echo 'hide'; } ?> open hs-lightbox">
						<label>Show title</label>
						<select name="title" class="form-control">
							<option value="1" <?php if($data['title'] == 1) { echo 'selected=""'; } ?> >Yes</option>
							<option value="0" <?php if($data['title'] == 0) { echo 'selected=""'; } ?>>No</option>
						</select>
					</div>

					<div class="form-group <?php if($data['open'] != 'link') { echo 'hide'; } ?> open hs-link">
						<label>Url</label>
						<input type="text" class="form-control" name="url" value="<?= $data['url'] ?>" />
					</div>

					<div class="form-group <?php if($data['open'] != 'link') { echo 'hide'; } ?> open hs-link">
						<label>Target</label>
						<select name="target" class="form-control">
							<option value="_self" <?php if($data['target'] == '_self') { echo 'selected=""'; } ?>>_self</option>
							<option value="_blank" <?php if($data['target'] == '_blank') { echo 'selected=""'; } ?>>_blank</option>

						</select>
					</div>
				</div>
			</div>

			<div class="upload-image-box mb-4">
				<a href="#" data-bs-toggle="modal-multiple" data-bs-target="#modalMedia" data-trigger="module_image_<?= $page . $item . $column . $module; ?>">
					<?php 
					$no_image_src       = \common\models\Tools::adminNoImageSrc();
					$uploaded_image_src = \common\models\Media::showImg($data['image']);

					if(empty($uploaded_image_src)) {
						$image_src = $no_image_src;
					} else {
						$image_src = $uploaded_image_src;
					}
					?>
					<img src="<?= $image_src; ?>" class="img-fluid" />
				</a>
				<input type="hidden" class="form-control input_image" name="image" value="<?= $data['image']; ?>"/>
				<div class="upload-image-overlay"><span><i class="fas fa-edit"></i>&nbsp;Change...</span></div>
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