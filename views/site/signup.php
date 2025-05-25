<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCssFile('@web/css/signup.css');
$this->title = 'Регистрация';

$this->registerCss('

    
    /* Кнопка */
    .btn-register {
        background-color: #ffaa2d;
        color: white !important; /* Белый текст на кнопке */
        font-weight: bold;
        padding: 12px 30px;
        border: none;
        border-radius: 4px;
        display: block;
        margin: 0 auto;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .btn-register:hover {
        background-color: #ff9500;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(255, 170, 45, 0.4);
    }
    
    .btn-register:active {
        transform: translateY(0);
    }
    
    /* Дополнительные эффекты */
    .form-group fieldset::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background: #ffaa2d;
        transition: width 0.3s ease;
    }
    
    .form-group:hover fieldset::after {
        width: 100%;
    }
');
?>
<div class="registration-container">
    <h1 class="registration-title"><?= Html::encode($this->title) ?></h1>
    <p class="registration-description">Заполните форму для регистрации</p>

    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['id' => 'signup-form']); ?>

            <?= $form->field($us, 'surname')->textInput(['autofocus' => true]) ?>
            <?= $form->field($us, 'name')->textInput() ?>
            <?= $form->field($us, 'username')->textInput() ?>
            <?= $form->field($us, 'password')->passwordInput() ?>
            <?= $form->field($us, 'password_repeat')->passwordInput() ?>
            <?= $form->field($us, 'email')->textInput() ?>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="flexCheckDefault" required>
                <label class="form-check-label" for="flexCheckDefault">
                    Согласен с правилами
                </label>
            </div>

            <div class="form-group">
                <br>
                <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-register', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>