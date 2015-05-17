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
 * @property string $net_unit
 * @property string $total_weight
 * @property string $pallet_weight
 * @property string $kitted_unit
 * @property string $manufacturing_date
 * @property string $expiry_date
 * @property string $pallet_type
 * @property string $kitting_type
 * @property string $packaging_code
 * @property string $kitting_code
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
            [['transaction_id', 'customer_code', 'material_code', 'pallet_type', 'batch', 'net_weight', 'net_unit', 'total_weight', 'pallet_no', 'packaging_code', 'pallet_weight'], 'required'],
            [['batch', 'net_weight', 'total_weight', 'pallet_weight', 'kitted_unit', 'creator_id', 'updater_id'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['status'], 'string'],
            [['customer_code', 'pallet_no', 'net_unit'], 'string', 'max' => 10],
            [['pallet_no', 'kitted_unit'], 'string', 'min' => 10],
            [['material_code', 'packaging_code', 'kitting_code'], 'string', 'max' => 32],
            [['manufacturing_date', 'expiry_date'], 'checkManufacturingExpiryDate'], // @TODO: calendar disable dates
            [['pallet_no'], 'checkPackagingPalletNoRange'],
            [['pallet_no'], 'checkKittingPalletNoRange'],
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
            'net_unit' => 'Net Weight Unit',
            'total_weight' => 'Total Weight',
            'pallet_weight' => 'Pallet Weight',
            'kitted_unit' => 'Kitted Unit',
            'manufacturing_date' => 'Manufacturing Date',
            'expiry_date' => 'Expiry Date',
            'pallet_type' => 'Pallet Type',
            'kitting_type' => 'Kitting Type',
            'packaging_code' => 'Packaging Material Code',
            'kitting_code' => 'Kitting Material Code',
            'status' => 'Status',
            'creator_id' => 'Creator ID',
            'created_date' => 'Created Date',
            'updater_id' => 'Updater ID',
            'updated_date' => 'Updated Date',
        ];
    }

	/**
	 * manufacturing and expiry date validation
	 */
	public function checkManufacturingExpiryDate($attribute, $params)
	{
		if ($this->manufacturing_date >= $this->expiry_date) {
			$this->addError('manufacturing_date', 'Manufacturing date should be less than the expiry date.');
			$this->addError('expiry_date', 'Expiry date should be greater than the manufacturing date.');
		}
	}

    /**
     * pallet_no for packaging type validation
     */
    public function checkPackagingPalletNoRange($attribute, $params) {
        $user = Yii::$app->user->identity;

        if ($user && $user->assignment) {
            $plantLocation = Yii::$app->modelFinder->findAllowedIpModel($user->assignment);

            if (substr($this->pallet_no, 0, 1) !== $plantLocation->pallet_range) {
                $this->addError('pallet_no', 'Pallet no. is not in range ['.$plantLocation->pallet_range.'*********]');
            }
        }
    }

    /**
     * pallet_no for kitting type validation
     */
    public function checkKittingPalletNoRange($attribute, $params) {
        $user = Yii::$app->user->identity;

        if ($this->kitted_unit && $user && $user->assignment) {
            $plantLocation = Yii::$app->modelFinder->findAllowedIpModel($user->assignment);

            if (substr($this->kitted_unit, 0, 1) !== $plantLocation->pallet_range) {
                $this->addError('kitted_unit', 'Pallet no. is not in range ['.$plantLocation->pallet_range.'*********]');
            }
        }
    }

}
