<?php

use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'form-edit-page-type',
    'action' => ['page-type/edit', 'id' => $model->id],
    'fieldConfig' => [
        'template' => "<div class=\"input-group input-group-static\">{label}\n{input}\n{error}</div>",
        'labelOptions' => ['class' => ''],
        'inputOptions' => ['class' => 'form-control'],
    ],
]);

 ?>

<div class="modal-header">
    <h5 class="modal-title">Add Page Type</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <?= $form->field($model, 'name_singular')->label('Name singular (ex. Article)'); ?>
    <?= $form->field($model, 'name_plural')->label('Name plural (ex. Articles)'); ?>
    <?= $form->field($model, 'status')->dropDownList($model->statusList); ?>
    <?= $form->field($model, 'icon')->label('Material icon - select or type name'); ?>

    <div class="page-type-icons-box" style="max-height: 300px; overflow: auto;">
        <?php 
        $materialIcons = [
            'article' => ['description', 'article', 'notes'],
            'project' => ['assignment', 'work', 'build'],
            'page' => ['insert_drive_file', 'description', 'file_copy'],
            'blog' => ['rss_feed', 'text_snippet', 'post_add'],
            'gallery' => ['photo_library', 'collections', 'image'],
            'contact' => ['contacts', 'contact_page', 'person'],
            'home' => ['home', 'house', 'home_work'],
            'about' => ['info', 'info_outline', 'person'],
            'portfolio' => ['work', 'folder_special', 'assignment_ind'],
            'service' => ['build', 'settings', 'handyman'],
            'faq' => ['help_outline', 'live_help', 'question_answer']
        ];
         ?>
         <?php 
         foreach($materialIcons as $material_category => $icons) {
            ?>
            <div style="background: rgba(0,0,0,0.05); max-width: 95%;" class="p-3 mb-3">
                
                <p><?= ucfirst($material_category); ?></p>
                <?php
                foreach ($icons as $icon) {
                    ?>
                    <button type="button" class="btn p-0 me-4 btn-select-material-icon" data-icon="<?= $icon; ?>">
                        <i class="material-icons" style="font-size: 30px;"><?= $icon; ?></i>
                        <span style="text-transform: lowercase; font-size: 13px;"><?= $icon; ?></span>
                    </button>
                    <?php
                }
                ?>
            </div>
            <?php
         }
          ?>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-sm btn-primary">Save</button>
</div>


<?php 

ActiveForm::end();

?>