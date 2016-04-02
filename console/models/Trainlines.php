<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "trainlines".
 *
 * @property integer $id
 * @property integer $cityid
 * @property integer $trainid
 * @property string $cityname
 * @property string $fromtrain
 * @property string $totrain
 * @property string $traintype
 * @property string $trainno
 * @property string $starttime
 * @property string $endtime
 * @property string $duration
 * @property string $rawData
 *
 * @property Citys $city
 * @property Trainstations $train
 */
class Trainlines extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trainlines';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cityid', 'trainid', 'cityname', 'fromtrain', 'totrain', 'traintype', 'trainno', 'starttime', 'endtime', 'duration', 'rawData'], 'required'],
            ['fromtrain' , 'unique' , 'targetAttribute' => ['fromtrain' , 'totrain' , 'trainno' , 'starttime'] , 'message' => 'data is not unique'],
            [['cityid', 'trainid'], 'integer'],
            [['rawData'], 'string'],
            [['cityname', 'fromtrain', 'totrain', 'traintype', 'trainno', 'starttime', 'endtime', 'duration'], 'string', 'max' => 255]
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
            'trainid' => 'Trainid',
            'cityname' => 'Cityname',
            'fromtrain' => 'Fromtrain',
            'totrain' => 'Totrain',
            'traintype' => 'Traintype',
            'trainno' => 'Trainno',
            'starttime' => 'Starttime',
            'endtime' => 'Endtime',
            'duration' => 'Duration',
            'rawData' => 'Raw Data',
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
    public function getTrain()
    {
        return $this->hasOne(Trainstations::className(), ['id' => 'trainid']);
    }
}
