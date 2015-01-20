<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TrxTransactions */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Trx Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trx-transactions-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'transaction_id',
            'inbound_no',
            'plant_location_id',
            'customer_id',
            'material_id',
            'material',
            'quantity',
            'unit',
            'weight',
            'batch',
            'manufacturing_date',
            'expiry_date',
            'type',
            'packaging_id',
            'pallet_no',
            'lower_hu',
            'remarks',
            'truck_van',
            'status',
            'creator_id',
            'created_date',
            'updater_id',
            'updated_date',
        ],
    ]) ?>

</div>
