<?php

namespace app\controllers;

use app\models\Konkurs;
use app\models\Submission;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class AdminController extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        if (in_array($action->id, ['admin-submissions'])) {
            if (Yii::$app->user->isGuest || Yii::$app->user->identity->role != 1) {
                throw new \yii\web\ForbiddenHttpException('Доступ запрещён.');
            }
        }
        return parent::beforeAction($action);
    }
    public function actionKonkurs()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Konkurs::find(),
            'pagination' => ['pageSize' => 10],
        ]);

        return $this->render('konkurs/index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionKonkursCreate()
    {
        $model = new Konkurs();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['konkurs']);
        }

        return $this->render('konkurs/form', ['model' => $model]);
    }

    public function actionKonkursUpdate($id)
    {
        $model = $this->findKonkursModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['konkurs']);
        }

        return $this->render('konkurs/form', ['model' => $model]);
    }

    public function actionKonkursDelete($id)
    {
        $this->findKonkursModel($id)->delete();
        return $this->redirect(['konkurs']);
    }

    protected function findKonkursModel($id)
    {
        if (($model = Konkurs::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Конкурс не найден.');
    }
    public function actionAdminSubmissions()
    {
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => \app\models\Submission::find()->with('user')->orderBy(['created_at' => SORT_DESC]),
        ]);
        if (Yii::$app->request->isPost && Yii::$app->request->post('statuses')) {
            $statuses = Yii::$app->request->post('statuses');
            foreach ($statuses as $id => $status) {
                $submission = \app\models\Submission::findOne($id);
                if ($submission) {
                    $submission->status = (int)$status;
                    $submission->save(false);
                }
            }
            Yii::$app->session->setFlash('success', 'Статусы обновлены.');
            return $this->refresh();
        }
        $query = Submission::find()
            ->select(['submission.*', 'COUNT(vote.id) AS vote_count'])
            ->joinWith('votes', false)
            ->groupBy('submission.id');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'vote_count' => [
                        'asc' => ['vote_count' => SORT_ASC],
                        'desc' => ['vote_count' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Голоса',
                    ],
                    'title',
                    'status',
                ],
                'defaultOrder' => ['vote_count' => SORT_DESC],
            ],
        ]);


        return $this->render('admin-submissions', [
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionIndex()
    {
        return $this->render('index');
    }
}