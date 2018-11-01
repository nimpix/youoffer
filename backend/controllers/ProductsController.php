<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use backend\models\currency\Currency;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use backend\models\products\Products;
use backend\models\merchants\Merchant;
use backend\models\products\ProductProvider;
use backend\models\catalog\sections\Sections;
use yii\helpers\ArrayHelper;
use backend\models\products\CategoryList;
use backend\models\products\BrandsList;
use backend\models\products\MerchantsList;
use backend\models\products\Params;
use yii\web\UploadedFile;
use backend\models\products\ProductValidator;


class ProductsController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [''],
                        'allow' => true,
                        'roles' => ['manager-role', 'product-role'],
                    ],
                    [
                        'actions' => ['index', 'add', 'delete', 'update', 'insert', 'dellinks', 'uplinks', 'productform', 'productadd'],
                        'allow' => true,
                        'roles' => ['admin-role'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {

        $data = Products::find();

        $provider = new ActiveDataProvider([
            'query' => $data,
            'pagination' => [
                'pageSize' => 20,
            ]
        ]);

        $grid = GridView::widget([
            'dataProvider' => $provider,
            'columns' => [
                [
                    'attribute' => 'id',
                    'format' => 'text',
                    'label' => 'id',
                    'options' => ['width' => '10'],

                ],
                [
                    'attribute' => 'name',
                    'format' => 'text',
                    'label' => 'Наименование',
                    'options' => ['width' => '70'],
                ],
                [
                    'attribute' => 'merchant.name',
                    'format' => 'text',
                    'label' => 'Поставщик',
                    'options' => ['width' => '70'],
                ],
                [
                    'attribute' => 'brands.name',
                    'format' => 'text',
                    'label' => 'Бренд',
                    'options' => ['width' => '70'],
                ],
                [
                    'format' => 'raw',
                    'label' => 'Категория',
                    'options' => ['width' => '70'],
                    'value' => function ($section) {
                        $result = '';
                        $section = ArrayHelper::toArray($section->sections, [Sections::class => ['name']]);
                        foreach ($section as $sect) {
                            $result .= '<li>' . $sect['name'] . '</li>';
                        }

                        return '<ul>' . $result . '</ul>';
                    },
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete}',
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'delete') {
                            return \yii\helpers\Url::toRoute(['products/delete', 'id' => $model['id']]);
                        }
                        if ($action === 'update') {
                            return \yii\helpers\Url::toRoute([
                                'products/update',
                                'id' => $model['id'],
                                'name' => $model['name']
                            ]);
                        }
                    },
                    'header' => 'Действия',
                    'options' => ['width' => '20'],
                    'headerOptions' => ['style' => 'color:#337ab7'],
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return Html::a('<span class="fas fa-pen"></span>', $url, [
                                'title' => 'Изменить',
                            ]);
                        },
                        'delete' => function ($url, $model) {
                            return Html::a('<span class="fas fa-ban"></span>', $url, [
                                'title' => 'Удалить',
                                'data' => [
                                    'method' => 'post',
                                    'confirm' => 'Вы уверены, что хотите удалить товар?',
                                ]
                            ]);
                        },
                    ],
                ],
            ],
        ]);

        return $this->render('index.twig', ['data' => $grid]);
    }

    /**
     * @return string
     */
    public function actionDelete()
    {
        $request = Yii::$app->request->get();

        return Products::deleteAll(['=', 'id', $request['id']]) ? $this->redirect(['products/index', ''], 301) : 'Не удалился товар. Для уточнения информации свяжитесь с администратором';
    }

    /**
     * @return mixed
     * Сделать фабрику
     */
    public function actionUpdate()
    {
        $get = Yii::$app->request->get();

        /**
         * Category list
         */
        $catlistData = CategoryList::renderCatList($get);
        $catlist_default = ArrayHelper::getValue($catlistData[0], 'default');
        $catlist_body = ArrayHelper::getValue($catlistData[0], 'body');
        $cat_id = ArrayHelper::getValue($catlistData[0], 'id');

        /**
         * Brandlist
         */
        $brandlistData = BrandsList::getBrandsList($get);
        $brandlist_default = ArrayHelper::getValue($brandlistData[0], 'default');
        $brandlist_body = ArrayHelper::getValue($brandlistData[0], 'body');
        $brand_id = ArrayHelper::getValue($brandlistData[0], 'brand_id');

        /**
         * Merchants list
         */
        $merchlistData = MerchantsList::getMerchantsList($get);
        $merchlist_default = ArrayHelper::getValue($merchlistData[0], 'default');
        $merchlist_body = ArrayHelper::getValue($merchlistData[0], 'body');
        $merch_id = ArrayHelper::getValue($merchlistData[0], 'merch_id');

        $params = Params::getParams($get);
        $params = $params[0];
        $description = ArrayHelper::getValue($params, 'description');
        $name = ArrayHelper::getValue($params, 'name');

        $inputs = ArrayHelper::getValue($params, function ($params) {
            $paramsArr = [
                ['id' => 'articul', 'name' => 'Артикул', 'value' => $params['articul']],
                ['id' => 'price_roznica', 'name' => 'Цена розничная', 'value' => $params['price_roznica']],
                ['id' => 'price_opt', 'name' => 'Цена оптовая', 'value' => $params['price_opt']],
                ['id' => 'status', 'name' => 'Статус', 'value' => $params['status']],
                ['id' => 'waiting', 'name' => 'Доставка через(дней)', 'value' => $params['waiting']],
                ['id' => 'amount', 'name' => 'Количество', 'value' => $params['amount']],
                ['id' => 'weight', 'name' => 'Вес', 'value' => $params['weight']],
                ['id' => 'size', 'name' => 'Размер', 'value' => $params['size']],
            ];
            return $paramsArr;
        });

        return $this->render('update.twig',
            [
                'name' => $name,
                'main_cat' => $catlist_default,
                'options_cat' => $catlist_body,
                'cat_id' => $cat_id,
                'main_brand' => $brandlist_default,
                'options_brand' => $brandlist_body,
                'brand_id' => $brand_id,
                'main_merch' => $merchlist_default,
                'options_merch' => $merchlist_body,
                'merch_id' => $merch_id,
                'description' => $description,
                'inputs' => $inputs,
                'id' => $get['id'],
            ]);
    }

    public function actionInsert()
    {
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;

        $post = Yii::$app->request->post();

        $prod = Products::findOne($post['id']);

        /**
         * Сохраняем
         */
        $prod->name = $post['name'];
        $prod->brand_id = $post['brand-list'];
        $prod->merchant_id = $post['merch-list'];
        $prod->description = $post['descr'];
        $prod->articul = $post['articul'];
        $prod->image = ''; //image
        $prod->price_roznica = $post['price_roznica'];
        $prod->price_opt = $post['price_opt'];
        $prod->status = $post['status'];
        $prod->waiting = $post['waiting'];
        $prod->weight = $post['weight'];
        $prod->amount = $post['amount'];
        $prod->size = $post['size'];

        if ($prod->save()) {
            $response->data = 'Успешно обновлено';
        }

        return $response;
    }

    public function actionUplinks()
    {

        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $get = Yii::$app->request->get();

        /**
         * Обновляем связи
         */

        $prod = Products::findOne($get['id']);

        $sections = Sections::findOne($get['cat_id']);

        try {
            $prod->link('sections', $sections);
            $response->data = 'Категория успешно добавлена';
        } catch (yii\base\InvalidArgumentException $e) {
            $response->data = 'Категория не добавлена ошибка ' . $e->getMessage();
        }

        return $response;
    }

    public function actionDellinks()
    {
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $get = Yii::$app->request->get();

        $prod = Products::findOne($get['id']);


        /**
         * Удаляем связи
         */

        $sectionsdel = Sections::findOne($get['cat_id']);

        try {
            $prod->unlink('sections', $sectionsdel, true);
            $response->data = 'Категория успешно удалена';
        } catch (yii\base\InvalidArgumentException $e) {
            $response->data = 'Категория не удалена ошибка ' . $e->getMessage();
        }

        return $response;
    }

    public function actionProductform()
    {
        /**
         * Category list
         */
        $catlistData = CategoryList::renderCatList();
        $catlist_body = ArrayHelper::getValue($catlistData[0], 'body');

        /**
         * Brandlist
         */
        $brandlistData = BrandsList::getBrandsList();
        $brandlist_body = ArrayHelper::getValue($brandlistData[0], 'body');

        /**
         * Merchants list
         */
        $merchlistData = MerchantsList::getMerchantsList();
        $merchlist_body = ArrayHelper::getValue($merchlistData[0], 'body');

        $paramsArr = [
            ['id' => 'articul', 'name' => 'Артикул','required' => 'required'],
            ['id' => 'price_roznica', 'name' => 'Цена розничная','required' => 'required'],
            ['id' => 'price_opt', 'name' => 'Цена оптовая','required' => 'required'],
            ['id' => 'status', 'name' => 'Статус'],
            ['id' => 'waiting', 'name' => 'Доставка через(дней)'],
            ['id' => 'amount', 'name' => 'Количество'],
            ['id' => 'weight', 'name' => 'Вес'],
            ['id' => 'size', 'name' => 'Размер'],
        ];

        return $this->render('add.twig',
            [
                'options_cat' => $catlist_body,
                'options_brand' => $brandlist_body,
                'options_merch' => $merchlist_body,
                'inputs' => $paramsArr,
            ]
        );
    }

    public function actionProductadd()
    {
        $post = Yii::$app->request->post();

        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $post;

        $prod = new Products();

        /**
         * Сохраняем
         */
        $prod->name = $post['name'];
        $prod->brand_id = $post['brand-list'];
        $prod->merchant_id = $post['merch-list'];
        $prod->description = $post['descr'];
        $prod->articul = $post['articul'];
        $prod->image = ''; //image
        $prod->price_roznica = $post['price_roznica'];
        $prod->price_opt = $post['price_opt'];
        $prod->status = $post['status'];
        $prod->waiting = $post['waiting'];
        $prod->weight = $post['weight'];
        $prod->amount = $post['amount'];
        $prod->size = $post['size'];

        if ($prod->save()) {
            $response->data = 'Успешно обновлено';
        }

        $cat_list = [];
        foreach ($post as $key => $value) {
            if (strstr($key, 'category-list')) {
                array_push($cat_list, $value);
            }
        }

        foreach ($cat_list as $cat) {
            $sections = Sections::findOne($cat);
            try {
                $prod->link('sections', $sections);
                $response->data = 'Категория успешно добавлена';
            } catch (yii\base\InvalidArgumentException $e) {
                $response->data = 'Relation is not added ' . $e->getMessage();
            }
        }

        return $this->redirect(['products/index'], 301);
    }
}