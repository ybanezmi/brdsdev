<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'BIGBLUE Receiving Dispatch System - Successful Site';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([
        'id' => 'successful',
    ]); ?>
	<div class="login-logo png_bg"></div>
	<div class="info-box">
	    <p class="help-textcenter timelog"><?php echo date('m/d/Y H:i A', strtotime($model->last_login_date)) ?></p>
	    <div>
	    	<p>Welcome:  <b><?php echo "$model->first_name $model->last_name" ?></b></p>
	    	<p>You currently assign to:  <b><?php echo $model->assignment ?></b></p>
		</div>
	</div>
	<div class="info-box-2">
	    <p class="help-textcenter"><b>Please Verify</b></p>
	    <div class="successfully-button">
	    	<?= Html::submitButton('Confirm', ['class' => 'btn btn-primary successful-confirm', 'name' => 'confirm']) ?>
	    	<?= Html::submitButton('Abort', ['class' => 'btn btn-primary successful-abort', 'name' => 'abort']) ?>
		</div>
	</div>
<?php ActiveForm::end(); ?>
