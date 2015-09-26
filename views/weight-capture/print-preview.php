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
	<p class="product-name"><b><?php echo truncate(Yii::$app->request->post('material_description'), 30); ?></b></p>
	<table class="product-details">
		<tr>
			<td>
				<b>TOTAL TARE:</b>
			</td>
			<td>
				<b><?php echo number_format((float)Yii::$app->request->post('pallet_packaging_tare'), 2, '.', ','); ?> KG</b>
			</td>
			<td width="55%" rowspan="3" class="net-weight">
				<b><?php echo number_format((float)Yii::$app->request->post('net_weight'), 2, '.', ','); ?>KG</b>
			</td>
		</tr>
		<tr>
			<td>
				<b>DATE:</b></td>
			<td>
				<b><?= date('d-M-Y') ?></b>
			</td>
		</tr>
		<tr>
			<td>
				<b>TIME</b></td>
			<td>
				<b><?= date('H:i:s') ?></b>
			</td>
		</tr>
	</table>
	<div class="code-bars-dns1d">
		<?php 
			$barcode = Yii::$app->request->post('material_code') . str_pad(number_format((float)Yii::$app->request->post('net_weight'), 2, '.', ''), 8, '0', STR_PAD_LEFT);
			echo Yii::$app->DNS1D->getBarcodeSVG($barcode, 'C39',1,78);
		?>
	</div>
	<table class="footer-bar">
		<tr>
		<td align="left">
			<b><?php echo Yii::$app->request->post('material_code'); ?><?php echo str_pad(number_format((float)Yii::$app->request->post('net_weight'), 2, '.', ''), 8, '0', STR_PAD_LEFT); ?></b>
		</td>
		<td align="right">
			<b>Big <span style="background:#000; display:block; float:left; color:#fff;">&nbsp;Blue&nbsp;</span></b>
		</td>
	</table>
</div>

<style>
	.barcode {
		border: 2px solid #000;
		width: 100%;
		height: 100%;
		padding: 2px 5px 2px 5px;
		font-weight: bold;
	}
	.product-name {
		width: 100%;
		text-align: center;
		font-weight: bolder;
		font-size: 19px;
		margin: 2px 5px 2px 5px;
	}
	.product-details {
		font-size: 11px;
		width:100%; 
		display:inline; 
	}
	.net-weight {
		font-size: 30px;
	}
	.code-bars-dns1d{
		width:90%; 
		margin:3px auto;
	}
	.footer-bar{
		font-size:12px;
		width:100%;
	}
</style>
