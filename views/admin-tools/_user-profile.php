<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MstAccount */

$this->title = $model->first_name . ' ' . $model->last_name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['user-management']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="help-bg-gray">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
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
</div>
