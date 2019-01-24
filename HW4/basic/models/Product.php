<?php

namespace app\models;

use Yii;



/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property string $price
 * @property int $created_at
 */

class Product extends \yii\db\ActiveRecord
{
    CONST SCENARIO_CREATE = 'create';
    CONST SCENARIO_UPDATE = 'update';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['name']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price', 'created_at'], 'required'],
            [['created_at'], 'integer'],
            [['name'], 'string', 'max' => 20, 'min' => 2],
            [['name'], 'filter', 'filter' => 'trim'],
            [['name'], 'filter', 'filter' => function  ($value) {
                return strip_tags($value);
            }],
            [['price'], 'integer', 'max' => 1000, 'min' => 0],
            [['id'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
            'created_at' => 'Created At',
        ];
    }
}
