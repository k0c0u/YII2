<?php
namespace common\models;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
/**
 * Task model
 * @property integer $id
 * @property string  $title
 * @property string  $description
 * @property integer $project_id
 * @property integer $executor_id
 * @property integer $started_at
 * @property integer $completed_at
 * @property integer $creator_id
 * @property integer $updater_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property Project $project
 * @property User    $executor
 * @property User    $creator
 * @property User    $updater
 */
class Task extends \yii\db\ActiveRecord
{
    const RELATION_PROJECT = 'project';
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%task}}';
    }
    /**
     * @return array
     */
    public function behaviors() {
        return [
            TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'creator_id',
                'updatedByAttribute' => 'updater_id',
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['title', 'description'], 'required'],
            [['description'], 'string'],
            [['project_id', 'executor_id', 'started_at', 'completed_at', 'creator_id', 'updater_id', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['executor_id' => 'id']],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id']],
            [['updater_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updater_id' => 'id']],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'project_id' => 'Project ID',
            'executor_id' => 'Executor ID',
            'started_at' => 'Started At',
            'completed_at' => 'Completed At',
            'creator_id' => 'Creator ID',
            'updater_id' => 'Updater ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExecutor() {
        return $this->hasOne(User::className(), ['id' => 'executor_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator() {
        return $this->hasOne(User::className(), ['id' => 'creator_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater() {
        return $this->hasOne(User::className(), ['id' => 'updater_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject() {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }
    /**
     * {@inheritdoc}
     * @return \common\models\query\TaskQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\models\query\TaskQuery(get_called_class());
    }
}