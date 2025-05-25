<?php
use yii\helpers\Html;

$this->registerCssFile('@web/css/organizers.css');
$this->title = 'Организаторы';
?>


<div class="organizers-container">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php foreach ($organizers as $org): ?>
        <div class="organizer-card" style="position: relative; padding-bottom: 40px;">
            <img src="<?= Yii::getAlias('@web') . '/images/' . $org->image ?>" alt="<?= Html::encode($org->name) ?>" class="org-image">

            <div class="organizer-info">
                <h3><?= Html::encode($org->name) ?></h3>
                <div class="organizer-role"><?= Html::encode($org->role) ?></div>
                <div class="organizer-description"><?= nl2br(Html::encode($org->description)) ?></div>
                <div class="social-links">
                    <?php if ($org->social_facebook): ?>
                        <a href="<?= Html::encode($org->social_facebook) ?>" target="_blank">VK</a>
                    <?php endif; ?>
                    <?php if ($org->social_instagram): ?>
                        <a href="<?= Html::encode($org->social_instagram) ?>" target="_blank">Telegram</a>
                    <?php endif; ?>
                    <?php if ($org->social_website): ?>
                        <a href="<?= Html::encode($org->social_website) ?>" target="_blank">Website</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Ссылка "Написать" внизу справа -->
            <div style="position: absolute; bottom: 10px; right: 10px;">
                <?= Html::a('Написать', ['/site/contacts'], ['class' => 'write-link']) ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<style>
    .write-link {
        color: #ffaa2d;
        font-weight: 600;
        text-decoration: none;
        font-size: 17px;
    }

    .write-link:hover {
        text-decoration: underline;
    }

</style>

