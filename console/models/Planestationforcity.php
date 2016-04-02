<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "planestationforcity".
 *
 * @property integer $id
 * @property integer $cityid
 * @property integer $planestationid
 *
 * @property Citys $city
 * @property Planestations $planestation
 */
class Planestationforcity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'planestationforcity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cityid', 'planestationid'], 'required'],
            [['cityid', 'planestationid'], 'integer']
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
            'planestationid' => 'Planestationid',
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
    public function getPlanestation()
    {
        return $this->hasOne(Planestations::className(), ['id' => 'planestationid']);
    }
}
