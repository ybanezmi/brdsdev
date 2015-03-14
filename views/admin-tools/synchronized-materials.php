<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TrxTransactions */
/* @var $customer_list app\models\MstCustomer */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Synch Materials';
?>

<div id="main-content">
	<div class="create-receiving">
		<div class="wrapper-150">
			<h1 class="page-title">Synch Materials</h1>
			<div class="one-column help-bg-gray pdt-one-column" style="width:50%" >

       <?php 
    	$js = 'function beforeValidate(form) {if ( form.data("back") {this.validateOnSubmit = false;this.beforeValidate = "";form.submit();return false;}return true;}';
    	$form = ActiveForm::begin([
    	'fieldConfig' => [
    		'template' => '<div class="control-group">{label}<div class="f-full-size">{input}</div><div class=\"col-lg-8\">{error}</div></div>',
    	]
    ]); ?>
    
																		 
	<?= $form->field($customer_model, 'name')->dropDownList($customer_list, ['class'	=> 'uborder help-80percent',
			'prompt'	=> '-- Select a customer --',
			'onchange'	=> 'getTransactionList(getFieldValueById("mstcustomer-name"));
			 hideHTMLById("trx-details");'])->label('CUSTOMER PRODUCT', ['class' => 'control-label-f']); 
	?>

			
			
    	<div class="one-column-button pdt-one-column-button" style="wdith:100%;">
			<div class="submit-button ie6-submit-button">
				<button type="submit" class="btn btn-primary" style="width:35%;" name="synch_all">Sync All Materials</button>
				<button class="btn btn-primary" style="width:35%;">View Details</button>
				<button class="btn btn-primary" style="width:35%;">Material Only</button>
				<button type="submit" class="btn btn-primary back cancel-button" style="width:35%;" name="back">Back To Main</button>

        	</div>
        </div>


    <?php ActiveForm::end(); ?>
	
				
			</div>
		</div>
	</div>
</div>
