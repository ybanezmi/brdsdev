<?php
	//use Dinesh\Barcode\DNS1D;
function truncate($str, $len) {
  $tail = max(0, $len-10);
  $trunk = substr($str, 0, $tail);
  $trunk .= strrev(preg_replace('~^..+?[\s,:]\b|^...~', ' ...', strrev(substr($str, $tail, $len-$tail))));
  return $trunk;
}
?>

<div class="dispatch">

<table class="head_logo">
		<tr>
			<td style="width:50%"></td>
			<td style="width:45%"><div style="font-size:70px;">DISPATCH</div></td>
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
		<div class="row_ship"><b>Customer Request No:</b> 888</div>
		<div class="row_date"><b>Date:</b> 00/00/0000</div>
		<div class="row_ship"><b>Sales Order Number:</b> 0000000009</div>
		<div class="row_date"><b>Date:</b> 00/00/0000</div>
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
	<div class="right_column">
		<p class="conditions">Weight - Volume</p>
		<div class="row_weight"><b>Total Weight:</b> <?= Yii::$app->request->post('total_weight'); ?></div>
		<div class="row_weight"><b>Total Volume:</b> <?= Yii::$app->request->post('total_volume'); ?></div>
	</div>
</div>
<br />
<p class="shipping_details">Shipping Details</p>
	<p class="ship_info">Header Text test line 1<br />Header Text test line 1</p>
<table class="item-list">
	<tr>
		<td><b>Item</b></td>
		<td><b>Material No.</b></td>
		<td><b>Material Description</b></td>
		<td><b>Quantity</b></td>
		<td><b>Weight</b></td>
		<td><b>Batch</b></td>
		<td><b>Expiry</b></td>
	</tr>
	<tr>
		<td>0001</td>
		<td>ALS MAT</td>
		<td>TOOLS - TEST MATERIAL</td>
		<td>1</td>
		<td>0.5 KG</td>
		<td>0080000001</td>
		<td>2012-07-31</td>
	</tr>
	<tr>
		<td>0001</td>
		<td>ALS MAT</td>
		<td>TOOLS - TEST MATERIAL</td>
		<td>1</td>
		<td>0.5 KG</td>
		<td>0080000001</td>
		<td>2012-07-31</td>
	</tr>
</table>

<br /><hr /><br /><br /><br />

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

<style type"text/css">
	.dispatch {
		width: 100%;
		height: 100%;
		padding: 20px 30px;
		font-weight: bold;
		font-size: 12px;
		line-height: 20px;
	}
	.row_1_title{
		position: relative;
		font-size:25px;
		margin-top:20px;
		margin-bottom:5px;
		line-height: 28px;
	}
	.row_2_cnumber{
		position: relative;
		font-size:12px;
		font-weight: normal;
	}
	.row_3_deliver{
		position: relative;
		font-size:12px;
		font-weight: normal;
	}
	.row_4_deliver{
		position: relative;
		font-size:12px;
		font-weight: normal;
		margin-left: 50px;
		margin-top: 10px;
	}
	.row_ship{
		position: relative;
		font-size:12px;
		font-weight: normal;
		margin-left: 6px;
	}
	.row_date{
		position: relative;
		font-size:12px;
		font-weight: normal;
		margin-bottom: 10px;
		margin-left: 6px;
	}
	.row_cond{
		position: relative;
		font-size:12px;
		font-weight: normal;
		margin-left: 6px;
	}
	.row_weight{
		position: relative;
		font-size:12px;
		font-weight: normal;
		margin-left: 6px;
	}
	.ship_info{
		position: relative;
		font-size:12px;
		font-weight: normal;
		margin-left: 6px;
	}
	.item-list{
		width: 100%;
		position: relative;
		font-size:12px;
		font-weight: normal;
	}
	.shipping_title{
		background: #ccc;
		width:100%;
		padding-left: 5px;
		line-height: 25px;
	}
	.conditions{
		background: #ccc;
		width:100%;
		padding-left: 5px;
		line-height: 25px;
	}
	.shipping_details{
		background: #ccc;
		width:100%;
		padding-left: 5px;
		line-height: 25px;
	}

	.two_column{
		clear: both;
		overflow: hidden;
		width: 100%;
	}
	.right_column{
		float: right;
		width: 50%;
	}
	.left_column{
		float: left;
		width: 50%;
	}
	.footer_bar{
		width:100%;
		font-size: 12px;
		line-height: 18px;
		position: fixed;
		bottom: 0;
	}

	.f_info4 {
		font-size: 11px;
		font-style: italic;
		width: 40%;
		text-align: center;
	}	
</style>
