<?php
namespace common\models\query;
use common\models\Project;
use common\models\ProjectUser;
use common\services\TaskService;
/**
 * This is the ActiveQuery class for [[\common\models\Project]].
 * @see \common\models\Project
 */
class ProjectQuery extends \yii\db\ActiveQuery
{
    /**
     * @param integer     $userId
     * @param string|null $role
     *
     * @return ProjectQuery
     */
    public function byUser($userId, $role = null) {
        $query = ProjectUser::find()->select('project_id')->byUser($userId, $role);
        return $this->andWhere(['id' => $query]);
    }
    /**
     * {@inheritdoc}
     * @return \common\models\Project[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }
    /**
     * {@inheritdoc}
     * @return \common\models\Project|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }
    public function byCreator($userId) {
        return $this->andWhere(['creator_id' => $userId]);
    }
}