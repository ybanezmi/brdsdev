<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\TrxTransactions */

$this->title = 'View Entries';
// $this->params['breadcrumbs'][] = ['label' => 'Receiving', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => 'Receiving Menu', 'url' => ['menu', 'id' => Yii::$app->request->get('id')]];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="trx-transactions-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="one-column-button pdt-one-column-button">
        <div class="submit-button ie6-submit-button">
            <?= Html::button('Back', ['class'   => 'btn btn-primary back-button',
                                      'name'    => 'back',
                                      'onclick' => ' window.history.back(); return false;',]) ?>
        </div>
    </div>

    <p>
    	<?php /*
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
		 *
		 */ ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $data_provider,
        'filterModel'  => $search_model,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'], // @TODO: Remove id column
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
            'batch',
            ['attribute'    =>  'packaging_code',
             'label'        =>  'Packaging Type',
             'value'        =>  function ($model) {
                                    if ($model['packaging_code'] != null && $model['pallet_type'] != null) {
                                        $transaction = Yii::$app->modelFinder->findTransactionModel($model['transaction_id']);
                                        if ($transaction != null) {
                                            $packagingMaterial = Yii::$app->modelFinder->getPackagingMaterial(['material_code'     =>  $model['packaging_code'],
                                                                                                                'plant_location'    =>  $transaction->plant_location,
                                                                                                                'pallet_type'       =>  $model['pallet_type']]);
                                            return $packagingMaterial->description;
                                        }
                                    }
                                }
            ],
            'pallet_no',
            ['attribute'    =>  'net_weight',
             'label'        =>  'Quantity',
             'value'        =>  function ($model) {
                                    if ($model['material_code'] != null) {
                                        $materialConversion = Yii::$app->modelFinder->findMaterialConversionModel($model['material_code']);
                                        if ($materialConversion != null) {
                                            if ($model['net_weight'] != null && $model['net_unit'] != null) {
                                                return $model['net_weight'] . ' ' . $materialConversion[$model['net_unit']];
                                            }
                                        }
                                    }

                                    if ($model['net_weight'] != null) {
                                        return $model['net_weight'] . ' KG';
                                    }
                                }
            ],
            ['attribute'    =>  'total_weight',
             'label'        =>  'Net Weight',
             'value'        =>  function ($model) {
                                    if ($model['total_weight'] != null) {
                                        return $model['total_weight'] . ' KG';
                                    }
                                }
            ],
            ['attribute'    =>  'pallet_weight',
             'value'        =>  function ($model) {
                                    if ($model['pallet_weight'] != null) {
                                        return $model['pallet_weight'] . ' KG';
                                    }
                                }
            ],
            ['attribute'    => 'manufacturing_date',
             'label'        => 'Manuf. Date',
             'value'        =>  function ($model) {
                                    if ($model['manufacturing_date'] != null) {
                                        return date('d-M-Y', strtotime($model['manufacturing_date']));
                                    }
                                }
            ],
            ['attribute'    => 'expiry_date',
             'label'        => 'Expiry Date',
             'value'        =>  function ($model) {
                                    if ($model['expiry_date'] != null) {
                                        return date('d-M-Y', strtotime($model['expiry_date']));
                                    }
                                }
            ],
            ['attribute'    =>  'kitting_code',
             'label'        =>  'Kitting Type',
             'value'        =>  function ($model) {
                                    if ($model['kitting_code'] != null && $model['kitting_type'] != null) {
                                        $transaction = Yii::$app->modelFinder->findTransactionModel($model['transaction_id']);
                                        if ($transaction != null) {
                                            $packagingMaterial = Yii::$app->modelFinder->getPackagingMaterial(['material_code'     =>  $model['kitting_code'],
                                                                                                                'plant_location'    =>  $transaction->plant_location,
                                                                                                                'pallet_type'       =>  $model['kitting_type']]);
                                            return $packagingMaterial->description;
                                        }
                                    }
                                }
            ],
            'kitted_unit',
            'status',
            ['attribute'    =>  'creator_id',
             'label'        =>  'Created by',
             'value'        =>  function($model) {
                                    if ($model['creator_id'] != null) {
                                        $account = Yii::$app->modelFinder->findAccountModel($model['creator_id']);
                                        if ($account != null) {
                                            return $account->first_name . ' ' . $account->last_name;
                                        }
                                    }
                                }
            ],
            ['attribute'    =>  'created_date',
             'value'        =>  function ($model) {
                                    if ($model['created_date'] != null) {
                                        return date('d-M-Y H:m:s', strtotime($model['created_date']));
                                    }
                                }
            ],
            ['attribute'    =>  'updater_id',
             'label'        =>  'Updated by',
             'value'        =>  function($model) {
                                    if ($model['updater_id'] != null) {
                                        $account = Yii::$app->modelFinder->findAccountModel($model['updater_id']);
                                        if ($account != null) {
                                            return $account->first_name . ' ' . $account->last_name;
                                        }
                                    }
                                }
            ],
            ['attribute'    => 'updated_date',
             'value'        =>  function ($model) {
                                    if ($model['updated_date'] != null) {
                                        return date('d-M-Y H:m:s', strtotime($model['updated_date']));
                                    }
                                }
            ],
        ],
    ]) ?>

</div>
