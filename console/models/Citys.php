<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "citys".
 *
 * @property integer $id
 * @property string $name
 * @property integer $trainstationnum
 * @property integer $planestationnum
 *
 * @property Planestationforcity[] $planestationforcities
 * @property Trainstationforcity[] $trainstationforcities
 */
class Citys extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'citys';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['trainstationnum', 'planestationnum'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'trainstationnum' => 'Trainstationnum',
            'planestationnum' => 'Planestationnum',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanestationforcities()
    {
        return $this->hasMany(Planestationforcity::className(), ['cityid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainstationforcities()
    {
        return $this->hasMany(Trainstationforcity::className(), ['cityid' => 'id']);
    }
    public function getTrains()
    {
        $trainList = [];
        foreach($this->trainstationforcities as $tc){
            $train = Trainstations::findOne(['id' => $tc->trainstationid]);
            if(!empty($train)){
                $trainList[] = $train;
            }
        }  
        return $trainList;
    }
    public function getPlanes()
    {
        $planeList = [];
        foreach($this->planestationforcities as $pc){
            $plane = Planestations::findOne(['id' => $pc->planestationid]);
            if(!empty($plane)){
                $planeList[] = $plane;
            }
        }  
        return $planeList;
        
    }
}
