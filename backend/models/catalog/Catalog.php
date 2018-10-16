<?php

namespace backend\models\catalog;

use backend\models\catalog\sections\SectionsTemplateRenderer;
use backend\models\catalog\sections\Sections;
use backend\models\catalog\sections\Sectionsbuffer;
use yii\base\Model;
use yii;
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

    public function renderTemplateList($request)
    {
        $tree = $this->catalogRender->filterList($request);
        $result = $this->catalogRender->renderList($tree);

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

    public function updateSection()
    {
        $newname = Yii::$app->request->post('name');
        $currentcat = Yii::$app->request->post('currentCat');
        $parentname = Yii::$app->request->post('parent');

        if ($parentname == 'none') {

        } else {
            
            if ($parentname == 'root') {
                $childFinded = Sections::find()->where(['=', 'name', $currentcat])->all();
                $childFinded[0]->makeRoot();
            } else {
                $parentFinded = Sections::find()->where(['=', 'name', $parentname])->all();

                $childFinded = Sections::find()->where(['=', 'name', $currentcat])->all();

                $childFinded[0]->appendTo($parentFinded[0]);
            }
        }


        if (!empty($newname)) {
            $changename = Sections::find()->where(['=', 'name', $currentcat])->all();
            $changename[0]->name = $newname;
            $changename[0]->save();
        }

        return ['data' => $parentname];
    }
}