<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
//@TODO: convert to ActiveFields
?>

<!-- Forgot Password -->
<div id="forgotpassword" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel" class="header-popup">Forgot Password?</h3>
  </div>
  <div class="modal-body">
    <p><b>Please contact administrator</b></p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>


<!-- Open Pallet -->
<div id="openpallet" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel" class="header-popup">Open Pallet</h3>
  </div>
  <div class="modal-body">
      <h4>Scan Pallet to Process</h4>
      <?php 
    	$js = 'function beforeValidate(form) {if ( form.data("cancel") {this.validateOnSubmit = false;this.beforeValidate = "";form.submit();return false;}return true;}';
    	$form = ActiveForm::begin([
	    	'options' => ['class' => 'form-horizontal'],
	    	'fieldConfig' => [
	    		'template' => '<div class="control-group">{label}<div class="f-inline-size">{input}</div></div>',
	    	]
   		]); ?>
        <div class="control-group">
            <?= Html::textInput('open_pallet_no', '', ['id'		 => 'open-pallet-no',
								 					  	'class'	 	 => 'uborder help-40percent']) ?>
            <?= Html::submitButton('Use Pallet', ['class' 	=> 'btn',
        									  	  'name'	=> 'open-pallet']) ?>
        </div>
      <?php ActiveForm::end(); ?>
    
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Open</button>
  </div>
</div>


<!-- Close Pallet -->
<div id="closepallet" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel" class="header-popup">Close Pallet</h3>
  </div>
  <div class="modal-body">
      <h4>Scan Pallet to Process</h4>
      <?php 
    	$js = 'function beforeValidate(form) {if ( form.data("cancel") {this.validateOnSubmit = false;this.beforeValidate = "";form.submit();return false;}return true;}';
    	$form = ActiveForm::begin([
	    	'options' => ['class' => 'form-horizontal'],
	    	'fieldConfig' => [
	    		'template' => '<div class="control-group">{label}<div class="f-inline-size">{input}</div></div>',
	    	]
   		]); ?>
        <div class="control-group">
            <?= Html::textInput('close_pallet_no', '', ['id'		 => 'close-pallet-no',
								 					  	'class'	 	 => 'uborder help-40percent']) ?>
            <?= Html::submitButton('Use Pallet', ['class' 	=> 'btn',
        									  	  'name'	=> 'close-pallet']) ?>
        </div>
      <?php ActiveForm::end(); ?>
    
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>


<!-- Reject Pallet -->
<div id="rejectpallet" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel" class="header-popup">Reject Pallet</h3>
  </div>
  <div class="modal-body">
      <h4>Scan Pallet to Process</h4>
      <?php 
    	$js = 'function beforeValidate(form) {if ( form.data("cancel") {this.validateOnSubmit = false;this.beforeValidate = "";form.submit();return false;}return true;}';
    	$form = ActiveForm::begin([
	    	'options' => ['class' => 'form-horizontal'],
	    	'fieldConfig' => [
	    		'template' => '<div class="control-group">{label}<div class="f-inline-size">{input}</div></div>',
	    	]
   		]); ?>
        <div class="control-group">
            <?= Html::textInput('reject_pallet_no', '', ['id'		 => 'reject-pallet-no',
								 					  	'class'	 	 => 'uborder help-40percent']) ?>
            <?= Html::submitButton('Use Pallet', ['class' 	=> 'btn',
        									  	  'name'	=> 'reject-pallet']) ?>
        </div>
      <?php ActiveForm::end(); ?>
    
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Reject</button>
  </div>
</div>


<!-- Create Transfer Order -->
<div id="createto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel" class="header-popup">Create Transfer Order</h3>
  </div>
  <div class="modal-body">
      <h4>Scan Pallet to Process</h4>
      <form action="receiving_menu.php" method="post" class="form-horizontal" role="form">
        <div class="control-group">
            <input type="text" class="uborder help-40percent" />
            <button class="btn" data-dismiss="modal" aria-hidden="true">Use Pallet</button>
        </div>
      </form>
    
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>