<?php 


use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Settings | ' . Yii::$app->name;
?>

<script src="/backend/web/js/ace/ace.js" type="text/javascript" charset="utf-8"></script>

<div class="container-fluid my-3 py-3">
    <div class="row mb-5">
        <div class="col-lg-3">
            <div class="card position-sticky top-1">
                <?= $this->render('_nav'); ?>
            </div>
        </div>
        <div class="col-lg-9 mt-lg-0 mt-4">
            
            <?php ActiveForm::begin(['id' => 'form-settings']); ?>

            <textarea name="custom_css" id="custom_css_textarea" style="display:none;"></textarea>

            <div class="card">
                <div class="card-header">
                    <h5>Custom CSS</h5>
                </div>
                <div class="card-body pt-0">

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Write CSS stylesheet</label>
                                <div id="custom_css" style="width: 100%; height: 400px;"></div>
                                
                                <script>
                                    var editor = ace.edit("custom_css");
                                    editor.setTheme("ace/theme/solarized_light");
                                    editor.session.setMode("ace/mode/css");
                                    editor.setValue(decodeURIComponent("<?= rawurlencode($custom_css) ?>"), 1);

                                    document.getElementById('form-settings').addEventListener('submit', function() {
                                        document.getElementById('custom_css_textarea').value = editor.getValue();
                                    });
                                </script>
                            </div>

                        </div>
                       
                    </div>

                    
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>