<?php

namespace frontend\controllers;

use common\models\Brand;
use common\models\Cart;
use common\models\Product;
use common\models\Rating;
use common\models\search\ProductSearch;
use common\models\Type;
use common\models\Wishlist;
use Exception;
use frontend\components\BaseController;
use Throwable;
use Yii;
use yii\captcha\CaptchaAction;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\ErrorAction;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ShopController extends BaseController
{
    public function behaviors(): array
    {
        return array_merge([
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => [
                            'products',
                            'view',
                            'get-rating',
                            'add-rating',
                            'add-to-cart',
                            'add-to-wishlist',
                            'remove-from-wishlist'
                        ],
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
        ], parent::behaviors());
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

    public function actionProducts($pageSize = 12): string
    {
        $this->layout = 'shop';
        $request = Yii::$app->request;
        $searchModel = new ProductSearch();
        $searchModel->pageSize = $pageSize;

        $types = ArrayHelper::map(Type::getAll(), 'name', 'name');
        $brands = ArrayHelper::map(Brand::getAll(), 'name', 'name');

        $paramCount = 0;
        $filterTypeCount = [];
        foreach ($request->queryParams as $key => $param) {
            if ($key !== 'page' && $key !== 'per-page' && $key !== 'pageSize' && $param !== '') {
                $paramCount++;
                if (is_array($param)) {
                    $filterTypeCount[$key] = count($param);
                }
            }
        }
        $dataProvider = $searchModel->search($request->get());

        return $this->render('products', [
            'filterTypeCount' => $filterTypeCount,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'brands' => $brands,
            'types' => $types,
            'paramCount' => $paramCount
        ]);
    }

    public function actionView($id): Response|string
    {
        $product = Product::findOne($id);
        $cart = new Cart();
        $rating = Rating::find()->ofUser(Yii::$app->user->id)->ofProduct($id)->one();

        if (!$rating) {
            $rating = new Rating();
        }

        if ($product === null) {
           return $this->redirect('/shop/products');
        }

        return $this->render('view', [
            'rating' => $rating,
            'product' => $product,
            'cart' => $cart
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionAddRating($id): array
    {
        if (Yii::$app->user->isGuest) {
            return [
                'success' => false
            ];
        } else if (Yii::$app->request->isPost) {
            $rating = Rating::find()->ofUser(Yii::$app->user->id)->ofProduct($id)->one();

            if (!$rating) {
                $rating = new Rating();
            }

            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($rating->load(Yii::$app->request->post())) {
                $rating->user_id = Yii::$app->user->id;
                $rating->product_id = $id;
                if ($rating->save()) {
                    return [
                        'success' => true
                    ];
                }
            }
            return [
                'success' => false
            ];
        } else {
            throw new NotFoundHttpException('You can not access this page with this method: '. Yii::$app->request->method);
        }
    }

    public function actionGetRating($id): array
    {
        $query = Product::find()->ofId($id)->with('rating');
        $product = $query->one();
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!$product) {
            return [
                'success' => false
            ];
        }

        $avgRating = $product->getAverageRatings();
        $ratings = $product->getRelatedRecords()['rating'];

        $reviews = new ArrayDataProvider([
            'allModels' => $ratings
        ]);


        return [
            'success' => true,
            'rating' => $avgRating,
            'reviews' => $this->renderAjax('_reviews', [
                'reviews' => $reviews
            ])
        ];
    }

    public function actionAddToCart(): array|Response
    {
        $request = Yii::$app->request;
        $id = $request->post('product_id');
        $product = Product::findOne($id);
        if ($product === null) {
            return $this->redirect('/shop/products');
        }

        $cart = new Cart();
        $data = [];

        if ($request->isPost && $cart->load($request->post())) {
            $cart->user_id = Yii::$app->user->id;
            $cart->product_id = $id;
            $cart->price = $product->price;

            if($cart->save()){
                $data = [
                    'success' => true,
                    'product' => $product,
                ];
            } else {
                $data = [
                    'success' => false,
                    'errors' => $cart->getErrors()
                ];
            }
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $data;
    }

    public function actionAddToWishlist($id): Response|array
    {
        $product = Product::findOne($id);

        if ($product === null) {
            return $this->redirect('/shop/products');
        }

        try {
            $wish = new Wishlist();
            $wish->user_id = Yii::$app->user->id;
            $wish->product_id = $id;
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($wish->save()) {
                return [
                    'success' => true,
                    'down' => false,
                    'title' => 'Success!',
                    'text' => 'Product Added To Your Wishlist!'
                ];
            } else {
                return [
                    'success' => false,
                    'title' => 'Oops!',
                    'text' => 'Failed To Add Product To Your Wishlist!'
                ];
            }
        }catch (Exception ) {
            return [
                'success' => false,
                'title' => 'Error',
                'text' => 'Something Went Wrong!'
            ];
        }
    }

    public function actionRemoveFromWishlist($id): Response|array
    {
        $product = Product::findOne(['id' => $id]);
        $user = Yii::$app->user;

        if ($product === null) {
           return $this->redirect('/shop/products');
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        try {
            $wish = Wishlist::find()->ofUser($user->id)->ofProduct($product->id)->one();
            $wish->delete();
            return [
                'success' => true,
                'down' => true,
                'title' => 'Success!',
                'text' => 'Product Removed From Wishlist!'
            ];
        }catch (Throwable $t) {
            return [
                'success' => false,
                'title' => 'Failed To Remove Product From Your Wishlist!',
                'text' => $t->getMessage()
            ];
        }
    }
}