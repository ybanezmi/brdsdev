<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MstAccount */

$this->title = 'Weighing';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">
	<div class="wrapper-150">
	    <h1 class="page-title">Weighing and Tagging</h1>
		
		<div class="one-column help-bg-gray pdt-one-column">
		    <?= $this->render('_print-tag-form', [
		        //'model' => $model,
		        'customer_list' => $customer_list,
		    ]) ?>
	    </div>
	</div>
</div>
