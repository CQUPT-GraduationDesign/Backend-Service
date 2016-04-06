<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "maxtrainduration".
 *
 * @property integer $id
 * @property integer $fromcityid
 * @property integer $tocityid
 * @property integer $maxduration
 * @property integer $trainlineid
 * @property string $trainlinerawdata
 */
class Maxtrainduration extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'maxtrainduration';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fromcityid', 'tocityid', 'maxduration', 'trainlineid', 'trainlinerawdata'], 'required'],
            [['fromcityid', 'tocityid', 'maxduration', 'trainlineid'], 'integer'],
            [['trainlinerawdata'], 'string']
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
            'maxduration' => 'Maxduration',
            'trainlineid' => 'Trainlineid',
            'trainlinerawdata' => 'Trainlinerawdata',
        ];
    }
}
