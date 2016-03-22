<?php
namespace backend\models;
use Yii;
use yii\base\Model;
use common\models\LoginForm;

/**
 * @brief  backend login from model
 * @author lk1ngaa7@gmail.com
 * */
class BackendLoginForm extends  LoginForm {
    /**
     * Finds user by [[username]]
     *
     * @return BackendUser|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $backUser = new BackendUser();
            $this->_user = $backUser->findByUsername($this->username);
        }
        return $this->_user;
    }
    

}
