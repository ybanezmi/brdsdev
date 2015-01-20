<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MstAccount */

$this->title = 'Update User: ' . ' ' . $model->first_name . ' ' . $model->last_name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['user-management']];
$this->params['breadcrumbs'][] = ['label' => $model->first_name . ' ' . $model->last_name, 'url' => ['view-user', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mst-account-update">
	<div class="wrapper-150">
    	<h1 class="page-title"><?= Html::encode($this->title) ?></h1>
	
		<div class="one-column help-bg-gray pdt-one-column">
		    <?= $this->render('_user-form', [
		        'model' => $model,
		        'assignment_list' => $assignment_list,
		    ]) ?>
	    </div>
	</div>

</div>
