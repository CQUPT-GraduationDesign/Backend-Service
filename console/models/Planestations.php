<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "planestations".
 *
 * @property integer $id
 * @property string $province
 * @property string $city
 * @property string $code
 * @property string $name
 * @property string $alphabetic
 */
class Planestations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'planestations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['province', 'city', 'code', 'name', 'alphabetic'], 'required'],
            [['name'] , 'unique'],
            [['province', 'city', 'code', 'name', 'alphabetic'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'province' => 'Province',
            'city' => 'City',
            'code' => 'Code',
            'name' => 'Name',
            'alphabetic' => 'Alphabetic',
        ];
    }
}
