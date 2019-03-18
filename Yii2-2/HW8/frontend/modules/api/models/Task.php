<?php
namespace frontend\modules\api\models;
/**
 * {@inheritdoc}
 */
class Task extends \common\models\Task
{
    /**
     * @return array|false
     */
    public function fields() {
        return [
            'id',
            'title',
            'description_short' => function (Task $model) {
                return mb_substr($model->description, 0, 50);
            }
        ];
    }

    /**
     * @return array|false
     */
    public function extraFields() {

        return [
            self::RELATION_PROJECT,
        ];
    }
}