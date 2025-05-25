<style>
    /* Основные стили в стиле Portfolio Award */
    body {
        background-color: #000000;
    }
    .portfolio-form {
        max-width: 800px;
        margin: 40px auto;
        padding: 40px;
        background-color: #fff;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        border-radius: 8px;
    }

    .form-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .form-header h2 {
        font-size: 36px;
        font-weight: 700;
        color: #000;
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    :root {
        --accent-color: #ffaa2d;
    }

    /* Акцентная линия */
    .form-divider {
        border-top: 3px solid var(--accent-color);
        width: 80px;
        margin: 25px auto;
    }


    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 16px;
        color: var(--accent-color);
    }
    .form-control:focus {
        outline: none;
        border-color: var(--accent-color);
        box-shadow: 0 0 8px rgba(255, 170, 45, 0.4);
    }



    .form-control {
        width: 100%;
        padding: 12px 15px;
        font-size: 16px;
        border: 2px solid #000;
        border-radius: 4px;
        background-color: #f8f8f8;
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='black'%3e%3cpath d='M7 10l5 5 5-5z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 15px;
    }

    /* Стили для загрузки файлов */
    .file-input-container {
        border: 2px dashed #000;
        padding: 20px;
        text-align: center;
        border-radius: 4px;
        margin-bottom: 20px;
    }

    .file-input-label {
        font-weight: 600;
        display: block;
        margin-bottom: 10px;
    }

    /* Стили для кнопки */
    .submit-btn {
        background-color: #ffaa2d;
        color: #fff;
        border: none;
        padding: 15px 30px;
        font-size: 18px;
        font-weight: bold;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: background-color 0.3s;

    }

    .submit-btn:hover {
        background-color: #e38c0f;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(255, 170, 45, 0.3);
    }

    /* Стили для превью изображений */
    .image-previews {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 20px;
    }

    .image-preview {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border: 2px solid #000;
    }
    .portfolio-form:hover {
        background-color: #fffaf5;
        transition: background-color 0.4s;
    }
</style>
<?php

$this->registerCssFile('@web/css/submission.css');
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Konkurs;

$this->title = 'Участие в конкурсе';

$items = Konkurs::find()
    ->where(['status' => 'открыт'])
    ->select(['title'])
    ->indexBy('id')
    ->column();

$isGuest = Yii::$app->user->isGuest ? 'true' : 'false';

?>

<style>
</style>

<div class="portfolio-form">
    <div class="form-header">
        <h2>Участие в конкурсе</h2>
        <div class="form-divider"></div>
    </div>

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'class' => 'award-form'
    ]); ?>

    <div class="form-group">
        <?= $form->field($model, 'title')->textarea([
            'class' => 'form-control',
            'placeholder' => 'Название работы'
        ])->label('Название работы') ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'description')->textarea([
            'class' => 'form-control',
            'placeholder' => 'Описание работы'
        ])->label('Описание') ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'konkurs_id')->dropDownList(
            $items,
            [
                'class' => 'form-control',
                'prompt' => 'Выберите конкурс'
            ]
        )->label('Конкурс') ?>
    </div>

    <div class="form-group">
        <div class="file-input-container">
            <?= $form->field($model, 'imageFile[]')->fileInput([
                'multiple' => true,
                'accept' => 'image/*',
                'style' => 'display: none;'
            ])->label('Загрузите фотографии (максимум 5)', [
                'class' => 'file-input-label'
            ]) ?>
            <p>Перетащите файлы сюда или кликните для выбора</p>
            <p class="file-count" style="margin-top: 10px; font-weight: bold; color: #555;"></p>
            <p class="file-warning" style="color: red; display: none; font-weight: bold;"></p>

        </div>

        <div class="image-previews">
            <?php for ($i = 1; $i <= 5; $i++) {
                $attr = 'image' . $i;
                if ($model->$attr) {
                    echo Html::img('/' . $model->$attr, [
                        'class' => 'image-preview',
                        'style' => 'margin: 10px'
                    ]);
                }
            } ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Отправить заявку', [
            'class' => 'submit-btn',
            'name' => 'submit'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isGuest = <?= $isGuest ?>;
        const form = document.querySelector('.award-form');
        const fileInput = document.querySelector('input[type="file"]');
        const previewContainer = document.querySelector('.image-previews');
        const fileCountText = document.querySelector('.file-count');
        const fileWarning = document.querySelector('.file-warning');

        form.addEventListener('submit', function(e) {
            if (isGuest) {
                e.preventDefault();
                window.location.href = '/site/login';
            }
        });

        fileInput.addEventListener('change', function () {
            const files = this.files;
            const maxFiles = 5;
            previewContainer.innerHTML = '';

            if (files.length > maxFiles) {
                fileWarning.textContent = `Вы можете загрузить не более ${maxFiles} файлов.`;
                fileWarning.style.display = 'block';
            } else {
                fileWarning.style.display = 'none';
            }

            const displayCount = Math.min(files.length, maxFiles);
            fileCountText.textContent = `Вы выбрали ${displayCount} файл(а)/ов.`;

            for (let i = 0; i < displayCount; i++) {
                const file = files[i];
                if (file.type.match('image.*')) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'image-preview';
                        img.style.margin = '10px';
                        previewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });
    });
</script>
