<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\DatePicker;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;

?>

	<div class="user-statistics-form">
    <?php 
    	$js = 'function beforeValidate(form) {if ( form.data("cancel") {this.validateOnSubmit = false;this.beforeValidate = "";form.submit();return false;}return true;}';
    	$form = ActiveForm::begin([
    	'fieldConfig' => [
    		'template' => '<div class="control-group">{label}<div class="f-inline-size">{input}</div></div>',
    	]
    ]); ?>
		<div class="one-column pdt-one-column help-bg-gray" style="width: 49%; height: 400px; float: left;">
			<div class="control-group">
				<label class="control-label-f">TRANSACTION DATE</label>
				<div class="f-full-size" style="margin-bottom: 10px;">
					<?php 	echo DatePicker::widget([
							'name'			=> 'start_date',
							'name2'			=> 'end_date',
							//'attribute'  	=> 'from_date',
		    				//'attribute2' 	=> 'to_date',
		    				'options' 		=> ['placeholder' => 'Start date'],
		    				'options2'	 	=> ['placeholder' => 'End date'],
		    				'type' => DatePicker::TYPE_RANGE,
					    	//'value'  => $value,
					    	//'language' => 'ru',
					    	//'dateFormat' => 'yyyy-MM-dd',
							]); 
					?>
				</div>
			</div>
			<!--
			<div class="control-group">
				<label class="control-label-f">USER</label>
				<div class="f-full-size">
			        <?= Html::dropDownList
			            ('user_list', null, $user_list, 
	                       ['id'        => 'customer-name',
	                        'class'	    => 'uborder help-70percent',
							'label'	    => 'User',
							'prompt'	=> '-- Select a user --',
							]);
			        ?>
				</div>
			</div>
			-->
			<table>
				<?php
					$createdCount = isset($statusCount['process']) ? $statusCount['process'] : 0;
					$processedCount = isset($statusCount['closed']) ? $statusCount['closed'] : 0;
					$rejectedCount = isset($statusCount['rejected']) ? $statusCount['rejected'] : 0;
				?>
				<tbody>
					<tr>
						<td class="control-group" style="width: 40%">
							<label class="control-label-f" style="display:inline;">CREATED</label>
						</td>
						<td>
							<?= Html::textInput('status-created', $createdCount, 
			                            ['id'		 => 'status-created',
									 	 'class'	 => 'uborder help-50percent',
									 	 'disabled'	 => 'disabled',
										]) 
			        		?>
						</td>
					</tr>
					<tr>
						<td class="control-group">
							<label class="control-label-f" style="display:inline;">PROCESSED</label>
						</td>
						<td>
							<?= Html::textInput('status-processed', $processedCount, 
			                            ['id'		 => 'status-processed',
									 	 'class'	 => 'uborder help-50percent',
									 	 'disabled'	 => 'disabled',
										]) 
			        		?>
						</td>
					</tr>
					<tr>
						<td class="control-group">
							<label class="control-label-f" style="display:inline;">REJECTED</label>
						</td>
						<td>
							<?= Html::textInput('status-rejected', $rejectedCount, 
			                            ['id'		 => 'status-rejected',
									 	 'class'	 => 'uborder help-50percent',
									 	 'disabled'	 => 'disabled',
										]) 
			        		?>
						</td>
					</tr>
				</tbody>
			</table>
	    </div>
	    <div id="chart" style="width: 50%; float: left;">
	    	<?php 
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
	    <?php ActiveForm::end(); ?>
	</div>

	<div style="float: left;">
		<?php
			$gridColumns = [
	            ['class' => 'kartik\grid\SerialColumn'], // @TODO: Remove id column
	            // 'account_type',
	            // 'first_name',
	            // 'last_name',
	            ['attribute' => 'updater_id',
	             'label'	 => 'User Name',
	             'value'	 => function($model) {
	             				$account = Yii::$app->modelFinder->findAccountModel($model->updater_id);
								if ($account) {
									return $account->first_name . ' ' . $account->last_name;
								}
							},
	             ],
	            ['attribute' => 'updated_date',
	             'label'	 => 'Date'],
	            ['attribute' => 'transaction_id',
	             'label'	 => 'Transaction'],
	            ['attribute' => 'customer_code',
	             'label'	 => 'Customer',
	             'value'	 => function($model) {
								$customer = Yii::$app->modelFinder->findCustomerModel($model->customer_code);
								if ($customer) {
									return $customer->name;
								}
	             			},
	             ],
	            ['attribute' => 'pallet_no',
	             'label'	 => 'Pallet No'],
	            [	'class'			=> 'kartik\grid\BooleanColumn',
	             	'attribute' 	=> 'status',
	             	'label'	 		=> 'Created',
	             	'trueLabel'		=> 'Yes', 
	        		'falseLabel' 	=> 'No',
	        		'vAlign'		=>'middle',
			        'value' 		=> function($model) {
			        					if (Yii::$app->params['STATUS_PROCESS'] === $model->status) {
			        						return true;
			        					}
										return false;
			        				},
	        	],
	            [	'class'			=> 'kartik\grid\BooleanColumn',
	             	'attribute' 	=> 'status',
	             	'label'	 		=> 'Processed',
	             	'trueLabel'		=> 'Yes', 
	        		'falseLabel' 	=> 'No',
	        		'vAlign'		=>'middle',
			        'value' 		=> function($model) {
			        					if (Yii::$app->params['STATUS_CLOSED'] === $model->status) {
			        						return true;
			        					}
										return false;
			        				},
	        	],
	            [	'class'			=> 'kartik\grid\BooleanColumn',
	             	'attribute' 	=> 'status',
	             	'label'	 		=> 'Rejected',
	             	'trueLabel'		=> 'Yes', 
	        		'falseLabel' 	=> 'No',
	        		'vAlign'		=>'middle',
			        'value' 		=> function($model) {
			        					if (Yii::$app->params['STATUS_REJECTED'] === $model->status) {
			        						return true;
			        					}
										return false;
			        				},
	        	],        	
	            // 'last_login_date',
	            // 'status',
	            // 'creator_id',
	            // 'created_date',
	            // 'updater_id',
	            // 'updated_date',
	        ];
		?>
	
	    <?= GridView::widget([
	        'dataProvider' => $dataProvider,
	        'filterModel' => $searchModel,
	        'columns' => $gridColumns,
	        'responsive' => true,
	        // set your toolbar
		    'toolbar' =>  [
		        '{export}',
		    ],
		    // set export properties
		    'export' => [
		        'fontAwesome' => true
		    ],
	        'exportConfig' => [
	        	\kartik\grid\GridView::CSV => ['label' => 'Export CSV',
	        								   'filename' => '[BRDS] Transaction  Details List'],
	        ],
	        'panel' => [
			        'type' => GridView::TYPE_PRIMARY,
			        'heading' => 'TRANSACTION DETAILS LIST',
			    ],
	        /*
	        'layout' => '{summary}<div class="pull-right">{export}&nbsp</div><div>{items}</div>{pager}',
	            'exportConfig' => [
	                \kartik\grid\GridView::CSV => ['label' => 'Export CSV'],
	            ],
			 */
	    ]); ?>
    </div>
