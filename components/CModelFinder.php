<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use app\models\MstAccount;
use app\models\MstAllowedIp;
use app\models\MstCustomer;
use app\models\MstMaterial;
use app\models\MstMaterialConversion;
use app\models\MstPlantlocation;
use app\models\MstPackaging;
use app\models\MstPackagingMaterials;
use app\models\TrxTransactions;
use app\models\TrxTransactionDetails;
use app\models\TrxHandlingUnit;

class CModelFinder extends Component
{
	/**
     * Gets the account list from MstAccount model based on its status.
     * If the model is not found, return empty array.
     * @return MstAccount the loaded array
     */
    public function getAccountList($index = null, $conditions = null, $count = null)
    {
    	if (null != $count) {
	        // to retrieve all *active* materials by their index and order them by their ID:
	    	$accounts = MstAccount::find()
			    ->where(['not', ['id' => Yii::$app->user->id]])
				->andWhere(ArrayHelper::merge($conditions, ['status' => Yii::$app->params['STATUS_ACTIVE']]))
				->indexBy($index)
			    ->count($count);
		} else {
			// to retrieve all *active* materials by their index and order them by their ID:
	    	$accounts = MstAccount::find()
				->where(['not', ['id' => Yii::$app->user->id]])
			    ->andWhere(ArrayHelper::merge($conditions, ['status' => Yii::$app->params['STATUS_ACTIVE']]))
			    ->orderBy('id')
				->indexBy($index)
			    ->all();
		}

		return $accounts;
    }

	/**
     * Gets the customer list from MstCustromer model based on its status.
     * If the model is not found, return empty array.
     * @return MstCustomer the loaded array
     */
    public function getCustomerList($index = null)
    {
        if (null != $index) {
        	// to retrieve all *active* customers by their index and order them by their ID:
        	$customers = MstCustomer::find()
			    ->where(['status' => Yii::$app->params['STATUS_ACTIVE']])
			    ->orderBy('code')
				->indexBy($index)
				->asArray()
			    ->all();
        } else {
        	// to retrieve all *active* customers and order them by their ID:
        	$customers = MstCustomer::find()
			    ->where(['status' => Yii::$app->params['STATUS_ACTIVE']])
			    ->orderBy('code')
				->asArray()
			    ->all();
        }

		return $customers;
    }

	/**
     * Gets the plant location list from MstPlantlocation model based on its status.
     * If the model is not found, return empty array.
     * @return MstCustomer the loaded array
     */
    public function getPlantList($index = null, $conditions = null, $groupBy = null)
    {
    	// to retrieve all *active* customers by their index and order them by their ID:
    	$plant_location = MstPlantLocation::find()
		    ->where(ArrayHelper::merge($conditions, ['status' => Yii::$app->params['STATUS_ACTIVE']]))
		    ->orderBy('plant_location')
			->indexBy($index)
			->groupBy($groupBy)
			->asArray()
		    ->all();

		return $plant_location;
    }

	/**
     * Gets the material list from MstMaterial model based on its status.
     * If the model is not found, return empty array.
     * @return MstMaterial the loaded array
     */
    public function getMaterialList($index = null, $conditions = null)
    {
        // to retrieve all *active* materials by their index and order them by their ID:
    	$materials = MstMaterial::find()
		    ->where($conditions)
            ->andWhere(['status' => Yii::$app->params['STATUS_ACTIVE']])
		    ->orderBy('item_code')
			->indexBy($index)
		    ->all();

		return $materials;
    }

	/**
     * Gets the material conversion list from MstMaterialConversion model based on its status.
     * If the model is not found, return empty array.
     * @return MstMaterialConversion the loaded array
     */
    public function getMaterialConversionList($index = null, $conditions = null)
    {
        // to retrieve all *active* material conversions by their index and order them by their ID:
        	$material_conversion = MstMaterialConversion::find()
			    ->where($conditions)
			    ->orderBy('material_code')
				->indexBy($index)
                ->asArray()
			    ->all();

		return $material_conversion;
    }

    /**
     * Gets the packaging list from MstPackaging model.
     * If the model is not found, return empty array.
     * @return MstPackaging the loaded array
     */
    public function getPackagingList($index = null, $conditions = null, $groupBy = null)
    {
        // to retrieve all *active* material conversions by their index and order them by their ID:
        $packaging = MstPackaging::find()
            ->where($conditions)
            ->orderBy('id')
            ->indexBy($index)
			->groupBy($groupBy)
            ->all();

        return $packaging;
    }

    /**
     * Gets the packaging material list from MstPackagingMaterial model.
     * If the model is not found, return empty array.
     * @return MstPackaging the loaded array
     */
    public function getPackagingMaterialList($index = null, $conditions = null, $groupBy = null)
    {
        // to retrieve all *active* material conversions by their index and order them by their ID:
        $packagingMaterial = MstPackagingMaterials::find()
            ->where($conditions)
            ->orderBy('id')
            ->indexBy($index)
            ->groupBy($groupBy)
            ->asArray()
            ->all();

        return $packagingMaterial;
    }

        /**
     * Gets the list from TrxTransactions model based on its status.
     * If the model is not found, return empty array.
     * @return TrxTransactions the loaded array
     */
    public function getTransactionList($index = null, $conditions = null)
    {
        if (null != $index) {
        	// to retrieve all *active* material conversions by their index and order them by their ID:
        	$transactions = TrxTransactions::find()
			    ->where(['status' => Yii::$app->params['STATUS_PROCESS']])
                ->andWhere($conditions)
			    ->orderBy('id')
				->indexBy($index)
				->asArray()
			    ->all();
        } else {
        	// to retrieve all *active* material conversions and order them by their ID:
	        $transactions = TrxTransactions::find()
				->where(['status' => Yii::$app->params['STATUS_PROCESS']])
                ->andWhere($conditions)
				->orderBy('id')
				->asArray()
				->all();
        }

		return $transactions;
    }

	/**
     * Gets the list from TrxTransactionDetails model based on its status.
     * If the model is not found, return empty array.
     * @return TrxTransactionDetails the loaded array
     */
    public function getTransactionDetailList($max = null, $count = null, $index = null, $conditions = null, $data_provider = false, $groupBy = null)
    {
    	if (null != $max) {
    		// to retrieve all *active* material conversions by their index and order them by their ID:
        	$transaction_details = TrxTransactionDetails::find()
				->where($conditions)
				->groupBy($groupBy)
				->indexBy($index)
				->max($max);
    	} else if (null != $count) {
    		// to retrieve all *active* material conversions by their index and order them by their ID:
        	$transaction_details = TrxTransactionDetails::find()
				->where($conditions)
				->groupBy($groupBy)
				->indexBy($index)
				->count($count);
		} else {
    		// to retrieve all *active* material conversions by their index and order them by their ID:
	    	if (false != $data_provider) {
	        	$transaction_details = TrxTransactionDetails::find()
					->where($conditions)
					->indexBy($index)
					->groupBy($groupBy)
					->asArray();
			} else {
				$transaction_details = TrxTransactionDetails::find()
					->where($conditions)
					->indexBy($index)
					->groupBy($groupBy)
					->asArray()
				    ->all();
			}
    	}


		return $transaction_details;
    }

    /**
     * Gets the material conversion from MstMaterialConversion model based on its status.
     * If the model is not found, return empty.
     * @return MstMaterialConversion
     */
    public function getMaterialConversion($index = null, $conditions = null)
    {
        // to retrieve all *active* material conversions by their index and order them by their ID:
            $material_conversion = MstMaterialConversion::find()
                ->where($conditions)
                ->one();

        return $material_conversion;
    }

    /**
     * Gets the packaging material from MstPackagingMaterials model based on its status.
     * If the model is not found, return empty.
     * @return MstPackagingMaterials
     */
    public function getPackagingMaterial($conditions = null)
    {
        // to retrieve all *active* material conversions by their index and order them by their ID:
            $packaging_material = MstPackagingMaterials::find()
                ->where($conditions)
                ->one();

        return $packaging_material;
    }

    /**
     * Finds the MstAccount model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return MstAccount the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findAccountModel($id)
    {
        if (($model = MstAccount::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the MstCustomer model based on its primary key value.
     * If the model is not found, return null
     * @param string $id
     * @return MstCustomer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findCustomerModel($id)
    {
        if (($model = MstCustomer::findOne($id)) !== null) {
            return $model;
        } else {
            return null;
        }
    }

    /**
     * Finds the TrxTransactions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TrxTransactions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findTransactionModel($id)
    {
        if (($model = TrxTransactions::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

	/**
     * Finds the TrxHandlingUnit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TrxHandlingUnit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findHandlingUnitModel($id)
    {
        if (($model = TrxHandlingUnit::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

	/**
     * Finds the MstPlantLocation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return MstPlantLocation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findPlantLocationModel($plant_location)
    {
        if (($model = MstPlantLocation::findOne($plant_location)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

	/**
     * Finds the MstAllowedIp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return MstAllowedIp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findAllowedIpModel($plant_location)
    {
        if (($model = MstAllowedIp::findOne($plant_location)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
