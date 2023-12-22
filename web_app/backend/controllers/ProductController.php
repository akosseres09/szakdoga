<?php

namespace backend\controllers;

use common\models\Brand;
use common\models\Product;
use common\models\Type;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\rest\Controller;
use yii\web\Response;

class ProductController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['products', 'add', 'edit', 'delete'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST']
                ]
            ]
        ];
    }

    public function actionProducts(): string
    {
        $products = new ActiveDataProvider([
            'query' => Product::find(),
            'sort' => ['defaultOrder' => [
                'is_activated' => SORT_DESC,
            ]],
            'pagination' => [
                'pageSize' => 15
            ]
        ]);
        return $this->render('products', [
            'products' => $products
        ]);
    }

    public function actionAdd(): Response|string
    {
        $request = \Yii::$app->request;
        $product = new Product();
        $types = ArrayHelper::map(Type::find()->all(), 'id', 'product_type');
        $brands = ArrayHelper::map(Brand::find()->all(), 'id', 'name');
        if ($request->isPost && $product->load($request->post())) {
            if ($product->save()) {
                \Yii::$app->session->setFlash('success', 'Successfully Created a new Product!');
            } else {
                \Yii::$app->session->setFlash('error', 'Failed to create this product!');
            }
            return $this->redirect(['/product/products']);
        }

        return $this->renderPartial('add', [
            'product' => $product,
            'types' => $types,
            'brands' => $brands
        ]);
    }

    public function actionEdit($id): Response|string
    {
        $product = Product::findOne($id);
        $request = \Yii::$app->request;
        $types = Type::find();
        $brands = Brand::find();

        if ($product === null) {
           return $this->redirect('/product/products');
        }

        if ($request->isPost && $product->load($request->post())) {
            if ($product->save()) {
                \Yii::$app->session->setFlash('Success', 'Successfully Edited the Product!');
            } else {
              \Yii::$app->session->setFlash('Error', 'Failed to Edit the Product!');
            }
            return $this->redirect('/product/products');
        }

        return $this->renderPartial('edit', [
            'product' => $product,
            'types' => $types,
            'brands' => $brands
        ]);
    }

    public function actionDelete($id): Response
    {
        $product = Product::findOne($id);

        if ($product === null) {
            return $this->redirect('/product/products');
        }

        try {
            $product->delete();
            \Yii::$app->session->setFlash('Success', 'Successfully Deleted Product!');
        } catch (\Throwable $t) {
            \Yii::$app->session->setFlash('Error', 'Failed to Delete Product! ' . $t->getMessage());
        }
        return $this->redirect('/product/products');
    }
}