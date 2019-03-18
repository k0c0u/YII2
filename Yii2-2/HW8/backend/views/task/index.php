<?php
use yii\helpers\ArrayHelper;
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
                'value' => function (\common\models\Task $model) {
                    return Html::a($model->project->title, ['project/view', 'id' => $model->project_id]);
                },
                'format' => 'html',
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'project_id',
                    ArrayHelper::map(\common\models\Project::find()->all(), 'id', 'title'),
                    ['prompt' => '', 'class' => 'form-control form-control-sm']
                ),
            ],
            [
                'attribute' => 'Executor',
                'value' => function (\common\models\Task $model) {
                    if ($model->executor) {
                        return Html::a($model->executor->username, ['user/view', 'id' => $model->executor_id]);
                    }
                    return 'empty';
                },
                'format' => 'html',
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'executor_id',
                    ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username'),
                    ['prompt' => '', 'class' => 'form-control form-control-sm']
                ),
            ],
            'started_at:datetime',
            'completed_at:datetime',
            [
                'attribute' => 'updater',
                'value' => function (\common\models\Task $model) {
                    if ($model->updater) {
                        return Html::a($model->updater->username, ['user/view', 'id' => $model->updater_id]);
                    }
                    return 'empty';
                },
                'format' => 'html',
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'updater_id',
                    ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username'),
                    ['prompt' => '', 'class' => 'form-control form-control-sm']
                ),
            ],
            'created_at:datetime',
            'updated_at:datetime',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>