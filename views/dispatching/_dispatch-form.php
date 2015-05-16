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
    	'options' => ['class' => 'form-horizontal', 'name'=>'dispatchFORM','onSubmit'=>'return valDispatchform()'],
    	'fieldConfig' => [
    		'template' => '<div class="control-group">{label}<div class="f-full-size">{input}</div><div class=\"col-lg-8\">{error}</div></div>',
    	],
    ]); ?>
    
	<div class="control-group">
	<label class="control-label-f" for="document_number">Enter Document #:</label>
		<div class="f-full-size">
			<?= Html::textInput('document_number', '', ['id'  => 'document_number','class' => 'uborder help-85percent', 'maxlength'=>'8', 'onkeypress'=> 'return isNumberKey(event)' ]) ?>
		</div>
	</div>
	
	<div class="one-column-button pdt-one-column-button">
		<div class="submit-button ie6-submit-button">
		<?= Html::submitButton('Search', ['class' => 'btn btn-primary',
                                             'id' => 'submit-document',
												  'name'  => 'submit-document']) ?>
		<?= Html::submitButton('Cancel', ['class' => 'btn btn-primary',
										  'name'  => 'cancel']) ?>
		</div>
	</div>

    <?php ActiveForm::end(); ?>

    <style type="text/css">
    .dispatch-header, .dispatch-details{
        border:1px solid #ccc;
        margin-bottom: 20px;
        padding-bottom: 10px;
    }
    .disptach-preview h1 {
    	font-size: 25px;
    	line-height: 20px;
        background: #ccc;
        padding:15px 15px;
        margin: 0;
    }
    .disptach-preview h3 {
        font-size: 22px;
        line-height: 15px;
        margin-top:30px;
    }
    .row{
    	clear: both;
    	overflow: hidden;
    	width:auto;
    	margin: 7px 0;
    }
    .emptyr{ color:#000;}
    .disp-left { float:left; font-weight: bold; }
    .disp-right { float:left; margin-left: 10px; }

    </style>
    <?php if(empty($dispatch_model_1) && empty($dispatch_model_2)) { echo '<b class="emptyr">Dispatch record is empty</b>'; } else { 
    	$dismodel = new DispatchModel; 
    ?>

    <?php 
        $js = 'function beforeValidate(form) {if ( form.data("cancel") {this.validateOnSubmit = false;this.beforeValidate = "";form.submit();return false;}return true;}';
        $form = ActiveForm::begin([]); 
    ?>
   <!-- <h3>Results for [ DR #: <?php //echo $dispatch_model_1[0]->VBELN; ?> ]</h3> -->
    <div class="disptach-preview">
    <?php  $customer_data = $dismodel->getCustomerData($dispatch_model_1[0]->KUNAG); ?>

	<div class="dispatch-header">
    <h1>Shipping Information</h1>
    <div style="padding:0 20px;">
    <h3><?php echo $customer_data[0]->NAME1; ?></h3>
    <table class="tablelist">
    <tr>
        <td>
            <div class="row">
        		<div class="disp-left">Customer Number:</div>
        		<div class="disp-right"><?php echo $dispatch_model_1[0]->KUNNR; ?> 
        			<?php //echo $dismodel->getKUNNR($dispatch_model_1[0]->KUNNR)[0]->NAME1; ?></div>
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
        </td>
        <td style="padding-left:50px;">
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
        </td>
    </tr>
    <tr>
        <td colspan="5">
            <div class="control-group" style="width:100%; margin:20px 0 0">
                <?= Html::textInput('scanner', '', ['id'  => 'scanner','class' => 'uborder help-100percent']) ?>
            </div>
        </td>
    </tr>
    </table>

        <div>
            <?php  $so_data = $dismodel->getSO($dispatch_model_1[0]->VBELN); //echo '<pre>'; print_r($so_data); echo '</pre>';  ?>
        </div>
    </div>
    </div>

    <div class="dispatch-details">
    	<h1>Shipping Details</h1>
			<style>table.details{ width:auto; margin-top: 20px; } </style>
			<div style="padding:0 20px;">		
				<table class="details">
				<tbody>
				<?php
                $i=1;
					foreach ($dispatch_model_2 as $dispatch_model_2_key => $dispatch_model_2_info) {
						
						echo "<tr><td style='width:50px; vertical-align:top; padding-top:7px;'> <input type='text' class='uborder help-80percent' maxlength='3' onkeypress='return isNumberKey(event)'' id='quantity_".$i."' /></td><td style='padding-top:5px;'>" ;
							echo $dispatch_model_2_info->ARKTX; //$dispatch_model_2_info->MATNR;
							echo "<br />";
							echo $dispatch_model_2_info->UMVKZ.' / '.$dispatch_model_2_info->LFIMG;
							echo "<br />";
							echo $dispatch_model_2_info->CHARG.' / '.date("Y-m-d", strtotime($dispatch_model_2_info->VFDAT));
						echo "<td></tr>";
                        $i++;

					}
					?>
					</tbody>
				</table>
            </div>
    </div>
    </div>
    
    
    
    <div class="one-column-button pdt-one-column-button">
		<div class="submit-button ie6-submit-button">
		<?= Html::submitButton('Print', ['class' => 'btn btn-primary',
												  'name'  => 'print-document']) ?>
		<button type="button" class="btn btn-primary" name="clear" onclick="return clearvalue()">Clear</button>
		</div>
	</div>

    <?php ActiveForm::end(); ?>

	<?php } ?>

</div>


<script type="text/javascript">
    function valDispatchform()
    {
        var pname=encodeURIComponent(document.getElementById("document_number").value);
        if (pname == '')
        { alert('Please enter document number');l
            return false;}
        else if (pname.length != 8)
        {alert('You must input 8 numeric numbers');return false;}

        return true;
    }
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    function clearvalue(){
        var elements = document.getElementsByTagName("input");
        for (var ii=0; ii < elements.length; ii++) {
          if (elements[ii].type == "text") {
            elements[ii].value = "";
          }
        }
    }
</script>