<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        body {
            font-weight: normal !important;
            background-color: #e5e1d8 !important;
        }

        header, footer {
            background-color: #93867a !important;
        }

        .hover-animate {
            transition: all 0.3s ease;
            color: white;
            font-weight: normal !important;
        }

        .hover-animate:hover {
            color: #ffaa2d;
            transform: scale(1.1);
        }

        @media (max-width: 768px) {
            .navbar-flex,
            .footer-flex {
                flex-direction: column !important;
                align-items: center !important;
                text-align: center;
            }
            .navbar-flex .logo,
            .navbar-flex nav,
            .navbar-flex .action-btn,
            .footer-flex nav,
            .footer-flex .action-btn {
                margin: 10px 0;
            }
        }
    </style>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header style="padding: 20px 0; border-bottom: 1px solid #ffaa2d;">
    <div class="container d-flex justify-content-between align-items-center flex-wrap navbar-flex" style="max-width: 1200px; margin: auto;">
        <div class="logo d-flex align-items-center">
            <?= Html::a(
                Html::img(Yii::getAlias('@web/image/1.png'), ['alt' => 'Логотип', 'style' => 'height: 40px; margin-right: 10px;']) .
                '<span class="hover-animate" style="font-size: 18px;">PHOTO STUDIO</span>',
                ['/site/index'],
                ['class' => 'd-flex align-items-center', 'style' => 'text-decoration: none;']
            ) ?>
        </div>

        <nav class="d-flex flex-wrap justify-content-center align-items-center">
            <?= Html::a('номинации', ['/site/nominations'], ['class' => 'hover-animate mx-2', 'style' => 'text-decoration:none;']) ?>
            <?= Html::a('правила', ['/site/rules'], ['class' => 'hover-animate mx-2', 'style' => 'text-decoration:none;']) ?>
            <?= Html::a('организаторы', ['/site/organizers'], ['class' => 'hover-animate mx-2', 'style' => 'text-decoration:none;']) ?>
            <?= Html::a('галерея', ['/site/submissions'], ['class' => 'hover-animate mx-2', 'style' => 'text-decoration:none;']) ?>
            <?= Html::a('результаты', ['/site/result'], ['class' => 'hover-animate mx-2', 'style' => 'text-decoration:none;']) ?>
            <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role == 1): ?>
                <?= Html::a('админка', ['admin/index'], ['class' => 'hover-animate mx-2', 'style' => 'text-decoration:none;']) ?>
            <?php endif; ?>
            <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role == 0): ?>
                <?= Html::a('профиль', ['/site/profile'], ['class' => 'hover-animate mx-2', 'style' => 'text-decoration:none;']) ?>
            <?php endif; ?>
            <?php if (Yii::$app->user->isGuest): ?>
                <?= Html::a('войти', ['/site/login'], ['class' => 'hover-animate mx-2', 'style' => 'text-decoration:none;']) ?>
            <?php else: ?>
                <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'd-inline']) ?>
                <?= Html::submitButton(
                    'выйти (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link hover-animate mx-2', 'style' => 'color: white; text-decoration: none; padding: 0; border: none; background: none;']
                ) ?>
                <?= Html::endForm() ?>
            <?php endif; ?>
        </nav>
        <div class="action-btn">
            <?= Html::a('Участвовать', ['/site/submission'], [
                'style' => 'background-color: #ffaa2d; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none;',
            ]) ?>
        </div>
    </div>
</header>

<main id="main" class="flex-grow-1 py-4" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer style="padding: 30px 0; border-top: 1px solid #ffaa2d;">
    <div class="container" style="max-width: 1200px;">
        <div class="d-flex justify-content-center flex-wrap mb-3">
            <?= Html::a('номинации', ['/site/nominations'], ['class' => 'hover-animate mx-2', 'style' => 'text-decoration: none;']) ?>
            <?= Html::a('правила', ['/site/rules'], ['class' => 'hover-animate mx-2', 'style' => 'text-decoration: none;']) ?>
            <?= Html::a('организаторы', ['/site/organizers'], ['class' => 'hover-animate mx-2', 'style' => 'text-decoration: none;']) ?>
        </div>

        <div class="d-flex justify-content-end" style="margin-top: -4%;">
            <?= Html::a('Участвовать', ['/site/submission'], [
                'style' => 'background-color: #ffaa2d; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none;',
            ]) ?>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
