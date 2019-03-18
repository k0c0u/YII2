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

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'title',
                'value' => function (\common\models\Project $model) {
                    return Html::a($model->title, ['view', 'id' => $model->id]);
                },
                'format' => 'html',
            ],
            [
                'attribute' => \common\models\Project::RELATION_PROJECT_USERS . '.role',
                'value' => function (\common\models\Project $model) {
                    return join(',', Yii::$app->projectService->getRoles($model, Yii::$app->user->identity));
                },
            ],
            [
                'attribute' => 'active',
                'value' => function (\common\models\Project $model) {
                    return \common\models\Project::STATUS_LABELS[$model->active];
                },
                'filter' => \common\models\Project::STATUS_LABELS,
            ],
            [
                'attribute' => 'description',
                'value' => function (\common\models\Project $model) {
                    return mb_substr($model->description, 0, 50);
                },
                'format' => 'ntext',
            ],
            [
                'attribute' => 'Creator',
                'value' => function (\common\models\Project $model) {
                    return Html::a($model->creator->username, ['user/view', 'id' => $model->creator->id]);
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'Updater',
                'value' => function (\common\models\Project $model) {
                    return Html::a($model->updater->username, ['user/view', 'id' => $model->updater->id]);
                },
                'format' => 'html',
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>