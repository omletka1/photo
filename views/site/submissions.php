<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;

$this->registerCssFile('@web/css/submissions.css');
$this->title = 'Работы участников';
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js', [
    'depends' => [\yii\web\JqueryAsset::class]
]);
?>

    <head>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
        <meta name="csrf-token" content="<?= Yii::$app->request->csrfToken ?>">
        <?php
        $this->registerCssFile('https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css');
        $this->registerJsFile('https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js', [
            'depends' => [\yii\web\JqueryAsset::class]
        ]);
        ?>

    </head>
<style>
    .submissions-container {
        font-family: 'Helvetica Neue', Arial, sans-serif;
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px 15px;
        background-color: #fafafa;
        border-radius: 10px;
        box-shadow: 0 3px 15px rgba(0,0,0,0.05);
    }



    h1 {
        font-size: 2rem;
        color: #222;
        text-align: center;
        margin-bottom: 1.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        position: relative;
        padding-bottom: 10px;
    }

    h1:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: #ffaa2d;
        border-radius: 2px;
    }
    .filter {
        display: flex;
        justify-content: center;
        margin-bottom: 1.5rem;
    }

    .filter-select {
        background-color: #fafafa;
        color: #333;
        border-radius: 6px;
        padding: 0.6rem 1rem;
        font-size: 1rem;
        font-weight: 600;
        border: 2px solid #ffaa2d;
        margin-right: 10px;
        transition: border-color 0.3s ease;
    }

    .filter-select:hover {
        border-color: #ff8c00;
    }

    .submission-item {
        background: #fff;
        border-radius: 10px;
        margin-bottom: 1.8rem;
        overflow: hidden;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        position: relative;
    }

    .submission-item:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(to bottom, #ffaa2d, #ff8c00);
    }

    .submission-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .submission-header {
        padding: 1.2rem;
        background: #fff;
    }

    .submission-title {
        font-size: 1.3rem;
        color: #ff8c00;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 0.6rem;
    }

    .submission-author {
        font-size: 0.95rem;
        color: #555;
        font-weight: 500;
        margin-bottom: 0.3rem;
        display: flex;
        align-items: center;
    }

    .submission-author:before {
        content: '👤';
        margin-right: 6px;
        font-size: 0.8em;
    }

    .submission-contest {
        font-size: 1rem;
        color: #333;
        font-weight: 600;
        display: flex;
        align-items: center;
    }

    .submission-contest:before {
        content: '🏆';
        margin-right: 6px;
        font-size: 0.8em;
    }

    .submission-images {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1rem;
        padding: 1.2rem;
        background-color: #f9f9f9;
        border-top: 1px solid #eee;
    }

    .submission-image {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-radius: 6px;
        transition: all 0.2s ease;
        box-shadow: 0 3px 8px rgba(0,0,0,0.08);
        border: 1px solid #eee;
    }

    .submission-image:hover {
        transform: scale(1.02);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .no-images {
        grid-column: 1 / -1;
        text-align: center;
        padding: 2rem;
        color: #999;
        font-style: italic;
        background-color: #f5f5f5;
        border-radius: 6px;
        border: 1px dashed #ddd;
        font-size: 0.9rem;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin: 3rem 0 1rem;
        list-style: none;
        padding: 0;
    }

    .pagination li {
        margin: 0 0.2rem;
    }

    .pagination li a {
        display: block;
        padding: 0.5rem 1rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        color: #555;
        text-decoration: none;
        transition: all 0.2s;
        font-weight: 500;
        background: #fff;
        font-size: 0.9rem;
    }

    .pagination li.active a {
        background: linear-gradient(to right, #ffaa2d, #ff8c00);
        color: #fff;
        border-color: transparent;
        font-weight: 600;
    }

    .pagination li a:hover {
        background: #f5f5f5;
        color: #ff8c00;
    }

    .summary {
        text-align: center;
        color: #777;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
        font-weight: 500;
    }
    .filter select {
        border: 2px solid #ffaa2d;
        padding: 8px 15px;
        font-size: 1rem;
        font-weight: normal;
        color: #333;
        background-color: #fff;
        border-radius: 5px;
        transition: border 0.3s ease;
    }

    .filter select:focus {
        outline: none;
        border-color: #ffaa2d;
    }
    /* Стили для иконки сердца */
    .heart-icon {
        width: 40px;
        height: 40px;
        transition: transform 0.3s ease, filter 0.3s ease;
    }

    /* Стили при наведении */
    .vote-button:hover .heart-icon {
        transform: scale(1.2);
        filter: brightness(1.2);
    }

    /* Стили при нажатии */
    .vote-button:active .heart-icon {
        filter: brightness(0.8);
    }

    /* Стили для активного состояния (когда пользователь проголосовал) */
    .vote-button[data-voted="true"] .heart-icon {
        filter: brightness(0.5);
    }



    @media (max-width: 768px) {
        .submission-images {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        }

        .submission-image {
            height: 160px;
        }

        h1 {
            font-size: 1.8rem;
        }
    }
</style>

    <div class="submissions-container">
        <h1><?= Html::encode($this->title) ?></h1>

        <div class="filter">
            <form method="get" class="filter-form">
                <select name="konkurs" class="filter-select" onchange="this.form.submit()">
                    <option value="">Все конкурсы</option>
                    <?php foreach ($konkursList as $konkurs): ?>
                        <option value="<?= Html::encode($konkurs->id) ?>"
                            <?= $konkursFilter == $konkurs->id ? 'selected' : '' ?>>
                            <?= Html::encode($konkurs->title) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_submission',
            'viewParams' => ['baseImageUrl' => $baseImageUrl],
            'summary' => 'Показано {begin}-{end} из {totalCount} работ',
            'emptyText' => 'Работы участников пока не добавлены',
            'options' => ['class' => 'submissions-list'],
            'itemOptions' => ['class' => 'submission-item'],
            'pager' => [
                'class' => LinkPager::class,
                'options' => ['class' => 'pagination'],
                'linkOptions' => ['class' => 'page-link'],
                'activePageCssClass' => 'active',
                'disabledPageCssClass' => 'disabled'
            ]
        ]) ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.body.addEventListener('click', async function(e) {
                if (e.target.closest('.vote-button')) {
                    const button = e.target.closest('.vote-button');
                    if (button.classList.contains('processing')) return;

                    const submissionId = button.dataset.id;
                    const isVoted = button.dataset.voted === 'true';

                    button.classList.add('processing');

                    try {
                        const formData = new FormData();
                        formData.append('submissionId', submissionId);

                        const response = await fetch('<?= Url::to(['/site/vote']) ?>', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content,
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: formData
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const data = await response.json();

                        if (data.success) {
                            button.dataset.voted = data.voted ? 'true' : 'false';

                            const voteCountElement = button.closest('.vote-section').querySelector('.vote-count');
                            if (voteCountElement) {
                                voteCountElement.textContent = data.voteCount;
                            }

                            const heartIcon = button.querySelector('.heart-icon');
                            if (heartIcon) {
                                heartIcon.style.transform = 'scale(1.5)';
                                setTimeout(() => {
                                    heartIcon.style.transform = 'scale(1)';
                                }, 300);
                            }
                        } else {
                            alert(data.message);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Произошла ошибка. Пожалуйста, попробуйте позже.');
                    } finally {
                        button.classList.remove('processing');
                    }
                }
            });
        });
    </script>


<?php
$this->registerMetaTag([
    'name' => 'csrf-token',
    'content' => Yii::$app->request->csrfToken
]);
?>