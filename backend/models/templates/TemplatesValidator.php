<?php

namespace backend\models\templates;

use backend\models\templates\Templates;
use  yii\base\Model;
use Yii;

class TemplatesValidator extends Model
{
    public $name;
    public $template;
    public $updater;


    public function rules(){
        return [
            [['name', 'template'], 'required'],
            ['name', 'string', 'min' => 3],
            ['template', 'string', 'min' => 3],
            ['updater','safe']
        ];
    }

    public function attributeLabels()
    {
        return
            [
                'name' => 'Название',
                'template' => 'Шаблон'
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

    public function getTemplateData(){
        $request = Yii::$app->request->get();
        $data = Templates::find()->where(['=','id',$request['id']])->asArray()->all();
        $this->template = $data[0]['data'];
        $this->name = $data[0]['name'];
    }

    public function updateTemplate(){
        $request = Yii::$app->request->get();
        $template = Templates::find()->where(['=','id',$request['id']])->all();
        $template[0]->name = $this->name;
        $template[0]->data = $this->template;

        if($template[0]->save()){
            return true;
        }else{
            return null;
        }
    }

}