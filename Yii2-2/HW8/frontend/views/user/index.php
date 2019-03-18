<?php
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(['timeout' => 5000]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'username',
            'email:email',
            [
                'attribute' => 'status',
                'value' => function (\common\models\User $model) {
                    return \common\models\User::STATUS_LABELS[$model->status];
                },
                'filter' => \common\models\User::STATUS_LABELS,
            ],
            [
                'attribute' => 'created_date',
                'format' => ['date', 'php:H:i:s d-m-Y'],
                'value' => 'created_at',
                'label' => 'Created At',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'type' => DatePicker::TYPE_RANGE,
                    'attribute' => 'created_date',
                    'attribute2' => 'created_date_end',
                    'pluginOptions' => [
                        'format' => 'dd-mm-yyyy',
                        'autoclose' => true,
                    ]]),
            ],
            [
                'attribute' => 'updated_date',
                'format' => ['date', 'php:H:i:s d-m-Y'],
                'value' => 'updated_at',
                'label' => 'Updated At',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'type' => DatePicker::TYPE_RANGE,
                    'attribute' => 'updated_date',
                    'attribute2' => 'updated_date_end',
                    'pluginOptions' => [
                        'format' => 'dd-mm-yyyy',
                        'autoclose' => true,
                    ]]),
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>