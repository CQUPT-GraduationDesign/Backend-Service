<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "frontuser".
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
        return 'frontuser';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'unique', 'targetAttribute' => ['password', 'ext','username'], 'message'=>'data is not unique'],
            [['username' , 'password'] ,'required'],
        ];

    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'username' => 'Username',
            'password' => 'Password',
            'ext' => 'Ext',
        ];
    }
}
