<?php

namespace backend\models\catalog;

use backend\models\catalog\sections\Sections;
use backend\models\catalog\sections\Sectionsbuffer;
use yii\base\Model;
use yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use backend\models\catalog\sections\types\block\ListViewCreator;
use backend\models\catalog\sections\types\block\TreeCreator;
use backend\models\catalog\sections\types\block\SelectCreator;


class Catalog extends Model
{
    public $name;

    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'Название введено неверно'],
            ['name', 'string', 'max' => 50]
        ];
    }


    public function renderTemplateList($request)
    {
        $list_creator = new ListViewCreator();
        $list = $list_creator->factory();

        return $list->formData($request);
    }

    public function renderTemplateHierarchy()
    {
        $list_creator = new TreeCreator();
        $list = $list_creator->factory();

        return $list->formData([]);
    }

    public function renderTemplateSelectList()
    {
        $list_creator = new SelectCreator();
        $list = $list_creator->factory();

        return $list->formData([]);
    }

    public function addNewBranch($conf)
    {
        if ($conf['branch']) {
            $branch = new Sections(['name' => $conf['name']]);
            $parent = Sections::findOne(['name' => $conf['branch']]);
            $branch->appendTo($parent);
        } else {
            $branch = new Sections(['name' => $conf['name']]);
            $branch->makeRoot();
        }
    }

    public static function catalogDelete($params)
    {
        $name = Sections::find()->where(['=', 'id', $params['id']])->all();
        $name = ArrayHelper::toArray($name, [
            Sections::class => [
                'name',
            ]
        ]);

        $branch = Sections::findOne(['name' => $name]);

        $branch = $branch->deleteWithChildren();

        return Controller::redirect(['catalog/index'], 301);
    }

    public function updateSection()
    {
        $catid = Yii::$app->request->post('catid');
        $newname = Yii::$app->request->post('name');
        $currentcat = Yii::$app->request->post('currentCat');
        $parentname = Yii::$app->request->post('parent');

        $message = 'Данные успешно изменены';
        $message_status = false;

        if ($parentname == 'none') {
            $message = 'Данные не были изменены';
        } else {
            $message_status = true;
            if ($parentname == 'root') {
                $childFinded = Sections::find()->where(['=', 'id', $catid])->all();
                $childFinded[0]->makeRoot();
            } else {
                $parentFinded = Sections::find()->where(['=', 'name', $parentname])->all();

                $childFinded = Sections::find()->where(['=', 'id', $catid])->all();

                $childFinded[0]->appendTo($parentFinded[0]);
            }
        }


        if (!empty($newname)) {
            $changename = Sections::find()->where(['=', 'id', $catid])->all();
            $changename[0]->name = $newname;
            $changename[0]->save();
            $message = 'Данные успешно изменены';
        } else {
            if (!$message_status) {
                $message = 'Данные не были изменены';
            }
        }


        return ['data' => $message];
    }
}