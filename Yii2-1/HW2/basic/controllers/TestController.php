<?php

namespace app\controllers;

use app\components\TestService;
use app\models\Product;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionIndex()
    {
        return \Yii::$app->test->run();

        $model = new Product();
        $model->id = 11;
        $model->name = 'First';
        $model->cost = 123456;

        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
