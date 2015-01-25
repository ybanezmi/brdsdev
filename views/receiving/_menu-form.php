<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $transaction_model app\models\TrxTransactions */
/* @var $handling_unit_model app\models\TrxHandlingUnit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="receiving_menu-form">
    <?php 
    	$js = 'function beforeValidate(form) {if ( form.data("cancel") {this.validateOnSubmit = false;this.beforeValidate = "";form.submit();return false;}return true;}';
    	$form = ActiveForm::begin([
	    	'options' => ['class' => 'form-horizontal'],
	    	'fieldConfig' => [
	    		'template' => '<div class="control-group">{label}<div class="f-inline-size">{input}</div></div>',
	    	]
   		]); ?>

    <div class="col-1 help-bg-gray">
		<h2 class="legend">Transaction Header</h2>
		
		<?= $form->field($customer_model, 'name',
						['inputOptions' => ['class' => 'text-view'],
						 'options'   	=> ['style' => 'margin-bottom: 0']])->textInput(['disabled' => 'disabled'])->label(false) ?>
		<?= $form->field($customer_model, 'code',
						['inputOptions' => ['class' => 'text-view'],
						 'options'   	=> ['style' => 'margin-bottom: 0']])->textInput(['disabled' => 'disabled'])->label(false) ?>
		
		<?= $form->field($transaction_model, 'created_date')->textInput(['value'	=> date('m/d/Y', strtotime($transaction_model->created_date)),
															 			 'disabled' => 'disabled',
															 			 'class' 	=> 'uborder disabled help-20percent'])->label('DATE') ?>
		
		<?= $form->field($transaction_model, 'id')->textInput(['disabled' => 'disabled',
												   			   'class'	  => 'uborder disabled help-40percent'])->label('BRDS ID #') ?>
		
		<?= $form->field($transaction_model, 'sap_no')->textInput(['disabled' => 'disabled',
												   	   			   'class'	  => 'uborder disabled help-40percent'])->label('SAP #') ?>

		<?= $form->field($transaction_model, 'plant_location')->textInput(['disabled' => 'disabled',
												   		  				   'class'	  => 'uborder disabled help-20percent'])->label('WAREHOUSE') ?>
												   		  
		<?= $form->field($transaction_model, 'storage_location')->textInput(['disabled' => 'disabled',
												   		  					 'class'	  => 'uborder disabled help-40percent'])->label('S. LOC') ?>

		<?= $form->field($transaction_model, 'truck_van', 
				['inputOptions' => ['class' 	=> 'uborder disabled help-20percent',
									'disabled' 	=> 'disabled'],
                 
				 'template' 	=> '<div class="control-group">{label}<div class="f-inline-size">{input}
				 					<button class="btn btn-primary help-20percent" type="button" onclick="alert(\''.$transaction_model->remarks.'\')">Remarks</button></div></div>'	
				 /*'template' 	=> '<div class="control-group">{label}<div class="f-inline-size">{input}
				 					<button class="btn btn-primary help-20percent" type="button" data-toggle="modal" data-target="#remarks">Remarks</button></div></div>'	*/			
				])
				->textInput(['maxlength' => 10])->label('T.PLATE #') ?>

		<?php
		    Modal::begin([
			    'header' 		=> '<h2>Remarks</h2>',
			    'id'	 		=> 'remarks',
			    'closeButton'	=> ['tag' 	=> 'button',
			    					'label' => '×'],
			]);
			
			echo $transaction_model->remarks;
			
			Modal::end();
		?>

		<?= $form->field($transaction_model, 'pallet_count',
				['inputOptions' => ['class' 	=> 'disabled uborder help-20percent',
									'disabled' 	=> 'disabled',
									'value'		=> $pallet_count],
				 'template' 	=> '<div class="control-group">{label}<div class="f-inline-size">{input} PP
				 					<button type="submit" class="btn btn-primary help-20percent" name="view-entries">View</button></div></div>'
				])->textInput(['maxlength' => 10])->label('# Pallet(s)') ?>

		<?= $form->field($transaction_model, 'weight',
				['inputOptions' => ['class' => 'disabled uborder help-20percent'],
				 'template' => '<div class="control-group">{label}<div class="f-inline-size" >{input} KG</div></div>'				
				])->textInput(['maxlength' => 10,
							   'disabled'  => 'disabled',
							   'value'	   => $total_weight])->label('Total WT') ?>
							   
	</div>

	<div id="trx-details-panel" class="col-2 help-bg-gray" style="display: block;">
		<h2 class="legend">Transaction Details</h2>

		<?= $form->field($transaction_detail_model, 'material_code')->dropDownList($material_list, ['class'	=> 'uborder help-70percent',
																							 		'prompt'	=> '-- Select a product --',
																							 		'onchange'	=> 'setFieldValueById("material_code", getFieldValueById("trxtransactiondetails-material_code"));
																							 						setFieldValueById("trxtransactiondetails-pallet_type", material_pallet_ind[getFieldValueById("trxtransactiondetails-material_code")]);
																							 						setInnerHTMLById("net-weight-unit", getMaterialConversionUnit());
																							 						setInnerHTMLById("kitted-unit", getMaterialConversionUnit());
																							 						checkMaterialSled();'])->label('Customer Product'); ?>

		<?= Html::textInput('material_code', '', ['id'		 => 'material_code',
												  'readonly' => 'readonly',
												  'class'	 => 'uborder disabled help-44percent',
												  'onchange' => 'setFieldValueById("trxtransactiondetails-material_code", getFieldValueById("material_code"))']) ?>

		<?= Html::textInput('material_barcode', '', ['id'		 => 'material_barcode',
						 					  	  	 'class'	 => 'uborder help-44percent',
						 					  	  	 'onchange'  => 'setFieldValueById("trxtransactiondetails-material_code", searchMaterial())']) ?>
												  
		<?= $form->field($transaction_detail_model, 'batch',
						['inputOptions' => ['class' => 'uborder help-20percent'],
						 'template' => '<div class="control-group">{label}<div class="f-inline-size">{input} 
						 				<button class="btn btn-primary help-15percent" onclick="setFieldValueById(&quot;trxtransactiondetails-batch&quot;,getTimestamp());" type="button">INT</button></div></div>'				
						])->input('number', ['maxlength' => 10])->label('Batch / Lot') ?>

		<?= $form->field($transaction_detail_model,'manufacturing_date')->widget(DatePicker::className(),['clientOptions' 	 => ['dateFormat' 	=> 'm/dd/yy',
																										   						 'showOn'		=> 'button',
																																 'buttonImage'  => '../images/calendar.gif',
																																 'buttonImageOnly' => 'true'],
																										   'options' 		 => ['class' 		=> 'uborder disabled help-20percent dateclass',
																										   						 'readonly'		=> 'readonly',
																										   						 'dateFormat' 	=> 'm/dd/yy',
																										   						 'onchange'		=> 'checkMaterialSled()']])->label('Manuf Date') ?>

		<?= $form->field($transaction_detail_model,'expiry_date')->widget(DatePicker::className(),['clientOptions' 	 => ['dateFormat' 		=> 'm/dd/yy',
																								   						 'showOn'			=> 'button',
																														 'buttonImage'  	=> '../images/calendar.gif',
																														 'buttonImageOnly' 	=> 'true'],
																								'options' 			 => ['class' 			=> 'uborder disabled help-20percent dateclass',
																								   						 'readonly'			=> 'readonly',
																								   						 'dateFormat' 		=> 'm/dd/yy']])->label('Expiry Date') ?>
																								   						 
		<?= $form->field($transaction_detail_model, 'pallet_type')->textInput([
																		'value'	   => '',
																		'readonly' => 'readonly',
												  						'class'	   => 'uborder disabled help-20percent',
												  						'onchange' => 'validateTransactionPalletType();'])->label('Pallet Type') //@TODO: fix onchange executes multiple times ?>

		<?= $form->field($transaction_detail_model, 'net_weight',
				['inputOptions' => ['class' => 'uborder help-20percent',
									'onchange' => 'setFieldValueById("trxtransactiondetails-total_weight", getMaterialTotalWeight());
												   setFieldValueById("trxtransactiondetails-pallet_weight", parseInt(getMaterialTotalWeight()) + parseInt(getTransactionPalletWeight()))'],
				 'template' => '<div class="control-group">{label}<div class="f-inline-size">{input} <span id="net-weight-unit">KG</span> </div></div> '				
				])->input('number', ['maxlength' => 10])->label('Net WT / Quantity') ?>
							   
		<?= $form->field($transaction_detail_model, 'total_weight',
				['inputOptions' => ['class' => 'uborder disabled help-20percent totalweight',
									'readonly' => 'readonly'],
				 'template' => '<div class="control-group">{label}<div class="f-inline-size">{input} KG</div></div>'				
				])->textInput(['maxlength' => 10])->label('Total WT') ?>
							   
		<?= $form->field($transaction_detail_model, 'pallet_no',
				['inputOptions' => ['class' => 'uborder help-20percent',
									'value' => $pallet_no,
									'onchange' => 'validateTransactionPallet();
												   checkTransactionKittedUnit();
												   checkTransactionPalletWeight();
												   checkTransactionPalletType();
												   validateTransactionPalletType();
												   '],
				 'template' => '<div class="control-group">{label}<div class="f-inline-size">{input} 
				 					<input type="text" id="material-pallet_type" class="uborder disabled help-20percent" value="" disabled="disabled">
				 				</div></div> '
				])->textInput(['maxlength' => 10])->label('Pallet #') ?>
							   
		<?= $form->field($transaction_detail_model, 'kitted_unit',
				['inputOptions' => ['class' => 'uborder help-20percent',
									'value' => 0,],
				 'template' => '<div class="control-group">{label}<div class="f-inline-size">{input} <span id="kitted-unit">KG</span> </div></div>'				
				])->textInput(['maxlength' => 10])->label('Kitted Unit') ?>
							   
		<?= $form->field($transaction_detail_model, 'pallet_weight',
				['inputOptions' => ['class' => 'uborder disabled help-20percent',
									'readonly' => 'readonly',
									'value' => 0],
				 'template' => '<div class="control-group">{label}<div class="f-inline-size">{input} KG </div></div>'				
				])->textInput(['maxlength' => 10])->label('Pallet WT') ?>

	</div>
	
	<div id="close-pallet-panel" class="col-2 help-bg-gray" style="display: none;">
		<h2 class="legend">Close Pallet</h2>
		
		<div class="control-group">
			<label class="control-label" for="trxtransactiondetails-kitted_unit">Enter Pallet #:</label>
			<div class="f-inline-size">
				<?= Html::textInput('close_pallet_no', '', ['id'		 => 'close-pallet-no',
								 					  	  	'class'	 	 => 'uborder help-40percent']) ?>
			</div>
		</div>
				
		<?= Html::submitButton('Use Pallet', ['class' 	=> 'btn',
        									  'name'	=> 'close-pallet']) ?>
		<?= Html::button('Cancel', ['class' 	=> 'btn',
								    'onclick' 	=> 'hideHTMLById("close-pallet-panel");
									      			showHTMLById("trx-details-panel");']) ?>
	</div>

	<div class="two-column-button">
		<div class="submit-button ie6-submit-button">
			<?= Html::submitButton('Add to Pallet', ['class' 	=> 'btn btn-primary',
        										  	 'name'		=> 'add-pallet']) ?>
			<?= Html::button('Close Pallet', ['class' 	=> 'btn btn-primary',
											  'onclick' => 'hideHTMLById("trx-details-panel");
											  				showHTMLById("close-pallet-panel");']) ?>
		</div>
		<div class="submit-button ie6-submit-button">
			<?= Html::submitButton('View Entries', ['class' 	=> 'btn btn-primary',
        										  	 'name'		=> 'view-entries',
        										  	 'onclick'	=> 'js: window.location = "view-entries?id='.$transaction_model->id.'"']) ?>
			<?= Html::submitButton('Cancel', ['class' 			=> 'btn btn-primary',
        								  	  'name'  			=> 'cancel',
        								  	  'onclick'			=> 'js: window.location = "index"']) ?>
		</div>
	</div>

    <?php ActiveForm::end(); ?>
    
</div>

<script>
var net_weight = document.getElementById("trxtransactiondetails-net_weight");
var pallet_no = document.getElementById("trxtransactiondetails-pallet_no");
net_weight.addEventListener("blur", catchWeight, true);
pallet_no.addEventListener("blur", catchWeight, true);

function catchWeight() {
    if (parseInt(getFieldValueById("trxtransactiondetails-pallet_weight")) > 1000 ) {
        alert('The weight exceeds the maximum allowed.');
        setFieldValueById("trxtransactiondetails-net_weight", 0);
    }
}

</script>
