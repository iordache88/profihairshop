<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = Yii::$app->name . ' | ADMIN';
?>
<div class="site-login">
    <div class="site-login-inner">
        <h1><?= Html::encode(Yii::$app->name) ?></h1>
        <h2>Admin</h2>

        <p>Completeaza campurile de mai jos pentru a te autentifica:</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Nume utilizaor'); ?>

            <?= $form->field($model, 'password')->passwordInput()->label('Parola'); ?>

            <?= $form->field($model, 'rememberMe')->checkbox()->label('Tine-ma minte'); ?>

            <div class="form-group">
                <?= Html::submitButton('Autentificare', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<style>
body {
    background-image: url('/backend/web/theme/img/bg-login.jpg');
    background-position: center;
    background-size: cover;
    color: rgba(255,255,255,0.9);
}
h1, h2, h3, label, .form-label {
    color: rgba(255,255,255,0.7);
}
.form-control {
    border: 1px solid rgba(255,255,255,0.7) !important;
    padding-left: 0.5rem;
    color: #fff !important;
}
.field-loginform-rememberme .form-check {
    padding-left: 0;
}
#login-form {
    max-width: 380px;
}
.site-login {
    display: flex;
    position: relative;
    justify-content: center;
    align-items: center;
    height: 100vh;
    overflow: hidden;
}
.site-login-inner {

}
</style>