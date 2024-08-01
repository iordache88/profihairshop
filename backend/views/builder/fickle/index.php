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

	<div class="modal-content modal-content-fickle">
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
				<div class="col-md-3">
					<div class="form-group">
						<label>Title tag</label>
                        <select class="form-control" name="title_html_tag">
                            <option value="h4" <?= $data['title_html_tag'] == 'h4' ? 'selected' : '' ?>>H4</option>
                            <option value="h1" <?= $data['title_html_tag'] == 'h1' ? 'selected' : '' ?>>H1</option>
                            <option value="h2" <?= $data['title_html_tag'] == 'h2' ? 'selected' : '' ?>>H2</option>
                            <option value="h3" <?= $data['title_html_tag'] == 'h3' ? 'selected' : '' ?>>H3</option>
                            <option value="h5" <?= $data['title_html_tag'] == 'h5' ? 'selected' : '' ?>>H5</option>
                            <option value="h6" <?= $data['title_html_tag'] == 'h6' ? 'selected' : '' ?>>H6</option>
                            <option value="paragraph" <?= $data['title_html_tag'] == 'paragraph' ? 'selected' : '' ?>>Paragraph</option>
                        </select>
						
					</div>
				</div>

                <div class="col-md-9">
					<div class="form-group">
						<label>Title</label>
						<input type="text" name="title_text" class="form-control" value="<?= $data['title_text'] ?>" placeholder="Leave empty for no title" />
					</div>
				</div>
			</div>


            <div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label>Subtitle tag</label>
                        <select class="form-control" name="subtitle_html_tag">
                            <option value="paragraph" <?= $data['subtitle_html_tag'] == 'paragraph' ? 'selected' : '' ?>>Paragraph</option>
                            <option value="h6" <?= $data['subtitle_html_tag'] == 'h6' ? 'selected' : '' ?>>H6</option>
                            <option value="h5" <?= $data['subtitle_html_tag'] == 'h5' ? 'selected' : '' ?>>H5</option>
                            <option value="h4" <?= $data['subtitle_html_tag'] == 'h4' ? 'selected' : '' ?>>H4</option>
                            <option value="h3" <?= $data['subtitle_html_tag'] == 'h3' ? 'selected' : '' ?>>H3</option>
                            <option value="h2" <?= $data['subtitle_html_tag'] == 'h2' ? 'selected' : '' ?>>H2</option>
                            <option value="h1" <?= $data['subtitle_html_tag'] == 'h1' ? 'selected' : '' ?>>H1</option>
                        </select>
						
					</div>
				</div>

                <div class="col-md-9">
					<div class="form-group">
						<label>Subtitle</label>
						<input type="text" name="subtitle_text" class="form-control" value="<?= $data['subtitle_text'] ?>" placeholder="Leave empty for no subtitle" />
					</div>
				</div>
			</div>

            
            <div class="row">
                <div class="col-md-8">
					<div class="form-group">
						<label>Layout</label>
                        <select class="form-control" name="view_type">

                            <option value="1" <?= $data['view_type'] == '1' ? 'selected' : '' ?>>Basic: (e.g. title, subtitle, image, description)</option>
                            <option value="2" <?= $data['view_type'] == '2' ? 'selected' : '' ?>>Inline: (e.g. icon on left followed by phone number)</option>
                            
                        </select>
						
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Font awesome icon?</label>
                        <?php 
                            include(Yii::getAlias('@backend/views/builder/fickle/icons.php'));
                            /* @var $fa_icons array */
                        ?>
                        
                        <select class="form-control fa" name="icon">
                            <option value="no">No</option>
                            <?php 
                                foreach($fa_icons as $fa_classname => $fa_code){
                                    $selected = $fa_classname == $data['icon'] ? 'selected' : '';

                                    echo "<option class='fa' value='{$fa_classname}' {$selected}>  &#x{$fa_code};  {$fa_classname}</option>";
                                }
                             ?>
                        </select>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-8">
					<div class="form-group">
						<label>Link?</label>
                        <input type="text" class="form-control" name="link" value="<?=$data['link']?>" placeholder="Paste link or leave empty for no link">
						
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Open in</label>
                        <select class="form-control" name="link_target">

                            <option value="_self" <?= $data['link_target'] == '_self' ? 'selected' : '' ?>>The same window</option>
                            <option value="_blank" <?= $data['link_target'] == '_blank' ? 'selected' : '' ?>>A new tab</option>
                            
                        </select>
                    </div>
                </div>
            </div>

<div class="form-group">
                <div class="row">
                    
                    <div class="col-md-6">
                        <div class="upload-image-box mb-4">
                            <a href="#" data-bs-toggle="modal-multiple" data-bs-target="#modalMedia" data-trigger="module_fickle_image_<?= $page . $item . $column . $module; ?>">
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
                            <?php if(!empty($data['image'])) { ?>
                            <p><a href="#" class="btn btn-danger btn-sm btn-remove-fickle-image" data-no-image-src="<?= $no_image_src; ?>">Remove image</a></p>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="upload-image-box mb-4">
                            <a href="#" data-bs-toggle="modal-multiple" data-bs-target="#modalMedia" data-trigger="module_fickle_background_image_<?= $page . $item . $column . $module; ?>">
                                <?php 
                                $no_image_src       = \common\models\Tools::adminNoImageSrc();
                                $uploaded_image_src = \common\models\Media::showImg($data['background_image']);

                                if(empty($uploaded_image_src)) {
                                    $image_src = $no_image_src;
                                } else {
                                    $image_src = $uploaded_image_src;
                                }
                                ?>
                                <img src="<?= $image_src; ?>" class="img-fluid" />
                            </a>
                            <input type="hidden" class="form-control input_image" name="background_image" value="<?= $data['background_image']; ?>"/>
                            <div class="upload-image-overlay"><span><i class="fas fa-edit"></i>&nbsp;Change...</span></div>
                            <?php if(!empty($data['background_image'])) { ?>
                            <p><a href="#" class="btn btn-danger btn-sm btn-remove-fickle-background-image" data-no-image-src="<?= $no_image_src; ?>">Remove image</a></p>
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="text_content" class="form-control" id="ckeditor"><?= $data['text_content'] ?></textarea>
                    </div>
                </div>
            </div>


			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
                    
						<label>Additional html code</label>
						<textarea name="additional_html_code" class="code-editor" style="min-height: 300px; resize: both"><?= $data['additional_html_code'] ?></textarea>
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