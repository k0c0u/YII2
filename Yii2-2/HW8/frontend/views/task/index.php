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
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {take} {pass}',
                'buttons' => [
                    'take' => function ($url, \common\models\Task $model, $key) {
                        $icon = \yii\bootstrap\Html::icon('hand-right');
                        return Html::a($icon, ['task/take', 'id' => $model->id], ['data' => [
                            'confirm' => 'Do you take task?',
                            'method' => 'post',
                        ]]);
                    },
                    'pass' => function ($url, \common\models\Task $model, $key) {
                        $icon = \yii\bootstrap\Html::icon('glyphicon glyphicon-saved');
                        return Html::a($icon, ['task/complete', 'id' => $model->id], ['data' => [
                            'confirm' => 'Do you complete task?',
                            'method' => 'post',
                        ]]);
                    }
                ],
                'visibleButtons' => [
                    'update' => function (\common\models\Task $model, $key, $index) {
                        return Yii::$app->taskService->canManage(\common\models\Project::findOne($model->project_id), Yii::$app->user->identity);
                    },
                    'delete' => function (\common\models\Task $model, $key, $index) {
                        return Yii::$app->taskService->canManage(\common\models\Project::findOne($model->project_id), Yii::$app->user->identity);
                    },
                    'take' => function (\common\models\Task $model, $key, $index) {
                        return Yii::$app->taskService->canTake($model, Yii::$app->user->identity);
                    },
                    'pass' => function (\common\models\Task $model, $key, $index) {
                        return Yii::$app->taskService->canComplete($model, Yii::$app->user->identity);
                    },
                ],
            ],
            [
                'attribute' => 'title',
                'value' => function (\common\models\Task $model) {
                    return Html::a($model->project->title, ['project/view', 'id' => $model->project_id]);
                },
                'format' => 'html',
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'project_id',
                    ArrayHelper::map(\common\models\Project::find()->byUser(Yii::$app->user->id)->all(), 'id', 'title'),
                    ['prompt' => '', 'class' => 'form-control form-control-sm']
                ),
            ],
            'title',
            [
                'attribute' => 'description',
                'value' => function (\common\models\Task $model) {
                    return mb_substr($model->description, 0, 50);
                },
                'format' => 'ntext',
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
                    ArrayHelper::map(\common\models\User::find()->onlyActive()->all(), 'id', 'username'),
                    ['prompt' => '', 'class' => 'form-control form-control-sm']
                ),
            ],
            'started_at:datetime',
            'completed_at:datetime',
            [
                'attribute' => 'Creator',
                'value' => function (\common\models\Task $model) {
                    return Html::a($model->creator->username, ['user/view', 'id' => $model->creator_id]);
                },
                'format' => 'html',
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'creator_id',
                    ArrayHelper::map(\common\models\User::find()->onlyActive()->all(), 'id', 'username'),
                    ['prompt' => '', 'class' => 'form-control form-control-sm']
                ),
            ],
            'updater.username:text:Updater',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>