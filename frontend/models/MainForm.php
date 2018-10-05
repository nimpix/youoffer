<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\LoginForm;

class MainForm extends Model
{
    public $name;
    public $password;

    public function rules()
    {
        return [
            [['name','password'],'required','message'=>'Пожалуйста, правильно заполните {attribute}.'],
            ['name','string','length'=>[2,15]], 
            ['password','string','length'=>[5,30]]
        ];
    }

    public function attributeLabels()
	{
		return array(
            'name'=>'Имя',
            'phone'=>'Пароль'
		);
    }

    public static function CreateAllForms(){
        $model1 = new EntryLogin;
        $resforms = [$model1];
        return $resforms;
    }

    public static function CreateForm($formname=""){
        $class = 'app\models\Entry'.$formname;
        $obj = new $class;
        return $obj;
    }

    public function CustomAction(){

    }

  
}