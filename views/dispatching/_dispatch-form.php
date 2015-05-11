<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

use app\models\DispatchModel;
/* @var $this yii\web\View */
/* @var $model app\models\MstAccount */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="dispatch-form">
    <?php 
    	$js = 'function beforeValidate(form) {if ( form.data("cancel") {this.validateOnSubmit = false;this.beforeValidate = "";form.submit();return false;}return true;}';
    	$form = ActiveForm::begin([
    	'options' => ['class' => 'form-horizontal'],
    	'fieldConfig' => [
    		'template' => '<div class="control-group">{label}<div class="f-full-size">{input}</div><div class=\"col-lg-8\">{error}</div></div>',
    	],
    ]); ?>
    
	<div class="control-group">
	<label class="control-label-f" for="document_number">Enter Document #:</label>
		<div class="f-full-size">
			<?= Html::textInput('document_number', '', ['id'  => 'document_number','class' => 'uborder help-85percent']) ?>
		</div>
	</div>
	
	<div class="one-column-button pdt-one-column-button">
		<div class="submit-button ie6-submit-button">
		<?= Html::submitButton('Search', ['class' => 'btn btn-primary',
												  'name'  => 'submit-document']) ?>
		<?= Html::submitButton('Cancel', ['class' => 'btn btn-primary',
										  'name'  => 'cancel']) ?>
		</div>
	</div>

    <?php ActiveForm::end(); ?>
    <style type="text/css">
    .disptach-preview h1 {
    	font-size: 25px;
    	line-height: 20px;
    }
    .row{
    	clear: both;
    	overflow: hidden;
    	width:auto;
    	margin: 7px 0;
    }
    .disp-left { float:left; font-weight: bold; }
    .disp-right { float:left; margin-left: 10px; }

    </style>
    <?php if(empty($dispatch_model_1) && empty($dispatch_model_2)) { echo 'Records Empty'; } else { 
    	$dismodel = new DispatchModel; 
    ?>

    <h3>Results [ DR #: <?php echo $dispatch_model_1[0]->VBELN; ?> ]</h3>

    <div class="disptach-preview">
    <?php  $customer_data = $dismodel->getCustomerData($dispatch_model_1[0]->KUNAG); ?>

	<div class="dispatch-header" style="padding:20px; border:1px solid #ccc; clear:both;">
		 <h1><?php echo $customer_data[0]->NAME1; ?></h1>
    	<div class="row">
    		<div class="disp-left">Customer Number:</div>
    		<div class="disp-right"><?php echo $dispatch_model_1[0]->KUNNR; ?> 
    			<?php //echo $dismodel->getKUNNR($dispatch_model_1[0]->KUNNR)[0]->NAME1; ?></div>
    	</div>
    	<div class="row">
    		<div class="disp-left">Customer Code:</div>
    		<div class="disp-right"><?php echo $dispatch_model_1[0]->KUNAG; ?>  
    			<?php //echo $dismodel->getKUNNR($dispatch_model_1[0]->KUNAG)[0]->NAME1; ?></div>
    	</div>
    	<div class="row">
    		<div class="disp-left">Delivered To:</div>
    		<div class="disp-right">
    				<?php echo $customer_data[0]->NAME1; ?><br />
    				<?php echo $customer_data[0]->STRAS; ?><br />
    				<?php echo $customer_data[0]->ORT01; ?>, 
    				<?php echo $customer_data[0]->LAND1; ?> <?php echo $customer_data[0]->PSTLZ; ?><br />
    				<?php echo $customer_data[0]->TELF1; ?><br />
    		</div>
    	</div>
    	<div class="row">
    		<div class="disp-left">Dispatch Number:</div>
    		<div class="disp-right"><?php echo $dispatch_model_1[0]->VBELN; ?></div>
    	</div>
    	<div class="row">
    		<div class="disp-left">Date:</div>
    		<div class="disp-right"><?php echo  date("Y-m-d", strtotime($dispatch_model_1[0]->BLDAT)) ?></div>
    	</div>
    	<div class="row">
    		<div class="disp-left">Customer Request Number:</div>
    		<div class="disp-right">-</div>
    	</div>
    	<div class="row">
    		<div class="disp-left">Date:</div>
    		<div class="disp-right">-</div>
    	</div>
    	<div class="control-group" style="width:40%">
				<?= Html::textInput('scanner', '', ['id'  => 'scanner','class' => 'uborder help-85percent']) ?>
		</div>
    </div>

    <div class="dispatch-details" style="padding:20px; border:1px solid #ccc; clear:both; margin-top:10px;">
    	<h1>Shipping Details</h1>

				<style>table.details{ width:auto; margin-top: 20px; } </style>
					
				<table class="details">
				<tbody>
				<?php
					foreach ($dispatch_model_2 as $dispatch_model_2_key => $dispatch_model_2_info) {
						
						echo "<tr><td style='width:50px; vertical-align:top; padding-top:7px;'> <input type='text' class='uborder help-90percent'</td><td style='padding-top:5px;'>" ;
							echo $dispatch_model_2_info->ARKTX; //$dispatch_model_2_info->MATNR;
							echo "<br />";
							echo $dispatch_model_2_info->UMVKZ.' / '.$dispatch_model_2_info->LFIMG;
							echo "<br />";
							echo $dispatch_model_2_info->CHARG.' / '.date("Y-m-d", strtotime($dispatch_model_2_info->VFDAT));
						echo "<td></tr>";

					}
					?>
					</tbody>
				</table>

				


    </div>

    </div>
    
    <?php } ?>
    


</div>
