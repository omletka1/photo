<?php
/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->registerCssFile('@web/css/login.css');
$this->title = 'Вход в систему';
?>

<style>

</style>

<div class="login-container">
    <div class="login-header">
        <h1>Вход в систему</h1>
        <div class="login-divider"></div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'username')->textInput([
                'autofocus' => true,
                'class' => 'form-control',
                'placeholder' => 'Введите ваш email'
            ])->label('Email') ?>

            <?= $form->field($model, 'password')->passwordInput([
                'class' => 'form-control',
                'placeholder' => 'Введите ваш пароль'
            ])->label('Пароль') ?>

            <?= $form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class=\"remember-me\">{input} {label}</div>",
                'labelOptions' => ['style' => 'padding-left: 5px;']
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('ВОЙТИ', [
                    'class' => 'login-btn',
                    'name' => 'login-button'
                ]) ?>
            </div>

            <?php ActiveForm::end(); ?>

            <div class="signup-link">
                Нет аккаунта? <?= Html::a('ЗАРЕГИСТРИРОВАТЬСЯ', ['site/signup']) ?>
            </div>
        </div>
    </div>
</div>