<?php 
use common\models\Projects;
use common\models\Customfield;
?>
<!-- Modal content-->
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
						<label>Columns size</label>
                        <select name="colsize" class="form-control">
                            <option value="6"<?= $data['colsize'] == '6' ? ' selected' : '' ?>>2 columns on row</option>
                            <option value="4"<?= $data['colsize'] == '4' ? ' selected' : '' ?>>3 columns on row</option>
                            <option value="3"<?= $data['colsize'] == '3' ? ' selected' : '' ?>>4 columns on row</option>
                            <option value="2"<?= $data['colsize'] == '2' ? ' selected' : '' ?>>6 columns on row</option>
                        </select>
					</div>
				</div>
                <div class="col-md-6">
					<div class="form-group mb-3">
						<label>Limit</label>
                        <input type="number" min="1" max="500" name="limit" class="form-control" value="<?= $data['limit'] ?>" >
					</div>
				</div>
                <div class="col-md-12 mt-3">
                    <div class="form-group">
                        <p class="m-0">Options</p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
							<label>Featured</label>
                        <?php 
                            $field_featured = Customfield::findOne(['target'=>'projects', 'slug'=>'featured']);

                            if($field_featured == null) : ?>

							<small> Create a checkbox field for projects and name it "featured" for this to work.</small>

                            <?php endif;
                            
                         ?>
                            <select name="featured" class="form-control">
                                <option value="both"<?= $data['featured'] == 'both' ? ' selected' : '' ?>>Both</option>
                                <option value="yes"<?= $data['featured'] == 'yes' ? ' selected' : '' ?>>Only featured</option>
                                <option value="no"<?= $data['featured'] == 'no' ? ' selected' : '' ?>>Only not featured</option>
                            </select>
					</div>
                </div>

				<div class="col-md-6">
                    <div class="form-group">
						<label>Order by</label>
						<select name="order" class="form-control">
                                <option value="title"<?= $data['order'] == 'title' ? ' selected' : '' ?>>Name</option>
								<option value="created_at"<?= $data['order'] == 'created_at' ? ' selected' : '' ?>>Date Added</option>
								<option value="updated_at"<?= $data['order'] == 'updated_at' ? ' selected' : '' ?>>Date Modified</option>
								<option value="ID"<?= $data['order'] == 'ID' ? ' selected' : '' ?>>ID</option>
								<option value="sort"<?= $data['order'] == 'sort' ? ' selected' : '' ?> disabled>Custom</option>
                                
						</select>
					</div>
				</div>

				<div class="col-md-6">
                    <div class="form-group">
						<label>Sort</label>
						<select name="direction" class="form-control">
                                <option value="asc"<?= $data['direction'] == 'asc' ? ' selected' : '' ?>>Ascendent</option>
                                <option value="desc"<?= $data['direction'] == 'desc' ? ' selected' : '' ?>>Descendent</option>
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