<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\bootstrap\Modal;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $transaction_model app\models\TrxTransactions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="receiving_menu-form">
    <?php
        $js = 'function beforeValidate(form) {if ( form.data("cancel") ) {this.validateOnSubmit = false;this.beforeValidate = "";form.submit();return false;}return true;}';
        $form = ActiveForm::begin([
            'options' => ['class' => 'form-horizontal'],
            'validateOnSubmit' => true,
            'enableClientValidation' => false,
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


        <?= $form->field($transaction_model, 'actual_gr_date')->textInput(['value'    => date('m/d/Y', strtotime($transaction_model->actual_gr_date)),
                                                                          'disabled' => 'disabled',
                                                                          'class'     => 'uborder disabled help-25percent'])->label('DATE') ?>

        <?= $form->field($transaction_model, 'id')->textInput(['disabled' => 'disabled',
                                                                  'class'      => 'uborder disabled help-40percent'])->label('BRDS ID #') ?>

        <?= $form->field($transaction_model, 'sap_no')->textInput(['disabled' => 'disabled',
                                                                         'class'      => 'uborder disabled help-40percent'])->label('SAP #') ?>

        <?= $form->field($transaction_model, 'plant_location')->textInput(['disabled' => 'disabled',
                                                                                'class'      => 'uborder disabled help-25percent'])->label('WAREHOUSE') ?>

        <?= $form->field($transaction_model, 'storage_location')->textInput(['disabled' => 'disabled',
                                                                                  'class'      => 'uborder disabled help-25percent'])->label('STORAGE LOCATION') ?>

        <?= $form->field($transaction_model, 'truck_van',
                ['inputOptions' => ['class'     => 'uborder disabled help-30percent',
                                    'disabled'     => 'disabled'],
                 'template'     => '<div class="control-group">{label}<div class="f-inline-size">{input}
                                     <button class="btn btn-primary help-25percent" type="button" onclick="alert(\''.$transaction_model->remarks.'\')">Remarks</button>
                                     </div><div class=\"col-lg-8\">{error}</div></div>'
                ])
                ->textInput(['maxlength' => 10])->label('TRUCK PLATE NUMBER') ?>

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
                                     <button type="button" class="btn btn-primary help-25percent" name="view-entries" onclick="js: window.location = &quot;view-entries?id='.$transaction_model->id.'&quot;">View</button>
                                     </div><div class=\"col-lg-8\">{error}</div></div>'
                ])->textInput(['maxlength' => 10])->label('NUMBER OF Pallet(s)') ?>

        <?= $form->field($transaction_model, 'weight',
                ['inputOptions' => ['class' => 'disabled uborder help-25percent'],
                 'template' => '<div class="control-group">{label}<div class="f-inline-size" >{input} KG</div><div class=\"col-lg-8\">{error}</div></div>'
                ])->textInput(['maxlength' => 10,
                               'disabled'  => 'disabled',
                               'value'       => $total_weight])->label('Total WEIGHT') ?>

        </div>
    </div>

    <div id="trx-details-panel" class="col-2 help-bg-gray" style="display: block;">
        <h2 class="legend" id="transaction-details" onclick="_toggleshow('toggle-div-2')">Transaction Details</h2>
        <div id="toggle-div-2">

		<?php $material_code_val = ''; if (isset($_GET['material_code'])) { $material_code_val = $_GET['material_code']; }?>

        <?= $form->field($transaction_detail_model, 'material_code',
            ['template' => '<div class="control-group">{label}<div class="f-full-size">{input}</div></div>'])
            ->dropDownList($material_list, ['class'    => 'uborder help-100percent',
											'style' => 'font-family: consolas;',
                                            'prompt'    => '-- Select a product --',
                                            'options'	=> [$material_code_val => ['Selected' => 'selected']],
                                            'onchange'    => 'onSelectMaterial();
                                                              validatePalletType(getFieldValueById("trxtransactiondetails-pallet_no"),
                                                                this.value);'])->label('Customer Product',['class' => 'control-label-f']); ?>

        <div class="control-group">
            <div class="f-full-size ie6-padtop">
                <?= Html::textInput('material_code', '', ['id'          => 'material_code',
                                                          'readonly'    => 'readonly',
                                                          'class'       => 'uborder disabled help-30percent']) ?>

                <?= Html::textInput('material_barcode', '', ['id'       => 'material_barcode',
                                                             'class'    => 'uborder help-50percent',
                                                             'onchange' => 'searchMaterial(this.value, customer_code, "trxtransactiondetails-material_code")']) ?>

                <?= Html::button('Scan', ['class'   => 'btn btn-primary help-15percent',
                                          'onclick' => 'scanPalletBarcode("material_barcode", "trxtransactiondetails-net_weight")']) ?>
            </div>
        </div>

        <?= $form->field($transaction_detail_model, 'batch',
                ['inputOptions' => ['class' => 'uborder help-25percent batch-text-input',
                                    'onchange' => 'setFieldValueToUpperCaseById("trxtransactiondetails-batch");
                                                   populateManufacturingExpiryDateFromBatch(this.value, getFieldValueById("material_code"));'],
                 'template' => '<div class="control-group" id="batch-text">{label}
                                    <div class="f-inline-size">{input}
                                    <button class="btn btn-primary help-15percent"
                                        onclick="setFieldValueById(&quot;trxtransactiondetails-batch&quot;,getTimestamp());"
                                        type="button">INT</button>
                                    <button id="btn-use" class="btn btn-primary help-15percent"
                                        onclick="toggleUse(this.id);"
                                        style="display: none;"
                                        type="button">USE</button>
                                    </div>
                                    <div class=\"col-lg-8\">{error}</div>
                                </div>',
                 ])->textInput(['maxlength' => 10])->label('Batch / Lot') ?>

        <?= $form->field($transaction_detail_model, 'batch',
                ['inputOptions' => ['class' => 'uborder help-25percent batch-dropdown-input',
                                    'onchange' => 'populateManufacturingExpiryDateFromBatch(this.value, getFieldValueById("material_code"));',
                                    'disabled' => 'disabled',],
                 'template' => '<div class="control-group" id="batch-dropdown" style="display: none;">{label}
                                    <div class="f-inline-size">{input}
                                    <button id="btn-use-cancel" class="btn btn-primary help-15percent"
                                        onclick="toggleUse(this.id);"
                                        style="display: none;"
                                        type="button">CANCEL</button>
                                    </div>
                                    <div class=\"col-lg-8\">{error}</div>
                                </div>',])->dropDownList([])->label('Batch / Lot') ?>

        <?= $form->field($transaction_detail_model,'manufacturing_date')->widget(DatePicker::className(),['language'        => 'en-GB',
                                                                                                          'clientOptions'   => ['dateFormat'        => 'dd-M-yy',
                                                                                                                                'showOn'            => 'button',
                                                                                                                                'buttonImage'       => '../images/calendar.gif',
                                                                                                                                'buttonImageOnly'   => 'true',
                                                                                                                                'maxDate'           => '0',
                                                                                                                               ],
                                                                                                          'options'         => ['class'             => 'uborder disabled help-25percent dateclass',
                                                                                                                                'readonly'          => 'readonly',
                                                                                                                                'dateFormat'        => 'dd-M-yy',
                                                                                                                                'onchange'          => 'checkMaterialSled("manufacturing_date")']])->label('Manuf Date') ?>



        <?= $form->field($transaction_detail_model,'expiry_date')->widget(DatePicker::className(),[
                                                                                                    'language' => 'en-GB',

                                                                                                    'clientOptions'      => ['dateFormat'         => 'dd-M-yy',
                                                                                                                            'showOn'            => 'button',
                                                                                                                         'buttonImage'      => '../images/calendar.gif',
                                                                                                                         'buttonImageOnly'     => 'true'],
                                                                                                'options'              => ['class'             => 'uborder disabled help-25percent dateclass',
                                                                                                                         'onchange'         => 'checkMaterialSled("expiry_date")',
                                                                                                                            'readonly'            => 'readonly',
                                                                                                                            'dateFormat'         => 'm/dd/yy']])->label('Expiry Date') ?>

        <?= $form->field($transaction_detail_model, 'net_weight',
                ['inputOptions' => ['class' => 'uborder help-25percent',
                                    'onchange' => 'calculateTotalWeight()'],
                 'template' => '<div class="control-group">{label}<div class="f-inline-size" id="net-wt">{input} <span id="net-unit">KG</span></div><div class=\"col-lg-8\">{error}</div></div> ',
                 'labelOptions' => ['id' => 'net-weight',
                                    'class' => 'control-label',],
                ])->textInput(['maxlength' => 10])->label('Net WeighT') ?>

        <?= $form->field($transaction_detail_model, 'total_weight',
                ['inputOptions' => ['class' => 'uborder disabled help-25percent totalweight',
                                    'readonly' => 'readonly'],
                 'template' => '<div class="control-group">{label}<div class="f-inline-size">{input} KG</div><div class=\"col-lg-8\">{error}</div></div>'
                ])->textInput(['maxlength' => 10])->label('Total WeighT') ?>
        <?php
            // retrieve post pallet_no
            // @TODO: fix pallet_no default value during post error
            if (null != Yii::$app->request->post('TrxTransactionDetails[pallet_no]')) {
                $pallet_no = Yii::$app->request->post('TrxTransactionDetails[pallet_no]');
            }
        ?>

        <?= $form->field($transaction_detail_model, 'packaging_code')
                    ->dropDownList($packaging_type_list, ['class'    => 'uborder help-60percent',
                                                    'style' => 'font-size: 16px',
                                                    'value'       => Yii::$app->request->post('TrxTransactionDetails[pallet_type]')])->label('PACKAGING TYPE'); ?>
        <?= $form->field($transaction_detail_model, 'pallet_no',
                ['inputOptions' => ['class' => 'uborder help-25percent',
                                    'value' => $pallet_no,
                                    'style' => 'font-size: 16px',
                                    'onchange' => 'validatePalletType(this.value, getFieldValueById("material_code"), getFieldValueById("trxtransactions-id"));'],
                 'labelOptions' => ['class' => 'control-label',
                    'style' => 'font-size: 16px',],
                 ])->textInput(['maxlength' => 10])->label('Pallet Number') ?>

        <?= $form->field($transaction_detail_model, 'kitting_code')
                    ->dropDownList($kitting_type_list, ['class'    => 'uborder help-60percent',
                                                    'style' => 'font-size: 16px',
                                                    'prompt'    => '-- Select a kitting type --',
                                                    'value'    => Yii::$app->request->post('TrxTransactionDetails[kitting_type]'),
                                                    'onchange'  => 'validateTransactionPalletType();'])->label('KITTING TYPE'); ?>
        <?= $form->field($transaction_detail_model, 'kitted_unit',
                ['inputOptions' => ['class' => 'uborder help-25percent'],
                'labelOptions' => ['class' => 'control-label',
                    'style' => 'font-size: 16px',
                    ]])->textInput(['maxlength' => 10,
                                    'onchange'  => 'validateKittingType(this.value, getFieldValueById("material_code"), getFieldValueById("trxtransactions-id"));'])->label('Kitting Number') ?>

        <?= $form->field($transaction_detail_model, 'pallet_weight',
                ['inputOptions' => ['class' => 'uborder disabled help-25percent',
                                    'readonly' => 'readonly',
                                    'value' => '0.000'],
                 'template' => '<div class="control-group">{label}<div class="f-inline-size">{input} KG </div><div class=\"col-lg-8\">{error}</div></div>'
                ])->textInput(['maxlength' => 10])->label('Pallet WeighT') ?>
        </div>
    </div>

    <div class="two-column-button pdt-two-column-button">
    <div class="submit-button ie6-submit-button">
        <?= Html::submitButton('Add to Pallet', ['class'     => 'btn btn-primary',
                                                       'name'        => 'add-pallet']) ?>
        <button href="#closepallet" data-toggle="modal" class="btn btn-primary">Close Pallet</button>
    </div>
    <div class="submit-button ie6-submit-button">
        <?= Html::button('View Entries', ['class'     => 'btn btn-primary',
                                                       'name'        => 'view-entries',
                                                       'onclick'    => 'js: window.location = "view-entries?id='.$transaction_model->id.'"']) ?>
            <?= Html::button('Cancel', ['class'             => 'btn btn-primary',
                                                'name'              => 'cancel',
                                                'onclick'            => 'js: window.location = "index"']) ?>
    </div>
    </div>

    <!-- Close Pallet -->
    <div style="height:275px" id="closepallet" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel" class="header-popup">Close Pallet</h3>
        </div>
        <div class="modal-body">
            <?php
                if (isset($_GET['closePalletFlag'])) {
                    Alert::begin([
                        'options' => [
                            'class' => 'alert-success',
                        ],
                    ]);
                    echo 'Pallet #' . $_GET['closePalletNo'] . ' successfully closed.';

                    Alert::end();
                }

                if (isset($_GET['closePalletError'])) {
                    Alert::begin([
                        'options' => [
                            'class' => 'alert-error',
                        ],
                    ]);
                    echo 'Failed to close pallet. Please enter pallet no.';

                    Alert::end();
                }
            ?>
            <h4>Scan Pallet to Process</h4>
            <div class="control-group">
                <?= Html::textInput('close_pallet_no', '', ['id'         => 'close-pallet-no',
                                                            'class'      => 'uborder help-40percent',
                                                            'maxlength'  => 10]) ?>
                <?= Html::submitButton('Use Pallet', ['class'   => 'btn btn-success',
                                                      'name'    => 'close-pallet']) ?>
            </div>
        </div>
        <div class="modal-footer">
            <?= Html::submitButton('Bulk Close Pallet', ['class' => 'btn btn-primary',
                                                         'name'  => 'bulk-close-pallet']) ?>
            <?php ActiveForm::end(); ?>
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
    </div>
</div>

<script type="text/javascript">
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

window.onload=function() {
    onSelectMaterial(true);
    validatePalletType(getFieldValueById("trxtransactiondetails-pallet_no"), getFieldValueById("trxtransactiondetails-material_code"), getFieldValueById("trxtransactions-id"));
}
setTimeout(function(){calculateTotalWeight();checkMaterialSled("expiry_date");},1000);

</script>

<?php if (isset($_GET['closePalletFlag']) || isset($_GET['closePalletError'])) { ?>
    <script type="text/javascript">
        window.onload=function() {
            $('#closepallet').modal('show');
        }
    </script>
<?php } ?>
