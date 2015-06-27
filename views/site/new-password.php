<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;

$this->title = 'Change Password';

?>
<div class="login-logo png_bg"></div>
<div class="form-box">
	<h1 class="page-title">Change Password</h1>
	<?php
    	$js = 'function beforeValidate(form) {if ( form.data("cancel") {this.validateOnSubmit = false;this.beforeValidate = "";form.submit();return false;}return true;}';
    	$form = ActiveForm::begin([
            'id' => 'login-form',
            'fieldConfig' => [
                'template' => '<div class="control-group">{label}<div class="f-inline-size">{input}</div><div class=\"col-lg-8\">{error}</div></div>',
            ],
    ]); ?>

		<?= $form->field($model, 'newPassword')->textInput(['maxlength' => 32,
										  	   			 'class' => 'uborder'])->label('New Password', ['class' => 'control-label-f'])->passwordInput() ?>

		<?= $form->field($model, 'confirmNewPassword')->textInput(['maxlength' => 32,
										  	   			 'class' => 'uborder'])->label('Confirm New Password', ['class' => 'control-label-f'])->passwordInput() ?>

    	<div class="one-column-button pdt-one-column-button">
			<div class="submit-button ie6-submit-button">
        		<?= Html::submitButton('Proceed', ['class' => 'btn btn-primary',
												'name'  => 'submit']) ?>
        	</div>
        </div>
    
    <?php ActiveForm::end(); ?>
</div>