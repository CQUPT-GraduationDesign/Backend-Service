<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "trainstationforcity".
 *
 * @property integer $id
 * @property integer $trainstationid
 * @property integer $cityid
 *
 * @property Citys $city
 * @property Trainstations $trainstation
 */
class Trainstationforcity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trainstationforcity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['trainstationid', 'cityid'], 'required'],
            [['trainstationid', 'cityid'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'trainstationid' => 'Trainstationid',
            'cityid' => 'Cityid',
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
    public function getTrainstation()
    {
        return $this->hasOne(Trainstations::className(), ['id' => 'trainstationid']);
    }
}
