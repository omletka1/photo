<?php
use yii\helpers\Html;

/** @var array $model */

$image = $model['image'] ?? 'default.jpg';
$imageUrl = Yii::getAlias('@web/images/' . $image);
?>

<div style="border: 1px solid #eee; border-radius: 12px; overflow: hidden; background: #fafafa; display: flex; flex-direction: column; height: 100%;">
    <div style="height: 330px; overflow: hidden;">
        <img src="<?= Html::encode($imageUrl) ?>" alt="<?= Html::encode($model['title']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
    </div>
    <div style="padding: 20px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
        <div>
            <h3 style="font-size: 1.4rem; color: #ff8c00; margin: 0 0 10px;"><?= Html::encode($model['title']) ?></h3>
            <p style="color: #555; font-size: 0.95rem; line-height: 1.5;"><?= Html::encode($model['description']) ?></p>
        </div>
        <div style="margin-top: 20px;">
            <?= Html::a('Участвовать', ['site/submission', 'id' => $model['id']], [
                'class' => 'participate-btn',
                'style' => '
                    display: inline-block;
                    padding: 10px 20px;
                    background: linear-gradient(to right, #ffaa2d, #ff8c00);
                    color: white;
                    border-radius: 5px;
                    font-weight: 600;
                    text-transform: uppercase;
                    font-size: 0.85rem;
                    text-decoration: none;
                    transition: all 0.3s ease;
                ',
                'onmouseover' => "this.style.transform='translateY(-2px)'",
                'onmouseout' => "this.style.transform='none'"
            ]) ?>
        </div>
    </div>
</div>
