<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'BIGBLUE Receiving Dispatch System - Login Site';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="login-logo png_bg"></div>

<div class="form-box">
	<?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'fieldConfig' => [
            //'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            //'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

	<?= $form->field($model, 'username',
					 ['inputOptions' => ['placeholder' => 'username']]) ?>

	<?= $form->field($model, 'password',
					 ['inputOptions' => ['placeholder' => 'password']])->passwordInput() ?>

	<div class="login-opt">
    	<div class="login-button">
    		<?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
    	</div>
    	<div class="forgot">
    		<?= Html::a('Forgot password?', '#forgotpassword', ['data-toggle' => 'modal']) ?>
    	</div>
    </div>

	<?php ActiveForm::end(); ?>
</div>
