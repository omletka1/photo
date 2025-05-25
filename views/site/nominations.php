<?php
use yii\helpers\Html;
use yii\widgets\ListView;

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
