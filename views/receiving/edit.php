<?php
/* @var $this yii\web\View */

$this->title = 'Edit Receiving';
?>
<div id="main-content">
	<div class="edit-receiving">
		<div class="wrapper-150">
			<h1 class="page-title">Edit Receiving</h1>
			<div class="one-column help-bg-gray pdt-one-column" >
			    <?= $this->render('_edit-form', [
			    	'customer_model'	=> $customer_model,
			        'customer_list'     => $customer_list,
			        'transaction_model' => $transaction_model,
                    'transaction_list'	=> $transaction_list,
			    ]) ?>
			</div>
		</div>
	</div>
</div>