<?php

namespace api\models;

use Yii;
use yii\web\IdentityInterface;
/**
 * This is the model class for table "{{%frontuser}}".
 *
 * @property integer $uid
 * @property string $username
 * @property string $password
 * @property string $ext
 */
class Frontuser extends \yii\db\ActiveRecord implements IdentityInterface {
    public static function findIdentity($id) {
    
    }
    public static function findIdentityByAccessToken($token, $type = null) {
        $security = Yii::$app->getSecurity();
        return static::findOne(['username' => $security->decryptByKey(base64_decode($token) , Yii::$app->params['securityPass'])]);
    }
    public function getId(){

    }
    public function getAuthKey() {

    }
    public function validateAuthKey($authKey) {
    
    }
    /**
     * @inheritdoc
     */
    public static function tableName(){
        return '{{%frontuser}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(){
        return [
            [['username', 'password'], 'required' , 'message'=>'用户名和密码是必填项'],
            [['username'], 'unique', 'message'=>'用户名已经存在'],
            [['ext'], 'string','message'=>'必须是字符串'],
            [['username', 'password'], 'string', 'max' => 255 ,'message'=>'超过最大限制']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(){
        return [
            'uid' => 'pri key',
            'username' => 'Username',
            'password' => 'Password',
            'ext' => 'Ext',
        ];
    }
}
