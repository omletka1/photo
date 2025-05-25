<?php

namespace app\commands;

use yii\console\Controller;
use app\models\Konkurs;

class KonkursController extends Controller
{
    public function actionUpdateStatus()
    {
        $today = date('Y-m-d');

        $konkursy = Konkurs::find()
            ->where(['status' => 'открыт'])
            ->andWhere(['<', 'end_date', $today])
            ->all();

        foreach ($konkursy as $konkurs) {
            $konkurs->status = 'закрыт';
            $konkurs->save(false);
            echo "Конкурс '{$konkurs->title}' закрыт.\n";
        }
    }
}
