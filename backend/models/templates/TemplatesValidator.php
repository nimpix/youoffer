<?php

namespace backend\models\templates;

use backend\models\templates\Templates;
use  yii\base\Model;
use Yii;

class TemplatesValidator extends Model
{
    public $name;
    public $template;

    public function rules(){
        return [
            [['name', 'template'], 'required'],
            ['name', 'string', 'min' => 3],
            ['template', 'string', 'min' => 3],
        ];
    }

    public function addTemplate(){
        $template = new Templates();

        $template->name = $this->name;
        $template->data = $this->template;
        if($template->save()){
            return true;
        }else{
            return null;
        }
    }

    public function Delete(){
        $request = Yii::$app->request->get();
        Templates::deleteAll(['=', 'id', $request['id']]);
    }
}