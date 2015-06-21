<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
            	if(preg_match('/(?i)msie [1-6]/',$_SERVER['HTTP_USER_AGENT'])) {
            		// if IE <= 6
            		echo 'alert("Incorrect username or password.")';
            	} else {
            		$this->addError($attribute, 'Incorrect username or password.');
            	}

            }

			if($user && !$user->assignment) {
				if(preg_match('/(?i)msie [1-6]/',$_SERVER['HTTP_USER_AGENT'])) {
            		// if IE <= 6
            		echo 'alert("User assignment not set. Please contact your administrator.")';
            	} else {
					$this->addError($attribute, 'User assignment not set. Please contact your administrator.');
				}
			}

			if ($user && $user->assignment) {
				$plantLocation = Yii::$app->modelFinder->findAllowedIpModel($user->assignment);

				$allowedIP =  explode('.', $plantLocation->ip_address);
				$userIP = explode('.', Yii::$app->request->userIP);

				unset($allowedIP[3]);
				unset($userIP[3]);

				$allowedIP = implode('.', $allowedIP);
				$userIP = implode('.', $userIP);

				if ($allowedIP !== $userIP) {
					$this->addError($attribute, 'Login not allowed from this ip address.');
				}
			}
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $model = Yii::$app->modelFinder->findAccountModel($this->getUser()->id);
            $model->last_login_date = date('Y-m-d H:i:s');
            $model->save();
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = MstAccount::findByUsername($this->username);
        }

        return $this->_user;
    }
}
