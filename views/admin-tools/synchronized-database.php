<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\bootstrap\Alert;


/* @var $this yii\web\View */
/* @var $model app\models\TrxTransactions */
?>

<style type="text/css">
	#sync-progress{
		position: fixed;
		z-index: 9999;
		left:40%;
		top:150px;
		text-align: center;
		display: none;
	}
	.process-loading{
		font-size:20px;
		margin-bottom: 20px;
		margin-top: 20px;
	}
	#sync-status{
		padding-left: 0px;
 		padding-top: 10px;
	}
</style>


<div id="main-content">
	<div id="content-wrapper">	
		<div class="help-150"><h1 class="page-title page-title-bt">Synchronize</h1></div>

		<div id="sync-status" class="help-150"></div>
		<div id="sync-progress">
			<div class="process-loading">Synchronize Database</div>
			<img src="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/images/loading.gif" />
			<div class="process-loading" style="font-size:18px;">Please wait...</div>
		</div>

		<ul class="list-sub-menu" id="synchronize-menu">
			<li><a href="javascript:;" onclick="if( confirm('Synchronize Customer Data. Do you want to continue?') ) syncCustomer();"> <span>Customers</span></a></li>


			<li><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/admin-tools/synchronized-materials" > <span>Materials</span></a></li>

			<li><a href="javascript:;" onclick="if( confirm('Synchronize Packaging Data. Do you want to continue?') ) syncPackaging(); "> <span>Packaging</span></a></li>

			<li><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/admin-tools/packaging-materials"> <span>Packaging Materials</span></a></li>

			<!-- <li><a href="javascript:;" onclick="if( confirm('Synchronize Packaging Data. Do you want to continue?') ) pageload('/brdsapi/packaging_materials/ZCUS/bigblue');"> <span>Packaging Materials</span></a></li>  -->
			
			<li><a href="javascript:;" onclick="if( confirm('Synchronize plant location Data. Do you want to continue?') ) syncplantlocation();"> <span>Plant Locations</span></a></li>

			<li><a href="javascript:;" onclick="if( confirm('Synchronize storage location Data. Do you want to continue?') ) syncstoragelocation();"> <span>Storage Locations</span></a></li>

		</ul>
	</div>
</div>


<script type="text/javascript">

function syncCustomer() {
	var url = brdsapi_site_url+"/brdsapi/customer/bigblue";
	var method = 'GET';
	var params = '';
	var container_id = 'sync-status' ;
	var loading_text = 'processing...' ;
	if(url == ''){
		alert('Please select customer')
	}else{
		ajax (url, method, params, container_id, loading_text) ;
	}
}

function syncPackaging() {
	var url = brdsapi_site_url+"/brdsapi/packaging/bigblue";
	var method = 'GET';
	var params = '';
	var container_id = 'sync-status' ;
	var loading_text = 'processing...' ;
	if(url == ''){
		alert('Please select packaging')
	}else{
		ajax (url, method, params, container_id, loading_text) ;
	}
}

function syncplantlocation() {
	var url = brdsapi_site_url+"/brdsapi/plant_location/plant/bigblue";
	var method = 'GET';
	var params = '';
	var container_id = 'sync-status' ;
	var loading_text = 'processing...' ;
	if(url == ''){
		alert('Please select plant location')
	}else{
		ajax (url, method, params, container_id, loading_text) ;
	}
}

function syncstoragelocation() {
	var url = brdsapi_site_url+"/brdsapi/plant_location/storage/bigblue";
	var method = 'GET';
	var params = '';
	var container_id = 'sync-status' ;
	var loading_text = 'processing...' ;
	if(url == ''){
		alert('Please select storage location')
	}else{
		ajax (url, method, params, container_id, loading_text) ;
	}
}


</script>