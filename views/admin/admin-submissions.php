<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCssFile('@web/css/adminkon.css');
$this->title = 'Работы участников';
$this->registerCssFile('@web/css/admin.css');
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

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => ['class' => 'table table-bordered table-striped table-custom'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'title',
                    'label' => 'Название',
                    'contentOptions' => ['style' => 'vertical-align: middle'],
                ],
                [
                    'attribute' => 'vote_count',
                    'label' => 'Голоса',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return $model->vote_count ?? 0;
                    },
                    'contentOptions' => ['style' => 'vertical-align: middle; font-weight: bold'],
                ],
                [
                    'attribute' => 'status',
                    'label' => 'Статус (место)',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return Html::dropDownList(
                            "statuses[{$model->id}]",
                            $model->status,
                            [
                                0 => 'Участник',
                                1 => '🥇 1 место',
                                2 => '🥈 2 место',
                                3 => '🥉 3 место',
                            ],
                            ['class' => 'form-control custom-select']
                        );
                    },
                    'contentOptions' => ['style' => 'vertical-align: middle'],
                ],
            ],
        ]); ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить изменения', ['class' => 'submit-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
