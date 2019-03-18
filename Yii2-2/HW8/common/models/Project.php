<?php
namespace common\models;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "project".
 * @property int           $id
 * @property string        $title
 * @property string        $description
 * @property int           $active
 * @property int           $creator_id
 * @property int           $updater_id
 * @property int           $created_at
 * @property int           $updated_at
 * @property User          $creator
 * @property User          $updater
 * @property User[]        $accessedUsers
 * @property ProjectUser[] $projectUsers
 * @property Task[]        $tasks
 */
class Project extends \yii\db\ActiveRecord
{
    const RELATION_PROJECT_USERS = 'projectUsers';
    const RELATION_ACCESSED_USERS = 'accessedUsers';
    const RELATION_TASKS = 'tasks';
    const STATUS_NOTACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUSES = [self::STATUS_ACTIVE, self::STATUS_NOTACTIVE];
    const STATUS_LABELS = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_NOTACTIVE => 'Not active',
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%project}}';
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
            'saveRelations' => [
                'class' => SaveRelationsBehavior::class,
                'relations' => [self::RELATION_PROJECT_USERS],
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
            [['creator_id', 'updater_id', 'created_at', 'updated_at'], 'integer'],
            ['active', 'default', 'value' => self::STATUS_ACTIVE],
            ['active', 'in', 'range' => self::STATUSES],
            [['title'], 'string', 'max' => 255],
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
            'active' => 'Active',
            'creator_id' => 'Creator ID',
            'updater_id' => 'Updater ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    /**
     * Get author of task
     * @return \yii\db\ActiveQuery
     */
    public function getCreator() {
        return $this->hasOne(User::className(), ['id' => 'creator_id']);
    }
    /**
     * Get updater of task
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater() {
        return $this->hasOne(User::className(), ['id' => 'updater_id']);
    }
    /**
     * Get accessed users for project
     * @return \yii\db\ActiveQuery
     */
    public function getProjectUsers() {
        return $this->hasMany(ProjectUser::className(), ['project_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks() {
        return $this->hasMany(Task::className(), ['project_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessedUsers() {
        return $this->hasMany(User::className(), ['id' => 'user_id'])
            ->via('projectUsers');
    }
    /**
     * {@inheritdoc}
     * @return \common\models\query\ProjectQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\models\query\ProjectQuery(get_called_class());
    }

    public function getUserData() {
        return $this->getProjectUsers()->select('role')->indexBy('user_id')->column();
    }
}
