<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'TRANSACTION HISTORY';

?>

<style type="text/css">
	.kv-panel-before .pull-right{
		float: none!important;
	}
</style>
<div>
<div style="width:95%; margin:0 auto;">
	<h1 class="page-title"><?= Html::encode($this->title) ?></h1>
	
	<?php
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
						 'label'		=> 'NO. OF PALLET',
						 'value'		=> function($model) {
						 						$params = ['transaction_id' => $model->id, 'status' => Yii::$app->params['STATUS_PROCESS']];
						 						$trxDetailsModel = Yii::$app->modelFinder->getTransactionDetailList(null, null, null, $params, false, null);
												return count($trxDetailsModel);
						 }],
						['attribute'	=> 'weight',
						 'label'		=> 'TOTAL WT.'],
						['attribute'	=> 'status',
						 'label'		=> 'STATUS']];
	?>
	
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'responsive' => true,
        // set your toolbar
	    'toolbar' =>  [
	        '{export}',
	    ],
        'exportConfig' => [
            \kartik\grid\GridView::CSV => ['label' => 'Export CSV',
            							   'filename' => '[BRDS] Transaction History'],
        ],
		'panel' => [
		        'type' => GridView::TYPE_PRIMARY,
		        'heading' => 'TRANSACTION HISTORY',
		    ],
    ]);
	
	?>
	</div>
</div>
