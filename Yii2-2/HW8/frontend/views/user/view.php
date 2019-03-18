<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model common\models\User */
$this->title = $model->id;
$this->params['breadcrumbs'][] = 'Users';
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <img
            src="<?= Yii::$app->user->identity->getThumbUploadUrl('avatar', \common\models\User::AVATAR_PREVIEW); ?>"
            class="center-block "
            alt="User Image"/>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',
            'avatar',
            [
                'attribute' => 'Status',
                'value' => function (\common\models\User $model) {
                    return \common\models\User::STATUS_LABELS[$model->status];
                },
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>