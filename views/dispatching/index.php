<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MstAccount */

$this->title = 'Dispatching';
?>
<div id="main-content">
	<div class="user-create">
		<div class="wrapper-150">
			<h1 class="page-title">Dispatching</h1>
			
			<div class="help-bg-gray desktop-only" style="padding:20px 0" >
				
				<?= $this->render('_dispatch-form.php', [
					'dispatch_model_1' => $dispatch_model_1,
					'dispatch_model_2' => $dispatch_model_2
				]) ?>

			</div>
		</div>
	</div>
</div>




