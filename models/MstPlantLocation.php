<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mst_plant_location".
 *
 * @property string $plant_location
 * @property string $storage_location
 * @property string $storage_name
 * @property string $allowed_ip
 * @property string $status
 * @property string $creator_id
 * @property string $created_date
 * @property string $updater_id
 * @property string $updated_date
 */
class MstPlantLocation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mst_plant_location';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['plant_location', 'storage_location', 'storage_name', 'allowed_ip', 'creator_id', 'updater_id'], 'required'],
            [['status'], 'string'],
            [['creator_id', 'updater_id'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['plant_location', 'storage_location', 'allowed_ip'], 'string', 'max' => 32],
            [['storage_name'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'plant_location' => 'Plant Location',
            'storage_location' => 'Storage Location',
            'storage_name' => 'Storage Name',
            'allowed_ip' => 'Allowed Ip',
            'status' => 'Status',
            'creator_id' => 'Creator ID',
            'created_date' => 'Created Date',
            'updater_id' => 'Updater ID',
            'updated_date' => 'Updated Date',
        ];
    }
}
