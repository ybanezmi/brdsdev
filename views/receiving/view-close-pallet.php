<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */

$this->title = 'View & Close Pallet';
?>
<div id="main-content">

	<div class="wrapper-150">
		<h1 class="page-title">View & Close Pallet</h1>

		<div class="one-column help-bg-gray pdt-one-column" >
		    <?php
    		      if ($palletStatus['close_success']) {

                    Alert::begin([
                        'options' => [
                            'class' => 'alert-success',
                        ],
                    ]);

                    echo 'Pallet #' . Yii::$app->request->post('TrxTransactionDetails')['pallet_no'] . ' successfully closed.';

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
		    ?>

		    <?php
		    	$js = 'function beforeValidate(form) {if ( form.data("cancel") {this.validateOnSubmit = false;this.beforeValidate = "";form.submit();return false;}return true;}';
		    	$form = ActiveForm::begin([
		    	'options' => ['class' => 'form-horizontal'],
		    	'fieldConfig' => [
		    		'template' => '<div class="control-group">{label}<div class="f-full-size">{input}</div></div>',
		    	]
		    ]); ?>

		    <?= $form->field($transactionModel, 'pallet_no',[])
                    ->textInput(['class'        => 'uborder help-50percent',
                                 'onchange'     => 'getPalletDetails(getFieldValueById("trxtransactiondetails-pallet_no"))',
                                 'value'        => Yii::$app->request->post('TrxTransactionDetails')['pallet_no'],
                                 'maxlength'    => 10])->label('SCAN A PALLET NUMBER', ['class' => 'control-label-f']) ?>

			<div class="control-group">
				<label class="control-label-f">PALLET DETAILS</label>
	            <div class="f-full-size help-75percent" style="background:#ccc; min-height: 200px; padding:20px;">
	            	<div id="pallet-details" style="display: none;">
	            		<div class="control-group">
                            <?= Html::label('TRANSACTION ID', 'transaction_id', ['class' => 'control-label']) ?>
                            <div class="f-inline-size">
                                <?= Html::textInput('transaction_id', null, ['class'    => 'uborder disabled help-40percent',
                                                                             'disabled' => 'disabled',
                                                                             'id'       => 'transaction-id']); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?= Html::label('CUSTOMER', 'transaction_id', ['class' => 'control-label']) ?>
                            <div class="f-inline-size">
                                <?= Html::textInput('customer', null, ['class'    => 'uborder disabled help-40percent',
                                                                       'disabled' => 'disabled',
                                                                       'id'       => 'customer']); ?>
                            </div>
                        </div>
		            	<div class="control-group">
		            		<?= Html::label('# PALLET(S)', 'pallet_count', ['class' => 'control-label']) ?>
		            		<div class="f-inline-size">
		            			<?= Html::textInput('pallet_count', null, ['class'     => 'uborder disabled help-20percent',
		            			                                           'disabled'  => 'disabled']); ?>
		            		</div>
		            	</div>
		            	<div class="control-group">
		            		<?= Html::label('PALLET WEIGHT', 'pallet_weight', ['class' => 'control-label']) ?>
		            		<div class="f-inline-size">
		            			<?= Html::textInput('pallet_weight', null, ['class'    => 'uborder disabled help-20percent',
		            									   		   			'disabled' => 'disabled']); ?>
		            		</div>
		            	</div>
                        <div class="control-group">
                            <?= Html::label('PALLET TYPE', 'pallet_type', ['class' => 'control-label']) ?>
                            <div class="f-inline-size">
                                <?= Html::textInput('pallet_type', null, ['class'       => 'uborder disabled help-40percent',
                                                                          'disabled'    => 'disabled']); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?= Html::label('STATUS', 'status', ['class' => 'control-label']) ?>
                            <div class="f-inline-size">
                                <?= Html::textInput('status', null, ['class'    => 'uborder disabled help-40percent',
                                                                     'disabled' => 'disabled']); ?>
                            </div>
                        </div>
	            	</div>
            	</div>

    		    <div class="form-group">
    		    	<div class="one-column-button">
    					<div class="submit-button ie6-submit-button">
    					    <button class="btn btn-primary"
    					       onclick="js: viewPalletDetails(getFieldValueById('transaction-id'), getFieldValueById('trxtransactiondetails-pallet_no')); return false;"
    					       name="btn-view-pallets">View Pallets</button>
    		        		<?= Html::submitButton('Close Pallet', ['class' => 'btn btn-primary',
    		        												'name'  => 'close-pallet',
    		        												'id'    => 'btn-close-pallet',]) ?>
    		        		<?= Html::submitButton('Cancel', ['class' => 'btn btn-primary cancel-button',
    		        										  'name'  => 'cancel']) ?>
    		        	</div>
    		        </div>
    		    </div>
		    </div>
	    <?php ActiveForm::end(); ?>
	</div>
</div>

<script type="text/javascript">
    window.onload=function() {
        getPalletDetails(getFieldValueById("trxtransactiondetails-pallet_no"));
    }
</script>
