<?php

namespace backend\controllers;

use common\components\File;
use common\models\Brand;
use common\models\Product;
use common\models\search\ProductSearch;
use common\models\Type;
use Yii;
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

    public function actionProducts($pageSize = 12): string|array
    {
        $searchModel = new ProductSearch();
        $searchModel->pageSize = $pageSize;
        $products = $searchModel->search(Yii::$app->request->get(), Yii::$app->request->get('is_activated'));
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'data' => $this->renderPartial('_listView', [
                    'products' => $products
                ]),
            ];
        }

        return $this->render('products', [
            'products' => $products,
        ]);
    }

    public function actionAdd(): Response|string
    {
        $request = Yii::$app->request;
        $product = new Product(['scenario' => Product::SCENARIO_CREATE]);
        $types = ArrayHelper::map(Type::getAll(), 'name', 'name');
        $brands = ArrayHelper::map(Brand::getAll(), 'name', 'name');
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
                        Yii::warning('Failed to create files!', __METHOD__);
                    }
                } else {
                    $errors = implode('', $product->getErrors());
                    Yii::$app->session->setFlash('Error', 'Failed to create this product!');
                    Yii::error('Failed to create this product!' . $errors, __METHOD__);
                }
                $transaction->commit();
            }catch (\Exception $e){
                Yii::$app->session->setFlash('Error', $e->getMessage());
                $transaction->rollBack();
                File::rrmdir(Yii::getAlias('@frontend/web/storage/images/'.$product->folder_id));
                Yii::error($e->getMessage(), __METHOD__);
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
        $types = ArrayHelper::map(Type::getAll(), 'name', 'name');
        $brands = ArrayHelper::map(Brand::getAll(), 'name', 'name');

        if ($product === null) {
           return $this->redirect('/product/products');
        }

        if ($request->isPost && $product->load($request->post())) {
            if ($product->save()) {
                Yii::$app->session->setFlash('Success', 'Successfully Edited the Product!');
            } else {
                $errors = implode('', $product->getErrors());
                Yii::warning('Failed to Edit the Product! ' . $errors  , __METHOD__);
                Yii::$app->session->setFlash('Error', 'Failed to Edit the Product!');
            }
            return $this->redirect('/products');
        } else if (Yii::$app->request->isGet) {
            return $this->renderAjax('edit', [
                'product' => $product,
                'types' => $types,
                'brands' => $brands
            ]);
        }

        Yii::$app->session->setFlash('Error', 'Something Went Wrong!');
        return $this->redirect('/products');
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
                if (File::rrmdir($pathName)) {
                    Yii::$app->session->setFlash('Success', 'Successfully Deleted Product!');
                    Yii::info('Deleted Product at ' . Yii::$app->formatter->asDate(strtotime('now')) , __METHOD__);
                    $product->delete();
                } else {
                    Yii::$app->session->setFlash('Error', 'Failed to Delete Files! Could not delete ' . $pathName);
                    Yii::error('Failed to Delete Files! Could not delete ' . $pathName , __METHOD__);
                }
            } else {
                Yii::$app->session->setFlash('Error', 'Failed to Delete Files! Maybe ' . $pathName . ' Does not Exist?');
                Yii::error('Failed to Delete Files! Maybe ' . $pathName . ' Does not Exist?', __METHOD__);
            }
        } catch (\Throwable $t) {
            Yii::$app->session->setFlash('Error', 'Failed to Delete Product! ' . $t->getMessage());
            Yii::error('Failed to Delete Product! ' . $t->getMessage(), __METHOD__);
        }
        return $this->redirect('/product/products');
    }
}