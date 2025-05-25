<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

$this->title = 'Главная';

$this->registerCssFile('@web/css/index.css');
$this->registerJs(<<<JS
document.querySelectorAll('.nomination-card img').forEach(img => {
    img.addEventListener('click', () => {
        const overlay = document.querySelector('.lightbox-overlay');
        const lightboxImg = overlay.querySelector('img');
        lightboxImg.src = img.src;
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    });
});
document.querySelector('.lightbox-overlay').addEventListener('click', () => {
    const overlay = document.querySelector('.lightbox-overlay');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
});
JS);
?>
<?php


$this->registerCssFile('@web/css/nominations.css');
$this->title = 'Номинации фотоконкурса';
?>
<div class="nominations-container">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_nomination',
        'summary' => false,
        'emptyText' => '<div class="no-nominations">Номинации пока не добавлены</div>',
        'options' => ['class' => 'nominations-list'],
        'itemOptions' => ['tag' => false],
        'layout' => "{items}\n{pager}",
    ]) ?>
</div>


<div class="lightbox-overlay"><img src="" alt="Просмотр изображения"></div>

<div class="extra-info">
    <h2>Почему выбирают нас?</h2>
    <p>Простой и красивый интерфейс. Современный дизайн. Возможность выделиться и проявить себя. Всё это — у нас!</p>
</div>
