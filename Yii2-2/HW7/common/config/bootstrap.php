<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
\yii\base\Event::on(\yii\db\ActiveRecord::className(), ActiveRecord::EVENT_BEFORE_VALIDATE,
    function (\yii\base\ModelEvent $e) {

    $e->isValid;
        return;
    });