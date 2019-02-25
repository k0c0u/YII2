<?php

namespace common\modules\chat\widgets;
use common\modules\chat\assets\ChatAsset;
use yii\bootstrap\Widget;

class Chat extends Widget
{
    public $port = 8080;
    public function init() {


    }
    public function run() {
        $this->view->registerJsVar('wsPort', $this->port);
        ChatAsset::register($this->view);
        return $this->render('chat');
    }
}