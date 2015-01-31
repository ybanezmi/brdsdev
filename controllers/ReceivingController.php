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

/**
 * ReceivingController implements the CRUD actions for TrxTransactions model.
 */
class ReceivingController extends Controller
{
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
		// get access of users
		$account_count = Yii::$app->modelFinder->getAccountList(null, ['access_token' => 'receiving'], 'id');
    	if ($account_count > 0) {
    		$this->redirect(['index']);
    	} else {
    		// set access token for user
	    	$account_model = Yii::$app->modelFinder->findAccountModel(Yii::$app->user->id);
			$account_model->access_token = 'receiving';
			$account_model->save();
    	}
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
		$account_count = Yii::$app->modelFinder->getAccountList(null, ['access_token' => 'receiving'], 'id');
		$isAccessReceiving = false;
    	if ($account_count > 0) {
    		$isAccessReceiving = true;
    	}
		
		// active pallets
		$params = [Yii::$app->params['STATUS_PROCESS'], Yii::$app->params['STATUS_CLOSED'], Yii::$app->params['STATUS_REJECTED']];
		
		// pallet status
		$palletStatus = array();
		
		// open pallets
		$palletStatus['open_success'] = false;
		$palletStatus['open_error'] = false;
		if(null !== Yii::$app->request->post('open-pallet')) {
			if (null !== Yii::$app->request->post('open_pallet_no') && "" !== Yii::$app->request->post('open_pallet_no')) {
				TrxTransactionDetails::updateAll(['status' 			=> Yii::$app->params['STATUS_PROCESS'],
												  'updater_id'		=> Yii::$app->user->id,
												  'updated_date'	=> date('Y-m-d H:i:s')], //@TODO: use yii date formatter
												 ['pallet_no' 		=> Yii::$app->request->post('open_pallet_no'),
												  'status' 			=> $params]);
				$palletStatus['open_success'] = true;
			} else {
				$palletStatus['open_error'] = true;
			}
		}	
		
		// close pallets
		$palletStatus['close_success'] = false;
		$palletStatus['close_error'] = false;
		if(null !== Yii::$app->request->post('close-pallet')) {
			if (null !== Yii::$app->request->post('close_pallet_no') && "" !== Yii::$app->request->post('close_pallet_no')) {
				TrxTransactionDetails::updateAll(['status' 			=> Yii::$app->params['STATUS_CLOSED'],
												  'updater_id'		=> Yii::$app->user->id,
												  'updated_date'	=> date('Y-m-d H:i:s')], //@TODO: use yii date formatter
												 ['pallet_no' 		=> Yii::$app->request->post('close_pallet_no'),
												  'status' 			=> $params]);
				$palletStatus['close_success'] = true;
			} else {
				$palletStatus['close_error'] = true;
			}
		}

		// reject pallets
		$palletStatus['reject_success'] = false;
		$palletStatus['reject_error'] = false;
		if(null !== Yii::$app->request->post('reject-pallet')) {
			if (null !== Yii::$app->request->post('reject_pallet_no') && "" !== Yii::$app->request->post('reject_pallet_no')) {
				TrxTransactionDetails::updateAll(['status' 			=> Yii::$app->params['STATUS_REJECTED'],
												  'updater_id'		=> Yii::$app->user->id,
												  'updated_date'	=> date('Y-m-d H:i:s')], //@TODO: use yii date formatter
												 ['pallet_no' 		=> Yii::$app->request->post('reject_pallet_no'),
												  'status' 			=> $params]);
				$palletStatus['reject_success'] = true;
			} else {
				$palletStatus['reject_error'] = true;
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
    public function actionViewEntries($id)
    {
    	$data_provider = new ActiveDataProvider([
							  						'query' => Yii::$app->modelFinder->getTransactionDetailList(null, null, null, 
							  																					['transaction_id' => $id,
															   			  	 									 'status' 		=> [Yii::$app->params['STATUS_PROCESS'], Yii::$app->params['STATUS_CLOSED'], Yii::$app->params['STATUS_REJECTED']]],
																												true),
													'sort'=> ['defaultOrder' => ['status'=>SORT_ASC,
																				 'id'=>SORT_ASC]],
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
		
    	if(null !== Yii::$app->request->post('cancel')) {
    		$this->redirect(['index']);
    	} else {
    		$model = new TrxTransactions();
            $model_plant_location = new MstPlantLocation();
			$date = date('Y-m-d H:i:s'); // @TODO Use Yii dateformatter
			
			// set defaults
			$model->id 	= strtotime(date("Ymdhis")); // @TODO should be set onBeforeSave in TrxTransactions model
			
			// @TODO: transfer updating of status/created/updated details to model
			// set status, created and updated details
			$model->status			= Yii::$app->params['STATUS_PROCESS'];
			$model->creator_id		= Yii::$app->user->id;
			$model->created_date 	= $date;
			$model->updater_id		= Yii::$app->user->id;
			$model->updated_date	= $date;
			
	        if ($model->load(Yii::$app->request->post()) && $model->save()) {
	            return $this->redirect(['menu', 'id' => $model->id]);
	        } else {
	        	// Get customer list
	        	$customer_list = ArrayHelper::map(Yii::$app->modelFinder->getCustomerList(), 'code', 'name');
                $plant_list = ArrayHelper::map(Yii::$app->modelFinder->getPlantList(null, ['plant_location' => Yii::$app->user->identity->assignment]), 
							'storage_location', 'plant_location');
                $storage_list = array_combine(array_unique (array_keys($plant_list)),array_unique (array_keys($plant_list)));
                $plant_list = array_combine(array_unique (array_values($plant_list)),array_unique (array_values($plant_list)));

	            return $this->render('create', [
	                'model' => $model,
	                'customer_list' => $customer_list,
                    'plant_list' => $plant_list,
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
    	} else if (null !== Yii::$app->request->post('close-pallet')) {
    		$transaction_model = Yii::$app->modelFinder->findTransactionModel($id);
    	    $material_conversion_model = new MstMaterialConversion;
			$date = date('Y-m-d H:i:s');
			
			// increment # of pallet
			$transaction_model->weight 		 = 0;
			
			// get total weight from trx_transaction_details
			$transaction_detail_list = Yii::$app->modelFinder->getTransactionDetailList(null, null, null,
																					    ['transaction_id' => $transaction_model->id,
																						 'status' 		  => [Yii::$app->params['STATUS_PROCESS'], Yii::$app->params['STATUS_CLOSED'], Yii::$app->params['STATUS_REJECTED']]]);
																							   
			// @TODO: use max param in getTransactionDetailList
			$total_weight = array_sum(ArrayHelper::map($transaction_detail_list, 'id', 'total_weight'));
			
			// set updated details 
			$transaction_model->updater_id		= Yii::$app->user->id;
			$transaction_model->updated_date	= $date;
			
			// close pallets
			TrxTransactionDetails::updateAll(['status' 			=> Yii::$app->params['STATUS_CLOSED'],
											  'updater_id'		=> Yii::$app->user->id,
											  'updated_date'	=> $date], 
											 ['transaction_id' 	=> $transaction_model->id,
											  'pallet_no' 		=> Yii::$app->request->post('close_pallet_no'),
											  'status' 			=> Yii::$app->params['STATUS_PROCESS']]);
			
			if ($transaction_model->save()) {
				return $this->redirect(['menu', 'id' => $transaction_model->id]);
			} else {
				return $this->render('menu', [
	                'transaction_model' 		=> $transaction_model,
	                'customer_model'			=> $customer_model,
	                'material_list'				=> $material_list,
                    'material_conversion_model' => $material_conversion_model,
	                'transaction_detail_model'	=> $transaction_detail_model,
	                'handling_unit_model' 		=> $handling_unit_model,
	                'total_weight'				=> $total_weight,
	            ]);
			}
    	} else if (null !== Yii::$app->request->post('view-entries')) {
    		$this->redirect(['view-entries', 'id' => $id]);
    	} else {
			$transaction_model = Yii::$app->modelFinder->findTransactionModel($id);
			$customer_model = Yii::$app->modelFinder->findCustomerModel($transaction_model->customer_code);
			$material_model = Yii::$app->modelFinder->getMaterialList(null, ['like', 'item_code', $transaction_model->customer_code]);
			
			$material_list = ArrayHelper::map($material_model, 'item_code', 'description');

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
					case 'y':
						$material_sled_conv[$value['item_code']] = $material_sled[$key]['sled'] * 12 * 30;
						break;
					case 'm':
						$material_sled_conv[$value['item_code']] = $material_sled[$key]['sled'] * 30;
						break;
					case 'd':
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
							var material_list_barcode = " . $js_material_barcode . "; 
							var material_list_desc = " . $js_material_desc . ";
							var material_sled = " . $js_material_sled . ";
							var material_pallet_ind = " . $js_material_pallet_ind . ";
							var material_conversion = " . $js_material_conversion . ";
							var transaction_details = " . $js_transaction_details . ";
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
			
	        if(isset($_GET["pallet_no"])){
	        	$pallet_no = htmlspecialchars($_GET["pallet_no"]);
	        } else {
	        	$pallet_no = '';
	        }
			
			$isPalletAdded = false;
			
	        if (!$isPalletClosed && !$isPalletRejected && $transaction_detail_model->load(Yii::$app->request->post()) && $transaction_detail_model->save()) {
				
				// add net weight of transaction_detail to the total weight of transaction
				$transaction_model->weight = $transaction_model->weight + $transaction_detail_model->net_weight;

				// convert to correct date format
				$transaction_detail_model->setAttribute('manufacturing_date', Yii::$app->dateFormatter->convert($transaction_detail_model->getAttribute('manufacturing_date')));
				$transaction_detail_model->setAttribute('expiry_date', Yii::$app->dateFormatter->convert($transaction_detail_model->getAttribute('expiry_date')));
              
                // get total weight
				if ($transaction_model->save() && $transaction_detail_model->save()) {
					$isPalletAdded = true;
					$this->redirect(['menu', 'id' => $transaction_model->id,
											 'pallet' => $transaction_detail_model->pallet_no,
											 'isPalletAdded' => $isPalletAdded,
		                ]);
				} else {
					return $this->render('menu', [
		                'transaction_model' 		=> $transaction_model,
		                'customer_model'			=> $customer_model,
                        'material_conversion_model' => $material_conversion_model,
		                'material_list'				=> $material_list,
		                'transaction_detail_model'	=> $transaction_detail_model,
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
	        } else {
	            return $this->render('menu', [
	                'transaction_model' 		=> $transaction_model,
	                'customer_model'			=> $customer_model,
                    'material_conversion_model' => $material_conversion_model,
	                'material_list'				=> $material_list,
	                'transaction_detail_model'	=> $transaction_detail_model,
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
	
	public function actionClose()
	{
		return $this->render('close');
	}
	
	public function actionSynchronize()
	{
		return $this->render('synchronize');
	}
	
	public function actionGetTransaction($id)
	{
		// if no transaction selected
		if ($id === '-- Select a transaction --') {
			return;
		}
		$transaction_model = Yii::$app->modelFinder->findTransactionModel($id); // @TODO: change to dynamic transaction id
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

	public function actionGetTransactionList($id) {
		$transactionlist = ArrayHelper::getColumn(Yii::$app->modelFinder->getTransactionList(null, ['customer_code' => $id]), 'id');
		echo json_encode($transactionlist);		
	}

	public function actionValidatePallet() {
		
		$return['valid'] = true;
		echo json_encode($return);
	}
	
}
