<?php

use yii\helpers\Html;
//use yii\jui\Tabs;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MstAccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'USER MANAGEMENT';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mst-account-index">

    <h1 class="page-title"><?= Html::encode($this->title) ?></h1>

	<?php 
		$user_assignment = $this->render('_user-assignment', [
					            'searchModel' 		=> $account_search_model,
					            'dataProvider' 		=> $account_data_provider,
					            'assignment_list'	=> $assignment_list,
					        ]);
		$register_user = $this->render('_user-form', [
						        'model' 			=> $account_model,
						        'assignment_list' 	=> $assignment_list,
						    ]);
		$user_statistics = $this->render('_user-statistics', [
						        'searchModel'	=> $account_search_model,
					            'dataProvider' 	=> $account_data_provider,
					            'statusCount'	=> $trx_details_status_count,
					            'user_list'		=> $user_list,
						    ]);
		$user_assignment_active = true;
		$user_statistics_active = false;
		if (null != Yii::$app->request->get('TrxTransactionDetailsSearch')) {
			$user_assignment_active = false;
			$user_statistics_active = true;
		}
	?>

	<?= Tabs::widget([
		'items' => [
			[
				'label' 	=> 'USER ASSIGNMENT',
				'content' 	=> $user_assignment,
				'active' 	=> $user_assignment_active,
			],
			[
				'label'		=> 'REGISTER USER',
				'content'	=> '<h2 class="page-title">User Profile</h2><div class="one-column help-bg-gray pdt-one-column">' . $register_user . '</div>'
			],
			[
				'label'		=> 'USER STATISTICS',
				'content' 	=> $user_statistics,
				'active'	=> $user_statistics_active,
			]
		],
	]); ?>
	
	

</div>
