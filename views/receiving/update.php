<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrxTransactions */

$this->title = 'Update Trx Transactions: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Trx Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="trx-transactions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
