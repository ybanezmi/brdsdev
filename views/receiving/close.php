<?php
/* @var $this yii\web\View */
use yii\bootstrap\Alert;

$this->title = 'Close Receiving';
?>
<div id="main-content">
	<div class="edit-receiving">
		<div class="wrapper-150">
			<h1 class="page-title">Close Receiving</h1>
			<?php
				if ($success) {
					Alert::begin([
					    'options' => [
					        'class' => 'alert-success',
					    ],
					]);
					
					echo 'Transaction #' . Yii::$app->request->post('transaction_id') . ' successfully closed.';
					
					Alert::end();
				}
			?>			
			<div class="one-column help-bg-gray pdt-one-column" >
			    <?= $this->render('_close-form', [
			    	'customer_model'	=> $customer_model,
			        'customer_list'     => $customer_list,
			        'transaction_model' => $transaction_model,
                    'transaction_list'	=> $transaction_list,
			    ]) ?>
			</div>
		</div>
	</div>
</div>