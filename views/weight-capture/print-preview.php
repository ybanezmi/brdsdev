<?php
	//use Dinesh\Barcode\DNS1D;
function truncate($str, $len) {
  $tail = max(0, $len-10);
  $trunk = substr($str, 0, $tail);
  $trunk .= strrev(preg_replace('~^..+?[\s,:]\b|^...~', ' ...', strrev(substr($str, $tail, $len-$tail))));
  return $trunk;
}
?>
<div class="barcode">
	<p class="product-name"><b><?php echo truncate(Yii::$app->request->post('material_description'), 25); ?></b></p>
	<table style="width: 100%; display: inline; margin-bottom: 5px;" class="product-details">
		<tr>
			<td>
				<b>PALLET TARE:</b></td>
			<td>
				<b><?php echo number_format((float)Yii::$app->request->post('pallet_tare'), 2, '.', ','); ?>KG</b>
			</td>
			<td width="50%" rowspan="3" class="net-weight">
				<b><?php echo number_format((float)Yii::$app->request->post('net_weight'), 2, '.', ','); ?>KG</b>
			</td>
		</tr>
		<tr>
			<td>
				<b>PACKAGING TARE:</b></td>
			<td>
				<b><?php echo number_format((float)Yii::$app->request->post('pallet_packaging_tare'), 2, '.', ','); ?>KG </b>
			</td>
		</tr>
		<tr>
			<td>
				<b>PRODUCT TARE:</b></td>
			<td>
				<b><?php echo number_format((float)Yii::$app->request->post('product_tare_total'), 2, '.', ','); ?>KG</b>
			</td>
		</tr>
	</table>
	<div style="text-align: center; margin-bottom: 6px; width:70%; margin-left:15%;">
		<?php 
			$barcode = Yii::$app->request->post('material_code') . str_pad(number_format((float)Yii::$app->request->post('net_weight'), 2, '.', ''), 8, '0', STR_PAD_LEFT) . 'KG';
			echo Yii::$app->DNS1D->getBarcodeSVG($barcode, 'C39', 1, 100);
		?>
	</div>
	<div style="float: left; width: 70%;">
		<p style="margin: 0 0 15px 0; font-size:12px;"><?php echo Yii::$app->request->post('material_code'); ?><?php echo str_pad(number_format((float)Yii::$app->request->post('net_weight'), 2, '.', ''), 8, '0', STR_PAD_LEFT); ?></span>
	</div>
	<div style="width: 20%;">
		<p style="margin: 0 -35px 15px 0; text-align: right;">
			<img src="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/images/logoS.png" width="60" />
		</p>
	</div>	
</div>

<style>
	.product-name {
		width: 100%;
		text-align: center;
		font-weight: bolder;
		font-size: 20px;
		margin: 2px 5px;
	}
	.product-details {
		font-size: 11px;
	}
	.net-weight {
		font-size: 35px;
	}
	.barcode {
		border: 3px solid #000;
		width: 100%;
		height: 100%;
		margin-bottom: 20px;
		padding: 2px 5px 2px 5px;
		font-weight: bold;
	}
	.red {
		color: red;
	}
	.underline {
		text-decoration: underline;
	}
	.info div {
		margin-bottom: 10px;
	}
</style>
