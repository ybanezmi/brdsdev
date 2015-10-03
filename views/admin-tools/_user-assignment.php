<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use kartik\editable\Editable;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;

?>
	<?php
		$dateEditableOptions = [	'size' => 'md',
									'inputType'=>\kartik\editable\Editable::INPUT_WIDGET,
								    'widgetClass'=> 'kartik\datecontrol\DateControl',
								        'options'=>[
								            'type'=>\kartik\datecontrol\DateControl::FORMAT_DATE,
								            'saveFormat'=>'php:Y-m-d',
								            'options' => [
								                'pluginOptions' => [
								                    'keyboardNavigation' => false,
								                ],
								            ]
								        ],
								        'pluginEvents' => [
								        	'editableSuccess'=>'function(event, val) {
								        		var date = new Date(val);
												document.getElementById(this.id + "-targ").innerHTML = (date.getMonth()+1).padLeft() + "/" +
               																							date.getDate().padLeft() + "/" +
               																							date.getFullYear();
											}',
								        ]
								    ];

        $dateRangeFilterOptions = [ 'pluginOptions' => [
                                        'autoclose' => true,
                                    ],
                                    'pluginEvents'      =>
                                        ['apply.daterangepicker' =>
                                            'function() {
                                                $(".grid-view").yiiGridView("applyFilter");
                                            }',
                                        ],
                                    ];

		$gridColumns = [
        	'username',
            [	'class'				=> 'kartik\grid\EditableColumn',
			    'attribute' 		=> 'password',
			    'value' 			=> function ($model) {
			    						if ($model->password === md5(Yii::$app->params["DEFAULT_PASSWORD"])) {
			    							return "DEFAULT";
			    						} else {
			    							return "********";
			    						}
			    					},
				'editableOptions' 	=> [
							            'header' 	=> 'Password',
							            'inputType'	=> 'passwordInput',
							            'pluginEvents' => [
								        	'editableSuccess'=>'function(event, val) {
								        		if (val == "password") {
								        			document.getElementById(this.id + "-targ").innerHTML = "DEFAULT";
								        		} else {
								        			document.getElementById(this.id + "-targ").innerHTML = "********";
								        		}
											}',
								        ],
								        'options' => [
								        	'value' => '',
								        	'maxlength' => '32',
								        	'placeholder' => '********',
								        ]
							        ],
			],
            [	'class'				=> 'kartik\grid\EditableColumn',
             	'attribute' 		=> 'assignment',
             	'label'		 		=> 'Current Location',
             	'editableOptions' 	=> [
							            'header' 	=> 'Current Location',
							            'inputType'	=> 'dropDownList',
							            'data'		=> $assignment_list,
							        ],
			],
            [	'class'				=> 'kartik\grid\EditableColumn',
            	'attribute' 		=> 'start_date',
             	'label'	 			=> 'Current Start Date',
                'filterType'        => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => $dateRangeFilterOptions,
             	'value'				=> function ($model) {
             							if (null != $model->start_date) {
             								return date('m/d/Y', strtotime($model->start_date));
             							}
             						},
             	'editableOptions' => ArrayHelper::merge(['header' => 'Current Start Date'], $dateEditableOptions),
            ],
            [	'class'				=> 'kartik\grid\EditableColumn',
            	'attribute' 		=> 'end_date',
             	'label'	 			=> 'Current End Date',
                'filterType'        => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => $dateRangeFilterOptions,
             	'value'				=> function ($model) {
             							if (null != $model->end_date) {
             								return date('m/d/Y', strtotime($model->end_date));
             							}
             						},
             	'editableOptions' => ArrayHelper::merge(['header' => 'Current End Date'], $dateEditableOptions),
            ],
            [	'class'				=> 'kartik\grid\EditableColumn',
             	'attribute' 		=> 'next_assignment',
             	'label'		 		=> 'Next Location',
                'filterType'        => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => $dateRangeFilterOptions,
             	'editableOptions' 	=> [
							            'header' 	=> 'Next Location',
							            'inputType'	=> 'dropDownList',
							            'data'		=> $assignment_list,
							        ],
			],
            [	'class'				=> 'kartik\grid\EditableColumn',
            	'attribute' 		=> 'next_start_date',
             	'label'	 			=> 'Next Start Date',
             	'value'				=> function ($model) {
             							if (null != $model->next_start_date) {
             								return date('m/d/Y', strtotime($model->next_start_date));
             							}
             						},
             	'editableOptions' => ArrayHelper::merge(['header' => 'Next Start Date'], $dateEditableOptions),
            ],
            [	'class'				=> 'kartik\grid\EditableColumn',
            	'attribute' 		=> 'next_end_date',
             	'label'	 			=> 'Next End Date',
                'filterType'        => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => $dateRangeFilterOptions,
             	'value'				=> function ($model) {
             							if (null != $model->next_end_date) {
             								return date('m/d/Y', strtotime($model->next_end_date));
             							}
             						},
             	'editableOptions' => ArrayHelper::merge(['header' => 'Next End Date'], $dateEditableOptions),
            ],
            // 'last_login_date',
            // 'status',
            // 'creator_id',
            // 'created_date',
            // 'updater_id',
            // 'updated_date',
            ['class' => 'yii\grid\ActionColumn',
             'buttons' =>
		        ['view' => function ($url, $model, $key) {
						        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', 'user-profile?id='.$key);
						   },
				 'update' => function ($url, $model, $key) {
						        //return Html::a('<span class="glyphicon glyphicon-pencil"></span>', str_replace('update', 'update-user', $url));
								return null;
						   },
				 'delete' => function ($url, $model, $key) {
				 				/*
						        return Html::a('<span class="glyphicon glyphicon-trash"></span>',
						        				str_replace('delete', 'delete-user', $url),
												['data' => [
									                'confirm' => 'Are you sure you want to delete this user?',
									                'method' => 'post',
									            ]]);
								 */
								return null;
						   },
			    ]
			],
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
        'exportConfig' => [
            \kartik\grid\GridView::CSV => ['label' => 'Export CSV',
            							   'filename' => '[BRDS] User List'],
        ],
		'panel' => [
		        'type' => GridView::TYPE_PRIMARY,
		        'heading' => 'USER LIST',
		    ],
    ]);

