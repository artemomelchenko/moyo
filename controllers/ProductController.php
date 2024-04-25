<?php
namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Product;
use app\models\Category;

class ProductController extends ActiveController
{
    public $modelClass = 'app\models\Product';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'delete' => ['DELETE'],
                'create' => ['POST'],
                'update' => ['PUT', 'PATCH'],
            ],
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['delete'], $actions['create'], $actions['update']);
        return $actions;
    }

    // GET /products/search?query=example
    public function actionSearch($query)
    {
        return Product::find()->where(['like', 'title', $query])->all();
    }

    // GET /products/category/1
    public function actionCategory($id)
    {
        $category = Category::findOne($id);
        if (!$category) {
            throw new NotFoundHttpException("Category not found.");
        }
        return $category->getProducts()->all();
    }

    // POST /products
    public function actionCreate()
    {
        $product = new Product();
        $product->load(Yii::$app->request->post(), '');
        if ($product->save()) {
            return $product;
        }
        Yii::$app->response->statusCode = 400;
        return ['errors' => $product->errors];
    }

    // PUT /products/1
    public function actionUpdate($id)
    {
        $product = Product::findOne($id);
        if (!$product) {
            throw new NotFoundHttpException("Product not found.");
        }
        $product->load(Yii::$app->request->post(), '');
        if ($product->save()) {
            return $product;
        }
        Yii::$app->response->statusCode = 400;
        return ['errors' => $product->errors];
    }

    // DELETE /products/1
    public function actionDelete($id)
    {
        $product = Product::findOne($id);
        if (!$product) {
            throw new NotFoundHttpException("Product not found.");
        }
        if ($product->delete()) {
            return ['status' => 'success', 'message' => 'Product deleted.'];
        }
        Yii::$app->response->statusCode = 400;
        return ['status' => 'error', 'message' => 'Product could not be deleted.'];
    }
}
