<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public $new_password;
    public $new_password_repeat;

    public static function tableName()
    {
        return 'user';
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
     //   return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
     //   return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password);
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            [['username', 'email'], 'string', 'max' => 255],
            ['email', 'email'],
            [['new_password', 'new_password_repeat'], 'string', 'min' => 6],
            ['new_password_repeat', 'compare', 'compareAttribute' => 'new_password', 'message' => 'Пароли не совпадают.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'email' => 'Email',
            'new_password' => 'Новый пароль',
            'new_password_repeat' => 'Повторите новый пароль',
        ];
    }

    public function beforeSave($insert)
    {
        if (!empty($this->new_password)) {
            $this->password = \Yii::$app->security->generatePasswordHash($this->new_password);
        }
        return parent::beforeSave($insert);
    }
}
