<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mst_customer".
 *
 * @property string $code
 * @property string $name
 * @property string $address
 * @property string $status
 * @property string $creator_id
 * @property string $created_date
 * @property string $updater_id
 * @property string $updated_date
 */
class MstCustomer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mst_customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'address', 'creator_id', 'updater_id'], 'required'],
            [['status'], 'string'],
            [['creator_id', 'updater_id'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['code'], 'string', 'max' => 10],
            [['name', 'address'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Code',
            'name' => 'Name',
            'address' => 'Address',
            'status' => 'Status',
            'creator_id' => 'Creator ID',
            'created_date' => 'Created Date',
            'updater_id' => 'Updater ID',
            'updated_date' => 'Updated Date',
        ];
    }
}
