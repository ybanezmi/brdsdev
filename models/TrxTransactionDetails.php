<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "trx_transaction_details".
 *
 * @property string $id
 * @property string $transaction_id
 * @property string $customer_code
 * @property string $material_code
 * @property string $batch
 * @property string $pallet_no
 * @property string $net_weight
 * @property string $total_weight
 * @property string $pallet_weight
 * @property string $kitted_unit
 * @property string $manufacturing_date
 * @property string $expiry_date
 * @property string $pallet_type
 * @property string $status
 * @property string $creator_id
 * @property string $created_date
 * @property string $updater_id
 * @property string $updated_date
 */
class TrxTransactionDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trx_transaction_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['transaction_id', 'customer_code', 'material_code', 'pallet_type', 'batch', 'net_weight', 'total_weight', 'pallet_no', 'kitted_unit', 'pallet_weight'], 'required'],
            [['transaction_id', 'batch', 'net_weight', 'total_weight', 'pallet_weight', 'kitted_unit', 'creator_id', 'updater_id'], 'integer'],
            [['manufacturing_date', 'expiry_date', 'created_date', 'updated_date'], 'safe'],
            [['status'], 'string'],
            [['customer_code', 'pallet_no', 'pallet_type'], 'string', 'max' => 10],
            [['material_code'], 'string', 'max' => 32],
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
            'customer_code' => 'Customer Code',
            'material_code' => 'Material Code',
            'batch' => 'Batch',
            'pallet_no' => 'Pallet No',
            'net_weight' => 'Net Weight',
            'total_weight' => 'Total Weight',
            'pallet_weight' => 'Pallet Weight',
            'kitted_unit' => 'Kitted Unit',
            'manufacturing_date' => 'Manufacturing Date',
            'expiry_date' => 'Expiry Date',
            'pallet_type' => 'Pallet Type',
            'status' => 'Status',
            'creator_id' => 'Creator ID',
            'created_date' => 'Created Date',
            'updater_id' => 'Updater ID',
            'updated_date' => 'Updated Date',
        ];
    }
}
