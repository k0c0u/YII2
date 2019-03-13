<?php
namespace common\services;
use yii\base\Component;
/**
 * Class EmailService
 * @package common\services
 */
class EmailService extends Component
{
    /**
     * @param string $to
     * @param string $subject
     * @param string $viewHTML
     * @param string $viewText
     * @param array  $data
     *
     * @return bool
     */
    public function send(string $to, string $subject, string $viewHTML, string $viewText, array $data) {
        return \Yii::$app
            ->mailer
            ->compose(
                ['html' => $viewHTML, 'text' => $viewText],
                $data)
            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
            ->setTo($to)
            ->setSubject($subject)
            ->send();
    }
}