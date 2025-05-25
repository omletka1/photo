<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\Submission;
use yii\data\ActiveDataProvider;

class AccountController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['my-works'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionMyWorks()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Submission::find()->where(['user_id' => Yii::$app->user->id])->orderBy(['created_at' => SORT_DESC]),
            'pagination' => ['pageSize' => 10],
        ]);

        return $this->render('my-works', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionProfile()
    {
        $model = Yii::$app->user->identity;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Профиль обновлён');
            return $this->refresh();
        }

        return $this->render('profile', ['model' => $model]);
    }

}