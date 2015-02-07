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
	
	<div class="form-group">
	<div class="control-group">
		<label class="control-label">Customer: </label>
		<div class="f-inline-size">
			<?= Html::dropDownList
			('customer', null, $customer_list, 
					   ['id'        => 'customer',
						'class'	    => 'uborder help-50percent',
						'label'	    => 'Customer',
						'prompt'	=> '-- Select a customer --',
						'onchange'	=> 'getMaterialList(getFieldValueById("customer"))']);
			?>
		</div>
		<div class="col-lg-8"></div>
	</div>
	</div>
	
	<div class="form-group">
	<div class="control-group">
		<label class="control-label">Material: </label>
		<div class="f-inline-size">
			<?= Html::dropDownList
			('material', null, [], 
					   ['id'        => 'material',
						'class'	    => 'uborder help-50percent',
						'label'	    => 'Material',
						'prompt'	=> '-- Select a material --',
						'onchange'	=> 'setFieldValueById("material_code", getFieldValueById("material"));
										var e = document.getElementById("material");
										if ("" != e.value) setFieldValueById("material_description", e.options[e.selectedIndex].text);
										else setFieldValueById("material_description", "");',]);
						
			?>
		</div>
		<div class="col-lg-8"></div>
	</div>
	</div>
	
	<div class="form-group">
	<div class="control-group">
		<label class="control-label">M. Code: </label>
		<div class="f-inline-size">
			<?= Html::textInput('material_code', null, ['id' 		=> 'material_code',
														'readonly'	=> 'readonly',
											  			'class'	 	=> 'uborder help-30percent',
											  			'onchange' 	=> 'setFieldValueById("material", getFieldValueById("material_code"))',]) ?>
		   <?= Html::input('hidden', 'material_description', '', ['id' => 'material_description']) ?>
		</div>
		<div class="col-lg-8"></div>
	</div>
	</div>
	
	
	<div class="form-group">
	<div class="control-group">
		<label class="control-label" style="color:#000">GROSS WT: </label>
		<div class="f-inline-size">
			<?= Html::input('number', 'gross_weight', '', ['id'		 => 'gross_weight',
														   'step'	 => 'any',
													  	   'class'	 => 'uborder help-32percent',
													  	   'style'	 => 'height: 50px; text-align: right;',
													  	   'onchange' => 'calculateNetWeight()']) ?> <span style="font-weight: bold;" class="page-title-bt">kg</span>
		</div>
		<div class="col-lg-8"></div>
	</div>
	</div>
	
	<h4 class="page-title-bt" style="padding: 10px 0;">TARE WEIGHTS </h4>
	
	<div class="form-group">
	<div class="control-group">
		<label class="control-label">PALLET TARE: </label>
		<div class="f-inline-size">
			<?= Html::input('number', 'pallet_tare', '', ['id'			=> 'pallet_tare',
														  'step'		=> 'any',
														  'class'	 	=> 'uborder help-32percent',
														  'style'		=> 'text-align: right;',
														  'onchange'	=> 'calculateNetWeight()',]) ?> <span style="font-weight: bold;" class="page-title-bt">kg</span>
		</div>
		<div class="col-lg-8"></div>
	</div>
	</div>
	<div class="form-group">
	<div class="control-group">
		<label class="control-label">PRODUCT TARE: </label>
		<div class="f-inline-size">
			<?= Html::input('number', 'product_tare', '', [	'id'	=> 'product_tare',
															'onchange' => 'calculateTotalProductTare()',
															'style'	=> 'text-align: right;',
															'class'	=> 'uborder help-32percent',]) ?> <span style="font-weight: bold;" class="page-title-bt">EA</span>
		</div>
		<div class="col-lg-8"></div>
	</div>
	</div>
	<div class="form-group">
	<div class="control-group">
		<label class="control-label"># OF UNITS: </label>
		<div class="f-inline-size">
			<?= Html::input('number', 'units', '', ['id'		=> 'units',
													'step'	 	=> 'any',
													'style'		=> 'text-align: right;',
													'class'		=> 'uborder help-32percent',
													'onchange' 	=> 'calculateTotalProductTare()']) ?>
		</div>
		<div class="col-lg-8"></div>
	</div>
	</div>	
	<div class="form-group">
	<div class="control-group">
		<label class="control-label">TOTAL: </label>
		<div class="f-inline-size">
			<?= Html::input('number', 'product_tare_total', '0', ['id'			=> 'product_tare_total',
																  'step'	 	=> 'any',
																  'readonly'	=> 'readonly',
																  'class'	 	=> 'uborder help-32percent disabled',
																  'style'	 	=> 'text-align: right;',
																  'onchange' 	=> 'calculateNetWeight()',]) ?> <span style="font-weight: bold;" class="page-title-bt">kg</span>
		</div>
		<div class="col-lg-8"></div>
	</div>
	</div>
	<div class="form-group">
	<div class="control-group">
		<label class="control-label">PALLET PACKAGING TARE: </label>
		<div class="f-inline-size">
				<?= Html::input('number', 'pallet_packaging_tare', '', ['id'		=> 'pallet_packaging_tare',
																		'step'	 	=> 'any',
																		'class'	 	=> 'uborder help-32percent',
																		'style'	 	=> 'text-align: right;',
																		'onchange' 	=> 'calculateNetWeight()',]) ?> <span style="font-weight: bold;" class="page-title-bt">kg</span>
		</div>
		<div class="col-lg-8"></div>
	</div>
	</div>
	<div class="submit-button ie6-submit-button">
	<div class="one-column-button pdt-one-column-button">
							  
		<button class="btn btn-primary cancel-button" type="button" onclick="window.location = 'index'">CANCEL</button>
		<?= Html::submitButton('PRINT', ['class' 	=> 'btn btn-primary',
										 'style'	=> '',
        								 'name'  	=> 'print']) ?>
	</div>
	</div>

	<div class="form-group">
	<div class="control-group">
		<label class="control-label" style="color:#000">NET WT: </label>
		<div class="f-inline-size">
			<?= Html::textInput('net_weight', '0', ['id'		=> 'net_weight',
													'step'	 	=> 'any',
												    'readonly' 	=> 'readonly',
												    'class'	 	=> 'uborder disabled help-32percent',
												    'style'	 	=> 'height: 50px; text-align: right;',]) ?> <span style="font-weight: bold;" class="page-title-bt">kg</span>
		</div>
		<div class="col-lg-8"></div>
	</div>
	</div>
	
    <?php ActiveForm::end(); ?>

</div>
