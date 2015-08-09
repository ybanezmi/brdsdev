<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MstAccount */

$this->title = $model->first_name . ' ' . $model->last_name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['user-mgmt']];
$this->params['breadcrumbs'][] = ['label' => $model->first_name, 'url' => ['/admin-tools/user-profile?id='.$model->id]];
$this->params['breadcrumbs'][] = 'Edit Profile';
?>

<h1>EDIT PROFILE</h1>

<div class="help-bg-gray">

 <div class="edit-form">

    <?php 
    	$js = 'function beforeValidate(form) {if ( form.data("cancel") {this.validateOnSubmit = false;this.beforeValidate = "";form.submit();return false;}return true;}';
    	$form = ActiveForm::begin([
    	'options' => ['class' => 'form-horizontal'],
    	'fieldConfig' => [
    		'template' => '<div class="control-group">{label}<div class="f-full-size">{input}</div><div class=\"col-lg-8\">{error}</div></div>',
    	],
    ]); ?>

	<?= $form->field($model, 'first_name')->textInput(['maxlength' => 100]) ?>
    
    <?= $form->field($model, 'last_name')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'account_type')->dropDownList([ 'admin' => 'Admin', 'checker' => 'Checker', 'standard' => 'Standard', ], ['prompt' => '-- Select account type --']) ?>

    <div class="form-group">
        <label class="control-label"></label>
        <?= Html::submitButton('Save Changes', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<style type="text/css">
	.edit-form{
		margin:50px 0;
	}
	.edit-form .form-horizontal .control-label{
		margin-right:10px;
		width: 20%;
	}

</style>
</div>
