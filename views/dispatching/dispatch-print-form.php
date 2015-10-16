<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\MstAccount */
$this->title = 'Print Dispatching';
header('Cache-Control: no cache'); //no cache
session_cache_limiter('private_no_expire'); // works
?>

<style type="text/css">
.breadcrumbs{
	font-size:15px;
}
.breadcrumbs a{

}
</style>

<div id="main-content">
	<div class="user-create">
		<div class="wrapper-150">
			<h1 class="page-title">Dispatching</h1>
			<p class="breadcrumbs"><a href="<?php echo Url::home() ?>dispatching/index">Back to Search Dispatch</a> &raquo; Search Result: </p>
			<div class="desktop-only" style="padding:20px 0" >
				<?= $this->render('_print-form.php', [
					'dispatch_model_1' => $dispatch_model_1,
					'dispatch_model_2' => $dispatch_model_2,
					'dispatch_model_3' => $dispatch_model_3,
					'full_dispatch_id' => $full_dispatch_id,
					'sap_dispatch' => $sap_dispatch
				]) ?>

			</div>
		</div>
	</div>
</div>




