<?php

namespace app\controllers;

use app\models\Product;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionIndex()
    {
        $model = new Product();
        $model->id = 11;
        $model->name = 'First';
        $model->cost = 123456;

        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
