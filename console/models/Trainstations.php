<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "trainstations".
 *
 * @property integer $id
 * @property string $shortalphabetic
 * @property string $name
 * @property string $alphabetic
 * @property string $code
 */
class Trainstations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trainstations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shortalphabetic', 'alphabetic', 'code'], 'required'],
            [['name'], 'unique'],
            [['shortalphabetic', 'name', 'alphabetic', 'code'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shortalphabetic' => 'Shortalphabetic',
            'name' => 'Name',
            'alphabetic' => 'Alphabetic',
            'code' => 'Code',
        ];
    }
}
