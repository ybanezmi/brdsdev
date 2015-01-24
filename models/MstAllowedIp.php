<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mst_allowed_ip".
 *
 * @property string $plant_location
 * @property string $ip_address
 */
class MstAllowedIp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mst_allowed_ip';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['plant_location', 'ip_address'], 'required'],
            [['plant_location', 'ip_address'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'plant_location' => 'Plant Location',
            'ip_address' => 'Ip Address',
        ];
    }
}
