<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "trx_transactions".
 *
 * @property string $id
 * @property string $customer_code
 * @property string $inbound_no
 * @property string $plant_location
 * @property string $storage_location
 * @property string $pallet_count
 * @property string $quantity
 * @property string $unit
 * @property string $weight
 * @property string $packaging_id
 * @property string $lower_hu
 * @property string $remarks
 * @property string $truck_van
 * @property string $actual_gr_date
 * @property string $status
 * @property string $creator_id
 * @property string $created_date
 * @property string $updater_id
 * @property string $updated_date
 */
class TrxTransactions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trx_transactions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_code', 'plant_location', 'storage_location', 'truck_van', 'actual_gr_date'], 'required'],
            [['pallet_count', 'quantity', 'packaging_id', 'creator_id', 'updater_id'], 'integer'],
            [['weight'], 'double'],
            [['actual_gr_date', 'created_date', 'updated_date'], 'safe'],
            [['id','customer_code', 'truck_van'], 'string', 'max' => 10],
            [['inbound_no', 'plant_location', 'storage_location', 'lower_hu'], 'string', 'max' => 32],
            [['unit'], 'string', 'max' => 4],
            [['truck_van'], 'match', 'not' => true, 'pattern' => '/[^a-z A-Z0-9_-]/', 'message' => 'Must contain alphanumeric, space, underscore (_) and dash (-) characters only.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_code' => 'Customer Code',
            'inbound_no' => 'Inbound No',
            'plant_location' => 'Plant Location',
            'storage_location' => 'Storage Location',
            'pallet_count' => 'Pallet Count',
            'quantity' => 'Quantity',
            'unit' => 'Unit',
            'weight' => 'Weight',
            'packaging_id' => 'Packaging ID',
            'lower_hu' => 'Lower Hu',
            'remarks' => 'Remarks',
            'truck_van' => 'Truck Plate #',
            'actual_gr_date' => 'Actual GR Date',
            'status' => 'Status',
            'creator_id' => 'Creator ID',
            'created_date' => 'Created Date',
            'updater_id' => 'Updater ID',
            'updated_date' => 'Updated Date',
        ];
    }
}
