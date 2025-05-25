<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->registerCssFile('@web/css/contacts.css');
$this->title = 'Обратная связь';
?>

<div class="portfolio-form">
    <div class="form-header">
        <h2><?= Html::encode($this->title) ?></h2>
        <div class="form-divider"></div>
    </div>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>
        <div class="alert alert-success">
            Спасибо! Ваш вопрос был успешно отправлен. Мы свяжемся с вами в ближайшее время.
        </div>
    <?php else: ?>

        <div class="form-group">
            <p>Если у вас есть вопрос, заполните форму ниже. Все поля, кроме описания, обязательны.</p>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <?php $form = ActiveForm::begin(); ?>

                <div class="form-group">
                    <?= $form->field($model, 'question')->textarea([
                        'class' => 'form-control',
                        'placeholder' => 'Введите ваш вопрос'
                    ])->label('Вопрос') ?>
                </div>

                <div class="form-group">
                    <?= $form->field($model, 'description')->textarea([
                        'class' => 'form-control',
                        'placeholder' => 'Подробное описание проблемы (необязательно)'
                    ])->label('Описание') ?>
                </div>

                <div class="form-group">
                    <?= $form->field($model, 'contacts')->textInput([
                        'class' => 'form-control',
                        'placeholder' => 'Ваши контакты для связи (почта, телефон и т.д.)'
                    ])->label('Контактная информация') ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'submit-btn']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>

    <?php endif; ?>
</div>
<style>
    .portfolio-form input:focus,
    .portfolio-form textarea:focus {
        border-color: #ffaa2d !important;
        box-shadow: 0 0 0 0.2rem rgba(255, 170, 45, 0.25) !important;
        outline: none;
    }
</style>
