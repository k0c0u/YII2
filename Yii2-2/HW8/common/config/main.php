<?php
use common\services\EmailService;
use common\services\NotificationService;
use common\services\ProjectService;
use common\services\TaskService;
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'i18n' => [
            'translations' => [
                'yii2mod.comments' => [
                    'class' => yii\i18n\PhpMessageSource::class,
                    'basePath' => '@yii2mod/comments/messages',
                ],
            ],
        ],
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
        'taskService' => [
            'class' => TaskService::class,
        ],
    ],
    'modules' => [
        'comment' => [
            'class' => yii2mod\comments\Module::class,
        ],
        'chat' => [
            'class' => common\modules\chat\Module::class,
        ],
    ],
];