<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Alert;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Receiving';
?>
<div id="main-content">
	<div id="content-wrapper">
		<?php
			if ($isAccessReceiving) {
				Alert::begin([
				    'options' => [
				        'class' => 'alert-error',
				    ],
				]);

				echo 'Pallet # is still being used by other account.';

				Alert::end();
			}

			if ($palletStatus['open_success']) {
				Alert::begin([
				    'options' => [
				        'class' => 'alert-success',
				    ],
				]);

				echo 'Pallet #' . Yii::$app->request->post("open_pallet_no") . ' successfully opened.';

				Alert::end();
			}

			if ($palletStatus['open_error']) {
				Alert::begin([
				    'options' => [
				        'class' => 'alert-error',
				    ],
				]);

				echo 'Failed to open pallet. Please enter pallet no.';

				Alert::end();
			}

			if ($palletStatus['close_success']) {
				Alert::begin([
				    'options' => [
				        'class' => 'alert-success',
				    ],
				]);

				echo 'Pallet #' . Yii::$app->request->post("close_pallet_no") . ' successfully closed.';

				Alert::end();
			}

			if ($palletStatus['close_error']) {
				Alert::begin([
				    'options' => [
				        'class' => 'alert-error',
				    ],
				]);

				echo 'Failed to close pallet. Please enter pallet no.';

				Alert::end();
			}

			if ($palletStatus['reject_success']) {
				Alert::begin([
				    'options' => [
				        'class' => 'alert-success',
				    ],
				]);

				echo 'Pallet #' . Yii::$app->request->post("reject_pallet_no") . ' successfully rejected.';

				Alert::end();
			}

			if ($palletStatus['reject_error']) {
				Alert::begin([
				    'options' => [
				        'class' => 'alert-error',
				    ],
				]);

				echo 'Failed to reject pallet. Please enter pallet no.';

				Alert::end();
			}

            if ($palletStatus['create_to_success']) {
                Alert::begin([
                    'options' => [
                        'class' => 'alert-success',
                    ],
                ]);

                echo 'Pallet #' . Yii::$app->request->post("create_to_pallet_no") . ' successfully created with Transfer Order.';
                echo '<br />T.O. Number: ' . $palletStatus['to_number'];

                Alert::end();
            }

            if ($palletStatus['create_to_error']) {
                Alert::begin([
                    'options' => [
                        'class' => 'alert-error',
                    ],
                ]);

                echo 'Failed to create TO number. ' . $palletStatus['to_error'];

                Alert::end();
            }
		?>
		<div class="help-150"><h1 class="page-title page-title-bt">Receiving</h1></div>
		<ul class="list-sub-menu">
			<li><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/receiving/create"> <span>Create Receiving</span></a></li>
			<li><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/receiving/edit"> <span>Edit Receiving</span></a></li>
			<li><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/receiving/view-close-pallet"> <span>View & Close Pallet</span></a></li>
			<?php if (Yii::$app->user->identity->account_type === 'admin' || Yii::$app->user->identity->account_type === 'checker') { ?>
				<li><a href="#openpallet" data-toggle="modal"> <span>Open Pallet</span></a></li>
			<?php } ?>
			<?php if (Yii::$app->user->identity->account_type === 'admin' || Yii::$app->user->identity->account_type === 'checker') { ?>
				<li><a href="#rejectpallet" data-toggle="modal"> <span>Reject Pallet</span></a></li>
			    <li><a href="#createto" data-toggle="modal"> <span>Create TO</span></a></li>
			    <li><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/receiving/close"> <span>Close Receiving</span></a></li>
			<?php } ?>
		</ul>
	</div>
</div>

<!-- Popup Box -->
<!-- Open Pallet -->
<div style="height:230px" id="openpallet" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
            <?= Html::textInput('open_pallet_no', '', ['id'		   => 'open-pallet-no',
								 					   'class'	   => 'uborder help-40percent',
								 					   'maxlength' => 10]) ?>
            <?= Html::submitButton('Use Pallet', ['class' 	=> 'btn btn-success',
        									  	  'name'	=> 'open-pallet']) ?>
        </div>
      <?php ActiveForm::end(); ?>

  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>


<!-- Close Pallet -->
<div style="height:230px" id="closepallet" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
            <?= Html::submitButton('Use Pallet', ['class' 	=> 'btn btn-success',
        									  	  'name'	=> 'close-pallet']) ?>
        </div>
      <?php ActiveForm::end(); ?>

  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>


<!-- Reject Pallet -->
<div style="height:230px" id="rejectpallet" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
								 					  	'class'	 	 => 'uborder help-40percent',
								 					  	'maxlength'  => 10,]) ?>
            <?= Html::submitButton('Use Pallet', ['class' 	=> 'btn btn-success',
        									  	  'name'	=> 'reject-pallet']) ?>
        </div>
      <?php ActiveForm::end(); ?>

  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>


<!-- Create Transfer Order -->
<div style="height:230px" id="createto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel" class="header-popup">Create Transfer Order</h3>
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
            <?= Html::textInput('create_to_pallet_no', '', ['id'        => 'create-to-pallet-no',
                                                            'class'     => 'uborder help-40percent',
                                                            'maxlength' => 10,]) ?>
            <?= Html::submitButton('Use Pallet', ['class'   => 'btn btn-success',
                                                  'name'    => 'create-to']) ?>
        </div>
      <?php ActiveForm::end(); ?>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>