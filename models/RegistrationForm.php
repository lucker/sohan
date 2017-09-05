<?php

namespace app\models;

use Yii;
use yii\base\Model;

class RegistrationForm extends Model
{
    public $password;
    public $email;
	public $login;

    public function rules()
    {
        return [
            [['email', 'password','login'], 'required'],
            ['email', 'email'],
        ];
    }
}