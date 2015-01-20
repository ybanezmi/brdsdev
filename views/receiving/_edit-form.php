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
    	'fieldConfig' => [
    		'template' => '<div class="control-group">{label}<div class="f-inline-size">{input}</div></div>',
    	]
    ]); ?>

<div class="control-group">
	<label class="control-label-f">SELECT CUSTOMER</label>
	<div class="f-full-size">
        <?= Html::dropDownList
            ('customer_list', null, $customer_list, 
                               ['id'        => 'customer-name',
                                'class'	    => 'uborder help-70percent',
								'label'	    => 'Customer Product',
								'prompt'	=> '-- Select a customer --',
								'onchange'	=> 'getTransactionList(getFieldValueById("customer-name"))']);
        ?>
	</div>
</div>


	
<div class="control-group">
    <label class="control-label-f">SELECT TRANSACTION</label>
    
        <?= Html::dropDownList('transaction_list', null, $transaction_list, 
                           ['id'        => 'transaction-list',
                            'class'	    => 'uborder help-50percent',
						    'label'     => 'Customer Product',
							'prompt'	=> '-- Select a transaction --',
                            'onchange'  => 'setFieldValueById("transaction-list", getFieldValueById("transaction-list"))']);
        ?>
       <?= Html::submitButton('Summary', 
                               ['class' => 'btn btn-primary help-20percent',
                                'style' => 'margin-bottom:10px;',
        						'name'  => 'btn-transaction-summary']) 
       ?>     
    
</div>    

<div class="control-group">
    <label class="control-label-f">SCAN A PALLET NUMBER</label>
    
        <?= Html::textInput('pallet_no', '', 
                            ['id'		 => 'pallet-number',
						 	 'class'	 => 'uborder help-50percent',
                             'onchange'  =>'setFieldValueById("trxtransactiondetails-pallet_no", getFieldValueById("pallet-number"))']) 
        ?>
        
        <?= Html::submitButton('Details', 
                               ['class' => 'btn btn-primary help-20percent',
                                'style' => 'margin-bottom:10px;',
        						'name'  => 'btn-pallet-details']) 
        ?>
    
</div>    
    

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
