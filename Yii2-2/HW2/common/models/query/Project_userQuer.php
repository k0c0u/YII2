<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Project_user]].
 *
 * @see \common\models\Project_user
 */
class Project_userQuer extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\Project_user[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Project_user|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
