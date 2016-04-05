<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "planelineout".
 *
 * @property integer $id
 * @property integer $cityid
 * @property string $planeno
 * @property string $fromcode
 * @property string $tocode
 * @property string $fromname
 * @property string $toname
 * @property string $starttime
 * @property string $endtime
 * @property string $rawdata
 *
 * @property Citys $city
 * @property Planestations $fromcode0
 * @property Planestations $tocode0
 */
class Planelineout extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'planelineout';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cityid', 'planeno', 'fromcode', 'tocode', 'fromname', 'toname', 'starttime', 'endtime', 'rawdata'], 'required'],
            ['fromname' , 'unique' , 'targetAttribute' => ['fromname' , 'toname' , 'planeno' , 'starttime'] , 'message' => 'data is not unique [planelines OUT]'],
            [['cityid'], 'integer'],
            [['rawdata'], 'string'],
            [['planeno', 'fromcode', 'tocode', 'fromname', 'toname', 'starttime', 'endtime'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cityid' => 'Cityid',
            'planeno' => 'Planeno',
            'fromcode' => 'Fromcode',
            'tocode' => 'Tocode',
            'fromname' => 'Fromname',
            'toname' => 'Toname',
            'starttime' => 'Starttime',
            'endtime' => 'Endtime',
            'rawdata' => 'Rawdata',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Citys::className(), ['id' => 'cityid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromcode0()
    {
        return $this->hasOne(Planestations::className(), ['code' => 'fromcode']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTocode0()
    {
        return $this->hasOne(Planestations::className(), ['code' => 'tocode']);
    }
}
