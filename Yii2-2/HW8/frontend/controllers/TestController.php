<?php
namespace frontend\controllers;
use yii\web\Controller;
/**
 * Site controller
 */
class TestController extends Controller
{
    /**
     * Displays homepage.
     * @return string
     */
    public function actionIndex() {
        phpinfo();
    }
}