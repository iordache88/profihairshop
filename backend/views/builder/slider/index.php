<!-- Modal content-->
<?php 
use backend\models\Slides;
$sliders = Slides::findAll(['ID_parent'=>0]);
?>
<form method="POST" action="/backend/web/index.php?r=builder/savemodule">
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
						<label>Select slider</label>
                        <p><small>Sliders are edited from Slides panel.</small></p>
                        <select name="slider" class="form-control">
                            <?php 
                                foreach($sliders as $slider) {

                                    $selected = $slider->ID == $data['slider'] ? ' selected' : '';

                                    echo '<option value="'.$slider->ID.'"'.$selected.'>'.$slider->title.'</option>';

                                } 
                            ?>
                        </select>
					</div>
				</div>
                <div class="col-md-6">
					<div class="form-group mb-3">
						<label>Slider type</label>
                        <p><small>Choose "raw" to apply your custom slider scripts and styles.</small></p>
                        <select name="type" class="form-control">
                            <option value="slick"<?= $data['type'] == 'slick' ? ' selected' : '' ?>>Slick slider</option>
                            <option value="m5"<?= $data['type'] == 'm5' ? ' selected' : '' ?> disabled style="opacity: 0.5">M5 slider</option>
                            <option value="bootstrap"<?= $data['type'] == 'raw' ? ' selected' : '' ?> disabled style="opacity: 0.5">Bootstrap slider</option>
                            <option value="raw"<?= $data['type'] == 'raw' ? ' selected' : '' ?>>Raw</option>
                        </select>
					</div>
				</div>
                <div class="col-md-6">
                    <div class="form-group">
						<label>Autoplay</label>
                        <p><small>Select slider autoplay behavior.</small></p>
                        <select name="autoplay" class="form-control">
                            <option value="1"<?= $data['autoplay'] == '1' ? ' selected' : '' ?>>On</option>
                            <option value="0"<?= $data['autoplay'] == '0' ? ' selected' : '' ?>>Off</option>
                        </select>
					</div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
						<label>Delay seconds</label>
                        <p><small>Has no effect when autoplay if off.</small></p>
                        <input type="number" name="delay" class="form-control" value="<?= $data['delay'] ?>" min="3" max="10">
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