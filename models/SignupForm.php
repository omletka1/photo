<?php

namespace app\models;

use yii\base\Model;


class SignupForm extends Model
{



    public $username;
    public $password;
    public $email;
    public $password_repeat;
    public $access_token;
    public $surname;
    public $name;

    public function rules(){
        return[
            [['username', 'password', 'name', 'surname'], 'required'],
            ['email', 'email'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
        ];
    }
    public function signup(){
        if (!$this->validate()){
            return null;
        }
        $user = new User();
        $user->username = $this->username;
        $user->name = $this->name;
        $user->surname = $this->surname;
        $user->password = \Yii::$app->security->generatePasswordHash($this->password);
        $user->access_token = \Yii::$app->security->generateRandomString();
        $user->email = $this->email;
        return $user->save() ? $user : null;
    }

    public function attributeLabels(){
        return [
            'username'=>'Логин',
            'password'=>'Пароль',
            'name'=>'Имя',
            'email'=>'емайл',
            'password_repeat'=>'Повтор пароля',
            'surname'=>'Фамилия',
        ];
    }

}