<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\Url;

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
    document.getElementById("cancel_button_dispatch").addEventListener("click", function(e) {
        e.preventDefault();
        window.location.assign(window.location.origin+ '<?php echo Url::home() ?>');
    });

    function valDispatchform()
    {
        var pname=encodeURIComponent(document.getElementById("document_number").value);
        if (document.dispatchFORM.document_number.value == "")
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




</script>
