<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "trx_handling_unit".
 *
 * @property integer $id
 * @property string $transaction_id
 * @property string $customer_code
 * @property string $inbound_no
 * @property string $pallet_no
 * @property string $plant_location
 * @property string $storage_location
 * @property string $packaging_code
 * @property double $pallet_weight
 * @property string $transfer_order
 * @property string $storage_type
 * @property string $storage_section
 * @property string $storage_bin
 * @property string $inbound_status
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
            [['transaction_id', 'customer_code', 'inbound_no', 'pallet_no', 'plant_location', 'storage_location', 'packaging_code', 'pallet_weight',
            'inbound_status', 'creator_id', 'updater_id'], 'required'],
            [['pallet_weight'], 'number'],
            [['creator_id', 'updater_id'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['transaction_id', 'customer_code', 'inbound_no', 'pallet_no'], 'string', 'max' => 10],
            [['plant_location', 'storage_location', 'packaging_code', 'transfer_order', 'storage_type', 'storage_section', 'storage_bin', 'inbound_status'], 'string', 'max' => 32],
            [['transaction_id', 'customer_code', 'inbound_no', 'pallet_no'], 'validateTO'],
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
            'inbound_no' => 'Inbound No',
            'pallet_no' => 'Pallet No',
            'plant_location' => 'Plant Location',
            'storage_location' => 'Storage Location',
            'packaging_code' => 'Packaging Code',
            'pallet_weight' => 'Pallet Weight',
            'transfer_order' => 'Transfer Order',
            'storage_type' => 'Storage Type',
            'storage_section' => 'Storage Section',
            'storage_bin' => 'Storage Bin',
            'inbound_status' => 'Inbound Status',
            'creator_id' => 'Creator ID',
            'created_date' => 'Created Date',
            'updater_id' => 'Updater ID',
            'updated_date' => 'Updated Date',
        ];
    }

    /**
     * Find unique user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findUniqueTO($transactionId, $customerCode, $inboundNo, $palletNo)
    {
        $handlingUnit = TrxHandlingUnit::find()
                    ->where(['transaction_id'   => $transactionId,
                             'customer_code'    => $customerCode,
                             'inbound_no'       => $inboundNo,
                             'pallet_no'        => $palletNo,
                             'inbound_status'           => [Yii::$app->params['STATUS_PROCESS'],
                                                    Yii::$app->params['STATUS_CLOSED']]])
                    ->one();

        return $handlingUnit;
    }

    /**
     * Validates username
     *
     * @param attribute
     * @param $params
     */
    public function validateTO($attribute, $params)
    {
        $handlingUnit = TrxHandlingUnit::findUniqueTO($this->transaction_id, $this->customer_code, $this->inbound_no, $this->pallet_no);
        if ($handlingUnit) {
            $this->addError('transfer_order', 'Transfer Order has already been issued.');
        }
    }
}
