<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "trx_handling_unit".
 *
 * @property string $id
 * @property string $transaction_id
 * @property string $customer_id
 * @property string $inbound_no
 * @property string $handling_unit
 * @property string $packaging_id
 * @property string $kitted_handling
 * @property string $item_count
 * @property string $pallet_weight
 * @property string $total_weight
 * @property string $brds_status
 * @property string $sap_status
 * @property string $sap_inbound
 * @property string $creator_id
 * @property string $created_date
 * @property string $updater_id
 * @property string $updated_date
 */
class TrxHandlingUnit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trx_handling_unit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['transaction_id', 'customer_id', 'inbound_no', 'handling_unit', 'packaging_id', 'item_count', 'pallet_weight', 'total_weight', 'creator_id', 'updater_id'], 'required'],
            [['transaction_id', 'customer_id', 'packaging_id', 'item_count', 'pallet_weight', 'total_weight', 'creator_id', 'updater_id'], 'integer'],
            [['brds_status', 'sap_status'], 'string'],
            [['created_date', 'updated_date'], 'safe'],
            [['inbound_no', 'handling_unit', 'sap_inbound'], 'string', 'max' => 32],
            [['kitted_handling'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'transaction_id' => 'Transaction ID',
            'customer_id' => 'Customer ID',
            'inbound_no' => 'Inbound No',
            'handling_unit' => 'Handling Unit',
            'packaging_id' => 'Packaging ID',
            'kitted_handling' => 'Kitted Handling',
            'item_count' => 'Item Count',
            'pallet_weight' => 'Pallet Weight',
            'total_weight' => 'Total Weight',
            'brds_status' => 'Brds Status',
            'sap_status' => 'Sap Status',
            'sap_inbound' => 'Sap Inbound',
            'creator_id' => 'Creator ID',
            'created_date' => 'Created Date',
            'updater_id' => 'Updater ID',
            'updated_date' => 'Updated Date',
        ];
    }
}
