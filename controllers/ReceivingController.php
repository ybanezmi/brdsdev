<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use app\models\MstAccount;
use app\models\MstCustomer;
use app\models\TrxTransactions;
use app\models\TrxTransactionDetails;
use app\models\TrxTransactionDetailsSearch;
use app\models\TrxHandlingUnit;
use app\models\MstPlantLocation;
use app\models\MstMaterial;
use app\models\MstMaterialConversion;

use app\constants\SapConst;
use linslin\yii2\curl;

/**
 * ReceivingController implements the CRUD actions for TrxTransactions model.
 */
class ReceivingController extends Controller
{
    /**
     * Yii action controller
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

	public function initUser()
	{
		// set access token for user
		$account_model = Yii::$app->modelFinder->findAccountModel(Yii::$app->user->id);
		$account_model->access_token = 'receiving';
		$account_model->save();

		// get access of users
		/*
		$account_count = Yii::$app->modelFinder->getAccountList(null, ['access_token' => 'receiving'], 'id');
				if ($account_count > 0) {
					$this->redirect(['index']);
				} else {
					// set access token for user
					$account_model = Yii::$app->modelFinder->findAccountModel(Yii::$app->user->id);
					$account_model->access_token = 'receiving';
					$account_model->save();
				}
		 */
	}

    /**
     * Lists all TrxTransactions models.
     * @return mixed
     */
    public function actionIndex()
    {
    	// @TODO: change implementation to access control
    	// clear access token for user
    	$account_model = Yii::$app->modelFinder->findAccountModel(Yii::$app->user->id);
		$account_model->access_token = null;
		$account_model->save();

		// get access of users
		// $account_count = Yii::$app->modelFinder->getAccountList(null, ['access_token' => 'receiving'], 'id');
		$isAccessReceiving = false;
    	// if ($account_count > 0) {
    		// $isAccessReceiving = true;
    	// }

		// active pallets
		$params = [Yii::$app->params['STATUS_PROCESS'], Yii::$app->params['STATUS_CLOSED'], Yii::$app->params['STATUS_REJECTED']];

		// pallet status
		$palletStatus = array();

		// open pallets
		$palletStatus['open_success'] = false;
		$palletStatus['open_error'] = false;
		if(null !== Yii::$app->request->post('open-pallet')) {
			if (null !== Yii::$app->request->post('open_pallet_no') && "" !== Yii::$app->request->post('open_pallet_no')) {
                $transactionDetailsModel = Yii::$app->modelFinder->getTransactionDetailList(null, null, null,
                                                                                            ['pallet_no'    => Yii::$app->request->post('open_pallet_no'),
                                                                                             'status'       => $params]);
                if ($transactionDetailsModel) {
                    $handlingUnit = Yii::$app->modelFinder->getHandlingUnit(['transaction_id'   =>  $transactionDetailsModel[0]['transaction_id'],
                                                                         'customer_code'    =>  $transactionDetailsModel[0]['customer_code'],
                                                                         'pallet_no'        =>  Yii::$app->request->post('open_pallet_no')]);

                    if (!$handlingUnit) {
                        TrxTransactionDetails::updateAll(['status'          => Yii::$app->params['STATUS_PROCESS'],
                                                      'updater_id'      => Yii::$app->user->id,
                                                      'updated_date'    => date('Y-m-d H:i:s')], //@TODO: use yii date formatter
                                                     ['pallet_no'       => Yii::$app->request->post('open_pallet_no'),
                                                      'status'          => $params]);
                        $palletStatus['open_success'] = true;
                    } else {
                        $palletStatus['open_error'] = true;
                    }

                } else {
                    $palletStatus['open_error'] = true;
                }
			} else {
				$palletStatus['open_error'] = true;
			}
		}

		// close pallets
		$palletStatus['close_success'] = false;
		$palletStatus['close_error'] = false;
		if(null !== Yii::$app->request->post('close-pallet')) {
			if (null !== Yii::$app->request->post('close_pallet_no') && "" !== Yii::$app->request->post('close_pallet_no')) {
			    $transactionDetailsModel = Yii::$app->modelFinder->getTransactionDetailList(null, null, null,
                                                                                            ['pallet_no'    => Yii::$app->request->post('close_pallet_no'),
                                                                                             'status'       => $params]);
                if ($transactionDetailsModel) {
                    $handlingUnit = Yii::$app->modelFinder->getHandlingUnit(['transaction_id'   =>  $transactionDetailsModel[0]['transaction_id'],
                                                                         'customer_code'    =>  $transactionDetailsModel[0]['customer_code'],
                                                                         'pallet_no'        =>  Yii::$app->request->post('close_pallet_no')]);

                    if (!$handlingUnit) {
                        TrxTransactionDetails::updateAll(['status'          => Yii::$app->params['STATUS_CLOSED'],
                                                      'updater_id'      => Yii::$app->user->id,
                                                      'updated_date'    => date('Y-m-d H:i:s')], //@TODO: use yii date formatter
                                                     ['pallet_no'       => Yii::$app->request->post('close_pallet_no'),
                                                      'status'          => $params]);
                        $palletStatus['close_success'] = true;
                    } else {
                        $palletStatus['close_error'] = true;
                    }

                } else {
                    $palletStatus['close_error'] = true;
                }
			} else {
				$palletStatus['close_error'] = true;
			}
		}

		// reject pallets
		$palletStatus['reject_success'] = false;
		$palletStatus['reject_error'] = false;
		if(null !== Yii::$app->request->post('reject-pallet')) {
			if (null !== Yii::$app->request->post('reject_pallet_no') && "" !== Yii::$app->request->post('reject_pallet_no')) {
				$transactionDetailsModel = Yii::$app->modelFinder->getTransactionDetailList(null, null, null,
                                                                                            ['pallet_no'    => Yii::$app->request->post('reject_pallet_no'),
                                                                                             'status'       => $params]);
                if ($transactionDetailsModel) {
                    $handlingUnit = Yii::$app->modelFinder->getHandlingUnit(['transaction_id'   =>  $transactionDetailsModel[0]['transaction_id'],
                                                                         'customer_code'    =>  $transactionDetailsModel[0]['customer_code'],
                                                                         'pallet_no'        =>  Yii::$app->request->post('reject_pallet_no')]);

                    if (!$handlingUnit) {
                        TrxTransactionDetails::updateAll(['status'          => Yii::$app->params['STATUS_REJECTED'],
                                                      'updater_id'      => Yii::$app->user->id,
                                                      'updated_date'    => date('Y-m-d H:i:s')], //@TODO: use yii date formatter
                                                     ['pallet_no'       => Yii::$app->request->post('reject_pallet_no'),
                                                      'status'          => $params]);
                        $palletStatus['reject_success'] = true;
                    } else {
                        $palletStatus['reject_error'] = true;
                    }

                } else {
                    $palletStatus['reject_error'] = true;
                }
			} else {
				$palletStatus['reject_error'] = true;
			}
		}

        // create transfer order
        $palletStatus['create_to_success'] = false;
        $palletStatus['create_to_error'] = false;
        if (null !== Yii::$app->request->post('create-to')) {
            if (null !== Yii::$app->request->post('create_to_pallet_no') && "" !== Yii::$app->request->post('create_to_pallet_no')) {
                $transactionDetailsModel = Yii::$app->modelFinder->getTransactionDetailList(null, null, null,
                                                                                            ['pallet_no' => Yii::$app->request->post('create_to_pallet_no')]);
                if (!$transactionDetailsModel || $transactionDetailsModel == null || count($transactionDetailsModel) == 0) {
                    $palletStatus['create_to_error'] = true;
                    $palletStatus['to_error'] = 'Pallet no. ' . Yii::$app->request->post('create_to_pallet_no') . ' does not exist.';
                } else {
                    $transactionDetailsStatusCountList = array_count_values(ArrayHelper::getColumn($transactionDetailsModel, 'status'));
                    if (isset($transactionDetailsStatusCountList['process']) && $transactionDetailsStatusCountList['process'] > 0) {
                        $palletStatus['create_to_error'] = true;
                        $palletStatus['to_error'] = 'Pallet no. ' . Yii::$app->request->post('create_to_pallet_no') . ' is still open.';
                    } else {
                        $model = new TrxHandlingUnit();
                        $date = date('Y-m-d H:i:s'); // @TODO Use Yii dateformatter
                        // set defaults
                        // @TODO: transfer updating of status/created/updated details to model
                        // set status, created and updated details
                        $model->inbound_status  = Yii::$app->params['STATUS_PROCESS'];
                        $model->creator_id      = Yii::$app->user->id;
                        $model->created_date    = $date;
                        $model->updater_id      = Yii::$app->user->id;
                        $model->updated_date    = $date;

                        $transactionModel = Yii::$app->modelFinder->findTransactionModel($transactionDetailsModel[0]['transaction_id']);
                        $model->transaction_id = $transactionModel->id;
                        $model->customer_code = $transactionModel->customer_code;
                        $model->inbound_no = $transactionModel->sap_no;
                        $model->pallet_no = Yii::$app->request->post('create_to_pallet_no');
                        $model->plant_location = $transactionModel->plant_location;
                        $model->storage_location = $transactionModel->storage_location;

                        $model->packaging_code = $transactionDetailsModel[0]['packaging_code'];
                        $model->pallet_weight = $transactionDetailsModel[0]['pallet_weight'];
                        //$model->storage_type = $createTO['export']['storage_type'];
                        //$model->storage_section = $createTO['export']['storage_section'];
                        //$model->storage_bin = $createTO['export']['storage_bin'];
                        //$model->inbound_status = $createTO['export']['storage_position'];
                        if ($model->validate()) {
                            $createTO = $this->createTO(Yii::$app->request->post('create_to_pallet_no'));
                            if (isset($createTO['error'])) {
                                $palletStatus['create_to_error'] = true;
                                $palletStatus['to_error'] = $createTO['error'];
                            } else {
                                $model->transfer_order = $createTO['export']['transfer_order'];
                                if ($model->save()) {
                                    $palletStatus['create_to_success'] = true;
                                    $palletStatus['to_number'] = $createTO['export']['transfer_order'];
                                } else {
                                    $palletStatus['create_to_error'] = true;
                                    if (isset($createTO['error'])) {
                                        $palletStatus['to_error'] = $createTO['error'];
                                    } else {
                                        $palletStatus['to_error'] = $createTO['export']['transfer_order'];
                                    }
                                }
                            }
                        } else {
                            $palletStatus['create_to_error'] = true;
                            $palletStatus['to_error'] = $model->getFirstError('transfer_order');
                        }
                    }
                }
            } else {
                $palletStatus['create_to_error'] = true;
                $palletStatus['to_error'] = 'Please enter pallet no.';
            }
        }

/*
        $dataProvider = new ActiveDataProvider([
            'query' => Yii::$app->modelFinder->getTransactionList(),
        ]);
*/

		$transactionDetails = new TrxTransactionDetails();

        return $this->render('index', [
            //'dataProvider' => $dataProvider,
            'isAccessReceiving' => $isAccessReceiving,
            'palletStatus' => $palletStatus,
            'transactionDetails' => $transactionDetails,
        ]);
    }

    /**
     * Displays a single TrxTransactions model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => Yii::$app->modelFinder->findTransactionModel($id),
        ]);
    }

    /**
     * Displays a list of TrxTransactionDetails model.
     * @param string $id
     * @return mixed
     */
    public function actionViewEntries($id, $transaction_type = 'brds')
    {
		if('sap' == $transaction_type)
		{
			 $sap_transaction =  Yii::$app->modelFinder->getTransaction(['sap_no' => $id]);
			 
			 if($sap_transaction)
			 {
				 $id = $sap_transaction->id;
			 }
		}
		
    	$data_provider = new ActiveDataProvider([
							  						'query' => Yii::$app->modelFinder->getTransactionDetailList(null, null, null,
							  																					['transaction_id' => $id,
															   			  	 									 'status' 		=> [Yii::$app->params['STATUS_PROCESS'], Yii::$app->params['STATUS_CLOSED'], Yii::$app->params['STATUS_REJECTED']]],
																												true),
													'sort'=> ['defaultOrder' => ['pallet_no' => SORT_DESC]],
												]);
		$search_model = new TrxTransactionDetailsSearch;
		if (null != Yii::$app->request->get('TrxTransactionDetailsSearch')['pallet_no']) {
			$params = ['transaction_id' => $id,
					   'status' 		=> [Yii::$app->params['STATUS_PROCESS'], Yii::$app->params['STATUS_CLOSED'], Yii::$app->params['STATUS_REJECTED']]];

			$data_provider = $search_model->search(Yii::$app->request->queryParams, $params);
		}

        return $this->render('view-entries', ['data_provider' => $data_provider,
        									  'search_model'  => $search_model,
        					]);
    }

    /**
     * Creates a new TrxTransactions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	$this->initUser();

    	if (null !== Yii::$app->request->post('cancel')) {
            $this->redirect(['index']);
        } else {
    		$model = new TrxTransactions();
            $model_plant_location = new MstPlantLocation();
			$date = date('Y-m-d H:i:s'); // @TODO Use Yii dateformatter

			// set defaults
			// $model->id 	= strtotime(date("Ymdhis")); // @TODO should be set onBeforeSave in TrxTransactions model
			$model->id 	= date("mdyhs"); // @TODO should be set onBeforeSave in TrxTransactions model

			// @TODO: transfer updating of status/created/updated details to model
			// set status, created and updated details
			$model->status			= Yii::$app->params['STATUS_PROCESS'];
			$model->creator_id		= Yii::$app->user->id;
			$model->created_date 	= $date;
			$model->updater_id		= Yii::$app->user->id;
			$model->updated_date	= $date;

	        if ($model->load(Yii::$app->request->post())) {
	        	$model->actual_gr_date = Yii::$app->dateFormatter->convert($model->getAttribute('actual_gr_date'));
	            $model->remarks = Yii::$app->user->identity->username . '@: ' . Yii::$app->request->post('TrxTransactions')['remarks'];
                if ($model->validate() && $model->save()) {
	               return $this->redirect(['menu', 'id' => $model->id]);
                }
	        } else {
	        	// Get customer list
	        	$customer_list = ArrayHelper::map(Yii::$app->modelFinder->getCustomerList(), 'code', 'name');
                $plant_list = Yii::$app->modelFinder->getPlantList(null, ['plant_location' => Yii::$app->user->identity->assignment]);
                $storage_list = array();
                foreach ($plant_list as $key => $value) {
                    $storage_list[$value['storage_location']] = $value['storage_location'] . ' - ' . $value['storage_name'];
                }
	            return $this->render('create', [
	                'model' => $model,
	                'customer_list' => $customer_list,
                    'storage_list' => $storage_list,
	            ]);
	        }
    	}
    }

    /**
     * Updates an existing TrxTransactions model.
     * If update is successfulf, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TrxTransactions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

	public function actionMenu($id)
    {
    	$this->initUser();
    	if(null !== Yii::$app->request->post('cancel')) {
    		$this->redirect(['index']);
    	} else if (null !== Yii::$app->request->post('close-pallet')
                    || null !== Yii::$app->request->post('bulk-close-pallet')) {
    		$transaction_model = Yii::$app->modelFinder->findTransactionModel($id);
    	    $material_conversion_model = new MstMaterialConversion;
			$date = date('Y-m-d H:i:s');

			// increment # of pallet
			$transaction_model->weight 		 = 0;

			// get total weight from trx_transaction_details
			$transaction_detail_list = Yii::$app->modelFinder->getTransactionDetailList(null, null, null,
																					    ['transaction_id' => $transaction_model->id,
																						 'status' 		  => [Yii::$app->params['STATUS_PROCESS'],
																						                      Yii::$app->params['STATUS_CLOSED'],
																						                      Yii::$app->params['STATUS_REJECTED']]]);

			// @TODO: use max param in getTransactionDetailList
			$total_weight = array_sum(ArrayHelper::map($transaction_detail_list, 'id', 'total_weight'));

			// set updated details
			$transaction_model->updater_id		= Yii::$app->user->id;
			$transaction_model->updated_date	= $date;

			// close pallets
			$condition = ['transaction_id'   => $transaction_model->id,
                          'status'          => Yii::$app->params['STATUS_PROCESS']];

            if (null !== Yii::$app->request->post('close-pallet')) {
                if (null !== Yii::$app->request->post('close_pallet_no') && "" !== Yii::$app->request->post('close_pallet_no')) {
                    $condition['pallet_no'] = Yii::$app->request->post('close_pallet_no');
                    $closePalletFlags['closePalletFlag'] = true;
                } else {
                    $closePalletFlags['closePalletError'] = true;
                }
            } else {
                $closePalletFlags['closeAllPalletsFlag'] = true;
            }

            if (isset($closePalletFlags['closePalletError'])) {
                return $this->redirect(['menu', 'id'                => $transaction_model->id,
                                                 'closePalletError' => true]);
            }
			TrxTransactionDetails::updateAll(['status' 			=> Yii::$app->params['STATUS_CLOSED'],
											  'updater_id'		=> Yii::$app->user->id,
											  'updated_date'	=> $date],
											  $condition
											 );

			if ($transaction_model->save()) {
			    if (isset($closePalletFlags['closePalletFlag'])) {
			        return $this->redirect(['menu', 'id'                => $transaction_model->id,
			                                        'closePalletFlag'   => true,
			                                        'closePalletNo'     => Yii::$app->request->post('close_pallet_no')]);
			    } else if (isset($closePalletFlags['closeAllPalletsFlag'])) {
                    return $this->redirect(['menu', 'id'                   => $transaction_model->id,
                                                    'closeAllPalletsFlag'  => true]);
                } else {
                    return $this->redirect(['menu', 'id' => $transaction_model->id]);
			    }
			} else {
				return $this->render('menu', [
	                'transaction_model' 		=> $transaction_model,
                    'material_conversion_model' => $material_conversion_model,
	                'total_weight'				=> $total_weight,
	            ]);
			}
    	} else if (null !== Yii::$app->request->post('view-entries')) {
    		$this->redirect(['view-entries', 'id' => $id]);
    	} else {
			$transaction_model = Yii::$app->modelFinder->findTransactionModel($id);
			$customer_model = Yii::$app->modelFinder->findCustomerModel($transaction_model->customer_code);
			$material_model = Yii::$app->modelFinder->getMaterialList(null, ['like', 'item_code', $transaction_model->customer_code]);
            $packaging_model = Yii::$app->modelFinder->getPackagingList(null, null, 'pallet_type');
            $packaging_type_model = Yii::$app->modelFinder->getPackagingMaterialList(null, ['and',
                 ['like', 'description', Yii::$app->params['PALLET']],['like', 'material_code', 'VERP%',false]]);
				//['like', 'description', Yii::$app->params['PALLET']], ['plant_location' => $transaction_model->plant_location]]);
                // ['plant_location' => $transaction_model->plant_location]]);
            $kitting_type_model = Yii::$app->modelFinder->getPackagingMaterialList(null, ['and',
                ['not like', 'description', Yii::$app->params['PALLET']],['like', 'material_code', 'VERP%',false]]);
                // ['plant_location' => $transaction_model->plant_location]]);

            $packaging_type_list = ArrayHelper::map($packaging_type_model, 'material_code', 'description');
            $kitting_type_list = ArrayHelper::map($kitting_type_model, 'material_code', 'description');
			$material_list = ArrayHelper::map($material_model, 'item_code', 'description');

			$description_max_length = 40;
			$space_char = '&nbsp;';
			foreach ($material_list as $key => $value)
			{
				$value_length = strlen($value);
				
				if($description_max_length < $value_length)
				{
					$value = substr($value, 0, $description_max_length);
				}
				else
				{
					$space_padding = $description_max_length - $value_length;
					$value = $value . str_repeat($space_char, $space_padding);
				}
				
				$material_list[$key] = html_entity_decode("{$value}{$space_char}{$space_char}-{$space_char}{$space_char}{$key}");
			}

			// retrieve and convert sled in days unit
			$material_sled_properties = [
										    'app\models\MstMaterial' => [
										        'item_code',
										        'sled',
										        'sled_unit',
										    ],
										];

			$material_sled = ArrayHelper::toArray($material_model, $material_sled_properties);
			$material_sled_conv = array();

			foreach ($material_sled as $key => $value) {
				switch(strtolower($value['sled_unit'])) {
				    // years
					case '3':
						$material_sled_conv[$value['item_code']] = $material_sled[$key]['sled'] * 12 * 30;
						break;
                    // months
					case '2':
						$material_sled_conv[$value['item_code']] = $material_sled[$key]['sled'] * 30;
						break;
                    // weeks
                    case '1':
                        $material_sled_conv[$value['item_code']] = $material_sled[$key]['sled'] * 7;
                        break;
                    // days
					case ' ':
						$material_sled_conv[$value['item_code']] = $material_sled[$key]['sled'];
						break;
					default:
						$material_sled_conv[$value['item_code']] = $material_sled[$key]['sled'];
						break;
				}
			}

			$material_conversion_model = Yii::$app->modelFinder->getMaterialConversionList('material_code');

			// retrieve unit_1, num_1, den_1 from material conversion list
			$material_conversion_properties = [
											    'app\models\MstMaterialConversion' => [
											        'unit_1',
											        'num_1',
											        'den_1',
											    ],
											];

			$material_conversion = ArrayHelper::toArray($material_conversion_model, $material_conversion_properties);

			$transaction_detail_model = new TrxTransactionDetails();
			$handling_unit_model = new TrxHandlingUnit();

			$date = date('Y-m-d H:i:s');

			// set transaction id
			$transaction_detail_model->transaction_id = $transaction_model->id;
			$handling_unit_model->transaction_id = $transaction_model->id;

			// retrieve all transaction details
			$transaction_details_model = Yii::$app->modelFinder->getTransactionDetailList(null, null, null,
																						  ['transaction_id' => $transaction_model->id,
																						   'status' 		=> [Yii::$app->params['STATUS_PROCESS'], Yii::$app->params['STATUS_CLOSED'], Yii::$app->params['STATUS_REJECTED']]], false, null);

			$transaction_details = array();
			// @TODO: Optimize
			$isPalletClosed = false;
			$isPalletRejected = false;
			foreach ($transaction_details_model as $key => $value) {
				$transaction_details[$value['pallet_no']]['pallet_type'] = $value['pallet_type'];
				$transaction_details[$value['pallet_no']]['kitted_unit'] = $value['kitted_unit'];
				$transaction_details[$value['pallet_no']]['kitting_code'] = $value['kitting_code'];
				$transaction_details[$value['pallet_no']]['pallet_weight'] = Yii::$app->modelFinder->getTransactionDetailList('pallet_weight', null, null, ['id' => $value['id'],
																			'status' => [Yii::$app->params['STATUS_PROCESS'], Yii::$app->params['STATUS_CLOSED'], Yii::$app->params['STATUS_REJECTED']]],false, null);
				$transaction_details[$value['pallet_no']]['status'] = Yii::$app->modelFinder->getTransactionDetailList('status', null, null, ['id' => $value['id'],
																			'status' => [Yii::$app->params['STATUS_PROCESS'], Yii::$app->params['STATUS_CLOSED'], Yii::$app->params['STATUS_REJECTED']]],false, null);

				if (Yii::$app->params['STATUS_CLOSED'] === $transaction_details[$value['pallet_no']]['pallet_type']) {
					$isPalletClosed = true;
					break;
				}

				if (Yii::$app->params['STATUS_REJECTED'] === $transaction_details[$value['pallet_no']]['pallet_type']) {
					$isPalletRejected = true;
					break;
				}
			}

			// encode and initialize all js variables
			// customer code
			$js_customer_code = json_encode($transaction_model->customer_code);

			// used for searching material list by barcode
			$js_material_barcode = json_encode(ArrayHelper::map($material_model, 'barcode', 'item_code'));
			$js_material_desc = json_encode(ArrayHelper::map($material_model, 'description', 'item_code'));

			// converted material sled
			$js_material_sled = json_encode($material_sled_conv);

			// retrieve pallet_ind for pallet_type
			$js_material_pallet_ind = json_encode(ArrayHelper::map($material_model, 'item_code', 'pallet_ind'));

			// retrieve all material conversion
			$js_material_conversion = json_encode($material_conversion);

			// retrieve transaction details by pallet_no
			$js_transaction_details = json_encode($transaction_details);

			$scripts = "<script type='text/javascript'>
			                var customer_code = " . $js_customer_code . ";
							var material_list_barcode = " . $js_material_barcode . ";
							var material_list_desc = " . $js_material_desc . ";
							var material_sled = " . $js_material_sled . ";
							var material_pallet_ind = " . $js_material_pallet_ind . ";
							var material_conversion = " . $js_material_conversion . ";
							var transaction_details = " . $js_transaction_details . ";
							var plant_location = '" . $transaction_model->plant_location . "';
					  	</script>";

			// get total weight from trx_transaction_details
			$total_weight = array_sum(ArrayHelper::map($transaction_details_model, 'id', 'total_weight'));

			// @TODO: transfer updating of status/created/updated details to model
			// set status, created and updated details
			$transaction_detail_model->status			= Yii::$app->params['STATUS_PROCESS'];
			$transaction_detail_model->creator_id		= Yii::$app->user->id;
			$transaction_detail_model->created_date 	= $date;
			$transaction_detail_model->updater_id		= Yii::$app->user->id;
			$transaction_detail_model->updated_date		= $date;

			// set customer code
			$transaction_detail_model->customer_code	= $transaction_model->customer_code;

			// get pallet count
			$pallet_count = Yii::$app->modelFinder->getTransactionDetailList(null, 'id', null, ['transaction_id' => $transaction_model->id,
																							   	'status' 		 => [Yii::$app->params['STATUS_PROCESS'], Yii::$app->params['STATUS_CLOSED'], Yii::$app->params['STATUS_REJECTED']]], false, 'pallet_no');

	        if (isset($_GET["pallet_no"])) {
	        	$pallet_no = htmlspecialchars($_GET["pallet_no"]);
	        } else {
	        	$pallet_no = '';
	        }

            if ($transaction_detail_model->load(Yii::$app->request->post())) {
                // convert to correct date format
                if (null != $transaction_detail_model->getAttribute('manufacturing_date')) {
                    $transaction_detail_model->setAttribute('manufacturing_date', Yii::$app->dateFormatter->convert($transaction_detail_model->getAttribute('manufacturing_date')));
                }

                if (null != $transaction_detail_model->getAttribute('expiry_date')) {
                    $transaction_detail_model->setAttribute('expiry_date', Yii::$app->dateFormatter->convert($transaction_detail_model->getAttribute('expiry_date')));
                }

                $packaging_material = Yii::$app->modelFinder->getPackagingMaterial(['material_code' => $transaction_detail_model->packaging_code]);
                $transaction_detail_model->pallet_type = $packaging_material->pallet_type;

                // set to null if no kitting_type selection
                if ($transaction_detail_model->kitting_code === '-- Select a kitting type --') {
                    $transaction_detail_model->kitting_code = null;
                } else {
                    $kitting_material = Yii::$app->modelFinder->getPackagingMaterial(['material_code' => $transaction_detail_model->kitting_code]);
                    if ($kitting_material != null) {
                        $transaction_detail_model->kitting_type = $kitting_material->pallet_type;
                    }
                }

                // set to default value if net_unit is not set
                if (null == $transaction_detail_model->getAttribute('net_unit')) {
                    $transaction_detail_model->net_unit = SapConst::DEFAULT_NET_UNIT;
                }
            }

			$isPalletAdded = false;
	        if (!$isPalletClosed
	               && !$isPalletRejected
	               && Yii::$app->request->post()
                   && $transaction_detail_model->validate()) {
	            // Get SAP Inbound Number
	            $sapNoFlag = false;
                $sapError = array();
                $sapInboundNumber = $this->getSapInboundNumber($transaction_model, $transaction_detail_model);

                // if (!$this->isEmpty($transaction_model->sap_no)
                if (isset($sapInboundNumber['sap_inbound_no']) && !$this->isEmpty($sapInboundNumber['sap_inbound_no'])) {
                    if (isset($sapInboundNumber['sap_inbound_no']) && !$this->isEmpty($sapInboundNumber['sap_inbound_no'])) {
                        $sapNoFlag = true;
                        $transaction_model->sap_no = $sapInboundNumber['sap_inbound_no'];
                    }

                    // add net weight of transaction_detail to the total weight of transaction
                    $transaction_model->weight = $transaction_model->weight + $transaction_detail_model->net_weight;


                    if ($transaction_model->save() && $transaction_detail_model->save()) {
                        $isPalletAdded = true;
                        $this->redirect(['menu', 'id'            => $transaction_model->id,
                                                 'pallet'        => $transaction_detail_model->pallet_no,
                                                 'isPalletAdded' => $isPalletAdded,
                                                 'sapNoFlag'     => $sapNoFlag,
                                                 'sapError'      => $sapError,
                                                 'material_code' => $transaction_detail_model->material_code,
                        ]);
                    } else {
                        return $this->render('menu', [
                            'transaction_model'         => $transaction_model,
                            'customer_model'            => $customer_model,
                            'material_conversion_model' => $material_conversion_model,
                            'material_list'             => $material_list,
                            'packaging_type_list'       => $packaging_type_list,
                            'kitting_type_list'         => $kitting_type_list,
                            'transaction_detail_model'  => $transaction_detail_model,
                            'transaction_details'       => $transaction_details,
                            'handling_unit_model'       => $handling_unit_model,
                            'total_weight'              => $total_weight,
                            'pallet_count'              => $pallet_count,
                            'pallet_no'                 => $pallet_no,
                            'isPalletAdded'             => $isPalletAdded,
                            'isPalletClosed'            => $isPalletClosed,
                            'isPalletRejected'          => $isPalletRejected,
                            'scripts'                   => $scripts,
                        ]);
                    }
                } else {
                    if (isset($sapInboundNumber['error'])) {
                        $sapError = $sapInboundNumber['error'] . ' Failed to save pallet.';
                    } else {
                        $sapError = 'Unable to retrieve inbound number. Failed to save pallet.';
                    }

                    $this->redirect(['menu', 'id'            => $transaction_model->id,
                                             'pallet'        => $transaction_detail_model->pallet_no,
                                             'isPalletAdded' => $isPalletAdded,
                                             'sapNoFlag'     => $sapNoFlag,
                                             'sapError'      => $sapError,
                    ]);
                }
	        } else {
	            return $this->render('menu', [
	                'transaction_model' 		=> $transaction_model,
	                'customer_model'			=> $customer_model,
                    'material_conversion_model' => $material_conversion_model,
	                'material_list'				=> $material_list,
	                'packaging_type_list'       => $packaging_type_list,
                    'kitting_type_list'         => $kitting_type_list,
	                'transaction_detail_model'	=> $transaction_detail_model,
	                'transaction_details'		=> $transaction_details,
	                'handling_unit_model' 		=> $handling_unit_model,
	                'total_weight'				=> $total_weight,
	                'pallet_count'				=> $pallet_count,
	                'pallet_no'					=> $pallet_no,
	                'isPalletAdded' 			=> $isPalletAdded,
	                'isPalletClosed'			=> $isPalletClosed,
					'isPalletRejected'			=> $isPalletRejected,
					'scripts'					=> $scripts,
	            ]);
	        }
    	}
    }

	public function actionEdit()
	{
		$this->initUser();

		if(null !== Yii::$app->request->post('cancel')) {
    		$this->redirect(['index']);
    	} else if (null !== Yii::$app->request->post('edit-receiving')) {
	    	// route to edit receiving page
			$transaction_details = Yii::$app->request->post('TrxTransactionDetails');
	    	return $this->redirect(['menu', 'id' => $transaction_details['transaction_id'], 'pallet_no' => $transaction_details['pallet_no']]);
		} else {
			// Get customer list
			$customer_model = new MstCustomer();
    		$customer_list = ArrayHelper::map(Yii::$app->modelFinder->getCustomerList(), 'code', 'name');
			$transaction_model = new TrxTransactionDetails();
			$transaction_list = array();
			$pallet_no = '';
			return $this->render('edit', [
				'customer_model'	=> $customer_model,
				'customer_list'		=> $customer_list,
				'transaction_model' => $transaction_model,
				'transaction_list'	=> $transaction_list,
				'pallet_no'         => $pallet_no,
			]);
		}
	}

	public function actionViewPallet()
	{
		$this->initUser();

		if(null !== Yii::$app->request->post('cancel')) {
    		$this->redirect(['index']);
    	} else if (null !== Yii::$app->request->post('edit-receiving')) {
	    	// route to edit receiving page
	    	$this->redirect(['menu', 'id' => Yii::$app->request->post('transaction_id')]);
		} else {
			// Get customer list
			$customer_model = new MstCustomer();
    		$customer_list = ArrayHelper::map(Yii::$app->modelFinder->getCustomerList(), 'code', 'name');
			$transaction_model = new TrxTransactionDetails();
			$transaction_list = array();

			return $this->render('view-pallet', [
				'customer_model' 	=> $customer_model,
				'customer_list'		=> $customer_list,
				'transaction_model' => $transaction_model,
				'transaction_list'	=> $transaction_list,
			]);
		}
	}

    public function actionViewClosePallet()
    {
        $this->initUser();

        // Initialize variables
        $transactionModel = new TrxTransactionDetails();
        $palletStatus = array();
        $palletStatus['close_success'] = false;
        $palletStatus['close_error'] = false;
        // active pallets
        $params = [Yii::$app->params['STATUS_PROCESS'], Yii::$app->params['STATUS_CLOSED'], Yii::$app->params['STATUS_REJECTED']];

        if (null !== Yii::$app->request->post('cancel')) {
            $this->redirect(['index']);
        } else if(null !== Yii::$app->request->post('close-pallet')) {
            // close pallets
            $transactionDetails = Yii::$app->request->post('TrxTransactionDetails');

            if (!$this->isEmpty($transactionDetails['pallet_no'])) {
                TrxTransactionDetails::updateAll(['status'          => Yii::$app->params['STATUS_CLOSED'],
                                                  'updater_id'      => Yii::$app->user->id,
                                                  'updated_date'    => date('Y-m-d H:i:s')], //@TODO: use yii date formatter
                                                 ['pallet_no'       => $transactionDetails['pallet_no'],
                                                  'status'          => $params]);
                $palletStatus['close_success'] = true;
            } else {
                $palletStatus['close_error'] = true;
            }
        } else {
            // Do nothing
        }

        return $this->render('view-close-pallet', [
                'transactionModel'  => $transactionModel,
                'palletStatus'      => $palletStatus,
        ]);
    }

	public function actionCreateToSelectPallet()
	{
        $this->initUser();

        // Initialize variables
        $transactionModel = new TrxTransactionDetails();
        $palletStatus = array();
        $palletStatus['close_success'] = false;
        $palletStatus['close_error'] = false;
        // active pallets
        $params = [Yii::$app->params['STATUS_PROCESS'], Yii::$app->params['STATUS_CLOSED'], Yii::$app->params['STATUS_REJECTED']];

        if (null !== Yii::$app->request->post('cancel')) {
            $this->redirect(['index']);
        } else if(null !== Yii::$app->request->post('close-pallet')) {
            // close pallets
            $transactionDetails = Yii::$app->request->post('TrxTransactionDetails');

            if (!$this->isEmpty($transactionDetails['pallet_no'])) {
                TrxTransactionDetails::updateAll(['status'          => Yii::$app->params['STATUS_CLOSED'],
                                                  'updater_id'      => Yii::$app->user->id,
                                                  'updated_date'    => date('Y-m-d H:i:s')], //@TODO: use yii date formatter
                                                 ['pallet_no'       => $transactionDetails['pallet_no'],
                                                  'status'          => $params]);
                $palletStatus['close_success'] = true;
            } else {
                $palletStatus['close_error'] = true;
            }
        } else {
            // Do nothing
        }

        return $this->render('create-to-select-pallet', [
                'transactionModel'  => $transactionModel,
                'palletStatus'      => $palletStatus,
        ]);
	}

    public function actionCreateTo()
    {
        $data_provider = new ActiveDataProvider(['query' => Yii::$app->modelFinder->getTransactionDetailList(null, null, null,
                                                                                                             ['status'         => [
                                                                                                                                   Yii::$app->params['STATUS_CLOSED'],
																																		]],
                                                                                                                true),
                                                 'sort'=> ['defaultOrder' => ['pallet_no' => SORT_DESC]],]);
        $search_model = new TrxTransactionDetailsSearch;

        if (null != Yii::$app->request->get('TrxTransactionDetailsSearch')['pallet_no']) {
            $params = ['status' => [Yii::$app->params['STATUS_CLOSED']] ];

            $data_provider = $search_model->search(Yii::$app->request->queryParams, $params);
        }

        $createToFlag = array();
        $rejectFlag = array();

        if (null !== Yii::$app->request->post('cancel')) {
            $this->redirect(['index']);
        } else if (null !== Yii::$app->request->post('create-to') && null !== Yii::$app->request->post('selection')) {
            $pallets = array_unique(Yii::$app->request->post('selection'));
            $palletsStatus = array();
            $arrPalletCount = array_count_values(Yii::$app->request->post('selection'));
            foreach ($pallets as $key => $value) {
                $transactionDetailsModel = Yii::$app->modelFinder->getTransactionDetailList(null, null, null,
                                                                                            ['pallet_no' => $value]);
                $transactionDetailsStatusCountList = array_count_values(ArrayHelper::getColumn($transactionDetailsModel, 'status'));
                if (count($transactionDetailsModel) != $arrPalletCount[$value]) {
                    $palletsStatus[$value]['create_to_flag'] = false;
                    $palletsStatus[$value]['to_error'] = 'Please select all pallets';
                } else if (isset($transactionDetailsStatusCountList['process']) && $transactionDetailsStatusCountList['process'] > 0
                    || isset($transactionDetailsStatusCountList['rejected']) && $transactionDetailsStatusCountList['rejected'] > 0) {
                    $palletsStatus[$value]['create_to_flag'] = false;
                    $palletsStatus[$value]['to_error'] = 'Pallet #:' . $value . ' is still open.';
                } else {
                    $model = new TrxHandlingUnit();
                    $date = date('Y-m-d H:i:s'); // @TODO Use Yii dateformatter
                    // set defaults
                    // @TODO: transfer updating of status/created/updated details to model
                    // set status, created and updated details
                    $model->inbound_status  = Yii::$app->params['STATUS_PROCESS'];
                    $model->creator_id      = Yii::$app->user->id;
                    $model->created_date    = $date;
                    $model->updater_id      = Yii::$app->user->id;
                    $model->updated_date    = $date;

                    $transactionModel = Yii::$app->modelFinder->findTransactionModel($transactionDetailsModel[0]['transaction_id']);
                    $model->transaction_id = $transactionModel->id;
                    $model->customer_code = $transactionModel->customer_code;
                    $model->inbound_no = $transactionModel->sap_no;
                    $model->pallet_no = $value;
                    $model->plant_location = $transactionModel->plant_location;
                    $model->storage_location = $transactionModel->storage_location;

                    $model->packaging_code = $transactionDetailsModel[0]['packaging_code'];
                    $model->pallet_weight = $transactionDetailsModel[0]['pallet_weight'];
                    //$model->storage_type = $createTO['export']['storage_type'];
                    //$model->storage_section = $createTO['export']['storage_section'];
                    //$model->storage_bin = $createTO['export']['storage_bin'];
                    //$model->inbound_status = $createTO['export']['storage_position'];

                    if ($model->validate()) {
                        $createTO = $this->createTO($value);
                        if (isset($createTO['error'])) {
                            $palletsStatus[$value]['create_to_flag'] = false;
                            $palletsStatus[$value]['to_error'] = $createTO['error'];
                        } else {
                            $model->transfer_order = $createTO['export']['transfer_order'];
                            if ($model->save()) {
                                $palletsStatus[$value]['create_to_flag'] = true;
                                $palletsStatus[$value]['to_number'] = $createTO['export']['transfer_order'];
                            } else {
                                $palletsStatus[$value]['create_to_flag'] = false;
                                if (isset($createTO['error'])) {
                                    $palletsStatus[$value]['to_error'] = $createTO['error'];
                                } else {
                                    $palletsStatus[$value]['to_error'] = $createTO['export']['transfer_order'];
                                }
                            }
                        }
                    } else {
                        $palletsStatus[$value]['create_to_flag'] = false;
                        $palletsStatus[$value]['to_error'] = $model->getFirstError('transfer_order');
                    }
                }
            }
            // Form success and/or error messages
            foreach ($palletsStatus as $palletKey => $palletValue) {

                if ($palletValue['create_to_flag']) {
                    // Success
                    $createToFlag['to_success'][$palletKey] = 'Successfully created Transfer Order for Pallet #: ' . $palletKey . ' T.O. Number: ' . $palletValue['to_number'] . '<br/>';
                } else {
                    // Error
                    $createToFlag['to_error'][$palletKey] = 'Failed to create Transfer Order for Pallet #: ' . $palletKey . ' Error: ' . $palletValue['to_error'] . '<br/>';
                }
            }
        } else if (null !== Yii::$app->request->post('reject') && null !== Yii::$app->request->post('selection')) {
            $pallets = array_unique(Yii::$app->request->post('selection'));
            $palletsStatus = array();

            // active pallets
            $params = [Yii::$app->params['STATUS_PROCESS'], Yii::$app->params['STATUS_CLOSED'], Yii::$app->params['STATUS_REJECTED']];

            foreach ($pallets as $key => $value) {
                // Reject pallets
                $transactionDetailsModel = Yii::$app->modelFinder->getTransactionDetailList(null, null, null,
                                                                                            ['pallet_no'    => $value,
                                                                                             'status'       => $params]);
                if ($transactionDetailsModel) {
                    $handlingUnit = Yii::$app->modelFinder->getHandlingUnit(['transaction_id'   =>  $transactionDetailsModel[0]['transaction_id'],
                                                                             'customer_code'    =>  $transactionDetailsModel[0]['customer_code'],
                                                                             'pallet_no'        =>  $value]);

                    if (!$handlingUnit) {
                        TrxTransactionDetails::updateAll(['status'          => Yii::$app->params['STATUS_REJECTED'],
                                                          'updater_id'      => Yii::$app->user->id,
                                                          'updated_date'    => date('Y-m-d H:i:s')], //@TODO: use yii date formatter
                                                         ['pallet_no'       => $value,
                                                          'status'          => $params]);
                        $rejectFlag['reject_success'][$value] = 'Successfully rejected Pallet #: ' . $value;
                    } else {
                        $rejectFlag['reject_error'][$value] = 'Failed to reject Pallet #: ' . $value . '. T.O. number is already issued.';
                    }

                } else {
                    $rejectFlag['reject_error'][$value] = 'Failed to reject Pallet #: ' . $value;
                }
            }
        } else {
            if (null !== Yii::$app->request->post('create-to')) {
                $createToFlag['error'] = 'No rows selected for create TO.';
            }
            if (null !== Yii::$app->request->post('reject')) {
                $rejectFlag['error'] = 'No rows selected for reject.';
            }
        }

        return $this->render('create-to', ['data_provider' => $data_provider,
                                           'search_model'  => $search_model,
                                           'createToFlag'  => $createToFlag,
                                           'rejectFlag'    => $rejectFlag,
                                          ]);
    }

	public function actionClose()
	{
		$this->initUser();

		$success = false;
        $error = null;

		// Get customer list
		$customer_model = new MstCustomer();
		$customer_list = ArrayHelper::map(Yii::$app->modelFinder->getCustomerList(), 'code', 'name');
		$transaction_model = new TrxTransactionDetails();
		$transaction_list = array();
		$pallet_no = '';

		if(null !== Yii::$app->request->post('cancel')) {
    		$this->redirect(['index']);
    	} else if (null !== Yii::$app->request->post('close-receiving')) {
	    	// close receiving
	    	$transaction = Yii::$app->modelFinder->findTransactionModel(Yii::$app->request->post('transaction_id'));

            $closeReceiving = $this->closeReceiving($transaction->sap_no, $transaction->actual_gr_date);
            if (isset($closeReceiving['success']) && $closeReceiving['success'] <> 0) {
                $transaction->status = Yii::$app->params['STATUS_CLOSED'];
                $success = $transaction->update();
            } else {
                $error = $closeReceiving['error'];
            }
		}

		return $this->render('close', [
			'customer_model'	=> $customer_model,
			'customer_list'		=> $customer_list,
			'transaction_model' => $transaction_model,
			'transaction_list'	=> $transaction_list,
			'pallet_no'         => $pallet_no,
			'success'			=> $success,
            'error'             => $error,
		]);
	}

	public function actionSynchronize()
	{
		return $this->render('synchronize');
	}

	public function actionGetTransaction($id, $type = null)
	{
        $transaction_model = null;
        if ($type != null && $type === 'brds') {
            $transaction_model = Yii::$app->modelFinder->findTransactionModel($id); // @TODO: change to dynamic transaction id
        } else if ($type != null && $type === 'sap') {
            $transaction_model = Yii::$app->modelFinder->getTransaction(['sap_no' => $id]);
        } else {
            // Do nothing
        }

		// if no transaction selected
		if ($id === '-- Select a transaction --') {
			return;
		}

		$customer_model = Yii::$app->modelFinder->findCustomerModel($transaction_model->customer_code);

		// retrieve all transaction details
		$transaction_details_model = Yii::$app->modelFinder->getTransactionDetailList(null, null, null,
																					  ['transaction_id' => $transaction_model->id,
																					   'status' 		=> [Yii::$app->params['STATUS_PROCESS'], Yii::$app->params['STATUS_CLOSED'], Yii::$app->params['STATUS_REJECTED']]], false, null);

		$transaction_model_properties = [
										    'app\models\TrxTransactions' => [
										        'id',
										        'customer_code',
										        'sap_no',
										        'created_date',
										        'plant_location',
										        'storage_location',
										        'truck_van',
										        'remarks',
										    ],
										];

		$customer_model_properties = 	[
										    'app\models\MstCustomer' => [
										        'customer_name' => 'name',
										    ],
										];

		// get pallet count
		$pallet_count = Yii::$app->modelFinder->getTransactionDetailList(null, 'id', null, ['transaction_id' => $transaction_model->id,
																						   	'status' 		 => [Yii::$app->params['STATUS_PROCESS'], Yii::$app->params['STATUS_CLOSED'], Yii::$app->params['STATUS_REJECTED']]], false, 'pallet_no');

		// get total weight from trx_transaction_details
		$total_weight = array_sum(ArrayHelper::map($transaction_details_model, 'id', 'total_weight'));

		$transaction_header = ArrayHelper::toArray($transaction_model, $transaction_model_properties);
		$customer_name = ArrayHelper::toArray($customer_model, $customer_model_properties);

		$transaction_header = ArrayHelper::merge($transaction_header, $customer_name);

		$transaction_header['pallet_count'] = $pallet_count;
		$transaction_header['total_weight'] = $total_weight;

		$transaction_header['created_date_formatted'] = date('m/d/Y', strtotime($transaction_header['created_date']));

		echo json_encode($transaction_header);
	}

	public function actionGetTransactionList($id, $type = null) {
        $column = 'id';
        $condition = ['customer_code' => $id];
        if ($type != null && $type === 'sap') {
            $column = 'sap_no';
            $condition = ['and',['customer_code' => $id], ['not', ['sap_no' => '']]];
        }

		$transactionlist = ArrayHelper::getColumn(Yii::$app->modelFinder->getTransactionList(null, $condition), $column);
		echo json_encode($transactionlist);
	}

    public function actionGetPackagingType($id, $plant_location) {

		$condition[] = 'and';
        $condition[] = ['like', 'description', Yii::$app->params['PALLET']];
		$condition[] = ['like', 'material_code', 'VERP%',false];
		
		if(isset($id) && $id !== 'undefined')
		{
			$condition[] = ['pallet_type' => $id];
		}
		
		/*if(isset($plant_location) && $plant_location !== 'undefined')
		{
			$condition[] = ['plant_location' => Yii::$app->request->get('plant_location')];
		}*/
		
        $packaging_type_model = Yii::$app->modelFinder->getPackagingMaterialList(null, $condition);

        $packaging_type_list['material_code'] = ArrayHelper::getColumn($packaging_type_model, 'material_code');
        $packaging_type_list['description'] = ArrayHelper::getColumn($packaging_type_model, 'description');

        echo json_encode($packaging_type_list);
    }

    public function actionGetKittingType($id) {
        $kitting_type_model = Yii::$app->modelFinder->getPackagingMaterialList(null, ['and',
            ['pallet_type' => Yii::$app->request->get('id'),
             'plant_location' => Yii::$app->request->get('plant_location')],
            ['not like', 'description', Yii::$app->params['PALLET']],['like', 'material_code', 'VERP%',false]]);

        $kitting_type_list['material_code'] = ArrayHelper::getColumn($kitting_type_model, 'material_code');
        $kitting_type_list['description'] = ArrayHelper::getColumn($kitting_type_model, 'description');

        echo json_encode($kitting_type_list);
    }

    public function actionGetMaterial($id, $desc) {
        $material_model = Yii::$app->modelFinder->getMaterialList(null, ['and',['like', 'item_code', "{$id}%", false], ['like', 'description', "{$desc}%", false]]);

        if ($material_model == null || count($material_model) == 0) {
            $material_model = Yii::$app->modelFinder->getMaterialList(null, ['and',['like', 'item_code', $id], ['like', 'barcode', $desc]]);
        }

		if ($material_model == null || count($material_model) == 0) {
            $material_model = Yii::$app->modelFinder->getMaterialList(null, ['and',['like', 'item_code', $id], ['upc_2' => $desc]]);
        }

		if ($material_model == null || count($material_model) == 0) {
            $material_model = Yii::$app->modelFinder->getMaterialList(null, ['and',['like', 'item_code', $id], ['upc_2' => $desc]]);
        }

        $material_list['item_code'] = ArrayHelper::getColumn($material_model, 'item_code');
        $material_list['description'] = ArrayHelper::getColumn($material_model, 'description');

        echo json_encode($material_list);
    }

    public function actionGetMaterialConversion($id) {
        if ($this->isEmpty($id)) {
            $material_conversion['conversion_flag'] = false;
        } else {
            $material_conversion_model = Yii::$app->modelFinder->getMaterialConversion(null, ['material_code' => $id]);

            if ($material_conversion_model != null && count($material_conversion_model) > 0) {
                $material_conversion = array();
                $material_conversion['conversion_flag'] = false;
                if (!$this->isEmpty($material_conversion_model->unit_1)) {
                    $material_conversion[Yii::$app->params['UNIT_1']]['unit'] = $material_conversion_model->unit_1;
                    $material_conversion[Yii::$app->params['UNIT_1']]['num'] = $material_conversion_model->num_1;
                    $material_conversion[Yii::$app->params['UNIT_1']]['den'] = $material_conversion_model->den_1;
                    if (!$material_conversion['conversion_flag'] && $material_conversion_model->unit_1 !== Yii::$app->params['UNIT_KG']) {
                        $material_conversion['conversion_flag'] = true;
                    }
                }

                if (!$this->isEmpty($material_conversion_model->unit_2)) {
                    $material_conversion[Yii::$app->params['UNIT_2']]['unit'] = $material_conversion_model->unit_2;
                    $material_conversion[Yii::$app->params['UNIT_2']]['num'] = $material_conversion_model->num_2;
                    $material_conversion[Yii::$app->params['UNIT_2']]['den'] = $material_conversion_model->den_2;
                    if (!$material_conversion['conversion_flag'] && $material_conversion_model->unit_2 !== Yii::$app->params['UNIT_KG']) {
                        $material_conversion['conversion_flag'] = true;
                    }
                }

                if (!$this->isEmpty($material_conversion_model->unit_3)) {
                    $material_conversion[Yii::$app->params['UNIT_3']]['unit'] = $material_conversion_model->unit_3;
                    $material_conversion[Yii::$app->params['UNIT_3']]['num'] = $material_conversion_model->num_3;
                    $material_conversion[Yii::$app->params['UNIT_3']]['den'] = $material_conversion_model->den_3;
                    if (!$material_conversion['conversion_flag'] && $material_conversion_model->unit_3 !== Yii::$app->params['UNIT_KG']) {
                        $material_conversion['conversion_flag'] = true;
                    }
                }
            }
        }
        echo json_encode($material_conversion);

    }

    public function actionGetPalletDetails($id) {

		if(!$id)
		{
			$transactionDetailsModel = new TrxTransactionDetails();
			$transactionDetailsFields = array_keys($transactionDetailsModel->attributeLabels());
			$additionalFields = array('inbound_no','transfer_order','customer_name','pallet_count');

			$transactionDetailsFields = array_merge($transactionDetailsFields,$additionalFields);
			foreach($transactionDetailsFields as $fieldName)
			{
				$palletDetails[$fieldName] = '';
			}

			echo json_encode($palletDetails);
			exit;
		}

        $status = [Yii::$app->params['STATUS_PROCESS'],
                     Yii::$app->params['STATUS_CLOSED'],
                     Yii::$app->params['STATUS_REJECTED']];

        $transactionDetailsModel = Yii::$app->modelFinder->getTransactionDetailList(null, null, null,
                                                                                    ['pallet_no'    => $id,
                                                                                     'status'       => $status]);
        if ($transactionDetailsModel == null || count($transactionDetailsModel) == 0) {
            $transactionDetailsModel = Yii::$app->modelFinder->getTransactionDetailList(null, null, null,
                                                                                    ['kitted_unit'  => $id,
                                                                                     'status'       => $status]);
        }

        if ($transactionDetailsModel != null && count($transactionDetailsModel) > 0) {
            $palletDetails['transaction_id'] = $transactionDetailsModel[0]['transaction_id'];
            // Transaction model
            $transactionModel = Yii::$app->modelFinder->findTransactionModel($palletDetails['transaction_id']);
            if ($transactionModel) {
                $palletDetails['inbound_no'] = $transactionModel['sap_no'];
            } else {
                $palletDetails['inbound_no'] = "";
            }
            $palletDetails['customer_code'] = $transactionDetailsModel[0]['customer_code'];
            $customer = Yii::$app->modelFinder->findCustomerModel($palletDetails['customer_code']);
            if ($customer != null) {
                $palletDetails['customer_name'] = $customer->name;
            } else {
                $palletDetails['customer_name'] = "";
            }
            $palletDetails['material_code'] = $transactionDetailsModel[0]['material_code'];
            $palletDetails['batch'] = $transactionDetailsModel[0]['batch'];
            $palletDetails['pallet_count'] = count($transactionDetailsModel);
            $palletDetails['net_weight'] = $transactionDetailsModel[0]['net_weight'];
            $palletDetails['total_weight'] = $transactionDetailsModel[0]['total_weight'];
            $palletDetails['pallet_weight'] = $transactionDetailsModel[0]['pallet_weight'];
            $palletDetails['kitted_unit'] = $transactionDetailsModel[0]['kitted_unit'];
            $palletDetails['manufacturing_date'] = $transactionDetailsModel[0]['manufacturing_date'];
            $palletDetails['expiry_date'] = $transactionDetailsModel[0]['expiry_date'];
            $palletDetails['pallet_type'] = $transactionDetailsModel[0]['pallet_type'];
            // Handling unit
            $handlingUnit = Yii::$app->modelFinder->getHandlingUnit(['transaction_id'   =>  $palletDetails['transaction_id'],
                                                                     'customer_code'    =>  $palletDetails['customer_code'],
                                                                     'pallet_no'        =>  $id]);
            if ($handlingUnit) {
                $palletDetails['transfer_order'] = $handlingUnit['transfer_order'];
            } else {
                $palletDetails['transfer_order'] = "";
            }
            $palletDetails['status'] = $transactionDetailsModel[0]['status'];
            // Creator details
            $creatorAccountModel = Yii::$app->modelFinder->findAccountModel($transactionDetailsModel[0]['creator_id']);
            $palletDetails['creator'] = $creatorAccountModel->first_name . ' ' . $creatorAccountModel->last_name;
            $palletDetails['created_date'] = date('m/d/Y', strtotime($transactionDetailsModel[0]['created_date']));
            // Updater details
            $updaterAccountModel = Yii::$app->modelFinder->findAccountModel($transactionDetailsModel[0]['updater_id']);
            $palletDetails['updater'] = $updaterAccountModel->first_name . ' ' . $updaterAccountModel->last_name;
            $palletDetails['updated_date'] = date('m/d/Y', strtotime($transactionDetailsModel[0]['updated_date']));
        }

        echo json_encode($palletDetails);
    }

    public function actionValidatePallet($id) {
        $response['success'] = true;
        $status = [Yii::$app->params['STATUS_PROCESS'],
                     Yii::$app->params['STATUS_CLOSED'],
                     Yii::$app->params['STATUS_REJECTED']];

        $transactionDetailsModel = Yii::$app->modelFinder->getTransactionDetailList(null, null, null,
                                                                                    ['pallet_no' => $id,
                                                                                     'status'    => $status]);

        if ($transactionDetailsModel == null || count($transactionDetailsModel) == 0) {
            $transactionDetailsModel = Yii::$app->modelFinder->getTransactionDetailList(null, null, null,
                                                                                    ['kitted_unit'  => $id,
                                                                                     'status'       => $status]);
        }

        if ($transactionDetailsModel != null && count($transactionDetailsModel) > 0) {
            if (Yii::$app->request->get('transaction_id') !== $transactionDetailsModel[0]['transaction_id']) {
                $response['success'] = false;
                $response['error'] = 'Pallet # is already being used in another transaction.';
            } else if (Yii::$app->request->get('material_code')) {
                $material = Yii::$app->modelFinder->findMaterialModel(Yii::$app->request->get('material_code'));
                if ($transactionDetailsModel[0]['pallet_type'] !== $material['pallet_ind']) {
                    $response['success'] = false;
                    $response['error'] = 'Compatibility error. Pallet type is different with the selected customer product pallet type. Please select compatible customer product.';
                }
            } else {
                $response['success'] = true;
            }
        }

        echo json_encode($response);
    }

    public function actionGetBatch($id, $desc) {
        $batchList = null;
        $transactionDetailsModel = Yii::$app->modelFinder->getTransactionDetailList(null, null, null,
                                                                                    ['material_code'    => $id,
                                                                                     'transaction_id'   =>  $desc,
                                                                                     'status'           => [Yii::$app->params['STATUS_PROCESS'],
                                                                                                            Yii::$app->params['STATUS_CLOSED'],
                                                                                                            Yii::$app->params['STATUS_REJECTED']]]);

        if ($transactionDetailsModel != null && count($transactionDetailsModel) > 0) {
            $batchList = ArrayHelper::getColumn($transactionDetailsModel, 'batch');
            $batchList = array_values(array_unique($batchList));
        }

        echo json_encode($batchList);
    }

    public function actionGetManufacturingExpiryDateFromBatch($id) {
        $response = null;
        $condition['batch'] = $id;
        if (isset($_GET['code']) && $_GET['code'] != '') {
            $condition['material_code'] = $_GET['code'];
        }
        $transactionDetailsModel = Yii::$app->modelFinder->getTransactionDetails($condition);

        if ($transactionDetailsModel != null && count($transactionDetailsModel) > 0) {
            $response['material_code'] = $transactionDetailsModel->material_code;
            $response['manufacturing_date'] = date('d-M-y', strtotime($transactionDetailsModel->manufacturing_date));
            $response['expiry_date'] = date('d-M-y', strtotime($transactionDetailsModel->expiry_date));
        }

        echo json_encode($response);
    }

    public function isEmpty($str) {
        if (isset($str) && $str != null && $str !== SapConst::EMPTY_STRING) {
            return false;
        } else {
            return true;
        }
    }

    public function getSapInboundNumber($trxTransaction, $trxTransactionDetails) {
        $params[SapConst::RFC_FUNCTION] = SapConst::ZBAPI_RECEIVING;

        // Post http://127.0.0.1/brdssap/sap/import
        $params[SapConst::PARAMS][SapConst::ZEX_VBELN] = $trxTransaction['id'];
        $params[SapConst::PARAMS][SapConst::KUNNR] = $trxTransactionDetails['customer_code'];
        $params[SapConst::PARAMS][SapConst::MATNR] = $trxTransactionDetails['material_code'];
        $params[SapConst::PARAMS][SapConst::LFIMG] = number_format((float)$trxTransactionDetails['total_weight'], 3, '.', '');
        $params[SapConst::PARAMS][SapConst::CHARG] = $trxTransactionDetails['batch'];
        $params[SapConst::PARAMS][SapConst::WERKS] = $trxTransaction['plant_location'];
        $params[SapConst::PARAMS][SapConst::LFART] = SapConst::ZEL;
        $params[SapConst::PARAMS][SapConst::LGORT] = $trxTransaction['storage_location'];
        $params[SapConst::PARAMS][SapConst::XABLN] = $trxTransaction['truck_van'];
        $params[SapConst::PARAMS][SapConst::WADAT] = date('Ymd');
        $params[SapConst::PARAMS][SapConst::WDATU] = date('Ymd', strtotime($trxTransaction['actual_gr_date']));
        $params[SapConst::PARAMS][SapConst::HSDAT] = date('Ymd', strtotime($trxTransactionDetails['manufacturing_date']));
        $params[SapConst::PARAMS][SapConst::VFDAT] = date('Ymd', strtotime($trxTransactionDetails['expiry_date']));
        $params[SapConst::PARAMS][SapConst::CRATES_IND] = !$this->isEmpty($trxTransactionDetails['kitting_code']) ? SapConst::X : SapConst::HALF_WIDTH_SPACE;
        // Packaging Type
        $params[SapConst::PARAMS][SapConst::EXIDV_PAL] = !$this->isEmpty($trxTransactionDetails['pallet_no']) ? $trxTransactionDetails['pallet_no'] : SapConst::HALF_WIDTH_SPACE;
        $params[SapConst::PARAMS][SapConst::VHILM2] = !$this->isEmpty($trxTransactionDetails['packaging_code']) ? $trxTransactionDetails['packaging_code'] : SapConst::HALF_WIDTH_SPACE;
        // Kitting Type
        $params[SapConst::PARAMS][SapConst::EXIDV] = !$this->isEmpty($trxTransactionDetails['kitted_unit']) ? $trxTransactionDetails['kitted_unit'] : SapConst::HALF_WIDTH_SPACE;
        $params[SapConst::PARAMS][SapConst::VHILM] = !$this->isEmpty($trxTransactionDetails['kitting_code']) ? $trxTransactionDetails['kitting_code'] : SapConst::HALF_WIDTH_SPACE;
        $params[SapConst::PARAMS][SapConst::REMARKS] = $trxTransaction['remarks'];
        $params[SapConst::PARAMS][SapConst::LAST_ITEM_IND] = SapConst::HALF_WIDTH_SPACE;
        $response = $this->curl(Yii::$app->params['SAP_API_URL'], false, http_build_query($params), false, true);
        return $response;
    }

    public function createTO($palletNo) {
        $params[SapConst::RFC_FUNCTION] = SapConst::L_TO_CREATE_MOVE_SU;

        // Post http://127.0.0.1/brdssap/sap/import
        $params[SapConst::PARAMS][SapConst::I_LENUM] = str_pad($palletNo, 20, '0', STR_PAD_LEFT);

        $response = $this->curl(Yii::$app->params['SAP_API_URL'], false, http_build_query($params), false, true);
        return $response;
    }

    public function closeReceiving($inboundNo, $actualGRDate) {
        $params[SapConst::RFC_FUNCTION] = SapConst::ZBAPI_POST_GR;

        // Post http://127.0.0.1/brdssap/sap/import
        $params[SapConst::PARAMS][SapConst::VBELN] = $inboundNo;
        $params[SapConst::PARAMS][SapConst::WDATU] = date('Ymd', strtotime($actualGRDate));

        $response = $this->curl(Yii::$app->params['SAP_API_URL'], false, http_build_query($params), false, true);
        return $response;
    }

    function curl($url, $cookie = false, $post = false, $header = false, $follow_location = false, $referer=false, $proxy=false) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_REFERER, $referer);
        curl_setopt($ch, CURLOPT_HEADER, $header);
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $follow_location);
        if ($cookie) {
            curl_setopt ($ch, CURLOPT_COOKIE, $cookie);
        }
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $response;
    }
}
