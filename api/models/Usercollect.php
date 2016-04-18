<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "usercollect".
 *
 * @property integer $id
 * @property integer $frontuserid
 * @property integer $transferlineid
 * @property integer $isdeleted
 * @property string $datetime
 *
 * @property Transfertrainline $transferline
 * @property Frontuser $frontuser
 */
class Usercollect extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usercollect';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['frontuserid', 'transferlineid', 'datetime'], 'required'],
            [['frontuserid', 'transferlineid', 'isdeleted'], 'integer'],
            ['frontuserid' , 'unique' , 'targetAttribute' => ['frontuserid' , 'transferlineid'] , 'message' => 'transferline for this user can not be duplicated'],
            [['datetime'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'frontuserid' => 'Frontuserid',
            'transferlineid' => 'Transferlineid',
            'isdeleted' => 'Isdeleted',
            'datetime' => 'Datetime',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransferline()
    {
        return $this->hasOne(Transfertrainline::className(), ['id' => 'transferlineid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFrontuser()
    {
        return $this->hasOne(Frontuser::className(), ['uid' => 'frontuserid']);
    }
}
