<?php 

use common\models\Projects;
use backend\models\Categories;
use common\models\Customfield;
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
						<label>Section (page type)</label>
                        <select name="type" class="form-control type_of_fields">
                        	<option value=""></option>

                        	<?php
                        		$types = Customfield::find()->where(['ID_parent'=>NULL])->groupBy(['target'])->all();
                        		foreach ($types as $type) {
                        	?>
                                <option value="<?= $type->target ?>"<?= $data['type'] == $type->target ? ' selected' : '' ?>><?= ucfirst($type->target) ?></option>

                        	<?php
                        		}
                        	?>

                        </select>
                    </div>
                </div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Field name</label>
                        <select name="field_id" class="form-control field_module_select_field_id">
                            <?php 

                                $fields = Customfield::findAll(['target' => $data['type'], 'ID_parent'=>NULL, 'status' => 1]);

                                if(empty($fields)) {
                                    echo '<option value="">Select type first</option>';
                                } else{

                                    foreach ($fields as $field)
                                        {
                                            echo '<option value="'.$field->ID.'" '.($data['field_id'] == $field->ID ? 'selected' : '').' >'.$field->title.'</option>';
                                        }
                                }


                             ?>
                        </select>
					</div>
				</div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Field value</label>
                        <div class="value-options-ajax-recipient">
                            <?php 
                            $field_check = Customfield::findOne($data['field_id']);

                            if(is_object($field_check)) {

                                echo $this->render('_value-options', ['field' => $field_check, 'data' => $data]);

                            } else {

                                echo "<input placeholder='Select field first' readonly class='form-control'>";

                            }
                            ?>
                        </div>
                    </div>
                </div>

				<div class="col-md-4">
					<div class="form-group">
						<label>Columns size</label>
						<select name="colsize" class="form-control">
                            <option value="12"<?= $data['colsize'] == '12' ? ' selected' : '' ?>>1 column on row</option>
							<option value="6"<?= $data['colsize'] == '6' ? ' selected' : '' ?>>2 columns on row</option>
							<option value="4"<?= $data['colsize'] == '4' ? ' selected' : '' ?>>3 columns on row</option>
							<option value="3"<?= $data['colsize'] == '3' ? ' selected' : '' ?>>4 columns on row</option>
							<option value="2"<?= $data['colsize'] == '2' ? ' selected' : '' ?>>6 columns on row</option>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group mb-3">
						<label>Limit</label>
						<input type="number" min="1" max="500" name="limit" class="form-control" value="<?= $data['limit'] ?>" >
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group mb-3">
						<label>Pagination</label>
						<select name="pagination" class="form-control">
							<option value="0" <?= $data['pagination'] == '0' ? ' selected' : '' ?>>No</option>
							<option value="1" <?= $data['pagination'] == '1' ? ' selected' : '' ?>>Yes</option>
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
							<option value="sort"<?= $data['order'] == 'sort' ? ' selected' : '' ?>>Custom</option>
							
							<?php 
                            if (!empty($data['type'])) {
                                $fields_pagetype = Customfield::findAll(['target' => $data['type']]);

                                if (!empty($fields_pagetype)) {
                                    echo "<option disabled style='background: #51bcda; color: #fff;'>Custom fields:</option>";
                                    foreach ($fields_pagetype as $field_pagetype){
                                        $selected = $data['order'] == $field_pagetype->slug ? 'selected' : '';
                                        echo "<option value='{$field_pagetype->slug}' {$selected}>{$field_pagetype->title}</option>";
                                    }
                                }
                            }
							?> 
								
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