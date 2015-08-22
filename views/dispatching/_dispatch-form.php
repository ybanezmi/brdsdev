<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

use app\models\DispatchModel;
/* @var $this yii\web\View */
/* @var $model app\models\MstAccount */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dispatch-form">
    <?php 
        $js = 'function beforeValidate(form) {if ( form.data("cancel") {this.validateOnSubmit = false;this.beforeValidate = "";form.submit();return false;}return true;}';
        $form = ActiveForm::begin([
        'options' => ['class' => 'form-horizontal', 'name'=>'dispatchFORM','onSubmit'=>'return valDispatchform()'],
        'action' => ['/dispatching/post-dispatch'],
        'fieldConfig' => [
            'template' => '<div class="control-group">{label}<div class="f-full-size">{input}</div><div class=\"col-lg-8\">{error}</div></div>',
        ],
    ]); ?>
    
    <div class="control-group">
    <div class="control-label-f dispatch_document_number_ie6" style="font-weight:bold; margin-bottom:10px;">Enter Document #:</div>
        <div class="f-full-size">
            <?= Html::textInput('document_number', '', ['id'  => 'document_number','class' => 'uborder help-85percent', 'maxlength'=>'8', 'onkeypress'=> 'return isNumberKey(event)' ]) ?>
        </div>
    </div>
    
    <div class="one-column-button pdt-one-column-button">
        <div class="submit-button ie6-submit-button">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary',
                                             'id' => 'submit-document',
                                                  'name'  => 'submit-document']) ?>
        <?= Html::submitButton('Cancel', ['class' => 'btn btn-primary',
                                          'id'  => 'cancel_button_dispatch']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>


<script type="text/javascript">
    function valDispatchform()
    {
        var pname=encodeURIComponent(document.getElementById("document_number").value);
        if (pname == '')
        { alert('Please enter document number');
            return false;}
        else if (pname.length != 8)
        {alert('You must input 8 numeric numbers');return false;}

        return true;
    }
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    function clearvalue(){
        var elements = document.getElementsByTagName("input");
        for (var ii=0; ii < elements.length; ii++) {
          if (elements[ii].type == "text") {
            elements[ii].value = "0";
          }
        }
    }

    function func_totalcnt(){
        return document.getElementById("total_inc").value;
    }


    function updatetotalWeight(ish,umvkz,qt,qt_1,qt_2,cnt){
        var total_inc = func_totalcnt();
        var total_row = 0;
        var umvkzElem = "umvkz_"+cnt;
        var wtElem = "weight_"+cnt;
        var hidwtElem = "temp_weight_"+cnt;
        var umvkzVal = document.getElementById(umvkzElem).innerHTML;


        document.getElementById(wtElem).innerHTML = parseFloat(ish) * parseFloat(umvkzVal);
        document.getElementById(hidwtElem).value = parseFloat(ish) * parseFloat(umvkzVal);


        for (var i = 1; i <= total_inc; i++) {
             var qat = document.getElementById("quantity_"+i+"").value;
             var wt = document.getElementById("weight_"+i+"").innerHTML;
            
             total_row = parseFloat(total_row) + parseFloat(wt);
        }

        document.getElementById("total_weight").value = parseFloat(total_row);

        //use this if weight has limit
        /*
        if(total_row <= 1000) {
            document.getElementById("total_weight").value = total_row;
        }else {
            alert('total weight limit: 1000kg');
            document.getElementById(qt).value = document.getElementById(qt_1).innerHTML;
        }*/
    }
    function closestById(el, id) {
        while (el.id != id) {
            el = el.parentNode;
            if (!el) {
                return null;
            }
        }
        return el;
    }
    document.getElementById("cancel_button_dispatch").addEventListener("click", function(e) {
        e.preventDefault();
        window.location.assign(window.location.origin+"/brdsdev/web/")
    });

</script>
