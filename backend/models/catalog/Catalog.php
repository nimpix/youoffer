<?php

namespace backend\models\catalog;

use backend\models\catalog\sections\SectionsTemplateRenderer;
use backend\models\catalog\sections\Sections;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\helpers\baseHtml;

class Catalog extends Model
{
    public $catalogRender;

    public $name;

    public function __construct()
    {
        $this->catalogRender = new SectionsTemplateRenderer();
    }

    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'Название введено неверно'],
            ['name', 'string', 'max' => 50]
        ];
    }

    public function renderTemplateList()
    {
        $result = $this->catalogRender->renderList();

        return $result;
    }

    public function renderTemplateHierarchy()
    {
        $result = $this->catalogRender->renderHierarchy();

        return $result;
    }

    public function renderTemplateSelectList()
    {
        $result = $this->catalogRender->renderSelectList();

        return $result;
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
}