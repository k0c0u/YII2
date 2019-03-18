<?php
namespace frontend\modules\api\models;
/**
 * {@inheritdoc}
 */
class User extends \common\models\User
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedTasks() {
        return $this->hasMany(Task::className(), ['creator_id' => 'id']);
    }

    /**
     * @return array|false
     */
    public function fields() {
        return [
            'username', 'email'
        ];
    }

    /**
     * @return array|false
     */
    public function extraFields() {
        return [
            self::RELATION_CREATED_TASKS,
            self::RELATION_ACTIVED_TASKS,
            self::RELATION_UPDATED_TASKS,
            self::RELATION_CREATED_PROJECTS,
            self::RELATION_UPDATED_PROJECTS,
        ];
    }
}