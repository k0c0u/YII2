<?php
namespace common\models;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
/**
 * User model
 * @property integer   $id
 * @property string    $username
 * @property string    $password_hash
 * @property string    $password_reset_token
 * @property string    $email
 * @property string    $avatar
 * @property string    $auth_key
 * @property integer   $status
 * @property integer   $created_at
 * @property integer   $created_date
 * @property integer   $updated_at
 * @property integer   $updated_date
 * @property string    $password
 * @property Task[]    $createdTasks
 * @property Task[]    $activedTasks
 * @property Task[]    $updatedTasks
 * @property Task[]    $completedTasks
 * @property Project[] $createdProjects
 * @property Project[] $updatedProjects
 * @property Project[] $projectUsers
 * @property Project[] $accessedProjects
 * @mixin \mohorev\file\UploadImageBehavior
 */
class User extends ActiveRecord implements IdentityInterface
{
    private $password;
    const ADMIN_ID = 1;
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const STATUSES = [self::STATUS_ACTIVE, self::STATUS_DELETED];
    const STATUS_LABELS = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_DELETED => 'Deleted',
    ];
    const SCENARIO_INSERT = 'insert';
    const SCENARIO_UPDATE = 'update';
    const AVATAR_ICO = 'ico';
    const AVATAR_PREVIEW = 'preview';
    const RELATION_CREATED_TASKS = 'createdTasks';
    const RELATION_ACTIVED_TASKS = 'activedTasks';
    const RELATION_UPDATED_TASKS = 'updatedTasks';
    const RELATION_COMPLETED_TASKS = 'completedTasks';
    const RELATION_CREATED_PROJECTS = 'createdProjects';
    const RELATION_UPDATED_PROJECTS = 'updatedProjects';
    const RELATION_PROJECT_USERS = 'projectUsers';
    const RELATION_ACCESSED_PROJECTS = '$accessedProjects';

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%user}}';
    }
    public function behaviors() {
        return [
            TimestampBehavior::className(),
            [
                'class' => \mohorev\file\UploadImageBehavior::class,
                'attribute' => 'avatar',
                'scenarios' => [self::SCENARIO_UPDATE, self::SCENARIO_INSERT],
                'path' => '@frontend/web/upload/user/{id}',
                'url' => Yii::$app->params['front.domain'] . Yii::getAlias('@web/upload/user/{id}'),
                'thumbs' => [
                    self::AVATAR_ICO => ['width' => 40, 'quality' => 90],
                    self::AVATAR_PREVIEW => ['width' => 200, 'height' => 200],
                ],
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['username', 'email'], 'required'],
            [['username', 'email'], 'trim'],
            [['username', 'email'], 'unique'],
            ['email', 'email'],
            [['password'], 'required', 'except' => [self::SCENARIO_UPDATE]],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => self::STATUSES],
            [['username', 'email', 'auth_key', 'password'], 'safe'],
            ['avatar', 'image',
                'extensions' => 'jpg, jpeg, gif, png, tiff',
                'on' => [self::SCENARIO_UPDATE, self::SCENARIO_INSERT],
                'minWidth' => 30,
                'maxWidth' => 600,
                'minHeight' => 30,
                'maxHeight' => 600],
            [['username', 'email'], 'string', 'max' => 255],
        ];
    }
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->generateAuthKey();
            }
            return true;
        }
        return false;
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    /**
     * Finds user by username
     *
     * @param string $username
     *
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }
    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     *
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }
        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }
    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     *
     * @return bool
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }
        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }
    /**
     * {@inheritdoc}
     */
    public function getId() {
        return $this->getPrimaryKey();
    }
    /**
     * {@inheritdoc}
     */
    public function getAuthKey() {
        return $this->auth_key;
    }
    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }
    /**
     * Validates password
     *
     * @param string $password password to validate
     *
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        if ($password) {
            $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        }
        $this->password = $password;
    }
    /**
     * Return password value
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }
    /**
     * Get created tasks by user
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedTasks() {
        return $this->hasMany(Task::className(), ['creator_id' => 'id']);
    }
    /**
     * Get active tasks for user
     * @return \yii\db\ActiveQuery
     */
    public function getActivedTasks() {
        return $this->hasMany(Task::className(), ['executor_id' => 'id']);
    }
    /**
     * Get completed tasks by user
     * @return \yii\db\ActiveQuery
     */
    public function getCompletedTasks() {
        return $this->hasMany(Task::className(), ['completed_id' => 'id']);
    }
    /**
     * Get updated tasks by user
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedTasks() {
        return $this->hasMany(Task::className(), ['updater_id' => 'id']);
    }
    /**
     * Get created projects by user
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedProjects() {
        return $this->hasMany(Project::className(), ['creator_id' => 'id']);
    }
    /**
     * Get updated projects by user
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedProjects() {
        return $this->hasMany(Project::className(), ['updater_id' => 'id']);
    }
    /**
     * Get numbers of projects accessed for user
     * @return \yii\db\ActiveQuery
     */
    public function getProjectUsers() {
        return $this->hasMany(ProjectUser::className(), ['user_id' => 'id']);
    }
    /**
     * Get projects accessed for user
     * @return \yii\db\ActiveQuery
     */
    public function getAccessedProjects() {
        return $this->hasMany(Project::className(), ['id' => 'project_id'])
            ->via($this::RELATION_PROJECT_USERS);
    }
    /**
     * @return string|null
     */
    public function getAvatar() {
        return $this->getThumbUploadUrl('avatar', self::AVATAR_ICO);
    }
    public function getUsername() {
        $this->username . '[' . $this->id . ']';
    }
    /**
     * {@inheritdoc}
     * @return \common\models\query\UserQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\models\query\UserQuery(get_called_class());
    }
}