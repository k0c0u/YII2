<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model common\models\Project */
/* @var $accessedUsers \common\models\User[] */
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="project-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:ntext',
            [
                'attribute' => 'active',
                'value' => function (\common\models\Project $model) {
                    return \common\models\Project::STATUS_LABELS[$model->active];
                },
                'filter' => \common\models\Project::STATUS_LABELS,
            ],
            'creator.username:text:Creator',
            'updater.username:text:Updater',
            'created_at:datetime',
            'updated_at:datetime',
            [
                'attribute' => 'Accessed users',
                'value' => $accessedUsers ? join(', ', $accessedUsers) : 'No access',
            ],
        ],
    ]) ?>

</div>