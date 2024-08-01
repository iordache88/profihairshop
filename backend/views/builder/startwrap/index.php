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
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Attributes</label>
                        <input type="text" name="attributes" class="form-control" value="<?= $data['attributes'] ?>" />
                        <small>Write them inline like this - ex: data-something="somevalue" data-other="othervalue"</small>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Element tag</label>
                        <select name="element" class="form-control" value="<?= $data['element']; ?>">
                            <option value="div">
                                < div>
                            </option>
                            <option value="span">
                                < span>
                            </option>
                            <option value="section">
                                < section>
                            </option>
                            <option value="form">
                                < form>
                            </option>
                            <option value="aside">
                                < aside>
                            </option>
                            <option value="main">
                                < main>
                            </option>
                            <option value="header">
                                < header>
                            </option>
                            <option value="footer">
                                < footer>
                            </option>
                            <option value="table">
                                < table>
                            </option>
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