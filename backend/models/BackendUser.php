<?php
namespace backend\models;

use yii\base\Model;
use yii\web\IdentityInterface;
 
class BackendUser  extends Model implements IdentityInterface {
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;
    public $_currentUsername = '';
    private static $_userArray = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey'  => 'backend100key',
            'accessToken' => '100-token',
        ],
    ];
    public function findByUsername($username){
        foreach (self::$_userArray as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }
        return null;
    }
    public function validatePassword($pass = ""){
        return $this->password === $pass;
    } 
    /**
     * @inheritdoc
     */
    public static function findIdentity($id){
        return isset(self::$_userArray[$id]) ? new static(self::$_userArray[$id]) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null){
        foreach (self::$_userArray as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey(){
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey){
        return $this->authKey === $authKey;
    }
}
