<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = 'View & Close Pallet';
?>
<div id="main-content">

	<div class="wrapper-150">
		<h1 class="page-title">View & Close Pallet</h1>

		<div class="one-column help-bg-gray pdt-one-column" >
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
                                 'maxlength'    => 10])->label('SCAN A PALLET NUMBER', ['class' => 'control-label-f']) ?>

			<div class="control-group">
				<label class="control-label-f">PALLET DETAILS</label>
	            <div class="f-full-size help-75percent" style="background:#ccc; min-height: 365px; padding:20px;">
	            	<div id="trx-details" style="display: none;">
	            		<div class="control-group">
                            <?= Html::label('TRANSACTION ID', 'transaction_id', ['class' => 'control-label']) ?>
                            <div class="f-inline-size">
                                <?= Html::textInput('transaction_id', null, ['class'    => 'uborder disabled help-40percent',
                                                                             'disabled' => 'disabled']); ?>
                            </div>
                        </div>
		            	<div class="control-group">
                            <?= Html::label('MATERIAL CODE', 'material_code', ['class' => 'control-label']) ?>
                            <div class="f-inline-size">
                                <?= Html::textInput('material_code', null, ['class'     => 'uborder disabled help-40percent',
                                                                            'disabled'  => 'disabled']); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?= Html::label('BATCH', 'batch', ['class' => 'control-label']) ?>
                            <div class="f-inline-size">
                                <?= Html::textInput('material_code', null, ['class'    => 'uborder disabled help-40percent',
                                                                            'disabled' => 'disabled']); ?>
                            </div>
                        </div>
		            	<div class="control-group">
		            		<?= Html::label('DATE', 'created_date', ['class' => 'control-label']) ?>
		            		<div class="f-inline-size">
		            			<?= Html::textInput('created_date', null, ['class' 	  => 'uborder disabled help-40percent',
		            									   		   		   'disabled' => 'disabled']); ?>
		            		</div>
		            	</div>
		            	<div class="control-group">
		            		<?= Html::label('# PALLET(S)', 'pallet_count', ['class' => 'control-label']) ?>
		            		<div class="f-inline-size">
		            			<?= Html::textInput('pallet_count', null, ['class'     => 'uborder disabled help-40percent',
		            			                                           'readonly'  => 'readonly']); ?>
		            		</div>
		            	</div>
		            	<div class="control-group">
		            		<?= Html::label('NET WEIGHT', 'net_weight', ['class' => 'control-label']) ?>
		            		<div class="f-inline-size">
		            			<?= Html::textInput('net_weight', null, ['class' 	=> 'uborder disabled help-40percent',
		            			                                         'disabled' => 'disabled']); ?>
		            		</div>
		            	</div>
		            	<div class="control-group">
		            		<?= Html::label('TOTAL WEIGHT', 'total_weight', ['class' => 'control-label']) ?>
		            		<div class="f-inline-size">
		            			<?= Html::textInput('total_weight', null, ['class'     => 'uborder disabled help-20percent',
		            									   		   		   'disabled'  => 'disabled']); ?>
		            		</div>
		            	</div>
		            	<div class="control-group">
		            		<?= Html::label('PALLET WEIGHT', 'pallet_weight', ['class' => 'control-label']) ?>
		            		<div class="f-inline-size">
		            			<?= Html::textInput('pallet_weight', null, ['class'    => 'uborder disabled help-40percent',
		            									   		   			'disabled' => 'disabled']); ?>
		            		</div>
		            	</div>
		            	<div class="control-group">
                            <?= Html::label('KITTED UNIT', 'kitted_unit', ['class' => 'control-label']) ?>
                            <div class="f-inline-size">
                                <?= Html::textInput('kitted_unit', null, ['class'       => 'uborder disabled help-40percent',
                                                                          'disabled'    => 'disabled']); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?= Html::label('MANUFACTURING DATE', 'manufacturing_date', ['class' => 'control-label']) ?>
                            <div class="f-inline-size">
                                <?= Html::textInput('manufacturing_date', null, ['class'    => 'uborder disabled help-40percent',
                                                                                 'disabled' => 'disabled']); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?= Html::label('EXPIRY DATE', 'expiry_date', ['class' => 'control-label']) ?>
                            <div class="f-inline-size">
                                <?= Html::textInput('expiry_date', null, ['class'       => 'uborder disabled help-40percent',
                                                                          'disabled'    => 'disabled']); ?>
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
                        <div class="control-group">
                            <?= Html::label('CREATOR', 'creator', ['class' => 'control-label']) ?>
                            <div class="f-inline-size">
                                <?= Html::textInput('creator', null, ['class'       => 'uborder disabled help-40percent',
                                                                      'disabled'    => 'disabled']); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?= Html::label('CREATED DATE', 'created_date', ['class' => 'control-label']) ?>
                            <div class="f-inline-size">
                                <?= Html::textInput('created_date', null, ['class'      => 'uborder disabled help-40percent',
                                                                           'disabled'   => 'disabled']); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?= Html::label('UPDATER', 'updater', ['class' => 'control-label']) ?>
                            <div class="f-inline-size">
                                <?= Html::textInput('updater', null, ['class'       => 'uborder disabled help-40percent',
                                                                      'disabled'    => 'disabled']); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?= Html::label('UPDATED DATE', 'updater', ['class' => 'control-label']) ?>
                            <div class="f-inline-size">
                                <?= Html::textInput('updater', null, ['class'       => 'uborder disabled help-40percent',
                                                                      'disabled'    => 'disabled']); ?>
                            </div>
                        </div>
	            	</div>
            	</div>

    		    <div class="form-group">
    		    	<div class="one-column-button">
    					<div class="submit-button ie6-submit-button">
    		        		<?= Html::submitButton('Close Pallet', ['class' => 'btn btn-primary',
    		        												'name'  => 'close-pallet']) ?>
    		        		<?= Html::submitButton('Cancel', ['class' => 'btn btn-primary cancel-button',
    		        										  'name'  => 'cancel']) ?>
    		        	</div>
    		        </div>
    		    </div>
		    </div>
	    <?php ActiveForm::end(); ?>
	</div>
</div>
