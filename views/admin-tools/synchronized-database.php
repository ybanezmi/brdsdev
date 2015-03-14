<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\bootstrap\Alert;


/* @var $this yii\web\View */
/* @var $model app\models\TrxTransactions */
?>

<div id="main-content">
	<div id="content-wrapper">	
		<div class="help-150"><h1 class="page-title page-title-bt">Synchronize</h1></div>
		<ul class="list-sub-menu">
			<li><a href="http://192.168.1.125/customer/bigblue"> <span>Customers</span></a></li>
			<li><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/admin-tools/synchronized-materials"> <span>Materials</span></a></li>
			<li><a href="http://192.168.1.125/packaging/bigblue"> <span>Packaging Materials</span></a></li>
			<li><a href="http://192.168.1.125/plant_location/bigblue"> <span>Plant Locations</span></a></li>
			<li><a href="http://192.168.1.125/plant_location/bigblue"> <span>Storage Locations</span></a></li>
		</ul>
	</div>
</div>