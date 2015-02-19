<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
//use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\MstAccount */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mst-account-form">

    <?php 
    	$js = 'function beforeValidate(form) {if ( form.data("cancel") {this.validateOnSubmit = false;this.beforeValidate = "";form.submit();return false;}return true;}';
    	$form = ActiveForm::begin([
    	'options' => ['class' => 'form-horizontal'],
    	'fieldConfig' => [
    		'template' => '<div class="control-group">{label}<div class="f-full-size">{input}</div><div class=\"col-lg-8\">{error}</div></div>',
    	],
    ]); ?>

	<?= $form->field($model, 'first_name')->textInput(['maxlength' => 100]) ?>
    
    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => 100]) ?>
    
    <?= $form->field($model, 'last_name')->textInput(['maxlength' => 100]) ?>
    
    <?= $form->field($model, 'address')->textInput(['maxlength' => 255]) ?>
    
    <?= $form->field($model, 'contact_no')->textInput(['maxlength' => 100]) ?>
    
    <h4 class="page-title-bt">In case of emergency</h4>
    
    <?= $form->field($model, 'notify')->textInput(['maxlength' => 255])->label('Person to notify') ?>
    
    <?= $form->field($model, 'notify_conact_no')->textInput(['maxlength' => 255])->label('Contact No') ?>
    
    <h4 class="page-title-bt">BRDS ACCESS</h4>

    <?= $form->field($model, 'account_type')->dropDownList([ 'admin' => 'Admin', 'checker' => 'Checker', 'standard' => 'Standard', ], ['prompt' => '-- Select account type --']) ?>

    <?= $form->field($model, 'username')->textInput($model->isNewRecord ? ['maxlength' => 32]: ['maxlength' => 32, 'disabled' => 'disabled']) ?>

    <?= $model->isNewRecord ? $form->field($model, 'password')->passwordInput(['maxlength' => 32]) : '' ?>

    <?= $form->field($model, 'assignment')->dropDownList($assignment_list, ['prompt'	=> '-- Select assignment --']) ?>

    <?= $form->field($model,'start_date')->widget(DatePicker::className(),['options' 	 => ['dateFormat' 		=> 'mm/dd/yy',
																		   					 'showOn'			=> 'button',
																							 'buttonImage'  	=> '../images/calendar.gif',
																						     'buttonImageOnly' 	=> 'true',
																							 'value'			=> date('m/d/Y', strtotime($model->start_date)),
																		     				 'class' 			=> 'uborder disabled dateclass',
																		   				   	 'readonly'			=> 'readonly',
																		   					 'dateFormat' 		=> 'mm/dd/yy']])->label('Start Date') ?>

    <?= $form->field($model,'end_date')->widget(DatePicker::className(),['options' 	 => ['dateFormat' 		=> 'm/dd/yy',
																   						 'showOn'			=> 'button',
																						 'buttonImage'  	=> '../images/calendar.gif',
																						 'buttonImageOnly' 	=> 'true',
																						 'value'			=> date('m/d/Y', strtotime($model->end_date)),
																     					 'class' 			=> 'uborder disabled dateclass',
																   						 'readonly'			=> 'readonly',
																   					 	 'dateFormat' 		=> 'mm/dd/yy']])->label('End Date') ?>

    <div class="form-group">
        <?= Html::submitButton(['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
