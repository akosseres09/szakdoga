<?php

namespace frontend\controllers;

use common\models\Brand;
use common\models\Cart;
use common\models\Product;
use common\models\search\ProductSearch;
use common\models\Type;
use yii\captcha\CaptchaAction;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\Response;

class ShopController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['products', 'view', 'add-to-cart'],
                'rules' => [
                    [
                        'actions' => ['products', 'view'],
                        'allow' => true,
                        'roles' => ['?', '@']
                    ],
                    [
                        'actions' => ['add-to-cart', 'delete-from-cart'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'add-to-cart' => ['POST'],
                ]
            ]
        ];
    }

    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
                'layout' => 'mainWithoutHeaderAndFooter'
            ],
            'captcha' => [
                'class' => CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ]
        ];
    }

    public function actionProducts($pageSize = 20): string
    {
        $this->layout = 'shop';
        $request = \Yii::$app->request;
        $searchModel = new ProductSearch();
        $types = ArrayHelper::map(Type::find()->all(), 'product_type', 'product_type');
        $brands = ArrayHelper::map(Brand::find()->all(), 'name', 'name');
        $max = Product::find()->ofActive()->max('price');
        $dataProvider = $searchModel->search($request->queryParams);


//        VarDumper::dump($request->queryParams, 5, true);
//        die();

        return $this->render('products',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'brands' => $brands,
            'types' => $types,
            'max' => $max
        ]);
    }

    public function actionView($id): Response|string
    {
        $product = Product::findOne($id);
        $cart = new Cart();

        if ($product === null) {
           return $this->redirect('/shop/products');
        }

        return $this->render('view', [
            'product' => $product,
            'cart' => $cart
        ]);
    }

    public function actionAddToCart(): Response|string
    {
        $request = \Yii::$app->request;
        $id = $request->post('product_id');
        $product = Product::findOne($id);
        if ($product === null) {
            return $this->redirect('/shop/products');
        }

        $cart = new Cart();

        if ($request->isPost && $cart->load($request->post())) {
            $cart->user_id = \Yii::$app->user->id;
            $cart->product_id = $id;
            $cart->price = $product->price;
            if($cart->save()){
                return $this->renderPartial('_cartModal',[
                    'product' => $product,
                    'success' => true
                ]);
            } else {
                return $this->renderPartial('_cartModal',[
                    'product' => $product,
                    'success' => false
                ]);
            }
        }
        return $this->redirect('/shop/view/'.$id);
    }

}