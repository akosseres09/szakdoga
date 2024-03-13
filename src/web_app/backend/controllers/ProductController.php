<?php

namespace backend\controllers;

use common\components\File;
use common\models\Brand;
use common\models\Product;
use common\models\search\ProductSearch;
use common\models\Type;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\rest\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

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
                    'delete' => ['POST'],
                ]
            ]
        ];
    }

    public function actionProducts(): string|array
    {
        if (Yii::$app->request->isAjax) {
            $searchModel = new ProductSearch();
            $products = $searchModel->search(Yii::$app->request->get(), 12, Yii::$app->request->get('is_activated'));
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'data' => $this->renderPartial('_listView', [
                    'products' => $products
                ]),
            ];
        }

        $query = Product::find()->with('brand', 'type')
            ->leftJoin('type', 'product.type_id = type.id')->ofFootball();

        $products = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'is_activated' => SORT_DESC
                ]
            ],
            'pagination' => [
                'pageSize' => 12
            ]
        ]);

        return $this->render('products', [
            'products' => $products
        ]);
    }

    public function actionAdd(): Response|string
    {
        $request = Yii::$app->request;
        $product = new Product(['scenario' => Product::SCENARIO_CREATE]);
        $types = ArrayHelper::map(Type::getAll(), 'id', 'product_type');
        $brands = ArrayHelper::map(Brand::getAll(), 'id', 'name');
        $transaction = Yii::$app->db->beginTransaction();
        if ($request->isPost && $product->load($request->post())) {
            try {
                $product->folder_id = Yii::$app->security->generateRandomString(11);
                $product->images = UploadedFile::getInstances($product, 'images');

                if ($product->save()) {
                    if($product->upload()) {
                        Yii::$app->session->setFlash('Success', 'Successfully Uploaded Images and Created Product!');
                    }else {
                        Yii::$app->session->setFlash('Error', 'Failed to create files!');
                    }
                } else {
                    Yii::$app->session->setFlash('Error', 'Failed to create this product!');
                }
                $transaction->commit();
            }catch (\Exception $e){
                Yii::$app->session->setFlash('Error', $e->getMessage());
                $transaction->rollBack();
                File::rrmdir(Yii::getAlias('@frontend/web/storage/images/'.$product->folder_id));
                return $this->redirect(['/product/products']);
            }
            return $this->redirect(['/product/products']);
        }

        return $this->renderAjax('add', [
            'product' => $product,
            'types' => $types,
            'brands' => $brands
        ]);
    }

    public function actionEdit($id): Response|string
    {
        $product = Product::findOne($id);
        $product->scenario = Product::SCENARIO_EDIT;
        $request = Yii::$app->request;
        $types = Type::find();
        $brands = Brand::find();

        if ($product === null) {
           return $this->redirect('/product/products');
        }

        if ($request->isPost && $product->load($request->post())) {
            if ($product->save()) {
                Yii::$app->session->setFlash('Success', 'Successfully Edited the Product!');
            } else {
              Yii::$app->session->setFlash('Error', 'Failed to Edit the Product!');
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
            $pathName = Yii::getAlias('@frontend/web/storage/images/'.$product->folder_id);
            if (file_exists($pathName)){
                File::rrmdir($pathName);
            }
            $product->delete();
            Yii::$app->session->setFlash('Success', 'Successfully Deleted Product!');
        } catch (\Throwable $t) {
            Yii::$app->session->setFlash('Error', 'Failed to Delete Product! ' . $t->getMessage());
        }
        return $this->redirect('/product/products');
    }
}