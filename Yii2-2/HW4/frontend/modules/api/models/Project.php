<?php
namespace frontend\modules\api\models;
/**
 * {@inheritdoc}
 */
class Project extends \common\models\Project
{
    /**
     * @return array|false
     */
    public function fields() {
        return [
            'id',
            'title',
            'description_short' => function (Project $model) {
                return substr($model->description, 0, 50);
            },
            'active'
        ];
    }

    /**
     * @return array|false
     */
    public function extraFields() {

        return [
            self::RELATION_TASKS,
        ];
    }
}