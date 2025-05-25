<?php
namespace app\models;

use yii\db\ActiveRecord;

class Nomination extends ActiveRecord
{
    public static function tableName()
    {
        return 'nominations';
    }

    public function rules()
    {
        return [
            [['title', 'description', 'image'], 'required'],
            [['description'], 'string'],
            [['title', 'image'], 'string', 'max' => 255],
        ];
    }
}