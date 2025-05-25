<?php
/** @var yii\web\View $this */

$this->registerCssFile('@web/css/rules.css');
use yii\helpers\Html;

$this->title = 'Правила конкурса Portfolio Award';
?>



<div class="rules-container">
    <div class="rules-header">
        <h1>ПРАВИЛА PHOTO STUDIO</h1>
        <div class="rules-divider"></div>
    </div>

    <div class="rules-section">
        <h2>О ПРЕМИИ</h2>
        <p>PHOTO STUDIO — масштабная онлайн-фотопремия для любителей и профессиональных фотографов.</p>
        <p>Ms — Wfolio и Celtans собрали главных представителей Российской фотоиндустрии для организации самого масштабного фотоконкурса в стране с призовым фондом более 500 000 рублей.</p>
    </div>

    <div class="rules-divider"></div>

    <div class="rules-section">
        <h2>КЛЮЧЕВЫЕ ДАТЫ</h2>

        <h3>ФЕСТИВАЛЬ</h3>
        <p>В МОСКВЕ 24 МАЯ</p>

        <h3>КОНКУРС</h3>
        <p>Прием работ с 01.04 до 01.05</p>

        <h3>НАГРАЖДЕНИЕ</h3>
        <p>Главный приз — SAMON R8</p>
        <p>Общий призовой фонд — 500 000 ₽</p>
    </div>

    <div class="rules-divider"></div>

    <div class="rules-section">
        <h2>ОСНОВНЫЕ ПРАВИЛА</h2>
        <ul class="rules-list">
            <li>Конкурс открыт для профессиональных фотографов и любителей старше 18 лет</li>
            <li>Участник может подать не более 3 работ в каждой номинации</li>
            <li>Фотографии должны быть сделаны не ранее 2023 года</li>
            <li>Допускается минимальная обработка фотографий (цветокоррекция, кадрирование)</li>
            <li>Запрещается использование чужих фотографий или элементов</li>
            <li>Организаторы оставляют право использовать работы участников в promotional-материалах</li>
            <li>Решения жюри окончательны и не подлежат обжалованию</li>
        </ul>
    </div>

    <div class="rules-divider"></div>

    <div class="rules-section">
        <h2>НОМИНАЦИИ</h2>
        <div>
            <span class="nomination-tag">Портрет</span>
            <span class="nomination-tag">Свадьба</span>
            <span class="nomination-tag">Путешествия</span>
            <span class="nomination-tag">Природа</span>
            <span class="nomination-tag">Уличная фотография</span>
            <span class="nomination-tag">Фэшн</span>
            <span class="nomination-tag">Архитектура</span>
            <span class="nomination-tag">Ч/Б фотография</span>
            <span class="nomination-tag">Концептуальная фотография</span>
            <span class="nomination-tag">Документальная фотография</span>
        </div>
    </div>

    <?= Html::a('УЧАСТВОВАТЬ', ['/site/submission'], ['class' => 'submit-btn']) ?>
</div>