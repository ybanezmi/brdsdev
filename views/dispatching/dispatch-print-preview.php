<?php
    function truncate($str, $len) {
      $tail = max(0, $len-10);
      $trunk = substr($str, 0, $tail);
      $trunk .= strrev(preg_replace('~^..+?[\s,:]\b|^...~', ' ...', strrev(substr($str, $tail, $len-$tail))));
      return $trunk;
    }
?>

<htmlpagefooter name="DispatchFooter" style="display:none">
    <div style="text-align:center; position:relative; bottom:0px; font-size:11px;">Page {PAGENO} of {nbpg}</div><br /><br />
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
            <td style="width:40%"><div style="font-size:75px; text-align:right">DISPATCH</div></td>
        <tr>
</table>
<div class="two_column">
    <div class="left_column">
        <div class="row_1_title"><b><?= Yii::$app->request->post('customer_name'); ?><b/></div>
        <div class="row_2_cnumber"><b>Customer Number:</b> <?= Yii::$app->request->post('customer_number'); ?></div>
        <div class="row_3_deliver"><b>Delivered To:</b></div>
        <div class="row_4_deliver">
            <?= Yii::$app->request->post('customer_address')['name']; ?> <br />
            <?= Yii::$app->request->post('customer_address')['street']; ?> <br />
            <?= Yii::$app->request->post('customer_address')['town']; ?>, <?= Yii::$app->request->post('customer_address')['country']; ?> <?= Yii::$app->request->post('customer_address')['zip']; ?> <br />
            <?= Yii::$app->request->post('customer_address')['tel']; ?> <br />
        </div>
    </div>

    <div class="right_column">
        <p class="shipping_title">Shipping Information</p>
        <div class="row_ship"><b>Dispatch Number:</b> <?= Yii::$app->request->post('dispatch_number'); ?></div>
        <div class="row_date"><b>Date:</b> <?= Yii::$app->request->post('dispatch_date'); ?></div>
        <div class="row_ship"><b>Customer Request:</b> <?= Yii::$app->request->post('po_number'); ?></div>
        <div class="row_date"><b>Date:</b> <?= Yii::$app->request->post('po_date'); ?></div>
        <div class="row_ship"><b>Request No.:</b> <?= ltrim(Yii::$app->request->post('so_number'),0); ?></div>
        <div class="row_date"><b>Date:</b> <?= Yii::$app->request->post('so_date'); ?></div>
    </div>  
</div>
<br />
<div class="two_column">
    <div class="left_column">
        <p class="conditions">Conditions</p>
        <div class="row_cond"><b>
            Shipping 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
            Pick Unit
        </b></div>
    </div>
    <div class="perfect-right_column">
        <p class="conditions">Weight - Volume</p>
        <div class="row_weight"><b>Total Weight:</b> <?= number_format((float)Yii::$app->request->post('total_weight'),3,'.',',') ?> <?= Yii::$app->request->post('total_unit'); ?></div>
    </div>
</div>
<br />
<p class="shipping_details">Shipping Details</p>
<p class="ship_info">
    <?php
    if(Yii::$app->request->post('sap_header')){
        foreach(Yii::$app->request->post('sap_header') as $key => $value){
            echo $value."<br />";
        }
    }
    ?>
</p>
</div>

</htmlpageheader>
<sethtmlpageheader name="DispatchHeader" page="O" value="on" show-this-page="1" />
<sethtmlpageheader name="DispatchHeader" page="E" value="on" />

<div class="dispatch">
<div class="dispatch-table">
<table class="item-list" style="margin-bottom:10px;">
    <tr>
        <td width="30"><b>Item</b></td>
        <td width="100"><b>Material No.</b></td>
        <td width="240"><b>Material Description</b></td>
        <td><b>Quantity</b></td>
        <td width="90"><b>Weight</b></td>
        <td width="100"><b>Batch</b></td>
        <td width="100"><b>Expiry</b></td>
    </tr>
</table>
    <?php
    
    $i=1;
    $x=0;
    foreach ($dispatch_model_2 as $dispatch_model_2_key => $dispatch_model_2_info) {    
        $current = $dispatch_model_2_info->LFIMG;
        $updated = Yii::$app->request->post('material_quantity')[$x];

        echo '<table class="item-list"><tr>';

            if($current == $updated){
                echo '<td width="30">'.$i.'</td>';  
            } else {
                 echo '<td width="30"><u>'.$i.'</u></td>'; 
            }

            echo '<td width="100">'.$dispatch_model_2_info->MATNR.'</td>';
            echo '<td width="240">'.$dispatch_model_2_info->ARKTX.'</td>';
            echo '<td>'.number_format((float)Yii::$app->request->post('material_quantity')[$x],3,'.',',').' '.$dispatch_model_2_info->VRKME.'</td>';
            echo '<td width="90">'.number_format((float)Yii::$app->request->post('temp_weight')[$x],3,'.',',').'KG </td>';
            echo '<td width="100">'.$dispatch_model_2_info->CHARG.'</td>';
            echo '<td width="100">'.date("d-M-Y", strtotime($dispatch_model_2_info->VFDAT)).'</td>';                            
        echo "</tr></table>";
        if( $i % 15 == 0 ){
            echo '<hr />';
            echo '<div class="breakNow"></div>';
            echo '<table class="item-list" style="margin-bottom:10px;">';
            echo '<tr>';
                echo '<td width="30"><b>Item</b></td>';
                echo '<td width="100"><b>Material No.</b></td>';
                echo '<td width="240"><b>Material Description</b></td>';
                echo '<td><b>Quantity</b></td>';
                echo '<td width="90"><b>Weight</b></td>';
                echo '<td width="100"><b>Batch</b></td>';
                echo '<td width="100"><b>Expiry</b></td>';
            echo '</tr>';
            echo '</table>';
            } 
        $i++;
        $x++;                    
    }
    ?>
</table>
<hr />
</div>
<table class="footer_bar">
    <tr>
    <td align="left" valign="top">
        <div><b>DR Created by</b></div>
        <div>SAP SUPPORT</div>
        <br />
        <br />
        <div>Checked By:</div>
        <br />
        <hr style="width:200px;" />
        <div class="f_info4">Print Name, Date, Time and Sign</div>

    </td>
    <td style="width:20%"></td>
    <td style="width:10%"></td>
    <td align="left" valign="top">

        <div><b>Items Prepared/Picked By:</b></div>
        <div>BTCABARDO</div>
        <br />
        <br />
        <div>Received in Good Order and Condition by:</div>
        <br />
        <hr />
        <div class="f_info4">Print Name, Date, Time and Sign</div>

    </td>
</table>
</div>