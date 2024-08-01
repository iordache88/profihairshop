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

            <textarea name="head_script" id="head_script_textarea" style="display:none;"></textarea>
            <textarea name="body_script" id="body_script_textarea" style="display:none;"></textarea>

            <div class="card">
                <div class="card-header">
                    <h5>Code, scripts</h5>
                </div>
                <div class="card-body pt-0">

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Head Script</label>
                                <div id="head_script" style="width: 100%; height: 400px;"></div>
                                
                                <script>
                                    var editor_head = ace.edit("head_script");
                                    editor_head.setTheme("ace/theme/monokai");
                                    editor_head.session.setMode("ace/mode/html"); // Change to "ace/mode/css" or "ace/mode/javascript" as neede
                                    editor_head.setValue(decodeURIComponent("<?= rawurlencode($head_script) ?>"), 1);

                                    document.getElementById('form-settings').addEventListener('submit', function() {
                                        document.getElementById('head_script_textarea').value = editor_head.getValue();
                                    });
                                </script>
                            </div>

                            <div class="form-group">
                                <label>Body Script</label>
                                <div id="body_script" style="width: 100%; height: 400px;"></div>
                                
                                <script>
                                    var editor_body = ace.edit("body_script");
                                    editor_body.setTheme("ace/theme/monokai");
                                    editor_body.session.setMode("ace/mode/html"); // Change to "ace/mode/css" or "ace/mode/javascript" as neede
                                    editor_body.setValue(decodeURIComponent("<?= rawurlencode($body_script) ?>"), 1);

                                    document.getElementById('form-settings').addEventListener('submit', function() {
                                        document.getElementById('body_script_textarea').value = editor_body.getValue();
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