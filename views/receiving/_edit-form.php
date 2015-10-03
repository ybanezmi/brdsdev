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
    		'template' => '<div class="control-group">{label}<div class="f-full-size">{input}</div><div class=\"col-lg-8\">{error}</div></div>',
    	],
    ]); ?>

	<?= $form->field($customer_model, 'name')->dropDownList($customer_list, ['class'	=> 'uborder help-70percent',
																 			 'prompt'	=> '-- Select a customer --',
																 			 'onchange'	=> 'getTransactionList(getFieldValueById("mstcustomer-name"))'])->label('SELECT CUSTOMER', ['class' => 'control-label-f']); ?>

	<?= $form->field($transaction_model, 'transaction_id',
						['template' 	=> '<div class="control-group">{label}<div>{input}
											<button class="btn btn-primary help-20percent" onclick="js: viewTransactionSummary(getFieldValueById(\'trxtransactiondetails-transaction_id\')); return false;"
											name="btn-transaction-summary">Summary</button>
											</div><div class=\"col-lg-8\">{error}</div></div>'])->dropDownList($transaction_list, ['class'	=> 'uborder help-50percent',
																							  'prompt'	=> '-- Select a transaction --'])->label('SELECT TRANSACTION', ['class' => 'control-label-f']); ?>

	<?= $form->field($transaction_model, 'pallet_no',
				['template' => '<div class="control-group">{label}<div>{input}
								<button class="btn btn-primary help-20percent"
								onclick="js: viewPalletDetails(getFieldValueById(\'trxtransactiondetails-transaction_id\'), getFieldValueById(\'trxtransactiondetails-pallet_no\')); return false;"
								name="btn-pallet-details">
								Details</button> </div><div class=\"col-lg-8\">{error}</div></div>'
				])->textInput(['class'	 => 'uborder help-50percent',
				               'maxlength' => 10,
				               'onchange' => 'getPalletDetailsForEdit(this.value);'])->label('SCAN A PALLET NUMBER', ['class' => 'control-label-f']) ?>

			<div class="one-column-button pdt-one-column-button">
				<div class="submit-button ie6-submit-button">
					<?= Html::submitButton('Edit Receiving', ['class' => 'btn btn-primary',
        												  'name'  => 'edit-receiving']) ?>
        		<?= Html::submitButton('Cancel', ['class' => 'btn btn-primary cancel-button',
        										  'name'  => 'cancel']) ?>
				</div>
				</div>

    <?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">
    window.onload=function() {
        if (getFieldValueById('trxtransactiondetails-pallet_no')) {
            getPalletDetailsForEdit(getFieldValueById('trxtransactiondetails-pallet_no'));
        }
    }
</script>
