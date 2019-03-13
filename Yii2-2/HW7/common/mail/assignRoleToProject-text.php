<?php
/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $project common\models\Project */
/* @var $role string */
?>
Привет <?= Html::encode($user->username) ?>,</p>
В проекте <?= $project->title ?> тебе назначена роль <?= $role ?></p>
