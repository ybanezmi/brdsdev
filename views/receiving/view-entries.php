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
            'material_code',
            'batch',
            'pallet_no',
            ['attribute'    => 'net_weight',
             'label'        => 'Quantity'],
            ['attribute'    => 'total_weight',
             'label'        => 'Net Weight'],
            'pallet_weight',
            'kitted_unit',
            'manufacturing_date',
            'expiry_date',
            'pallet_type',
            'status',
            'creator_id',
            'created_date',
            'updater_id',
            'updated_date',
        ],
    ]) ?>

</div>
