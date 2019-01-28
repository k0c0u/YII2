<?php

namespace app\controllers;

use app\components\TestService;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionIndex()
    {
        return \Yii::$app->test->run();

        /*$model = new Product();
        $model->id = 11;
        $model->name = 'First';
        $model->cost = 123456;
        $model->validate();
        $model->getErrors();
        $model->safeAttributes();
        $model->activeAttributes();

        return $this->render('index', [
            'model' => $model,
        ]);
    }
    //a
    public function insertIndex()
    {
        \Yii::$app->db->createCommand()->insert('user', ['password_hash' => 1])->execute();
        \Yii::$app->db->createCommand()->batchInsert('task', ['creator_id'], [
            [
                [???],
                [],
                []
            ]
        ])->execute();
    }
    //б
    public function selectIndex()
    {
        $query = new Query();
        $result = $query->from('user')->where(['id' => 1]);

        $query1 = new Query();
        $result1 = $query1->from('user')->where(['>', 'id', '1'])->orderDy(['username' => SORT_DESC]);
    }
    //в??
    */
}

