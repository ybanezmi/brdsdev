<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $transaction_model app\models\TrxTransactions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="receiving_menu-form">
    <?php
        $js = 'function beforeValidate(form) {if ( form.data("cancel") {this.validateOnSubmit = false;this.beforeValidate = "";form.submit();return false;}return true;}';
        $form = ActiveForm::begin([
            'options' => ['class' => 'form-horizontal']
           ]); ?>

    <div class="col-1 help-bg-gray">
        <h2 class="legend" id="transaction-header" onclick="_toggleshow('toggle-div-1')">Transaction Header</h2>
        <div id="toggle-div-1">

                <?= $form->field($customer_model, 'name',
                        ['inputOptions' => ['class' => 'text-view uborder help-100percent'],
                         'options'       => ['style' => 'margin-bottom: 0']])->textInput(['disabled' => 'disabled'])->label(false) ?>
                <?= $form->field($customer_model, 'code',
                        ['inputOptions' => ['class' => 'text-view uborder help-100percent'],
                         'options'       => ['style' => 'margin-bottom: 0']])->textInput(['disabled' => 'disabled'])->label(false) ?>


        <?= $form->field($transaction_model, 'created_date')->textInput(['value'    => date('m/d/Y', strtotime($transaction_model->created_date)),
                                                                          'disabled' => 'disabled',
                                                                          'class'     => 'uborder disabled help-25percent'])->label('DATE') ?>

        <?= $form->field($transaction_model, 'id')->textInput(['disabled' => 'disabled',
                                                                  'class'      => 'uborder disabled help-40percent'])->label('BRDS ID #') ?>

        <?= $form->field($transaction_model, 'sap_no')->textInput(['disabled' => 'disabled',
                                                                         'class'      => 'uborder disabled help-40percent'])->label('SAP #') ?>

        <?= $form->field($transaction_model, 'plant_location')->textInput(['disabled' => 'disabled',
                                                                                'class'      => 'uborder disabled help-25percent'])->label('WAREHOUSE') ?>

        <?= $form->field($transaction_model, 'storage_location')->textInput(['disabled' => 'disabled',
                                                                                  'class'      => 'uborder disabled help-25percent'])->label('S. LOC') ?>

        <?= $form->field($transaction_model, 'truck_van',
                ['inputOptions' => ['class'     => 'uborder disabled help-25percent',
                                    'disabled'     => 'disabled'],
                 'template'     => '<div class="control-group">{label}<div class="f-inline-size">{input}
                                     <button class="btn btn-primary help-25percent" type="button" onclick="alert(\''.$transaction_model->remarks.'\')">Remarks</button>
                                     </div><div class=\"col-lg-8\">{error}</div></div>'
                ])
                ->textInput(['maxlength' => 10])->label('T.PLATE #') ?>

        <?php
            Modal::begin([
                'header'         => '<h2>Remarks</h2>',
                'id'             => 'remarks',
                'closeButton'    => ['tag'     => 'button',
                                    'label' => '×'],
            ]);

            echo $transaction_model->remarks;

            Modal::end();
        ?>

        <?= $form->field($transaction_model, 'pallet_count',
                ['inputOptions' => ['class'     => 'disabled uborder help-25percent',
                                    'disabled'     => 'disabled',
                                    'value'        => $pallet_count],
                 'template'     => '<div class="control-group">{label}<div class="f-inline-size">{input} PP
                                     <button type="submit" class="btn btn-primary help-25percent" name="view-entries">View</button>
                                     </div><div class=\"col-lg-8\">{error}</div></div>'
                ])->textInput(['maxlength' => 10])->label('# Pallet(s)') ?>

        <?= $form->field($transaction_model, 'weight',
                ['inputOptions' => ['class' => 'disabled uborder help-25percent'],
                 'template' => '<div class="control-group">{label}<div class="f-inline-size" >{input} KG</div><div class=\"col-lg-8\">{error}</div></div>'
                ])->textInput(['maxlength' => 10,
                               'disabled'  => 'disabled',
                               'value'       => $total_weight])->label('Total WT') ?>

        </div>
    </div>

    <div id="trx-details-panel" class="col-2 help-bg-gray" style="display: block;">
        <h2 class="legend" id="transaction-details" onclick="_toggleshow('toggle-div-2')">Transaction Details</h2>
        <div id="toggle-div-2">

        <?= $form->field($transaction_detail_model, 'material_code',
            ['template' => '<div class="control-group">{label}<div class="f-full-size">{input}</div></div>'])
            ->dropDownList($material_list, ['class'    => 'uborder help-70percent',
                                            'prompt'    => '-- Select a product --',
                                            'onchange'    => 'onSelectMaterial()'])->label('Customer Product',['class' => 'control-label-f']); ?>

        <div class="control-group">
                    <div class="f-full-size ie6-padtop">
                                <?= Html::textInput('material_code', '', ['id'         => 'material_code',
                                                  'readonly' => 'readonly',
                                                  'class'     => 'uborder disabled help-44percent']) ?>


        <?= Html::textInput('material_barcode', '', ['id'         => 'material_barcode',
                                                          'class'     => 'uborder help-44percent',
                                                          'onchange'  => 'searchMaterial(this.value)']) ?>
                    </div>
                  </div>






        <?= $form->field($transaction_detail_model, 'batch',
                ['inputOptions' => ['class' => 'uborder help-25percent'],
                 'template' => '<div class="control-group">{label}
                                    <div class="f-inline-size">{input}
                                    <button class="btn btn-primary help-15percent"
                                        onclick="setFieldValueById(&quot;trxtransactiondetails-batch&quot;,getTimestamp());"
                                        type="button">INT</button>
                                    </div>
                                    <div class=\"col-lg-8\">{error}</div>
                                </div>',
                 ])->textInput(['maxlength' => 10])->label('Batch / Lot') ?>



        <?= $form->field($transaction_detail_model,'manufacturing_date')->widget(DatePicker::className(),[
                                                                                                            'language' => 'en-GB',


                                                                                                          'clientOptions'      => ['dateFormat'     => 'dd-M-yy',
                                                                                                                                    'showOn'        => 'button',
                                                                                                                                 'buttonImage'  => '../images/calendar.gif',
                                                                                                                                 'buttonImageOnly' => 'true',
                                                                                                                                 ],
                                                                                                           'options'          => ['class'         => 'uborder disabled help-25percent dateclass',
                                                                                                                                    'readonly'        => 'readonly',
                                                                                                                                    'dateFormat'     => 'dd-M-yy',
                                                                                                                                    'onchange'        => 'checkMaterialSled()']])->label('Manuf Date') ?>



        <?= $form->field($transaction_detail_model,'expiry_date')->widget(DatePicker::className(),[
                                                                                                    'language' => 'en-GB',

                                                                                                    'clientOptions'      => ['dateFormat'         => 'dd-M-yy',
                                                                                                                            'showOn'            => 'button',
                                                                                                                         'buttonImage'      => '../images/calendar.gif',
                                                                                                                         'buttonImageOnly'     => 'true'],
                                                                                                'options'              => ['class'             => 'uborder disabled help-25percent dateclass',
                                                                                                                         'onchange'         => 'checkMaterialSled()',
                                                                                                                            'readonly'            => 'readonly',
                                                                                                                            'dateFormat'         => 'm/dd/yy']])->label('Expiry Date') ?>

        <?= $form->field($transaction_detail_model, 'net_weight',
                ['inputOptions' => ['class' => 'uborder help-25percent',
                                    'onchange' => 'calculateTotalWeight()'],
                 'template' => '<div class="control-group">{label}<div class="f-inline-size" id="net-wt">{input} <span id="net-unit">KG</span></div><div class=\"col-lg-8\">{error}</div></div> ',
                 'labelOptions' => ['id' => 'net-weight',
                                    'class' => 'control-label',],
                ])->textInput(['maxlength' => 10])->label('Net WT') ?>

        <?= $form->field($transaction_detail_model, 'total_weight',
                ['inputOptions' => ['class' => 'uborder disabled help-25percent totalweight',
                                    'readonly' => 'readonly'],
                 'template' => '<div class="control-group">{label}<div class="f-inline-size">{input} KG</div><div class=\"col-lg-8\">{error}</div></div>'
                ])->textInput(['maxlength' => 10])->label('Total WT') ?>
        <?php
            // retrieve post pallet_no
            // @TODO: fix pallet_no default value during post error
            if (null != Yii::$app->request->post('TrxTransactionDetails[pallet_no]')) {
                $pallet_no = Yii::$app->request->post('TrxTransactionDetails[pallet_no]');
            }
        ?>

        <?= $form->field($transaction_detail_model, 'packaging_code')
                    ->dropDownList($packaging_type_list, ['class'    => 'uborder help-70percent',
                                                    'style' => 'font-size: 16px',
                                                    'value'       => Yii::$app->request->post('TrxTransactionDetails[pallet_type]')])->label('PACKAGING TYPE'); ?>
        <?= $form->field($transaction_detail_model, 'pallet_no',
                ['inputOptions' => ['class' => 'uborder help-25percent',
                                    'value' => $pallet_no,
                                    'style' => 'font-size: 16px',
                                    'onchange' => 'checkTransactionKittedUnit();
                                                   checkTransactionPalletWeight();
                                                   checkTransactionPalletType();
                                                   validateTransactionPalletType();
                                                   '],
                 'labelOptions' => ['class' => 'control-label',
                    'style' => 'font-size: 16px',],
                 ])->textInput(['maxlength' => 10])->label('Pallet #') ?>


        <?= $form->field($transaction_detail_model, 'kitting_code')
                    ->dropDownList($kitting_type_list, ['class'    => 'uborder help-70percent',
                                                    'style' => 'font-size: 16px',
                                                    'prompt'    => '-- Select a kitting type --',
                                                    'value'    => Yii::$app->request->post('TrxTransactionDetails[kitting_type]'),
                                                    'onchange'  => 'validateTransactionPalletType();'])->label('KITTING TYPE'); ?>
        <?= $form->field($transaction_detail_model, 'kitted_unit',
                ['inputOptions' => ['class' => 'uborder help-25percent'],
                'labelOptions' => ['class' => 'control-label',
                    'style' => 'font-size: 16px']])->textInput(['maxlength' => 10])->label('Kitting #') ?>

        <?= $form->field($transaction_detail_model, 'pallet_weight',
                ['inputOptions' => ['class' => 'uborder disabled help-25percent',
                                    'readonly' => 'readonly',
                                    'value' => '0.000'],
                 'template' => '<div class="control-group">{label}<div class="f-inline-size">{input} KG </div><div class=\"col-lg-8\">{error}</div></div>'
                ])->textInput(['maxlength' => 10])->label('Pallet WT') ?>
        </div>
    </div>

    <div id="close-pallet-panel" class="col-2 help-bg-gray" style="display: none;">
        <h2 class="legend">Close Pallet</h2>

        <div class="control-group">
            <label class="control-label" for="close-pallet-no">Enter Pallet #:</label>
            <div class="f-inline-size">
                <?= Html::textInput('close_pallet_no', '', ['id'         => 'close-pallet-no',
                                                                 'class'          => 'uborder help-40percent',
                                                                 'maxlength' => 10,]) ?>
            </div>
        </div>

        <?= Html::submitButton('Use Pallet', ['class'     => 'btn btn-success',
                                              'name'    => 'close-pallet']) ?>
        <?= Html::button('Cancel', ['class'     => 'btn btn-success',
                                    'onclick'     => 'hideHTMLById("close-pallet-panel");
                                                      showHTMLById("trx-details-panel");']) ?>
    </div>

    <div class="two-column-button pdt-two-column-button">
    <div class="submit-button ie6-submit-button">
        <?= Html::submitButton('Add to Pallet', ['class'     => 'btn btn-primary',
                                                       'name'        => 'add-pallet']) ?>
            <?= Html::button('Close Pallet', ['class'     => 'btn btn-primary',
                                              'onclick' => 'hideHTMLById("trx-details-panel");
                                                              showHTMLById("close-pallet-panel");']) ?>

    </div>
    <div class="submit-button ie6-submit-button">
        <?= Html::submitButton('View Entries', ['class'     => 'btn btn-primary',
                                                       'name'        => 'view-entries',
                                                       'onclick'    => 'js: window.location = "view-entries?id='.$transaction_model->id.'"']) ?>
            <?= Html::submitButton('Cancel', ['class'             => 'btn btn-primary',
                                                'name'              => 'cancel',
                                                'onclick'            => 'js: window.location = "index"']) ?>
    </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
var net_weight = document.getElementById("trxtransactiondetails-net_weight");
var pallet_no = document.getElementById("trxtransactiondetails-pallet_no");
net_weight.addEventListener("blur", catchWeight, true);
pallet_no.addEventListener("blur", catchWeight, true);

function catchWeight() {
    if (parseInt(getFieldValueById("trxtransactiondetails-pallet_weight")) > 1000 ) {
        alert('The weight exceeds the maximum allowed.');
        setFieldValueById("trxtransactiondetails-net_weight", 0, true);
    }
}

</script>
