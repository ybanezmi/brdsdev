<?php
/* @var $this yii\web\View */

$this->title = 'Change Password';

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;

?>
<div id="main-content">
	<div class="change-password">
		<div class="wrapper-150">
			<h1 class="page-title">Change Password</h1>
			<?php
				if ($success) {
					Alert::begin([
					    'options' => [
					        'class' => 'alert-success',
					    ],
					]);
					
					echo 'Password changed successfully.';
					
					Alert::end();
				}
			?>
			<div class="one-column help-bg-gray pdt-one-column" >
				<?php 
			    	$js = 'function beforeValidate(form) {if ( form.data("cancel") {this.validateOnSubmit = false;this.beforeValidate = "";form.submit();return false;}return true;}';
			    	$form = ActiveForm::begin([
			    	'options' => ['class' => 'form-horizontal'],
			    	'fieldConfig' => [
			    		'template' => '<div class="control-group">{label}<div class="f-inline-size">{input}</div><div class=\"col-lg-8\">{error}</div></div>',
			    	],
			    ]); ?>
			    
			    	<?= $form->field($model, 'oldPassword')->textInput(['maxlength' => 32,
													  	   			 'class' => 'uborder help-40percent'])->label('Old Password')->passwordInput() ?>
					
					<?= $form->field($model, 'newPassword')->textInput(['maxlength' => 32,
													  	   			 'class' => 'uborder help-40percent'])->label('New Password')->passwordInput() ?>
													  	   			 
					<?= $form->field($model, 'confirmNewPassword')->textInput(['maxlength' => 32,
													  	   			 'class' => 'uborder help-40percent'])->label('Confirm New Password')->passwordInput() ?>
			    	
			    	<div class="one-column-button pdt-one-column-button">
						<div class="submit-button ie6-submit-button">
			        		<?= Html::submitButton('Save', ['class' => 'btn btn-primary',
															'name'  => 'submit']) ?>
			        	</div>
			        </div>
        
			    <?php ActiveForm::end(); ?>
			</div>
		</div>
	</div>
</div>