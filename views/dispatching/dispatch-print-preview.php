<?php
    function truncate($str, $len) {
      $tail = max(0, $len-10);
      $trunk = substr($str, 0, $tail);
      $trunk .= strrev(preg_replace('~^..+?[\s,:]\b|^...~', ' ...', strrev(substr($str, $tail, $len-$tail))));
      return $trunk;
    }
?>

<htmlpagefooter name="DispatchFooter" style="display:none">
    <div style="text-align:center; position:relative; bottom:0px; font-size:11px;">Page {PAGENO} of {nbpg}</div><br /><br /><br />
</htmlpagefooter>
<sethtmlpagefooter name="DispatchFooter" page="O" value="on" show-this-page="1" />
<sethtmlpagefooter name="DispatchFooter" page="E" value="on" />

<htmlpageheader name="DispatchHeader">
<div class="page-header">
<table class="head_logo">
        <tr>
            <td style="width:60%">
                <img src='<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/images/dispatch_header.jpg' width="60%" />
            </td>
            <td style="width:40%"><div style="font-size:75px; text-align:right"><b>DISPATCH</b></div></td>
        <tr>
</table>
<div class="two_column" style="margin-bottom:5px">
    <div class="left_column">
        <div class="row_1_title"><b><?= Yii::$app->request->post('customer_name'); ?><b/></div>
        <div class="row_2_cnumber"><b>Customer Number:</b> <?= Yii::$app->request->post('customer_number'); ?></div>
        <div class="row_3_deliver"><b>Delivered To:</b></div>
        <div class="row_4_deliver" style="margin-left:20px;">
            <div style="font-size:14px;"><?= Yii::$app->request->post('customer_address')['name']; ?></div>
            <?= Yii::$app->request->post('customer_address')['street']; ?> <br />
            <?= Yii::$app->request->post('customer_address')['town']; ?>, <?= Yii::$app->request->post('customer_address')['country']; ?> <?= Yii::$app->request->post('customer_address')['zip']; ?> <br />
            <?= Yii::$app->request->post('customer_address')['tel']; ?> <br />
        </div>
    </div>

    <div class="right_column">
    <div class="shipping_title">Shipping Information</div>
    <table style="width:90%; margin:0 auto">
        <tr>
            <td style="width:50%; text-align:right"><div class="row_ship"><b>Dispatch Number:</b></div></td>
            <td style="width:50%; text-align:right"><div class="row_ship"><?= Yii::$app->request->post('dispatch_number'); ?></div></td>
        </tr>
        <tr>
            <td style="width:50%; text-align:right"><div class="row_ship"><b>Date:</b></div></td>
            <td style="width:50%; text-align:right"><div class="row_ship"><?= Yii::$app->request->post('dispatch_date'); ?></div></td>
        </tr>

        <tr>
            <td style="width:50%; text-align:right"><div class="row_ship"><b>Customer Request:</b></div></td>
            <td style="width:50%; text-align:right"><div class="row_ship"><?= Yii::$app->request->post('po_number'); ?></div></td>
        </tr>
        <tr>
            <td style="width:50%; text-align:right"><div class="row_ship"><b>Date:</b></div></td>
            <td style="width:50%; text-align:right"><div class="row_ship"><?= Yii::$app->request->post('po_date'); ?></div></td>
        </tr>

        <tr>
            <td style="width:50%; text-align:right"><div class="row_ship"><b>Request No.:</b></div></td>
            <td style="width:50%; text-align:right"><div class="row_ship"><?= ltrim(Yii::$app->request->post('so_number'),0); ?></div></td>
        </tr>
        <tr>
            <td style="width:50%; text-align:right"><div class="row_ship"><b>Date:</b></div></td>
            <td style="width:50%; text-align:right"><div class="row_ship"><?= Yii::$app->request->post('so_date'); ?></div></td>
        </tr>
    </table>
    </div>  
</div>
<div class="two_column">
    <div class="left_column">
        <div class="conditions">Conditions</div>
        <div class="row_cond">
            <b>Shipping</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pick-up
        </div>
    </div>
    <div class="perfect-right_column">
        <div class="conditions">Weight - Volume</div>
        <div class="row_weight"><b>Total Weight:</b> <?= number_format((float)Yii::$app->request->post('total_weight'),3,'.',',') ?> <?= Yii::$app->request->post('total_unit'); ?></div>
        <div class="row_weight"><b>Total Volume:</b> <?= number_format((float)Yii::$app->request->post('total_volume'),3,'.',',') ?> </div>
    </div>
</div>
</htmlpageheader>
<sethtmlpageheader name="DispatchHeader" page="O" value="on" show-this-page="1" />
<sethtmlpageheader name="DispatchHeader" page="E" value="on" />

<div class="dispatch">
<div class="dispatch-table">

<div class="shipping_details">Shipping Details</div>
<div class="ship_info">
    <?php
    if(Yii::$app->request->post('sap_header')){
        foreach(Yii::$app->request->post('sap_header') as $key => $value){
            echo $value."<br />";
        }
    } else {
        echo "<br />";
    }
    ?>
</div>
<table class="item-list" style="margin-bottom:10px; margin-top:10px;">
    <tr>
        <td class="thead" width="30"><b>Item</b></td>
        <td class="thead" width="100"><b>Material No.</b></td>
        <td class="thead" width="255"><b>Material Description</b></td>
        <td class="thead" align="right"><b>Quantity</b></td>
        <td class="thead" width="110" align="right"><b>Weight</b></td>
        <td class="thead" width="80" align="right"><b>Batch</b></td>
        <td class="thead" width="80" align="right"><b>Expiry</b></td>
    </tr>
</table>
    <?php
    
    $i=1;
    $x=0;

    foreach ($dispatch_model_2 as $dispatch_model_2_key => $dispatch_model_2_info) {
        if($dispatch_model_2_info->CHARG != " "){ 

        $cur_qty = $dispatch_model_2_info->LFIMG;
        $up_qty = Yii::$app->request->post('material_quantity')[$x];
        $fup_qty = '';

        $cur_bat = $dispatch_model_2_info->CHARG;
        $up_bat = Yii::$app->request->post('batch')[$x];
        $fup_bat = '';

        $cur_ex = date("d-M-Y", strtotime($dispatch_model_2_info->VFDAT));
        $up_ex = Yii::$app->request->post('expiry')[$x];
        $fup_ex = '';

        if($cur_qty == $up_qty) { 
            $fup_qty = number_format((float)Yii::$app->request->post('temp_weight')[$x],3,'.',',').' KG';
        } else {
            $fup_qty = "<span class='underline'>".number_format((float)Yii::$app->request->post('temp_weight')[$x],3,'.',',')." KG</span>";
        }

        if($cur_bat == $up_bat) { 
            $fup_bat = $up_bat;
        } else {
            $fup_bat = "<span class='underline'>".$up_bat."</span>";
        }

        if($cur_ex == $up_ex) { 
            $fup_ex = $up_ex;
        } else {
            $fup_ex = "<span class='underline'>".$up_ex."</span>";
        }

    
        echo '<table class="item-list"><tr>';

            echo '<td width="30">'.$i.'</td>';  
            echo '<td width="100">'.$dispatch_model_2_info->MATNR.'</td>';
            echo '<td width="255">'.$dispatch_model_2_info->ARKTX.'</td>';
            echo '<td align="right">'.number_format((float)Yii::$app->request->post('material_quantity')[$x],3,'.',',').' '.$dispatch_model_2_info->VRKME.'</td>';
            echo '<td width="110" align="right">'.$fup_qty.'</td>';
            echo '<td width="80" align="right">'.$fup_bat.'</td>';
            echo '<td width="80" align="right">'.$fup_ex.'</td>';                            
        echo "</tr></table>";
        if( $i % 22 == 0 ){
            echo '<hr />';
            echo '<div class="breakNow"></div>';

            echo '<div class="shipping_details">Shipping Details</div>';
            echo '<div class="ship_info">';
                if(Yii::$app->request->post('sap_header')){
                    foreach(Yii::$app->request->post('sap_header') as $key => $value){
                        echo $value."<br />";
                    }
                } else {
                    echo "<br />";
                }
            echo '</div>';
            echo '<table class="item-list" style="margin-bottom:10px; margin-top:10px;">';
            echo '<tr>';
                echo '<td class="thead" width="30"><b>Item</b></td>';
                echo '<td class="thead" width="100"><b>Material No.</b></td>';
                echo '<td class="thead" width="255"><b>Material Description</b></td>';
                echo '<td class="thead" align="right"><b>Quantity</b></td>';
                echo '<td class="thead" width="110" align="right"><b>Weight</b></td>';
                echo '<td class="thead" width="80" align="right"><b>Batch</b></td>';
                echo '<td class="thead" width="80" align="right"><b>Expiry</b></td>';
            echo '</tr>';
            echo '</table>';
            } 
        $i++;
        $x++;                    
        }
    }
    ?>
</table>
<hr />
</div>
<table class="footer_bar" style="width:100%">
    <tr>
    <td align="left" valign="top" style="width:50%">
        <div><b>DR Created by</b></div>
        <div><?= Yii::$app->request->post('prepared_by'); ?></div>
        <br />
        <div><b>Checked By:</b></div>
        <br />
        <div style="margin-top:10px; text-transform:uppercase">
            <?= Yii::$app->request->post('checked_by'); ?> <?= date('d-M-Y H:i:s') ?>
        </div>
        <hr style="width:80%; text-align:left; margin-top:0; padding-top:0" />
        <div class="f_info4">Print Name, Date, Time and Sign</div>
    </td>
    <td align="left" valign="top" style="width:30%">
        <div><b>Items Prepared/Picked By:</b></div>
        <div>
            <?php
            if(Yii::$app->request->post('picked_by')){

            $picked_data = Yii::$app->request->post('picked_by');
            $len = count($picked_data);

                foreach($picked_data as $key => $value){
                    echo $value;
                    if ($key != $len - 1) {
                        echo ", ";
                    }
                }
            }
            ?>
        </div>
        <br />
        <div><b>Received in Good Order and Condition by:</b></div>
        <br />
        <hr style="width:100%; text-align:left; margin-top:15px;" />
        <div class="f_info4">Print Name, Date, Time and Sign</div>
    </td>
</table>
</div>