<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "{{%frontuser}}".
 *
 * @property integer $uid
 * @property string $username
 * @property string $password
 * @property string $ext
 */
class Frontuser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%frontuser}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'username', 'password'], 'required'],
            [['uid'], 'integer'],
            [['ext'], 'string'],
            [['username', 'password'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'pri key',
            'username' => 'Username',
            'password' => 'Password',
            'ext' => 'Ext',
        ];
    }
}
