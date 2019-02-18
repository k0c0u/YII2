<?php
namespace backend\controllers;
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
        return $this->renderContent('Hello, world');
    }
}