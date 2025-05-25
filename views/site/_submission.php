<?php
use yii\helpers\Html;
use yii\helpers\Url;

$images = [];
for ($i = 1; $i <= 5; $i++) {
    $imageField = 'image' . $i;
    if (!empty($model[$imageField])) {
        $images[] = $model[$imageField];
    }
}
$galleryId = 'submission-' . $model['id'];
$isVoted = \app\models\Vote::find()
    ->where(['user_id' => Yii::$app->user->id, 'submission_id' => $model['id']])
    ->exists();
?>

<div class="submission-item">
    <div class="submission-header">
        <div class="submission-title"><?= Html::encode($model['konkurs_title']) ?></div>
        <div class="submission-author"><?= Html::encode($model['user_name'] . ' ' . $model['user_surname']) ?></div>
        <div class="submission-contest"><?= Html::encode($model['title']) ?></div>
    </div>

    <div class="submission-images">
        <?php if (!empty($images)): ?>
            <?php foreach ($images as $image): ?>
                <?php $imagePath = $baseImageUrl . ltrim($image, 'uploads/'); ?>
                <a href="<?= Html::encode($imagePath) ?>" data-lightbox="<?= $galleryId ?>"
                   data-title="<?= Html::encode($model['title']) ?>">
                    <img src="<?= Html::encode($imagePath) ?>" class="submission-image" alt="Работа">
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-images">Изображения отсутствуют</div>
        <?php endif; ?>
    </div>

    <div class="vote-section">
        <?php if (!Yii::$app->user->isGuest): ?>
            <div class="vote-label">
                Голоса:
                <span class="vote-count" id="vote-count-<?= $model['id'] ?>">
                    <?= (int)($model['voteCount'] ?? 0) ?>
                </span>
            </div>
            <button class="vote-button" data-id="<?= $model['id'] ?>"
                    data-voted="<?= $isVoted ? 'true' : 'false' ?>">
                <img src="https://img.icons8.com/?size=100&id=6ER3rS2ZLjRQ&format=png&color=000000"
                     class="heart-icon" alt="Голос">
            </button>
        <?php endif; ?>
    </div>
</div>

<style>
    .vote-section {
        margin-top: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px;
        background-color: #f5f5f5;
        border-radius: 5px;
    }

    .vote-button {
        background: none;
        border: none;
        cursor: pointer;
        padding: 5px;
        transition: all 0.3s;
    }

    .vote-button:hover {
        transform: scale(1.1);
    }


    .heart-icon {
        width: 30px;
        height: 30px;
        transition: all 0.3s;
    }
    .vote-section {
        margin-top: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 15px;
        background-color: #f5f5f5;
        border-radius: 5px;
    }

    .vote-label {
        font-size: 16px;
        font-weight: bold;
        color: #333;
    }

    .vote-count {
        margin-left: 5px;
        color: #ff6b6b;
    }

    .vote-button {
        background: none;
        border: none;
        cursor: pointer;
        padding: 5px;
        transition: transform 0.3s;
    }

    .vote-button:hover {
        transform: scale(1.1);
    }

    .heart-icon {
        width: 30px;
        height: 30px;
        transition: transform 0.3s;
    }

    .vote-button.voted .heart-icon {
        filter: brightness(0.7) sepia(1) hue-rotate(-20deg) saturate(5);
    }

    .vote-count {
        font-size: 16px;
        font-weight: bold;
        color: #ff6b6b;
    }

    [data-voted="true"] .heart-icon {
        filter: brightness(0.8);
    }
</style>