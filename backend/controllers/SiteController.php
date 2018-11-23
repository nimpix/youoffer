<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\helpers\Url;
use common\models\loader\parsers\Loader;
use yii\web\UploadedFile;
use backend\models\merchants\Merchant;
use backend\models\products\Products;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'getprods'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'getprods'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['parsers', 'getprods'],
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

    /**
     * {@inheritdoc}
     */
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
        return $this->render('index');
    }

    public function actionGetprods()
    {
        $products = new Products;
        $data = $products->find()->asArray()->all();

        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $data;

        return $response;
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->response->redirect(Url::to('/backend/web/'));
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionParsers()
    {
        $this->enableCsrfValidation = false;
        if (Yii::$app->request->post()) {

            $response = 'Товары успешно загружены';

            $post = Yii::$app->request->post();

            $file = UploadedFile::getInstanceByName('xml');


            $loader = new Loader();

            try {
                $parser = $loader->createParser($post, $file);
                $parser->Parsing();
            } catch (yii\base\ErrorException $e) {
                $response = 'Для данного поставщика отсутствует загрузчик. Обратитесь к администратору.';
            }

            return $this->render('parsed.twig', ['resp' => $response]);

        } else {
            $merch = new Merchant();
            $merch_arr = $merch->find()->Select(['name', 'id'])->asArray()->all();

            return $this->render('parsers.twig', [
                'link' => Url::toRoute('site/parsers'),
                'merches' => $merch_arr,
            ]);
        }
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
}
