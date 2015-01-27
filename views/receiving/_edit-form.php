<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TrxTransactions */
/* @var $customer_list app\models\MstCustomer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="edit-receiving-form">
    <?php 
    	$js = 'function beforeValidate(form) {if ( form.data("cancel") {this.validateOnSubmit = false;this.beforeValidate = "";form.submit();return false;}return true;}';
    	$form = ActiveForm::begin([
    	'options' => ['class' => 'form-horizontal'],
    	'fieldConfig' => [
    		'template' => '<div class="control-group">{label}<div class="f-inline-size">{input}</div></div>',
    	],
    ]); ?>
    
	<?= $form->field($customer_model, 'name')->dropDownList($customer_list, ['class'	=> 'uborder help-70percent',
																 			 'prompt'	=> '-- Select a customer --',
																 			 'onchange'	=> 'getTransactionList(getFieldValueById("mstcustomer-name"))'])->label('SELECT CUSTOMER'); ?>
	
	<?= $form->field($transaction_model, 'transaction_id', 
						['template' 	=> '<div class="control-group">{label}<div>{input}
											<button type="submit" class="btn btn-primary help-20percent" 
											name="btn-transaction-summary" style="margin-bottom:10px;">Summary</button>
											</div></div>'])->dropDownList($transaction_list, ['class'	=> 'uborder help-50percent',
																							  'prompt'	=> '-- Select a transaction --'])->label('SELECT TRANSACTION'); ?>

	<?= $form->field($transaction_model, 'pallet_no',
				['template' => '<div class="control-group">{label}<div>{input} 
								<button type="submit" class="btn btn-primary help-20percent" name="btn-pallet-details" 
								style="margin-bottom:10px;">Details</button> </div></div>'				
				])->textInput(['class'	 => 'uborder help-50percent'])->label('SCAN A PALLET NUMBER') ?>

    <div class="form-group">
    	<div class="one-column-button">
			<div class="submit-button ie6-submit-button">
        		<?= Html::submitButton('Edit Receiving', ['class' => 'btn btn-primary',
        												  'name'  => 'edit-receiving']) ?>
        		<?= Html::submitButton('Cancel', ['class' => 'btn btn-primary cancel-button',
        										  'name'  => 'cancel']) ?>
        	</div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
