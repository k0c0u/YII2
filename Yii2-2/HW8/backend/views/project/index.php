<?php
use yii\helpers\ArrayHelper;
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
                'attribute' => 'creator',
                'value' => function (\common\models\Project $model) {
                    if ($model->creator) {
                        return Html::a($model->creator->username, ['user/view', 'id' => $model->creator_id]);
                    }
                    return 'empty';
                },
                'format' => 'html',
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'creator_id',
                    ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username'),
                    ['prompt' => '', 'class' => 'form-control form-control-sm']
                ),
            ],
            [
                'attribute' => 'updater',
                'value' => function (\common\models\Project $model) {
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
            ['class' => 'yii\grid\ActionColumn',],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>