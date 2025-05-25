<?php

namespace app\controllers;

use app\models\Application;
use app\models\Category;
use app\models\Comments;
use app\models\ContactRequest;
use app\models\Konkurs;
use app\models\News;
use app\models\Nomination;
use app\models\Organizers;
use app\models\SignupForm;
use app\models\Submission;
use app\models\Vote;
use Yii;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'vote'],
                'rules' => [
                    [
                        'actions' => ['logout', 'vote'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['vote'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                    'vote' => ['post'],
                ],
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $konkursy = Konkurs::find()
            ->orderBy(['start_date' => SORT_DESC])
            ->limit(2)
            ->all();

        $nominations = Nomination::find()
            ->limit(2)
            ->all();

        $dataProvider = new ActiveDataProvider([
            'query' => Nomination::find(),
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'title' => SORT_ASC,
                ]
            ],

        ]);
        return $this->render('index', [
            'konkursy' => $konkursy,
            'nominations' => $nominations,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionComend()
    {
        $model = new Comments();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->goBack();
        }
        return $this->render('comend',
            [
                'model' => $model
            ]);
    }

    public function actionCategory()
    {
        $categorys = Category::find()->all();
        return $this->render('category', ['categorys' => $categorys]);
    }

    public function actionNews($id)
    {
        $category = Category::findOne($id);
        $news = News::find()->where(['category_id' => $id])->all();

        return $this->render('news', [
            'category' => $category,
            'news' => $news,
        ]);
    }

    public function actionSignup()
    {
        $us = new SignupForm();
        if ($us->load(Yii::$app->request->post()) && $us->signup()) {
            return $this->goHome();
        }
        return $this->render('signup', [
            'us' => $us
        ]);
    }

    public function actionVote()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::info('Vote request received: ' . print_r(Yii::$app->request->post(), true), 'vote');

        try {
            if (Yii::$app->user->isGuest) {
                throw new \yii\web\ForbiddenHttpException('Авторизуйтесь, чтобы голосовать');
            }

            $submissionId = Yii::$app->request->post('submissionId');
            Yii::info('Submission ID: ' . $submissionId, 'vote');

            if (empty($submissionId)) {
                throw new \yii\web\BadRequestHttpException('ID работы не указан');
            }

            $userId = Yii::$app->user->id;
            Yii::info('User ID: ' . $userId, 'vote');

            $transaction = Yii::$app->db->beginTransaction();

            $existing = Vote::findOne([
                'user_id' => $userId,
                'submission_id' => $submissionId
            ]);

            if ($existing) {
                Yii::info('Existing vote found, deleting...', 'vote');
                if (!$existing->delete()) {
                    throw new \RuntimeException('Не удалось отменить голос');
                }
                $voted = false;
            } else {
                Yii::info('Creating new vote...', 'vote');
                $vote = new Vote();
                $vote->user_id = $userId;
                $vote->submission_id = $submissionId;
                $vote->created_at = date('Y-m-d H:i:s');

                if (!$vote->save()) {
                    Yii::error('Failed to save vote: ' . print_r($vote->errors, true), 'vote');
                    throw new \RuntimeException('Не удалось сохранить голос: '
                        . implode(', ', $vote->getFirstErrors()));
                }
                $voted = true;
            }

            $voteCount = (int)Vote::find()
                ->where(['submission_id' => $submissionId])
                ->count();

            $transaction->commit();

            Yii::info('Vote processed successfully. Count: ' . $voteCount, 'vote');

            return [
                'success' => true,
                'voteCount' => $voteCount,
                'voted' => $voted,
                'message' => $voted ? 'Ваш голос учтён' : 'Голос отменён'
            ];

        } catch (\yii\web\HttpException $e) {
            Yii::warning($e->getMessage(), 'vote');
            return ['success' => false, 'message' => $e->getMessage()];

        } catch (\Exception $e) {
            if (isset($transaction)) {
                $transaction->rollBack();
            }
            Yii::error('Vote error: ' . $e->getMessage() . "\n" . $e->getTraceAsString(), 'vote');
            return [
                'success' => false,
                'message' => 'Ошибка при обработке запроса',
                'debug' => YII_DEBUG ? $e->getMessage() : null
            ];
        }
    }


    public function actionSubmissions()
    {
        $konkursFilter = Yii::$app->request->get('konkurs');
        $baseImageUrl = Yii::getAlias('@web/uploads/');

        $query = (new Query())
            ->select([
                'submission.*',
                'user.name as user_name',
                'user.surname as user_surname',
                'konkurs.title as konkurs_title',
                'COUNT(vote.id) as voteCount'
            ])
            ->addSelect([
                new \yii\db\Expression('SUM(CASE WHEN vote.user_id = :userId THEN 1 ELSE 0 END) as userVoted', [':userId' => Yii::$app->user->id])
            ])
            ->from('submission')
            ->leftJoin('user', 'user.id = submission.user_id')
            ->leftJoin('konkurs', 'konkurs.id = submission.konkurs_id')
            ->leftJoin('vote', 'vote.submission_id = submission.id')
            ->groupBy('submission.id')
            ->orderBy(['voteCount' => SORT_DESC, 'submission.created_at' => SORT_DESC]);


        if ($konkursFilter) {
            $query->andWhere(['submission.konkurs_id' => $konkursFilter]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);

        return $this->render('submissions', [
            'dataProvider' => $dataProvider,
            'baseImageUrl' => $baseImageUrl,
            'konkursList' => Konkurs::find()->all(),
            'konkursFilter' => $konkursFilter,
        ]);
    }

    /**
     * Список работ участников
     * @return string HTML-страница
     */
    public function actionSubmission()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        $model = new Submission();
        $model->user_id = Yii::$app->user->id;

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());

            $model->imageFile = UploadedFile::getInstances($model, 'imageFile');

            if ($model->validate() && $model->upload()) {
                Yii::$app->session->setFlash('success',
                    'Работа успешно сохранена! Загружено ' .
                    count($model->imageFile) . ' файлов.');
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('ошибка',
                    'Ошибка сохранения: ' .
                    print_r($model->errors, true));
            }
        }

        return $this->render('submission', ['model' => $model]);
    }

    public function actionContacts()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
        }

        $model = new ContactRequest();
        $model->user_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('contactFormSubmitted', true);
            return $this->refresh();
        }

        return $this->render('contacts', ['model' => $model]);
    }

    public function actionRules()
    {
        return $this->render('rules');
    }
    public function actionOrganizers()
    {
        $organizers = Organizers::find()->all();
        return $this->render('organizers', [
            'organizers' => $organizers,
        ]);
    }


    public function actionResult()
    {
        $closedContests = Konkurs::find()->where(['status' => 'закрыт'])->all();

        $results = [];

        foreach ($closedContests as $konkurs) {
            // Получаем работы этого конкурса
            $works = Submission::find()
                ->where(['konkurs_id' => $konkurs->id])
                ->orderBy(['status' => SORT_ASC])
                ->all();

            $results[] = [
                'konkurs' => $konkurs,
                'works' => $works,
            ];
        }

        $baseImageUrl = Yii::getAlias('@web/') ;

        return $this->render('result', [
            'results' => $results,
            'baseImageUrl' => $baseImageUrl,
        ]);
    }


    public function actionNominations()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Nomination::find(),
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'title' => SORT_ASC,
                ]
            ],
        ]);

        return $this->render('nominations', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionVotePage($id)
    {
        $submission = Submission::findOne($id);

        if ($submission === null) {
            return $this->render('error', ['message' => 'Работа не найдена']);
        }

        // Выводим страницу голосования
        return $this->render('vote', ['submission' => $submission]);
    }


}