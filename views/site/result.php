<?php
use yii\helpers\Html;

$this->registerCssFile('@web/css/result.css');
$this->title = 'Итоги закрытых конкурсов';
?>

<div class="submissions-container">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (empty($results)): ?>
        <p class="no-results">Нет закрытых конкурсов с результатами.</p>
    <?php else: ?>
        <div class="filter">
        </div>

        <?php foreach ($results as $result): ?>
            <div class="submission-item">
                <div class="submission-header">
                    <div class="submission-title"><?= Html::encode($result['konkurs']->title) ?></div>
                    <div class="submission-contest"><?= Html::encode($result['konkurs']->description) ?></div>
                </div>

                <?php if (empty($result['works'])): ?>
                    <p class="no-works no-images">Нет работ для этого конкурса.</p>
                <?php else: ?>
                    <?php foreach ($result['works'] as $index => $work): ?>
                        <div class="submission-item" style="margin: 1rem 0; padding: 1rem;">
                            <div class="submission-title"><?= ($index + 1) . '. ' . Html::encode($work->title) ?></div>
                            <div class="submission-author"><?= Html::encode($work->description) ?></div>

                            <?php
                            $images = [];
                            for ($i = 1; $i <= 5; $i++) {
                                $imgField = 'image' . $i;
                                if (!empty($work->$imgField)) {
                                    $images[] = $work->$imgField;
                                }
                            }
                            ?>
                            <?php if (!empty($images)): ?>
                                <div class="submission-images">
                                    <?php foreach ($images as $image): ?>
                                        <?php $imagePath = $baseImageUrl . $image; ?>
                                        <img src="<?= Html::encode($imagePath) ?>" alt="Фото работы" class="submission-image">
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="no-images">Изображения отсутствуют</div>
                            <?php endif; ?>

                            <div class="submission-contest" style="margin-top: 0.6rem;">
                                <?php
                                switch ($work->status) {
                                    case 1: echo '<span class="gold">🥇 1 место</span>'; break;
                                    case 2: echo '<span class="silver">🥈 2 место</span>'; break;
                                    case 3: echo '<span class="bronze">🥉 3 место</span>'; break;
                                    default: echo '<span class="participant">Участник</span>'; break;
                                }
                                ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<style>

</style>
