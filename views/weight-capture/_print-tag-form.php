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
    		'template' => '<div class="control-group">{label}<div class="control-field">{input}</div><div class=\"col-lg-8\">{error}</div></div>',
    	]]);
    ?>

	<div class="form-group">
	<div class="control-group">
		<label class="control-label">Customer: </label>
		<div class="control-field">
			<?= Html::dropDownList
			('customer', null, $customer_list,
					   ['id'        => 'customer',
						'class'	    => 'uborder',
						'required'	    => 'required',
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
		<div class="control-field">
			<?= Html::dropDownList
			('material', null, [],
					   ['id'        => 'material',
						'class'	    => 'uborder',
						'label'	    => 'Material',
						'required'	    => 'required',
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
		<label class="control-label">Material Code: </label>
		<div class="control-field">
			<?= Html::textInput('material_code', null, ['id' 		=> 'material_code',
														'readonly'	=> 'readonly',
											  			'class'	 	=> 'uborder disabled',
											  			'onchange' 	=> 'setFieldValueById("material", getFieldValueById("material_code"))',]) ?>
  			<?= Html::textInput('material_barcode', '', ['id'       => 'material_barcode',
                                                         'class'    => 'uborder help-44percent',
                                                         'onchange' => 'searchMaterial(this.value, getFieldValueById("customer"), "material")']) ?>
		   <?= Html::input('hidden', 'material_description', '', ['id' => 'material_description']) ?>
		</div>
		<div class="col-lg-8"></div>
	</div>
	</div>


	<div class="form-group">
	<div class="control-group">
		<label class="control-label" style="color:#000; font-size: 20px; padding-top: 15px;">GROSS Weight: </label>
		<div class="control-field">
			<?= Html::input('number', 'gross_weight', '', ['id'		 => 'gross_weight',
			                                               'min'     => 0,
			                                               'required' => 'required',
														   'step'	 => 'any',
													  	   'class'	 => 'uborder help-32percent',
													  	   'style'	 => 'height: 50px; text-align: right;',
													  	   'onchange' => 'calculateNOWorNEVER()']) ?> <span style="font-weight: bold;" class="page-title-bt">kg</span>
		</div>
		<div class="col-lg-8"></div>
	</div>
	</div>

	<div class="desktop-box-tare">
	<h4 class="page-title-bt" style="padding: 10px 0; font-size:18px;">TARE Weights </h4>

	<div class="form-group">
	<div class="control-group">
		<label class="control-label">Pallet Tare: </label>
		<div class="control-field">
			<?= Html::input('number', 'pallet_tare', '', ['id'			=> 'pallet_tare',
			                                              'min'         => 0,
			                                              'required'	=> 'required',
														  'step'		=> 'any',
														  'class'	 	=> 'uborder help-32percent',
														  'style'		=> 'text-align: right;',
														  'onchange'	=> 'calculateNOWorNEVER()',]) ?> <span style="font-weight: bold;" class="page-title-bt">kg</span>
		</div>
		<div class="col-lg-8"></div>
	</div>
	</div>
	<div class="form-group">
	<div class="control-group">
		<label class="control-label" style="text-align:left;">Product Tare: </label>
		<div class="control-field">
			<?= Html::input('number', 'product_tare', '', [	'id'	    => 'product_tare',
			                                                'min'       => 0,
			                                                'required' 	=> 'required',
			                                                'step'	 	=> 'any',
															'onchange'  => 'calculateNOWorNEVER()',
															'style'	    => 'text-align: right;',
															'class'	    => 'uborder help-32percent',]) ?> <span style="font-weight: bold;" class="page-title-bt">EA</span>
		</div>
		<div class="col-lg-8"></div>
	</div>
	</div>
	<div class="form-group">
	<div class="control-group">
		<label class="control-label" style="text-align: right; width: 200px!important; margin-right: 10px; padding-top: 5px;"># of units: </label>
		<div class="control-field">
			<?= Html::input('number', 'units', '', ['id'		=> 'units',
			                                        'min'       => 0,
			                                        'required' => 'required',
													'step'	 	=> 'any',
													'style'		=> 'text-align: right;',
													'class'		=> 'uborder help-32percent',
													'onchange' 	=> 'calculateNOWorNEVER()']) ?>
		</div>
		<div class="col-lg-8"></div>
	</div>
	</div>
	<div class="form-group">
	<div class="control-group">
		<label class="control-label" style="text-align: right; width: 200px!important; margin-right: 10px; padding-top: 5px;">TOTAL: </label>
		<div class="control-field">
			<?= Html::input('number', 'product_tare_total', '0', ['id'			=> 'product_tare_total',
																  'min'         => 0,
																  'step'	 	=> 'any',
																  'readonly'	=> 'readonly',
																  'class'	 	=> 'uborder help-32percent disabled',
																  'style'	 	=> 'text-align: right;',
																  'onchange' 	=> 'calculateNOWorNEVER()',]) ?> <span style="font-weight: bold;" class="page-title-bt">kg</span>
		</div>
		<div class="col-lg-8"></div>
	</div>
	</div>


    <div class="form-group">
	<div class="control-group">
		<label class="control-label">Pallet Packaging Tare: </label>
		<div class="control-field">
				<?= Html::input('number', 'pallet_packaging_tare', '0', ['id'		=> 'pallet_packaging_tare',
																		'min'       => 0,
																		'step'	 	=> 'any',
																		'class'	 	=> 'uborder help-32percent disabled',
																		'style'	 	=> 'text-align: right;',
																		'readonly'	=> 'readonly',
																		'onchange' 	=> 'calculateNOWorNEVER()',]) ?> <span style="font-weight: bold;" class="page-title-bt">kg</span>
		</div>
		<div class="col-lg-8"></div>
	</div>
	</div>
	</div>

	<div class="form-group" style="margin-top:20px;">
	<div class="control-group">
		<label class="control-label" style="color:#000; font-size: 20px; padding-top: 15px;">NET Weight: </label>
		<div class="control-field">
			<?= Html::textInput('net_weight', '0', ['id'		=> 'net_weight',
													'min'       => 0,
												    'readonly' 	=> 'readonly',
												    'class'	 	=> 'uborder disabled help-32percent',
												    'style'	 	=> 'height: 50px; text-align: right;',]) ?> <span style="font-weight: bold;" class="page-title-bt">kg</span>
		</div>
		<div class="col-lg-8"></div>
	</div>
	</div>
	<div class="desktop-only-weigh-capt">
	<div class="weight-capt-button">

		<button class="btn btn-primary cancel-button" type="button" onclick="window.location = 'index'">CANCEL</button>
		<?= Html::submitButton('PRINT', ['class' 	=> 'btn btn-primary',
										 'style'	=> '',
        								 'name'  	=> 'print']) ?>
	</div>
	</div>


    <?php ActiveForm::end(); ?>

</div>
