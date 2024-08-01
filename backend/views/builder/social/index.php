<?php 

use yii\helpers\Url;
?>
<!-- Modal content-->
<?php
	$socialLinks = Yii::$app->settings->show('social_media');
	$socialLinks = unserialize($socialLinks);
	$socialNames = Yii::$app->settings->socialNames();
?>
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
						<label>Show</label>

						<?php
							$empty = 1;
							foreach($socialNames as $key=>$social)
							{
								if($socialLinks[$key] != NULL)
								{
									$checked = '';
									if(json_decode($data['show'], true) != null)
									{
									    if(in_array($key, json_decode($data['show'], true)))
    									{
    										$checked = 'checked=""';
    									}    
									}

									echo '<div class="form-check">';
									echo '<label class="form-check-label">';
									echo '<input type="checkbox" '.$checked.' name="show[]" value="'.$key.'">'.$social;
									echo '<span class="form-check-sign"><span class="check"></span></span>';
									echo '</label>';
									echo '</div>';
									$empty = 0;
								}
							}

							if($empty == 1)
							{
								echo '<p class="text-warning">'.Yii::t('app', 'No social media links are completed').'.</p>';
							}
						?>

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