
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

use app\models\DispatchModel;
/* @var $this yii\web\View */
/* @var $model app\models\MstAccount */
/* @var $form yii\widgets\ActiveForm */
?>
<style type="text/css">
    .search_box{
        position: fixed;
        bottom: 50px;
        right: 10px;
        background: #3E4095;
        padding: 10px 10px 0px 10px;
        border-radius: 5px;
    }
    .search_box input{
        vertical-align: top;
    }

    .search_box input.display{
        padding-top:3px;
        padding-bottom:3px;
        font-weight: bold;
    }
    .details input.curloc {
        border:3px solid #990000!important;
    }
</style>

<div class="search_box">
    <input type="text" class="search" placeholder="Seach Here" />
    <input type="button" class="display" value="NEXT" />
    <input type="button" class="display" value="CLEAR" />
</div>

<div class="dispatch-form">
    <?php if(empty($dispatch_model_1) || empty($dispatch_model_2)) { 
        echo '<b class="emptyr">The Delivery '.$full_dispatch_id.' is empty</b>'; } 
    else { 
        $dismodel = new DispatchModel; 
    ?>

    <?php 
        $js = 'function beforeValidate(form) {if ( form.data("cancel") {this.validateOnSubmit = false;this.beforeValidate = "";form.submit();return false;}return true;}';
        $form = ActiveForm::begin([
        'options' => ['class' => 'form-horizontal', 'name'=>'dispatchFORM', 'target'=>'_blank'],
        'action' => ['/dispatching/print-dispatch'],
        'fieldConfig' => [
            'template' => '<div class="control-group">{label}<div class="f-full-size">{input}</div><div class=\"col-lg-8\">{error}</div></div>',
        ],
        ]); 
    ?>

   <!-- <h3>Results for [ DR #: <?php //echo $dispatch_model_1[0]->VBELN; ?> ]</h3> -->
    <div class="disptach-preview">
    <?php  $customer_data = $dismodel->getCustomerData($dispatch_model_1[0]->KUNNR); ?>

    <div class="dispatch-header">
    <h1>Shipping Information</h1>
    <div style="padding:0 20px;">
    <h3><?php echo $customer_data[0]->NAME1; ?></h3>

    
    <table class="tablelist">
    <tr>
        <td style="vertical-align:top;">
            <div class="row">
                <div class="disp-left">Customer Number:</div>
                <div class="disp-right"><?php echo $dispatch_model_1[0]->KUNNR; ?> </div>
            </div>
            <div class="row">
                <div class="disp-left">Delivered To:</div>
                <div class="disp-right">
                        <?php echo $customer_data[0]->NAME1; ?><br />
                        <?php echo $customer_data[0]->STRAS; ?><br />
                        <?php echo $customer_data[0]->ORT01; ?>, 
                        <?php echo $customer_data[0]->LAND1; ?> <?php echo $customer_data[0]->PSTLZ; ?><br />
                        <?php echo $customer_data[0]->TELF1; ?><br />
                </div>
            </div>
        </td>

        <?php  $so_data = $dismodel->getSO($dispatch_model_1[0]->VBELN); ?>
        <?php  $po_data = $dismodel->getPO($so_data[0]->VBELV); ?>

        <?php $po_data = (empty($so_data[0]->VBELV)) ? 'N/A' : $dismodel->getPO($so_data[0]->VBELV); ?>

        <td style="padding-left:50px;">
            <div class="row">
                <div class="disp-left">Dispatch Number:</div>
                <div class="disp-right"><?php echo $dispatch_model_1[0]->VBELN; ?></div>
            </div>
            <div class="row">
                <div class="disp-left">Date:</div>
                <?php $dispatch_date =  date("d-M-Y"); //date("d-M-Y", strtotime($dispatch_model_1[0]->BLDAT))?>
                <div class="disp-right"><?= $dispatch_date  ?></div>
            </div>
            <div class="row">
                <div class="disp-left">Customer Request:</div>
                <div class="disp-right"><?php
                    if(empty($po_data[0]->BSTNK)){
                        echo '<span class="red-col">N/A</span>'; }
                    else{
                        echo $po_data[0]->BSTNK; } ?>

                </div>
            </div>
            <div class="row">
                <div class="disp-left">Date:</div>
                <div class="disp-right"><?php
                    if(empty($po_data[0]->BSTDK)){
                        echo '<span class="red-col">N/A</span>'; }
                    else{
                        echo date("d-M-Y", strtotime($po_data[0]->BSTDK)); } ?>
                </div>
            </div>
             
             <div class="row">
                <div class="disp-left">Request #:</div>
                <div class="disp-right"><?php
                    if(empty($so_data[0]->VBELV)){
                        echo '<span class="red-col">N/A</span>'; }
                    else{
                        echo ltrim($so_data[0]->VBELV,0); } ?>

                </div>
            </div>
            <div class="row">
                <div class="disp-left">Date:</div>
                <div class="disp-right"><?php
                    if(empty($so_data[0]->ERDAT)){
                        echo '<span class="red-col">N/A</span>'; }
                    else{
                        echo date("d-M-Y", strtotime($so_data[0]->ERDAT)); } ?>
                </div>
            </div>

        </td>
    </tr>
    <tr>
        <td colspan="5">
           <!--  <div class="control-group" style="width:100%; margin:20px 0 0">
                <?= Html::textInput('scanner', '', ['id'  => 'scanner','class' => 'uborder help-100percent']) ?>
            </div> -->
        </td>
    </tr>
    </table>

       
    </div>
    </div>
    <div class="sap-header">
    
    <?php if($sap_dispatch["data_lines"]){ ?>
    <div class="dispatch-details">
    <h1>Details</h1>
    <div style="padding:20px 20px 30px;">
        <?php   
            foreach ($sap_dispatch["data_lines"] as $head_sap => $head_value) {
                foreach ($head_value as $body_value) {
                    echo "$body_value";
                    echo "<br />";
                    echo "<input type='hidden' value='".$body_value."' name='sap_header[]'>";
                }
            }
        ?>
    </div>
    </div>
    <?php }?>
    
    <div class="dispatch-details">
        <h1>Shipping Details</h1>
            <style>table.details{ width:auto; margin-top: 20px; } </style>
            <div style="padding:0 20px;">       
                <table class="details" id="ship-details">
                <tbody>
                <?php
                $i=1;
                $totalweight=0;
                $total_volume=0;
                $qname = array();

                foreach ($dispatch_model_3 as $dispatch_model_3_key => $dispatch_model_3_info) {   
                        
                        if (!in_array($dispatch_model_3_info->QNAME, $qname)) {
                            $qname[] = $dispatch_model_3_info->QNAME;  
                        }

                }

              
                if(!empty($dispatch_model_2)) {

                $total_inc = 0; 
                
                foreach ($dispatch_model_2 as $dispatch_model_2_key => $dispatch_model_2_info) {   
                        
                     if($dispatch_model_2_info->CHARG != " "){  

                        if($dispatch_model_2_info->VRKME == 'KG'){
                         
                         echo "<tr style='border-bottom:1px solid #ccc;'><td style='width:150px; vertical-align:top; padding-top:7px; padding-right:10px; padding-bottom:10px; '> <input type='text' class='bb uborder help-70percent' onkeypress='return checkInputWeight(event)' id='quantity_".$i."' 
                        onchange='updatetotalWeight(this.value, \"umvkz_".$i."\", \"quantity_".$i."\", \"current_quantity_".$i."\", \"weight_".$i."\", \"".$i."\" )' value='' name='material_quantity[]' /> ".$dispatch_model_2_info->VRKME."

                        <input type='hidden' class='barcode' value='".$dispatch_model_2_info->MATNR."' name='barcode[]' />
                        <input type='hidden' class='upc_1' value='".$dispatch_model_2_info->UPC_1."' name='upc_1[]' />
                        <input type='hidden' class='upc_2' value='".$dispatch_model_2_info->UPC_2."' name='upc_2[]' />
                        </td><td style='padding-top:5px;'>" ;
                                       
                        }  else {                     
                        echo "<tr style='border-bottom:1px solid #ccc;'><td style='width:150px; vertical-align:top; padding-top:7px; padding-right:10px; padding-bottom:10px; '> <input type='text' class='bb uborder help-70percent' onkeypress='return isNumberKey(event)' id='quantity_".$i."' 
                        onchange='updatetotalWeight(this.value, \"umvkz_".$i."\", \"quantity_".$i."\", \"current_quantity_".$i."\", \"weight_".$i."\", \"".$i."\" )' value='' name='material_quantity[]' /> ".$dispatch_model_2_info->VRKME."

                        <input type='hidden' class='barcode' value='".$dispatch_model_2_info->MATNR."' name='barcode[]' />
                        <input type='hidden' class='upc_1' value='".$dispatch_model_2_info->UPC_1."' name='upc_1[]' />
                        <input type='hidden' class='upc_2' value='".$dispatch_model_2_info->UPC_2."' name='upc_2[]' />
                        </td><td style='padding-top:5px;'>" ;
                        }    
                            echo $dispatch_model_2_info->MATNR.' '.$dispatch_model_2_info->ARKTX;
                            echo "<br />";
                            echo "<input type='text' class='uborder help-30percent' id='batch_".$i."'  value='".$dispatch_model_2_info->CHARG."' name='batch[]' /> ";
                            echo DatePicker::widget([
                            'name'  => 'expiry[]',
                            'language'      => 'en-GB',
                            'value'  => date("d-M-Y", strtotime($dispatch_model_2_info->VFDAT)),
                            'clientOptions' => ['dateFormat'     => 'dd-M-yy',
                                        'showOn'        => 'button',
                                        'buttonImage'  => '../images/calendar.gif',
                                        'buttonImageOnly' => 'true',],
                            'options'       => ['class'         => 'uborder disabled help-25percent dateclass',
                                        'readonly'        => 'readonly',
                                        'dateFormat'     => 'dd-M-yy',]
                            ]);
                            echo "<br />";

                            if($dispatch_model_2_info->VRKME == 'KG'){
                              

                              $gr_tot = $dispatch_model_2_info->LFIMG;
                              echo '<span style="display:none" id="umvkz_'.$i.'">1</span>';
                              echo '<span id="weight_'.$i.'" style="display:none;"></span>';
                              echo '<span>'.number_format((float)$gr_tot,3,'.','').'</span> '.$dispatch_model_2_info->VRKME;
                              echo '<input type= "hidden" value="" name="temp_weight[]" id="temp_weight_'.$i.'"';
                              echo '<input type= "hidden" value="'.$dispatch_model_2_info->VRKME.'" name="temp_weight[]" id="unit_weight_'.$i.'"';
                            
                            }else {

                              $umvkz_umvkn = $dispatch_model_2_info->UMVKZ / $dispatch_model_2_info->UMVKN;

                              $gr_tot = $dispatch_model_2_info->LFIMG * $umvkz_umvkn;
                              echo "<span>".$dispatch_model_2_info->LFIMG."".$dispatch_model_2_info->VRKME."</span> "; 
                              echo "<span id='umvkz_".$i."'>".number_format((float)$umvkz_umvkn,3,'.','')." KG</span>"; 
                              echo ' (<span id="weight_'.$i.'"></span> KG)';
                              echo '<input type= "hidden" value="" name="temp_weight[]" id="temp_weight_'.$i.'"';
                              echo '<input type= "hidden" value="'.$dispatch_model_2_info->VRKME.'" name="temp_weight[]" id="unit_weight_'.$i.'"';

                            }
                            
                            echo "<br />";
                        echo "<input type='hidden' value='".$dispatch_model_2_info->MATNR."' name='material_number[]' />";
                        echo "<input type='hidden' value='".$dispatch_model_2_info->ARKTX."' name='material_name[]' />";

                        echo "<td></tr>";
                        $i++;

                        $total_inc = $i-1;

                        (float) $totalweight = $totalweight + $gr_tot;
                        (float) $total_volume = $total_volume + $dispatch_model_2_info->VOLUM;

                        }
                    }

                    echo '<input type="hidden"  id="total_volume" value="'.$total_volume.'" name="total_inc" />';
                    echo '<input type="hidden"  id="total_inc" value="'.$total_inc.'" name="total_inc" />';
                    echo '<input type="hidden"  id="total_unit" value="KG" name="total_unit" />';
                    
                    } else {
                        echo "<div style='font-weight: bold; padding-top: 30px; color: #990000;''>No record found!</div>";
                    }
                    
                   
                    ?>
                    </tbody>
                </table>
                <p style="padding-top:50px; font-weight:bold; font-size:20px;">TOTAL WEIGHT: <input type='text' class='uborder disabled help-20percent' readonly="readonly" id="total_weight" value="" name="total_weight" /> KG
                </p>


            </div>
    </div>
    </div>

    <?php 
        if($qname){
            foreach($qname as $key => $value){
                echo '<input type="hidden" value="'.$value.'" name="picked_by[]">';
            }
        } else {
                echo '<input type="hidden" value="N/A" name="picked_by[]">';
        }
    ?>
    

    <!-- customer_information-->
    <input type="hidden" value="<?= $customer_data[0]->NAME1; ?>" name="customer_name">
    <input type="hidden" value="<?= $dispatch_model_1[0]->KUNNR; ?>" name="customer_number">
    <input type="hidden" value="<?= $dispatch_model_1[0]->ERNAM; ?>" name="prepared_by">
    <input type="hidden" value="<?= $customer_data[0]->NAME1; ?>" name="customer_address[name]">
    <input type="hidden" value="<?= $customer_data[0]->STRAS; ?>" name="customer_address[street]">
    <input type="hidden" value="<?= $customer_data[0]->ORT01; ?>" name="customer_address[town]">
    <input type="hidden" value="<?= $customer_data[0]->LAND1; ?>" name="customer_address[country]">
    <input type="hidden" value="<?= $customer_data[0]->PSTLZ; ?>" name="customer_address[zip]">
    <input type="hidden" value="<?= $customer_data[0]->TELF1; ?>" name="customer_address[tel]">

    <input type="hidden" value="<?= Yii::$app->user->identity->first_name .' '.Yii::$app->user->identity->last_name ?>" name="checked_by">

     <!-- shipping_information-->
    <input type="hidden" value="<?= $dispatch_model_1[0]->VBELN; ?>" name="dispatch_number">
    <input type="hidden" value="<?= $dispatch_date; ?>" name="dispatch_date">

     <!-- po_and_so information-->
     <?php if(empty($so_data[0]->VBELV)){
        echo '<input type="hidden" value="N/A" name="so_number">';
    }
    else{
        echo '<input type="hidden" value="'.$so_data[0]->VBELV.'" name="so_number">'; 
    } ?>
     <?php if(empty($so_data[0]->ERDAT)){
        echo '<input type="hidden" value="N/A" name="so_date">';
    }
    else{
        echo '<input type="hidden" value="'.date("d-M-Y", strtotime($so_data[0]->ERDAT)).'" name="so_date">'; 
    } ?>
     <?php if(empty($po_data[0]->BSTNK)){
        echo '<input type="hidden" value="N/A" name="po_number">'; 
    }
    else{
        echo '<input type="hidden" value="'.$po_data[0]->BSTNK.'" name="po_number">'; 
    } ?>
     <?php if(empty($po_data[0]->BSTDK)){
        echo '<input type="hidden" value="N/A" name="po_date">'; 
    }
    else{
        echo '<input type="hidden" value="'.date("d-M-Y", strtotime($po_data[0]->BSTDK)).'" name="po_date"> ';
    } ?>

    <div class="one-column-button pdt-one-column-button">
        <div class="submit-button ie6-submit-button">
        <?= Html::submitButton('Print', ['style' => 'display:none', 'class' => 'btn btn-primary', 'name'  => 'print-document', 'id'  => 'printButton']) ?>
        <!-- <button type="button" class="btn btn-primary" name="clear" onclick="return clearvalue()">Clear</button> -->
        </div>
    </div>

    <?php ActiveForm::end(); ?>
    <?php } ?>
</div>


<script type="text/javascript">
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

        var empty = 0;

        document.getElementById(wtElem).innerHTML = formatNumber(parseFloat(ish) * parseFloat(umvkzVal));
        document.getElementById(hidwtElem).value = formatNumber(parseFloat(ish) * parseFloat(umvkzVal));

        for (var i = 1; i <= total_inc; i++) {
             var qat = document.getElementById("quantity_"+i+"").value;
             var wt = document.getElementById("weight_"+i+"").innerHTML;

            if(qat < 0) {
                 qat = document.getElementById("quantity_"+i+"").value = 0;
            }
            if(wt == '' || qat == '' ) {
                wt = 0;
                empty = empty + i;
            } 
            
            total_row = parseFloat(total_row) + parseFloat(wt);

             
        }
        if(empty == 0) {
           document.getElementById('printButton').style.display = 'block'; 
        }

        document.getElementById("total_weight").value = formatNumber(parseFloat(total_row));
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

    function formatNumber(number)
    {
        // var number = number.toFixed(3) + '';
        // var x = number.split('.');
        // var x1 = x[0];
        // var x2 = x.length > 1 ? '.' + x[1] : '';
        // var rgx = /(\d+)(\d{3})/;
        // while (rgx.test(x1)) {
        //     x1 = x1.replace(rgx, '$1' + ',' + '$2');
        // }
        // return x1 + x2;
        return number.toFixed(3);
    }

    function checkInputWeight(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 45 || charCode > 57 || charCode == 47)) 
            return false;
        return true;
    }


</script>

<style type="text/css">
.dispatch-header, .dispatch-details{
    border:1px solid #ccc;
    margin-bottom: 20px;
    padding-bottom: 10px;
}
.disptach-preview h1 {
    font-size: 25px;
    line-height: 20px;
    background: #ccc;
    padding:15px 15px;
    margin: 0;
}
.disptach-preview h3 {
    font-size: 22px;
    line-height: 15px;
    margin-top:30px;
}
.row{
    clear: both;
    overflow: hidden;
    width:auto;
    margin: 7px 0;
}
.emptyr{ color:#000;}
.disp-left { float:left; font-weight: bold; }
.disp-right { float:left; margin-left: 10px; }
.red-col{
    color: #cc0000;
    font-weight: bold;
}
</style>