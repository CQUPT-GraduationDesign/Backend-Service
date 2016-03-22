<?php
namespace backend\models;

use yii\base\Model;
use yii\web\IdentityInterface;
 
class BackendUser  extends Model implements IdentityInterface {
    public $username;
    public $password;
    public $_currentUsername = '';
    private $_userArray = [
            'admin' => '123456',
    ];
    public function findByUsername($username = ""){
        $uss = array_keys($this->_userArray);
        if(in_array($username , $uss)){
            $backU = new BackendUser();
            $backU->username = $username;
            $backU->_currentUsername = $username;
            return $backU; 
        }else{
            return null;
        }
    }
    public function validatePassword($pass = ""){
        if(empty($this->_currentUsername)){
            return false;
        }
        if($pass !== $this->_userArray[$this->_currentUsername]){
            return false;
        }
        return true;
    } 
    public static function findIdentity($id){
        return true;
    }

    public static function findIdentityByAccessToken($token, $type = null){
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public function getId(){
        return '1';
    }

    public function getAuthKey(){
        return "";
    }

    public function validateAuthKey($authKey){
        return true;
    }
    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
}
