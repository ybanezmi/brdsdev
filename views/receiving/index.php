<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Receiving';
?>
<div id="main-content">
	<div id="content-wrapper">
		<?php
			if ($isAccessReceiving) {
				Alert::begin([
				    'options' => [
				        'class' => 'alert-error',
				    ],
				]);
				
				echo 'Pallet # is still being used by other account.';
				
				Alert::end();
			}
			
			if ($isPalletOpened) {
				Alert::begin([
				    'options' => [
				        'class' => 'alert-success',
				    ],
				]);
				
				echo 'Pallet #' . Yii::$app->request->post("open_pallet_no") . ' successfully opened.';
				
				Alert::end();
			}
			
			if ($isPalletClosed) {
				Alert::begin([
				    'options' => [
				        'class' => 'alert-success',
				    ],
				]);
				
				echo 'Pallet #' . Yii::$app->request->post("close_pallet_no") . ' successfully closed.';
				
				Alert::end();
			}
			
			if ($isPalletRejected) {
				Alert::begin([
				    'options' => [
				        'class' => 'alert-success',
				    ],
				]);
				
				echo 'Pallet #' . Yii::$app->request->post("reject_pallet_no") . ' successfully rejected.';
				
				Alert::end();
			}
		?>		
		<div class="help-150"><h1 class="page-title page-title-bt">Receiving</h1></div>
		<ul class="list-sub-menu">
			<li><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/receiving/create"> <span>Create Receiving</span></a></li>
			<li><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/receiving/edit"> <span>Edit Receiving</span></a></li>
			<li><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/receiving/view-pallet"> <span>View Pallet</span></a></li>
			<?php if (Yii::$app->user->identity->account_type === 'checker') { ?>
				<li><a href="#openpallet" data-toggle="modal"> <span>Open Pallet</span></a></li>
			<?php } ?>
			<li><a href="#closepallet" data-toggle="modal"> <span>Close Pallet</span></a></li>
			<?php if (Yii::$app->user->identity->account_type === 'checker') { ?>
				<li><a href="#rejectpallet" data-toggle="modal"> <span>Reject Pallet</span></a></li>
			<?php } ?>
			<li><a href="#createto" data-toggle="modal"> <span>Create TO</span></a></li>
			<li><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/receiving/close"> <span>Close Receiving</span></a></li>
			<li><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/receiving/synchronized-database"> <span>Synchronize</span></a></li>
			<li><a href="#"> <span>Print R. Records</span></a></li>
		</ul>
	</div>
</div>
