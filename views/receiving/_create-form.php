<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TrxTransactions */
/* @var $customer_list app\models\MstCustomer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="create-receiving-form">
    <?php
    	$js = 'function beforeValidate(form) {if ( form.data("cancel") {this.validateOnSubmit = false;this.beforeValidate = "";form.submit();return false;}return true;}';
    	$form = ActiveForm::begin([
    	'fieldConfig' => [
    		'template' => '<div class="control-group">{label}<div class="f-full-size">{input}</div><div class=\"col-lg-8\">{error}</div></div>',
    	]
    ]); ?>

	<?= $form->field($model, 'customer_code')->dropDownList($customer_list, ['class'	=> 'f-full-size',
																			 'prompt'	=> '-- Select a customer --',
																			 'onchange'	=> 'setFieldValueById("customer_code", getFieldValueById("trxtransactions-customer_code"))'])->label('Customer Name', ['class' => 'control-label-f']); ?>

	<div class="control-group">
    	<div class="f-full-size">
        	<?= Html::textInput('customer_code', '', ['id'		 => 'customer_code',
        											  'disabled' => 'disabled',
        						 					  'class'	 => 'uborder disabled help-30percent']) ?>
    	</div>
	</div>

	<?= $form->field($model, 'truck_van', ['template' => '<div class="control-group">{label}<div class="f-inline-size">{input}</div><div class=\"col-lg-8\">{error}</div></div>'])->textInput(['maxlength' => 10,
													  'class' => 'uborder help-20percent',
													  'onchange' => 'setFieldValueToUpperCaseById(this.id, this.value);'])->label('T.PLATE #') ?>

	<?= $form->field($model, 'plant_location', ['template' => '<div class="control-group">{label}<div class="f-inline-size">{input}</div><div class=\"col-lg-8\">{error}</div></div>'])->textInput(['value'	  => Yii::$app->user->identity->assignment,
														   'readonly' => 'readonly',
														   'class'	  => 'uborder disabled help-40percent'])->label('P. Loc') ?>

  	<?= $form->field($model, 'storage_location', ['template' => '<div class="control-group">{label}<div class="f-inline-size">{input}</div><div class=\"col-lg-8\">{error}</div></div>'])->dropDownList($storage_list, ['class'	=> 'uborder help-40percent',
																			   'prompt'	=> '-- Select a storage --'])->label('S. Loc'); ?>

    <?= $form->field($model, 'remarks',
            ['template' => '<div class="control-group">{label}<div class="f-inline-size">
                                <label class="class="control-label">' . Yii::$app->user->identity->username . '@:</label>
                                {input}</div><div class=\"col-lg-8\">{error}</div></div>'])->textarea(['rows'=>'5']) ?>


    	<div class="one-column-button pdt-one-column-button">
			<div class="submit-button ie6-submit-button">
        		<?= Html::submitButton('Create', ['class' => 'btn btn-primary',
        		                                  'name' => 'create']) ?>
        		<?= Html::submitButton('Cancel', ['class' => 'btn btn-primary cancel-button',
        										  'name'  => 'cancel']) ?>
        	</div>
        </div>


    <?php ActiveForm::end(); ?>

</div>
