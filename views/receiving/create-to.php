<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $model app\models\TrxTransactions */

$this->title = 'Create T.O';
?>
<div class="trx-transactions-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
              if (isset($createToFlag['to_success']) && count($createToFlag['to_success']) > 0) {

                foreach ($createToFlag['to_success'] as $key => $value) {
                    Alert::begin([
                        'options' => [
                            'class' => 'alert-success',
                        ],
                        'body' => $value,
                    ]);

                    Alert::end();
                }

              }

              if (isset($createToFlag['to_error']) && count($createToFlag['to_error']) > 0) {

                foreach ($createToFlag['to_error'] as $key => $value) {
                    Alert::begin([
                        'options' => [
                            'class' => 'alert-error',
                        ],
                        'body' => $value,
                    ]);

                    Alert::end();
                }

              }

              if (isset($createToFlag['error'])) {

                Alert::begin([
                    'options' => [
                        'class' => 'alert-error',
                    ],
                ]);

                echo $createToFlag['error'];

                Alert::end();
            }

              if (isset($rejectFlag['reject_success']) && count($rejectFlag['reject_success']) > 0) {

                foreach ($rejectFlag['reject_success'] as $key => $value) {
                    Alert::begin([
                        'options' => [
                            'class' => 'alert-success',
                        ],
                        'body' => $value,
                    ]);

                    Alert::end();
                }

              }

              if (isset($rejectFlag['reject_error']) && count($rejectFlag['reject_error']) > 0) {

                foreach ($rejectFlag['reject_error'] as $key => $value) {
                    Alert::begin([
                        'options' => [
                            'class' => 'alert-error',
                        ],
                        'body' => $value,
                    ]);

                    Alert::end();
                }

              }

              if (isset($rejectFlag['success'])) {

                Alert::begin([
                    'options' => [
                        'class' => 'alert-success',
                    ],
                ]);

                echo $rejectFlag['success'];

                Alert::end();
            }

              if (isset($rejectFlag['error'])) {

                Alert::begin([
                    'options' => [
                        'class' => 'alert-error',
                    ],
                ]);

                echo $rejectFlag['error'];

                Alert::end();
            }
        ?>
    </p>
    <?php
        $js = 'function beforeValidate(form) {if ( form.data("cancel") {this.validateOnSubmit = false;this.beforeValidate = "";form.submit();return false;}return true;}';
        $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => '<div class="control-group">{label}<div class="f-full-size">{input}</div><div class=\"col-lg-8\">{error}</div></div>',
        ]
    ]); ?>

    <?= GridView::widget([
        'dataProvider' => $data_provider,
        'filterModel'  => $search_model,
        'bootstrap'=>true,
		'options' => [],
		'containerOptions'=>['style'=>'overflow: auto'],
        //'responsive'   => true,
        'hover'        => true,
        'toolbar' =>  [],
        'panel' => [
                    'heading'   =>  '<h3 class="panel-title">Transaction Detail List</h3>',
                    'type'      =>  GridView::TYPE_PRIMARY,
                    'after'     =>  Html::submitButton('<i class="glyphicon glyphicon-thumbs-up"></i> Create TO', ['class'   => 'btn btn-success',
                                                                                                                   'name'    => 'create-to',
                                                                                                                   'style'   => 'margin-right: 5px !important;']) .
                                    Html::submitButton('<i class="glyphicon glyphicon-thumbs-down"></i> Reject', ['class'    => 'btn btn-danger',
                                                                                                                  'name'     => 'reject',
                                                                                                                  'style'    => 'margin-right: 5px !important;']) .
                                    Html::submitButton('<i class="glyphicon glyphicon-remove-circle"></i> Cancel', ['class'    => 'btn btn-primary',
                                                                                                                    'name'     => 'cancel',
                                                                                                                    'style'    => 'margin-right: 5px !important;'])
                ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'], // @TODO: Remove id column
            'pallet_no',
			'material_code',
            ['attribute'    =>  'material_code',
             'label'        =>  'Material Description',
             'value'        =>  function ($model) {
                                    $material = Yii::$app->modelFinder->findMaterialModel($model['material_code']);
                                    if ($material != null) {
                                        return $material->description;
                                    }
                                }
            ],
			'net_weight',
			'total_weight',
			//'quantity',
			//['attribute' => 'total_weight', 'label' => 'Net Weight/Quantity'],
			'batch',
			'expiry_date',
			'manufacturing_date',
            'status',
            // ['class' => 'yii\grid\ActionColumn',
             // 'buttons' =>
                // ['view' => function ($url, $model, $key) {
                                // return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', 'user-profile?id='.$key);
                           // },
                 // 'update' => function ($url, $model, $key) {
                                // return null;
                           // },
                 // 'delete' => function ($url, $model, $key) {
                                // return null;
                           // },
                // ]
            // ],
            'kitted_unit',
            'transaction_id',
            ['attribute'    =>  'customer_code',
             'label'        =>  'Customer Name',
             'value'        =>  function ($model) {
                                    $customer = Yii::$app->modelFinder->findCustomerModel($model['customer_code']);
                                    if ($customer != null) {
                                        return $customer->name;
                                    }
                                }
            ],
            [
                'class' => 'kartik\grid\CheckboxColumn',
                'headerOptions' => ['class'=>'kartik-sheet-style'],
                'checkboxOptions' => function ($model, $key, $index, $column) {
                                        return ['value' => $model['pallet_no']];
                                    }
            ],
        ],
    ]) ?>
<?php ActiveForm::end(); ?>
</div>

<style>
    .kv-panel-after {
        float: right;
    }
</style>
