<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\MstAccount */

$this->title = $model->first_name . ' ' . $model->last_name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['user-mgmt']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl().'/admin-tools/edit-profile?id='.$model->id ?>" class="btn btn-primary" style="float:right; position:relative; right:10px; top:-20px;">EDIT PROFILE</a>

<div class="help-bg-gray">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'account_type',
            'username',
            //'password',
            //'auth_key',
            //'access_token',
            'first_name',
            'last_name',
            'assignment',
            'start_date',
            'end_date',
            'last_login_date',
            //'status',
            //'creator_id',
            //'created_date',
            //'updater_id',
            //'updated_date',
        ],
    ]) ?>
    
    <?php 
    	$createdCount = isset($statusCount['process']) ? $statusCount['process'] : 0;
		$processedCount = isset($statusCount['closed']) ? $statusCount['closed'] : 0;
		$rejectedCount = isset($statusCount['rejected']) ? $statusCount['rejected'] : 0;
		echo Highcharts::widget([
	    'scripts' => [
	        'modules/exporting',
	        'themes/sand-signika',
	    ],
	    'options' => [
	        'title' => [
	            'text' => 'Transaction chart',
	        ],
	        'tooltip' => [
	        	'pointFormat' => '{series.name}: <b>{point.percentage:.1f}%</b>',
	        ],
	        'series' => [
	            
	            [
	                'type' => 'pie',
	                'name' => 'Total transactions',
	                'data' => [
	                    [
	                        'name' => 'Created',
	                        'y' => $createdCount,
	                        'color' => new JsExpression('Highcharts.getOptions().colors[0]'),
	                    ],
	                    [
	                        'name' => 'Processed',
	                        'y' => $processedCount,
	                        'color' => new JsExpression('Highcharts.getOptions().colors[1]'),
	                    ],
	                    [
	                        'name' => 'Rejected',
	                        'y' => $rejectedCount,
	                        'color' => new JsExpression('Highcharts.getOptions().colors[2]'),
	                    ],
	                ],
	                'showInLegend' => true,
	                'dataLabels' => [
	                    'enabled' => true,
	                ],
	            ],
	        ],
	    ]
	]);
	?>
</div>
