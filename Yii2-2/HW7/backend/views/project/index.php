<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Projects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Project', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'title',
            [
                'attribute' => 'description',
                'format' => 'ntext',
                'value' => function (\common\models\Project $model) {
                    return mb_substr($model->description, 0, 50);
                }
            ],
            [
                'attribute' => 'active',
                'value' => function (\common\models\Project $model) {
                    return \common\models\Project::STATUS_LABELS[$model->active];
                },
                'filter' => \common\models\Project::STATUS_LABELS,
            ],
            [
                'attribute' => 'Creator',
                'value' => 'creator.username',
            ],
            [
                'attribute' => 'Updater',
                'value' => 'updater.username',
            ],
            'created_at:datetime',
            'updated_at:datetime',
            ['class' => 'yii\grid\ActionColumn',],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>