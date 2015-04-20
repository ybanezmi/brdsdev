<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\bootstrap\Alert;


/* @var $this yii\web\View */
/* @var $model app\models\TrxTransactions */
?>

<style type="text/css">
	#loading{
		position: fixed;
		z-index: 9999;
		left:40%;
		top:150px;
		text-align: center;
		visibility: hidden;
	}
	.process-loading{
		font-size:20px;
		margin-bottom: 20px;
		margin-top: 20px;
	}
</style>


<script type="text/javascript">
   function pageload(loc) {
   	document.getElementById("synchronize-menu").style.visibility = 'hidden';
   	document.getElementById("sync-bg").style.display = 'block';
    setTimeout(function(){
        document.getElementById("loading").style.visibility = 'visible';
      },500);
    location = loc;
   };
</script>


<div id="main-content">
	<div id="content-wrapper">	
		<div class="help-150"><h1 class="page-title page-title-bt">Synchronize</h1></div>

		<div id="loading">
			<div class="process-loading">Synchronize Database</div>
			<img src="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/images/loading.gif" />
			<div class="process-loading" style="font-size:18px;">Please wait...</div>
		</div>

		<ul class="list-sub-menu" id="synchronize-menu">
			<li><a href="javascript:;" onclick="if( confirm('Synchronize Customer Data. Do you want to continue?') ) pageload('/brdsapi/customer/bigblue');"> <span>Customers</span></a></li>


			<li><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/admin-tools/synchronized-materials" > <span>Materials</span></a></li>

			<li><a href="javascript:;" onclick="if( confirm('Synchronize Packaging Data. Do you want to continue?') ) pageload('/brdsapi/packaging/bigblue');"> <span>Packaging</span></a></li>

			<li><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/admin-tools/packaging-materials"> <span>Packaging Materials</span></a></li>

			<!-- <li><a href="javascript:;" onclick="if( confirm('Synchronize Packaging Data. Do you want to continue?') ) pageload('/brdsapi/packaging_materials/ZCUS/bigblue');"> <span>Packaging Materials</span></a></li>  -->
			
			<li><a href="javascript:;" onclick="if( confirm('Synchronize plant location Data. Do you want to continue?') ) pageload('/brdsapi/plant_location/plant/bigblue');"> <span>Plant Locations</span></a></li>

			<li><a href="javascript:;" onclick="if( confirm('Synchronize storage location Data. Do you want to continue?') ) pageload('/brdsapi/plant_location/storage/bigblue');"> <span>Storage Locations</span></a></li>

		</ul>
	</div>
</div>