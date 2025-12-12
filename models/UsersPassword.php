<?php

namespace app\models;

use yii\base\Model;

class UsersPassword extends Model
{

    public $password;
    public $passwordConfirm;

    public function rules()
    {
        return [
            [['password', 'passwordConfirm'], 'required'],
            ['password', 'compare', 'compareAttribute' => 'passwordConfirm']
        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => 'Password',
            'passwordConfirm' => 'Password Confirmation'
        ];
    }
}
