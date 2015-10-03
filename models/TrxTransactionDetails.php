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
            [['kitted_unit', 'creator_id', 'updater_id'], 'integer'],
            [['net_weight', 'total_weight', 'pallet_weight'], 'double', 'min' => 0.001],
            [['pallet_weight'], 'double', 'max' => 1000],
            [['created_date', 'updated_date'], 'safe'],
            [['status'], 'string'],
            [['customer_code', 'pallet_no', 'net_unit'], 'string', 'max' => 10],
            [['pallet_no', 'kitted_unit'], 'string', 'min' => 10],
            [['material_code', 'packaging_code', 'kitting_code'], 'string', 'max' => 32],
            [['manufacturing_date', 'expiry_date'], 'checkManufacturingExpiryDate'], // @TODO: calendar disable dates
            [['pallet_no', 'kitted_unit'], 'checkUniquePalletKittedUnit'],
            [['pallet_no'], 'checkPackagingPalletNoRange'],
            [['kitted_unit'], 'checkKittingPalletNoRange'],
            [['pallet_no'], 'checkPallet'],
            [['kitted_unit'], 'checkKittedUnit'],
            [['pallet_type'], 'checkPalletTypeCompatibility'],
            [['kitting_type'], 'checkKittingTypeCompatibility'],
            [['batch'], 'match', 'not' => true, 'pattern' => '/[^a-zA-Z0-9- ]/', 'message' => 'Must contain alphanumeric, space ( ), and dash (-) characters only.'],
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
     * unique pallet_no and kitted_unit
     */
    public function checkUniquePalletKittedUnit($attribute, $params) {
        if ($this->pallet_no === $this->kitted_unit) {
            $this->addError('pallet_no', 'Pallet # should not be the same with Kitting #');
            $this->addError('kitted_unit', 'Kitted # should not be the same with Pallet #');
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

    /**
     * pallet_type validation
     */
    public function checkPalletTypeCompatibility($attribute, $params) {
        $transactionDetailsModel = Yii::$app->modelFinder->getTransactionDetailList(null, null, null,
                                                                                    ['pallet_no' => $this->pallet_no,
                                                                                     'status'    => [Yii::$app->params['STATUS_PROCESS'], Yii::$app->params['STATUS_CLOSED'], Yii::$app->params['STATUS_REJECTED']]]);
        if ($transactionDetailsModel != null && count($transactionDetailsModel) > 0) {
            $material = Yii::$app->modelFinder->findMaterialModel($this->material_code);
            if ($transactionDetailsModel[0]['pallet_type'] !== $material['pallet_ind']) {
                $this->addError('pallet_no', 'Compatibility error. Pallet type is different with the selected customer product pallet type. Please select compatible customer product.');
            }
        }
    }

    /**
     * kitting_type validation
     */
    public function checkKittingTypeCompatibility($attribute, $params) {
        $transactionDetailsModel = Yii::$app->modelFinder->getTransactionDetailList(null, null, null,
                                                                                    ['kitted_unit' => $this->kitted_unit,
                                                                                     'status'    => [Yii::$app->params['STATUS_PROCESS'], Yii::$app->params['STATUS_CLOSED'], Yii::$app->params['STATUS_REJECTED']]]);
        if ($transactionDetailsModel != null && count($transactionDetailsModel) > 0) {
            $material = Yii::$app->modelFinder->findMaterialModel($this->material_code);
            if ($transactionDetailsModel[0]['kitting_type'] !== $material['pallet_ind']) {
                $this->addError('kitted_unit', 'Compatibility error. Pallet type is different with the selected customer product pallet type. Please select compatible customer product.');
            }
        }
    }

    /**
     * batch validation
     */
    public function checkBatch($attribute, $params) {
        $transactionDetailsModel = Yii::$app->modelFinder->getTransactionDetails(['batch'   => $id,
                                                                                  'status'  => [Yii::$app->params['STATUS_PROCESS'],
                                                                                                Yii::$app->params['STATUS_CLOSED'],
                                                                                                Yii::$app->params['STATUS_REJECTED']]]);

        if ($transactionDetailsModel != null && count($transactionDetailsModel) > 0) {
            if ($transactionDetailsModel[0]['material_code'] !== $this->batch) {
                $this->addError('batch', 'Batch should only contain one type of material.');
            }
        }
    }

    /**
     * unique pallet no per transaction validation
     */
    public function checkPallet($attribute, $params) {
        $status = [Yii::$app->params['STATUS_PROCESS'],
                     Yii::$app->params['STATUS_CLOSED'],
                     Yii::$app->params['STATUS_REJECTED']];

        $transactionDetailsModel = Yii::$app->modelFinder->getTransactionDetailList(null, null, null,
                                                                                    ['pallet_no' => $this->pallet_no,
                                                                                     'status'    => $status]);

        if ($transactionDetailsModel == null || count($transactionDetailsModel) == 0) {
            $transactionDetailsModel = Yii::$app->modelFinder->getTransactionDetailList(null, null, null,
                                                                                    ['kitted_unit' => $this->pallet_no,
                                                                                     'status'      => $status]);
        }
        if ($transactionDetailsModel != null && count($transactionDetailsModel) > 0) {
            if ($this->transaction_id !== $transactionDetailsModel[0]['transaction_id']) {
                $this->addError('pallet_no', 'Pallet # is already being used in another transaction.');
            }
        }
    }

    /**
     * unique kitted_unit per transaction validation
     */
    public function checkKittedUnit($attribute, $params) {
        $status = [Yii::$app->params['STATUS_PROCESS'],
                     Yii::$app->params['STATUS_CLOSED'],
                     Yii::$app->params['STATUS_REJECTED']];

        $transactionDetailsModel = Yii::$app->modelFinder->getTransactionDetailList(null, null, null,
                                                                                    ['pallet_no' => $this->kitted_unit,
                                                                                     'status'    => $status]);

        if ($transactionDetailsModel == null || count($transactionDetailsModel) == 0) {
            $transactionDetailsModel = Yii::$app->modelFinder->getTransactionDetailList(null, null, null,
                                                                                    ['kitted_unit' => $this->kitted_unit,
                                                                                     'status'      => $status]);
        }
        if ($transactionDetailsModel != null && count($transactionDetailsModel) > 0) {
            if ($this->transaction_id !== $transactionDetailsModel[0]['transaction_id']) {
                $this->addError('kitted_unit', 'Pallet # is already being used in another transaction.');
            }
        }
    }

}
