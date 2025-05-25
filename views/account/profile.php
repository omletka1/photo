<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCssFile('@web/css/profile.css');
$this->title = 'Профиль';
?>

<div class="portfolio-form">
    <div class="form-header">
        <h2><?= Html::encode($this->title) ?></h2>
        <div class="form-divider"></div>
    </div>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['class' => 'form-control']) ?>
    <?= $form->field($model, 'email')->textInput(['class' => 'form-control']) ?>
    <h4 style="color: #000000; font-weight: 700; margin-bottom: 20px; display: flex;     justify-content: center;         font-size: 1.9rem;
}
    align-items: center;">Смена пароля</h4>
    <div class="form-divider"></div>



    <?= $form->field($model, 'new_password')->passwordInput(['class' => 'form-control']) ?>
    <?= $form->field($model, 'new_password_repeat')->passwordInput(['class' => 'form-control']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'submit-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
