<?php
use common\services\EmailService;
use common\services\NotificationService;
use common\services\ProjectService;
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => yii\caching\FileCache::class,
        ],
        'notificationService' => [
            'class' => NotificationService::class,
        ],
        'emailService' => [
            'class' => EmailService::class,
        ],
        'projectService' => [
            'class' => ProjectService::class,
            'on ' . ProjectService::EVENT_ASSIGN_ROLE => function (\common\services\AssignRoleEvent $e) {
                Yii::$app->notificationService->sendMail($e->user, $e->project, $e->role);
            }
        ],
    ],
    'modules' => [
        'chat' => [
            'class' => common\modules\chat\Module::class,
        ],
    ],
];