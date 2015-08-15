<?php

namespace app\controllers;

use Yii;
use app\models\MstAccount;
use app\models\MstAccountSearch;
use app\models\MstCustomer;
use app\models\TrxTransactions;
use app\models\TrxTransactionsSearch;
use app\models\TrxTransactionDetails;
use app\models\TrxTransactionDetailsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use arturoliveira\ExcelView;
use yii\helpers\Json;

/**
 * AdminToolsController implements the CRUD actions for MstAccount model.
 */
class AdminToolsController extends Controller
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

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Lists all MstAccount models.
     * @return mixed
     */
    public function actionUserMgmt()
    {
        $account_search_model = new MstAccountSearch();
        $account_data_provider = $account_search_model->search(Yii::$app->request->queryParams);

        $params = array();
        $trxQueryParams = array();
        if (null !== Yii::$app->request->post('processTransactionDateFilter')) {
            // convert to correct date format
            $trxDateFrom = Yii::$app->dateFormatter->convert(Yii::$app->request->post('trx_start_date'));
            $trxDateTo = Yii::$app->dateFormatter->convert(Yii::$app->request->post('trx_end_date'));

            $trxQueryParams = ['between', 'created_date', $trxDateFrom, $trxDateTo];
        }

		$statusParam = ['status' => [Yii::$app->params['STATUS_PROCESS'], Yii::$app->params['STATUS_CLOSED'], Yii::$app->params['STATUS_REJECTED']]];
        if (count($trxQueryParams) > 0) {
            $params = ['and', $statusParam, $trxQueryParams];
        } else {
            $params = $statusParam;
        }
		$trx_details_search_model = new TrxTransactionDetailsSearch();
		$trx_details_data_provider = $trx_details_search_model->search(Yii::$app->request->queryParams, $params);

		// get initial transaction list
		$trx_details_model = Yii::$app->modelFinder->getTransactionDetailList(null, null, null, $params, false, null);
		$trx_details_status_count = array_count_values(ArrayHelper::getColumn($trx_details_model, 'status'));

		// get plant list
		$plant_location_list = Yii::$app->modelFinder->getPlantList(null, ['status' => Yii::$app->params['STATUS_ACTIVE']], 'plant_location');
		$assignment_list = ArrayHelper::map($plant_location_list, 'plant_location', 'plant_location');
		
		// get user list
		$account_list = Yii::$app->modelFinder->getAccountList();
		foreach($account_list as $key => $value) {
			$user_list[$value['id']] = $value['first_name'] . ' ' . $value['last_name'];
		}
		
		// validate if there is a editable input saved via AJAX
	    if (Yii::$app->request->post('hasEditable')) {
	        // find account model
	        $model = Yii::$app->modelFinder->findAccountModel(Yii::$app->request->post('editableKey'));
	 
	        // store a default json response as desired by editable
	        $out = Json::encode(['output'=>'', 'message'=>'']);
	 
	        // fetch the first entry in posted data (there should 
	        // only be one entry anyway in this array for an 
	        // editable submission)
	        // - $posted is the posted data for MstAccount without any indexes
	        // - $post is the converted array for single model validation
	        $post = [];
	        $posted = current(Yii::$app->request->post('MstAccount'));
	        $post['MstAccount'] = $posted;
	        // load model like any single model validation
	        if ($model->load($post)) {
	        	// apply default password
	        	if (isset($posted['password']) && $posted['password'] !== "") {
	        		$model->password = md5($posted['password']);
	        	}
				
	            // can save model or do something before saving model
	            $model->save();
	            // custom output to return to be displayed as the editable grid cell
	            // data. Normally this is empty - whereby whatever value is edited by 
	            // in the input by user is updated automatically.
	            $output = '';
	 
	            // specific use case where you need to validate a specific
	            // editable column posted when you have more than one 
	            // EditableColumn in the grid view. We evaluate here a 
	            // check to see if buy_amount was posted for the Book model
	            //if (isset($posted['assignment'])) {
	           		//$output =  Yii::$app->formatter->asDecimal($model->buy_amount, 2);
	            //} 
	 
	            // similarly you can check if the name attribute was posted as well
	            //if (isset($posted['assignment'])) {
	               //$output =  $posted['assignment']; // process as you need
	            //} 
	            $out = Json::encode(['output'=>$output, 'message'=>'']);
	        } 
	        // return ajax json encoded response and exit
	        echo $out;
	        return;
	    }
		
		$account_model = new MstAccount;
		$account_model = $this->setAccountDefaults($account_model);
			
		$addUserSuccess = false;
        if ($account_model->load(Yii::$app->request->post())) {
        	$account_model->password = md5($account_model->password);
			
			// convert to correct date format
			$account_model->start_date = Yii::$app->dateFormatter->convert($account_model->start_date);
			$account_model->end_date = Yii::$app->dateFormatter->convert($account_model->end_date);
			
			
			
			if ($account_model->save()) {
				$addUserSuccess = true;
				$account_model = new MstAccount;
				$account_model = $this->setAccountDefaults($account_model);
			}
        }
		
		return $this->render('user-mgmt', [
        	'account_search_model' 		=> $account_search_model,
        	'account_data_provider' 	=> $account_data_provider,
        	'trx_details_search_model'	=> $trx_details_search_model,
        	'trx_details_data_provider'	=> $trx_details_data_provider,
        	'trx_details_status_count'	=> $trx_details_status_count,
            'account_model' 			=> $account_model,
            'assignment_list' 			=> $assignment_list,
            'user_list'					=> $user_list,
            'addUserSuccess'			=> $addUserSuccess,
        ]);
    }

	public function setAccountDefaults($account_model) {
		$date = date('Y-m-d');
		$datetime = date('Y-m-d H:i:s'); // @TODO Use Yii dateformatter
		
		// set defaults
		$account_model->start_date		= $date;
		$account_model->end_date		= $date;
		
		// @TODO: transfer updating of status/created/updated details to model
		// set status, created and updated details
		$account_model->status			= Yii::$app->params['STATUS_ACTIVE'];
		$account_model->creator_id		= Yii::$app->user->id;
		$account_model->created_date 	= $datetime;
		$account_model->updater_id		= Yii::$app->user->id;
		$account_model->updated_date	= $datetime;
		
		return $account_model;
	}

    /**
     * Lists all MstAccount models.
     * @return mixed
     */
    public function actionUserAssignment()
    {
        $searchModel = new MstAccountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('user-assignment', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MstAccount model.
     * @param string $id
     * @return mixed
     */
    public function actionUserProfile($id)
    {
    	$accountModel = Yii::$app->modelFinder->findAccountModel($id);
    	$params = ['creator_id' => $id,'status' => [Yii::$app->params['STATUS_PROCESS'], Yii::$app->params['STATUS_CLOSED'], Yii::$app->params['STATUS_REJECTED']]];

		// get user transaction detail list
		$userTransactionDetailList = Yii::$app->modelFinder->getTransactionDetailList(null, null, null, $params, false, null);
		$userTrxDetailStatusCount = array_count_values(ArrayHelper::getColumn($userTransactionDetailList, 'status'));
		
        return $this->render('_user-profile', [
            'model' => $accountModel,
            'statusCount' => $userTrxDetailStatusCount,
        ]);
    }

    public function actionEditProfile($id)
    {
    	$accountModel = Yii::$app->modelFinder->findAccountModel($id);
    	$updateUser = false;

        return $this->render('_edit-profile', ['model' => $accountModel, 'success' => $updateUser]);
    }

    public function actionUpdateProfile(){
  
   		$prof_id = Yii::$app->request->post('id');
    	$account_model = new MstAccount;
	 	$updateUser = false;

        if ($account_model->load(Yii::$app->request->post())) {
			if ($account_model->updateByUser($prof_id,Yii::$app->request->post())) {
				$updateUser = true;
			}
        }

        return $this->render('_edit-profile', array('model' => $account_model, 'success' => $updateUser));
    }

    /**
     * Creates a new MstAccount model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateUser()
    {
        $model = new MstAccount();
		$date = date('Y-m-d H:i:s'); // @TODO Use Yii dateformatter
		
		// set defaults
		// @TODO: transfer updating of status/created/updated details to model
		// set status, created and updated details
		$model->status			= Yii::$app->params['STATUS_ACTIVE'];
		$model->creator_id		= Yii::$app->user->id;
		$model->created_date 	= $date;
		$model->updater_id		= Yii::$app->user->id;
		$model->updated_date	= $date;
		
		// get plant list
		$plant_location_list = Yii::$app->modelFinder->getPlantList(null, ['status' => Yii::$app->params['STATUS_ACTIVE']], 'plant_location');
		$assignment_list = ArrayHelper::map($plant_location_list, 'plant_location', 'plant_location');
		
        if ($model->load(Yii::$app->request->post())) {
        	$model->password = md5($model->password);
			
			// convert to correct date format
			$model->start_date = Yii::$app->dateFormatter->convert($model->start_date);
			$model->end_date = Yii::$app->dateFormatter->convert($model->end_date);

			if ($model->save()) {
				return $this->redirect(['view-user', 'id' => $model->id]);
			} else {
				return $this->render('create-user', [
	                'model' => $model,
	                'assignment_list' => $assignment_list,
	            ]);
			}
        } else {
            return $this->render('create-user', [
                'model' => $model,
                'assignment_list' => $assignment_list,
            ]);
        }
    }

    /**
     * Updates an existing MstAccount model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdateUser($id)
    {
        $model = Yii::$app->modelFinder->findAccountModel($id);
		$date = date('Y-m-d H:i:s'); // @TODO Use Yii dateformatter
		
		// set defaults
		// @TODO: transfer updating of updated details to model
		// set updated details
		$model->updater_id		= Yii::$app->user->id;
		$model->updated_date	= $date;
		
		// get plant list
		$plant_location_list = Yii::$app->modelFinder->getPlantList(null, ['status' => Yii::$app->params['STATUS_ACTIVE']], 'plant_location');
		$assignment_list = ArrayHelper::map($plant_location_list, 'plant_location', 'plant_location');
		
        if ($model->load(Yii::$app->request->post())) {
        	// convert to correct date format
			$model->start_date = Yii::$app->dateFormatter->convert($model->start_date);
			$model->end_date = Yii::$app->dateFormatter->convert($model->end_date);
			
			if ($model->save()) {
				return $this->redirect(['view-user', 'id' => $model->id]);
			} else {
				return $this->render('update-user', [
	                'model' => $model,
	                'assignment_list' => $assignment_list,
	            ]);
			}
        } else {
            return $this->render('update-user', [
                'model' => $model,
                'assignment_list' => $assignment_list,
            ]);
        }
    }

    /**
     * Deletes an existing MstAccount model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDeleteUser($id)
    {
        //Yii::$app->modelFinder->findAccountModel($id)->delete();
        $model = Yii::$app->modelFinder->findAccountModel($id);
		$model->status = Yii::$app->params['STATUS_DELETED'];
		$date = date('Y-m-d H:i:s'); // @TODO Use Yii dateformatter
		
		// set defaults
		// @TODO: transfer updating of updated details to model
		// set updated details
		$model->updater_id		= Yii::$app->user->id;
		$model->updated_date	= $date;
		
		if ($model->save()) {
			return $this->redirect(['user-management']);					
		}
    }

	public function actionGetAccountInfo($id)
	{
		$user_profile = $this->renderPartial('_user-profile', [
            'model' => Yii::$app->modelFinder->findAccountModel($id),
        ]);
		echo $user_profile;
	}

	public function actionGetMaterialInfo($id)
	{
		$user_profile = $this->renderPartial('_user-profile', [
            'model' => Yii::$app->modelFinder->findAccountModel($id),
        ]);
		echo $user_profile;
	}


	/**
     * Database syncronized
     * @return mixed
     */
    public function actionSynchronizedDatabase() {
		
    	return $this->render('synchronized-database');
    }
	
	public function actionSynchronizedMaterials() {
		if(null !== Yii::$app->request->post('back')) {
    		$this->redirect(['synchronized-database']);
    	} 
		else if(null !== Yii::$app->request->post('synch_all')){
			$customer_code = Yii::$app->request->post()['MstCustomer']['name'];
			$this->redirect('http://192.168.1.125/materials_customer/'.$customer_code.'/bigblue');
		}
		else {
			// Get customer list
			$customer_model = new MstCustomer();
			$customer_list = ArrayHelper::map(Yii::$app->modelFinder->getCustomerList(), 'code', 'name');
			return $this->render('synchronized-materials', [
				'customer_model' 	=> $customer_model,
				'customer_list'		=> $customer_list,
			]);
		}
    }


	public function actionGetMaterialBy($id)
	{
		$material_model_by = Yii::$app->modelFinder->getMaterialBy(null, ['like', 'item_code', $id]);			
		$material_model_list = Yii::$app->modelFinder->getMaterialConversionList(null, ['like', 'material_code', $id]);			
		$material_by = ArrayHelper::toArray($material_model_by);		
		$material_conv = ArrayHelper::toArray($material_model_list);		
		return $this->renderPartial('view_material_details', ['materal_list' => $material_by, 'material_conv' => $material_conv]);
	}

	public function actionGetMaterialList($id) {
		$material_list = Yii::$app->modelFinder->getMaterialList(null, ['like', 'item_code', $id]);			
		$material_list_result = ArrayHelper::toArray($material_list);	

		echo json_encode($material_list_result);
	}

    public function actionGetTransactionList($id) {
		$transactionlist = ArrayHelper::getColumn(Yii::$app->modelFinder->getTransactionList(null, ['customer_code' => $id]), 'id');
		echo json_encode($transactionlist);
	}

    public function actionPackagingMaterials() {
		return $this->render('packaging-materials');
    }
	
	public function actionExport() {
		$searchModel = null;
		$dataProvider = null;
		if (false !== strpos(Yii::$app->request->post('export_filename'), 'User List')) {
			$searchModel = new MstAccountSearch();
        	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			$gridColumns = [
	                ['class' => 'yii\grid\SerialColumn'],
	                'username',
	                [	
				    	'attribute' 		=> 'password',
				    	'value' 			=> function ($model) {
				    						if ($model->password === md5(Yii::$app->params["DEFAULT_PASSWORD"])) {
				    							return "DEFAULT";
				    						} else {
				    							return '********';
				    						}
				    					},
					],
		            // 'first_name',
		            // 'last_name',
		            ['attribute' => 'assignment',
		             'label'	 => 'Current Location'],
		            ['attribute' => 'start_date',
		             'label'	 => 'Current Start Date'],
		            ['attribute' => 'end_date',
		             'label'	 => 'Current End Date'],
		            ['attribute' => 'next_assignment',
		             'label'	 => 'Next Location'],
		            ['attribute' => 'next_start_date',
		             'label'	 => 'Next Start Date'],
		            ['attribute' => 'end_date',
		             'label'	 => 'Next End Date'],
	              ];
		}
		
		if (false !== strpos(Yii::$app->request->post('export_filename'), 'Transaction Details List')) {
			$params = ['status' => [Yii::$app->params['STATUS_PROCESS'], Yii::$app->params['STATUS_CLOSED'], Yii::$app->params['STATUS_REJECTED']]];
			$searchModel = new TrxTransactionDetailsSearch();
        	$dataProvider = $searchModel->search(Yii::$app->request->queryParams, $params);
			$gridColumns = [
	            ['class' => 'kartik\grid\SerialColumn'], // @TODO: Remove id column
	            // 'account_type',
	            // 'first_name',
	            // 'last_name',
	            ['attribute' => 'updater_id',
	             'label'	 => 'User Name',
	             'value'	 => function($model) {
	             				$account = Yii::$app->modelFinder->findAccountModel($model->updater_id);
								if ($account) {
									return $account->first_name . ' ' . $account->last_name;
								}
							},
	             ],
	            ['attribute' => 'updated_date',
	             'label'	 => 'Date'],
	            ['attribute' => 'transaction_id',
	             'label'	 => 'Transaction'],
	            ['attribute' => 'customer_code',
	             'label'	 => 'Customer',
	             'value'	 => function($model) {
								$customer = Yii::$app->modelFinder->findCustomerModel($model->customer_code);
								if ($customer) {
									return $customer->name;
								}
	             			},
	             ],
	            ['attribute' => 'pallet_no',
	             'label'	 => 'Pallet No'],
				['attribute' => 'status',
	             'label'	 => 'Status'],
	        ];
		}
		
		if (false !== strpos(Yii::$app->request->post('export_filename'), 'Transaction History')) {
			$params = ['status' => [Yii::$app->params['STATUS_PROCESS'], Yii::$app->params['STATUS_CLOSED']]];
			$searchModel = new TrxTransactionsSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams, $params);
		
			$gridColumns = [['attribute' 	=> 'created_date',
						 'label' 		=> 'DATE'],
						['attribute' 	=> 'id',
						 'label'		=> 'BRDS NO.'],
						['attribute'	=> 'sap_no',
						 'label'		=> 'SAP NO.'],
						['attribute'	=> 'customer_code',
						 'label'		=> 'CUSTOMER',
						 'value'	 	=> function($model) {
											$customer = Yii::$app->modelFinder->findCustomerModel($model->customer_code);
											if ($customer) {
												return $customer->name;
											}
				             			}],
						['attribute'	=> 'pallet_count',
						 'label'		=> 'NO. OF PALLET'],
						['attribute'	=> 'weight',
						 'label'		=> 'TOTAL WT.'],
						['attribute'	=> 'status',
						 'label'		=> 'STATUS']];
		}
		
		if ($searchModel && $dataProvider) {
			ExcelView::widget([
	            'dataProvider' => $dataProvider,
	            'filterModel' => $searchModel,
	            'fullExportType'=> 'csv', //can change to html,xls,xlsx and so on
	            'grid_mode' => 'export',
	            'columns' => $gridColumns,
	        ]);
		}
    }

	/**
     * Lists all TrxTransaction models.
     * @return mixed
     */
    public function actionViewTransaction() {	    	
		$params = ['status' => [Yii::$app->params['STATUS_PROCESS'], Yii::$app->params['STATUS_CLOSED']]];
		$trxSearchModel = new TrxTransactionsSearch();
		$trxDataProvider = $trxSearchModel->search(Yii::$app->request->queryParams, $params);

    	return $this->render('view-transaction', ['dataProvider' => $trxDataProvider,
    											  'searchModel' => $trxSearchModel,]);
    }
}
