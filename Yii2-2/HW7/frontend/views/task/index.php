<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
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
                'value' => function (\common\models\Task $model) {
                    return mb_substr($model->description, 0, 50);
                }
            ],
            [
                'attribute' => 'Project',
                'value' => 'project.title',
            ],
            [
                'attribute' => 'Executor',
                'value' => 'executor.username',
            ],
            'started_at:datetime',
            'completed_at:datetime',
            [
                'attribute' => 'Updater',
                'value' => 'updater.username',
            ],
            'created_at:datetime',
            'updated_at:datetime',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>