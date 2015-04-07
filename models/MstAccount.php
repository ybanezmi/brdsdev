<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mst_account".
 *
 * @property string $id
 * @property string $account_type
 * @property string $username
 * @property string $password
 * @property string $auth_key
 * @property string $access_token
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $address
 * @property string $contact_no
 * @property string $notify
 * @property string $notify_conact_no
 * @property string $assignment
 * @property string $next_assignment
 * @property string $start_date
 * @property string $end_date
 * @property string $next_start_date
 * @property string $next_end_date
 * @property string $last_login_date
 * @property string $status
 * @property string $creator_id
 * @property string $created_date
 * @property string $updater_id
 * @property string $updated_date
 */
class MstAccount extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mst_account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_type', 'username', 'password', 'first_name', 'middle_name', 'last_name', 'address', 'contact_no', 
              'notify', 'notify_conact_no', 'assignment', 'status', 'creator_id', 'updater_id'], 'required'],
            [['account_type', 'status'], 'string'],
            [['start_date', 'end_date', 'next_start_date', 'next_end_date', 'last_login_date', 'created_date', 'updated_date'], 'safe'],
            [['creator_id', 'updater_id'], 'integer'],
            [['username', 'password', 'auth_key', 'access_token'], 'string', 'max' => 32],
            [['first_name', 'middle_name', 'last_name', 'contact_no'], 'string', 'max' => 100],
            [['address', 'notify', 'notify_conact_no'], 'string', 'max' => 255],
            [['assignment', 'next_assignment'], 'string', 'max' => 50],
            [['contact_no', 'notify_conact_no'], 'match', 'not' => true, 'pattern' => '/[^0-9()-]/', 'message' => 'Incorrect contact no. format.'],
            [['username'], 'validateUsername'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account_type' => 'Account Type',
            'username' => 'Username',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'address' => 'Address',
            'contact_no' => 'Contact No',
            'notify' => 'Notify',
            'notify_conact_no' => 'Notify Conact No',
            'assignment' => 'Assignment',
            'next_assignment' => 'Next Assignment',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'next_start_date' => 'Next Start Date',
            'next_end_date' => 'Next End Date',
            'last_login_date' => 'Last Login Date',
            'status' => 'Status',
            'creator_id' => 'Creator ID',
            'created_date' => 'Created Date',
            'updater_id' => 'Updater ID',
            'updated_date' => 'Updated Date',
        ];
    }

	/**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
    	$account = MstAccount::find()
			    	->where(['id'	 => $id,
			    		 	'status' => Yii::$app->params['STATUS_ACTIVE']])
			    	->one();

		// update last login date
		$account->last_login_date = date('Y-m-d H:i:s'); //@TODO change to global date format
		$account->save();
			
		return isset($account) ? new static($account) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
    	$account = MstAccount::find()
			    	->where(['access_token'	=> $token,
			    		 	 'status' 		=> Yii::$app->params['STATUS_ACTIVE']])
			    	->one();

        return new static($account);
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $account = MstAccount::find()
			    	->where(['username'	=> $username,
			    		 	 'status' => Yii::$app->params['STATUS_ACTIVE']])
			    	->one();

        return $account;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === md5($password);
	}

    /**
     * Validates username
     *
     * @param attribute
     * @param $params
     */
    public function validateUsername($attribute, $params)
    {
        $userName = MstAccount::findByUsername($this->username);
        if ($userName) {
            $this->addError('username', 'Username is already taken.');
        }
    }
}
