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

            <textarea name="custom_js" id="custom_js_textarea" style="display:none;"></textarea>

            <div class="card">
                <div class="card-header">
                    <h5>Custom JS</h5>
                </div>
                <div class="card-body pt-0">

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Write custom JS code</label>
                                <div id="custom_js" style="width: 100%; height: 400px;"></div>
                                
                                <script>
                                    var editor = ace.edit("custom_js");
                                    editor.setTheme("ace/theme/solarized_dark");
                                    editor.session.setMode("ace/mode/javascript");
                                    editor.setValue(decodeURIComponent("<?= rawurlencode($custom_js) ?>"), 1);

                                    document.getElementById('form-settings').addEventListener('submit', function() {
                                        document.getElementById('custom_js_textarea').value = editor.getValue();
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