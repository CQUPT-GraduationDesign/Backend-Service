<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "transfertrainline".
 *
 * @property integer $id
 * @property integer $fromcityid
 * @property integer $tocityid
 * @property string $fromcityname
 * @property string $tocityname
 * @property string $startData
 * @property string $middleData
 * @property integer $transferSeconds
 * @property integer $onTrainDuration
 * @property integer $wholeDuration
 *
 * @property Citys $fromcity
 * @property Citys $tocity
 */
class Transfertrainline extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transfertrainline';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fromcityid', 'tocityid', 'fromcityname', 'tocityname', 'startData', 'middleData', 'transferSeconds', 'onTrainDuration', 'wholeDuration'], 'required'],
            [['fromcityid', 'tocityid', 'transferSeconds', 'onTrainDuration', 'wholeDuration'], 'integer'],
            [['startData', 'middleData'], 'string'],
            [['fromcityname', 'tocityname'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fromcityid' => 'Fromcityid',
            'tocityid' => 'Tocityid',
            'fromcityname' => 'Fromcityname',
            'tocityname' => 'Tocityname',
            'startData' => 'Start Data',
            'middleData' => 'Middle Data',
            'transferSeconds' => 'Transfer Seconds',
            'onTrainDuration' => 'On Train Duration',
            'wholeDuration' => 'Whole Duration',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromcity()
    {
        return $this->hasOne(Citys::className(), ['id' => 'fromcityid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTocity()
    {
        return $this->hasOne(Citys::className(), ['id' => 'tocityid']);
    }
}
