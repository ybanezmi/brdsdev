<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MstAccount */

$this->title = 'Create User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['user-management']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">
	<div class="wrapper-150">
	    <h1 class="page-title">User Profile</h1>
		
		<div class="one-column help-bg-gray pdt-one-column">
		    <?= $this->render('_user-form', [
		        'model' => $model,
		        'assignment_list' => $assignment_list,
		    ]) ?>
	    </div>
	</div>

</div>
