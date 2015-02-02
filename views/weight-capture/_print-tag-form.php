<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use yii\jui\DatePicker;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\MstAccount */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="print-tag-form">

    <?php 
    	$js = 'function beforeValidate(form) {if ( form.data("cancel") {this.validateOnSubmit = false;this.beforeValidate = "";form.submit();return false;}return true;}';
    	$form = ActiveForm::begin([
    	'fieldConfig' => [
    		'template' => '<div class="control-group">{label}<div class="f-inline-size">{input}</div><div class=\"col-lg-8\">{error}</div></div>',
    	]]); 
    ?>

	<table class="f-full-size">
		<tbody>
			<tr class="control-group">
				<td style="width: 25%;">
					<label class="control-label-f">CUSTOMER: </label>
				</td>
				<td >
					<?= Html::dropDownList
			            ('customer', null, $customer_list, 
			                               ['id'        => 'customer',
			                                'class'	    => 'uborder help-70percent',
											'label'	    => 'Customer',
											'prompt'	=> '-- Select a customer --',
											'onchange'	=> 'getMaterialList(getFieldValueById("customer"))']);
			        ?>
				</td>
			</tr>
			<tr class="control-group">
				<td style="width: 25%;">
					<label class="control-label-f">MATERIAL: </label>
				</td>
				<td >
					<?= Html::dropDownList
			            ('material', null, [], 
			                               ['id'        => 'material',
			                                'class'	    => 'uborder help-70percent',
											'label'	    => 'Material',
											'prompt'	=> '-- Select a material --',
											'onchange'	=> 'setFieldValueById("material_code", getFieldValueById("material"));
															var e = document.getElementById("material");
															if ("" != e.value) setFieldValueById("material_description", e.options[e.selectedIndex].text);
															else setFieldValueById("material_description", "");',]);
											
			        ?>
				</td>
			</tr>
			<tr class="control-group">
				<td style="width: 25%;">
					<label class="control-label-f">MATERIAL CODE: </label>
				</td>
				<td >
					<?= Html::textInput('material_code', null, ['id'		=> 'material_code',
											  				    'class'	 	=> 'uborder help-44percent',
											  				    'onchange' 	=> 'setFieldValueById("material", getFieldValueById("material_code"))',]) ?>
					<?= Html::input('hidden', 'material_description', '', ['id' => 'material_description']) ?>
				</td>
			</tr>
		</tbody>
	</table>
	
	<h3 class="page-title-bt">
		GROSS Weight: &nbsp;&nbsp;
		<?= Html::input('number', 'gross_weight', '', [   'id'		 => 'gross_weight',
													  	  'class'	 => 'uborder help-32percent',
													  	  'style'	 => 'height: 50px; text-align: right;',
													  	  'onchange' => 'calculateNetWeight()']) ?> 
		kg
	</h3>
	
	<div class="tare-weights">
		<h4 class="page-title-bt" style="padding: 10px;">TARE Weights: </h4>
		<table class="f-full-size" style="margin: 10px;">
			<tbody>
				<tr class="control-group">
					<td style="width: 32%;">
						<label class="control-label-f">PALLET TARE: </label>
					</td>
					<td >
						<?= Html::input('number', 'pallet_tare', '', [	'id'		=> 'pallet_tare',
															  		  	'class'	 	=> 'uborder help-44percent',
															  		  	'style'		=> 'text-align: right;',
															  		  	'onchage'	=> 'calculateNetWeight()',]) ?> <span style="font-weight: bold;" class="page-title-bt">kg</span>
					</td>
				</tr>
				<tr class="control-group">
					<td style="width: 32%;">
						<label class="control-label-f">PRODUCT TARE: </label>
					</td>
					<td >
						<?= Html::input('number', 'product_tare', '', [	'id'	=> 'product_tare',
																		'style'	=> 'text-align: right;',
													  		  	 		'class'	=> 'uborder help-44percent',]) ?> <span style="font-weight: bold;" class="page-title-bt">EA</span>
					</td>
				</tr>
				<tr class="control-group">
					<td style="width: 32%;">
						<label class="control-label-f" style="text-align: right; margin-right: 10px;"># OF UNITS: </label>
					</td>
					<td >
						<?= Html::input('number', 'units', '', ['id'	=> 'units',
																'style'	=> 'text-align: right;',
													  		  	'class'	=> 'uborder help-44percent',]) ?>
					</td>
				</tr>
				<tr class="control-group">
					<td style="width: 32%;">
						<label class="control-label-f" style="text-align: right; margin-right: 10px;">TOTAL: </label>
					</td>
					<td >
						<?= Html::input('number', 'product_tare_total', '', ['id'		=> 'product_tare_total',
												  		  		'class'	 	=> 'uborder help-44percent',
												  		  		'style'	 	=> 'text-align: right;',
												  		  		'onchange' 	=> 'calculateNetWeight()',]) ?> <span style="font-weight: bold;" class="page-title-bt">kg</span>
					</td>
				</tr>
				<tr class="control-group">
					<td style="width: 32%;">
						<label class="control-label-f">PALLET PACKAGING TARE: </label>
					</td>
					<td >
						<?= Html::input('number', 'pallet_packaging_tare', '', ['id'		=> 'pallet_packaging_tare',
													  		  	  		  		'class'	 	=> 'uborder help-44percent',
													  		  	  		  		'style'	 	=> 'text-align: right;',
													  		  	  		  		'onchange' 	=> 'calculateNetWeight()',]) ?> <span style="font-weight: bold;" class="page-title-bt">kg</span>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	
	<div class="form-group">
		<button class="btn btn-primary help-20percent" type="button" style="height: 100px; margin-top: 70px;" onclick="window.location = 'index'">CANCEL</button>
		<?= Html::submitButton('PRINT', ['class' 	=> 'btn btn-primary help-20percent',
										 'style'	=> 'height: 100px; margin-top: 10px;',
        								 'name'  	=> 'print']) ?>
    </div>
	
	<h3 class="page-title-bt" style="display: inline-block">
		NET WEIGHT: &nbsp;&nbsp;
		<?= Html::textInput('net_weight', '0', ['id'		=> 'net_weight',
											   'readonly' 	=> 'readonly',
											   'class'	 	=> 'uborder disabled help-32percent',
											   'style'	 	=> 'height: 50px; text-align: right;',]) ?> 
		kg
	</h3>
	
    <?php ActiveForm::end(); ?>

</div>
