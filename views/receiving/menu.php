<?php

use yii\helpers\Html;
use yii\bootstrap\Alert;


/* @var $this yii\web\View */
/* @var $model app\models\TrxTransactions */

$this->title = 'Receiving Menu';

echo $scripts;
?>

<div id="main-content">
	<div class="receiving-menu">
		<div class="wrapper-150">
			<?php
				if ($isPalletAdded || isset($_GET['isPalletAdded'])) {
					Alert::begin([
					    'options' => [
					        'class' => 'alert-success',
					    ],
					]);
					$pallet = (isset($_GET['pallet'])) ? $_GET['pallet'] : $pallet_no;
					echo 'Successfully added transaction to pallet #' . $pallet;
					
					Alert::end();
				}
				
				if ($isPalletClosed) {
					Alert::begin([
					    'options' => [
					        'class' => 'alert-error',
					    ],
					]);
					
					echo 'Failed to add closed pallet #' . $pallet_no;
					
					Alert::end();
				}
				
				if ($isPalletRejected) {
					Alert::begin([
					    'options' => [
					        'class' => 'alert-error',
					    ],
					]);
					
					echo 'Failed to add rejected pallet #' . $pallet_no;
					
					Alert::end();
				}
			?>
			<h1 class="page-title">Receiving Menu</h1>
			<div class="two-column pdt-two-column" >
			    <?= $this->render('_menu-form', [
	                'transaction_model' 		=> $transaction_model,
	                'customer_model'			=> $customer_model,
	                'material_list'				=> $material_list,
	                'packaging_list'			=> $packaging_list,
                    'material_conversion_model' => $material_conversion_model,
	                'transaction_detail_model'	=> $transaction_detail_model,
	                'transaction_details'		=> $transaction_details,
	                'handling_unit_model' 		=> $handling_unit_model,
	                'total_weight'				=> $total_weight,
	                'pallet_count'				=> $pallet_count,
	                'pallet_no'					=> $pallet_no,
	            ]) ?>
			</div>
		</div>
	</div>
</div>
