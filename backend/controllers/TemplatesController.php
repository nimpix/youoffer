<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\templates\TemplatesValidator;
use backend\models\templates\FactoryTemplates;


class TemplatesController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'gettemplates'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'gettemplates'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['parsers', 'gettemplates','update','delete','add'],
                        'allow' => true,
                        'roles' => ['admin-role', 'product-role'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    // restrict access to
                    'Access-Control-Allow-Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    // Allow only POST and PUT methods
                    'Access-Control-Request-Headers' => ['*'],
                    // Allow only headers 'X-Wsse'
                    'Access-Control-Allow-Credentials' => true,
                    // Allow OPTIONS caching
                    'Access-Control-Max-Age' => 86400,
                    // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                    'Access-Control-Expose-Headers' => [],
                ]
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $factory = new FactoryTemplates();
        $data = $factory->getAllProcessorsData();

        return $this->render('index.twig',['list' => $data]);
    }

    public function actionUpdate(){

        if (Yii::$app->request->post()) {
            $template = new TemplatesValidator();
           if($template->load(Yii::$app->request->post()) && $template->validate()){
                if($template->addTemplate()){
                    return $this->render('update.php', ['error'=> 'Шаблон успешно добавлен']);
                }else{
                    return $this->render('update.php', ['error'=> 'Произошла ошибка']);
                }
           }else{
               return $this->render('update.php', ['error'=> 'Данные шаблона заполнены неверно']);
           }
        }else{

            return $this->render('update.php', []);
        }
    }

}