<?php
use yii\helpers\Html;

$this->title = 'Админ-панель';
?>

<div class="admin-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Добро пожаловать, <?= Yii::$app->user->identity->username ?>!</p>

    <div class="list-group mt-4" style="max-width: 500px;">
        <?= Html::a('📸 Оценка работ', ['admin/admin-submissions'], [
            'class' => 'list-group-item list-group-item-action',
            'style' => 'font-size: 18px;',
        ]) ?>
        <?= Html::a('📅 Управление конкурсами', ['admin/konkurs'], [
            'class' => 'list-group-item list-group-item-action',
            'style' => 'font-size: 18px;',
        ]) ?>

