<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TrxTransactions */

$this->title = 'Create Receiving';
?>

<div id="main-content">
	<div class="create-receiving">
		<div class="wrapper-150">
			<h1 class="page-title">Create Receiving</h1>
			<div class="one-column help-bg-gray pdt-one-column" >
			    <?= $this->render('_create-form', [
			        'model' => $model,
			        'customer_list' => $customer_list,
			        'plant_list' => $plant_list,
                    'storage_list' => $storage_list,
			    ]) ?>
			</div>
		</div>
	</div>
</div>
