<?php
use common\models\Project;
use unclead\multipleinput\MultipleInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\models\Project */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $users common\models\User[] */
?>

<div class="project-form">

    <?php $form = \yii\bootstrap\ActiveForm::begin([
        'layout' => 'horizontal',
        'fieldConfig' => [
            'horizontalCssClasses' => ['label' => 'col-sm-2',]
        ],
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'active')->dropDownList(\common\models\Project::STATUS_LABELS) ?>


    <?php if (!$model->isNewRecord): ?>
        <?= $form->field($model, \common\models\Project::RELATION_PROJECT_USERS)
            ->widget(MultipleInput::className(), [
                //https://github.com/unclead/yii2-multiple-input
                'max' => 10,
                'min' => 0,
                'addButtonPosition' => MultipleInput::POS_HEADER,
                'columns' => [
                    [
                        'name' => 'project_id',
                        'type' => 'hiddenInput',
                        'defaultValue' => $model->id,
                    ],
                    [
                        'name' => 'user_id',
                        'type' => 'dropDownList',
                        'title' => 'User',
                        'items' => $users,
                    ],
                    [
                        'name' => 'role',
                        'type' => 'dropDownList',
                        'title' => 'Role',
                        'items' => \common\models\ProjectUser::ROLES,
                    ],
                ]
            ]); ?>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-2 col-md-offset-2">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php \yii\bootstrap\ActiveForm::end(); ?>

</div>