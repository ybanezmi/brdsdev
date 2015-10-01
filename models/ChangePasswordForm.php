<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ChangePasswordForm is the model behind the change password form.
 */
class ChangePasswordForm extends Model
{
    public $shouldValidateOldPassword = true;
    public $oldPassword;
	public $newPassword;
	public $confirmNewPassword;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // all passwords are both required
            [['oldPassword', 'newPassword', 'confirmNewPassword'], 'required'],
            [['oldPassword', 'newPassword', 'confirmNewPassword'], 'string', 'max' => 32],
            // old password is validated by validateOldPassword()
            ['oldPassword', 'validateOldPassword'],
            // new password is validated by validateNewPassword()
            ['newPassword', 'validateNewPassword'],
            // confirm new password is validated by validateConfirmNewPassword()
            ['confirmNewPassword', 'validateConfirmNewPassword'],
        ];
    }

    /**
     * Validates the old password.
     * This method serves as the inline validation for old password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateOldPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = Yii::$app->user->identity;
            if (!$user && shouldValidateOldPassword && !$user->validatePassword($this->oldPassword)) {
            	if(preg_match('/(?i)msie [1-6]/',$_SERVER['HTTP_USER_AGENT'])) {
            		// if IE <= 6
            		echo 'alert("Incorrect password.")';
            	} else {
            		$this->addError($attribute, 'Incorrect password.');
            	}
            }
        }
    }

    /**
     * Validates the new password.
     * This method serves as the inline validation for new password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateNewPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if ($this->newPassword === Yii::$app->params['DEFAULT_PASSWORD']) {
                if(preg_match('/(?i)msie [1-6]/',$_SERVER['HTTP_USER_AGENT'])) {
                    // if IE <= 6
                    echo 'alert("New password should not use default password.")';
                } else {
                    $this->addError($attribute, 'New password should not use default password.');
                }
            } else if ($this->oldPassword === $this->newPassword) {
                if(preg_match('/(?i)msie [1-6]/',$_SERVER['HTTP_USER_AGENT'])) {
                    // if IE <= 6
                    echo 'alert("New password should not be the same with old password.")';
                } else {
                    $this->addError($attribute, 'New password should not be the same with old password.');
                }
            }
        }
    }

	/**
     * Validates the confirm new password.
     * This method serves as the inline validation for confirm new password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateConfirmNewPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
        	if ($this->confirmNewPassword != $this->newPassword) {
        		if(preg_match('/(?i)msie [1-6]/',$_SERVER['HTTP_USER_AGENT'])) {
            		// if IE <= 6
            		echo 'alert("The new password and confirmation password do not match.")';
            	} else {
            		$this->addError($attribute, 'The new password and confirmation password do not match.');
            	}
        	}
        }
    }

	/**
     * Changes the password of user using the provided old password, new password and confirm new password.
     * @return boolean whether the user has changed password successfully
     */
    public function changePassword()
    {
        if ($this->validate()) {
			$user = Yii::$app->modelFinder->findAccountModel(Yii::$app->user->identity->id);
			$user->password = md5($this->newPassword);
			return $user->save();
        } else {
            return false;
        }
    }

}
