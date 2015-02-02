<?php
	//use Dinesh\Barcode\DNS1D;
?>
<div class="barcode">
	<p class="product-name"><?php echo Yii::$app->request->post('material_description'); ?></p>
	<table style="width: 100%; display: inline; margin-bottom: 5px;" class="product-details">
		<tr>
			<td>
				PALLET TARE:  
			</td>
			<td>
				<?php echo number_format((float)Yii::$app->request->post('pallet_tare'), 2, '.', ','); ?>KG
			</td>
			<td width="50%" rowspan="3" class="net-weight">
				<?php echo number_format((float)Yii::$app->request->post('net_weight'), 2, '.', ','); ?>KG
			</td>
		</tr>
		<tr>
			<td>
				PACKAGING TARE:  
			</td>
			<td>
				<?php echo number_format((float)Yii::$app->request->post('pallet_packaging_tare'), 2, '.', ','); ?>KG
			</td>
		</tr>
		<tr>
			<td>
				PRODUCT TARE:  
			</td>
			<td>
				<?php echo number_format((float)Yii::$app->request->post('product_tare_total'), 2, '.', ','); ?>KG
			</td>
		</tr>
	</table>
	<div style="text-align: center; margin-bottom: 10px;">
		<?php 
			$barcode = Yii::$app->request->post('material_code') . str_pad(number_format((float)Yii::$app->request->post('net_weight'), 2, '.', ''), 8, '0', STR_PAD_LEFT) . 'KG';
			echo Yii::$app->DNS1D->getBarcodeSVG($barcode, 'C39', 3, 150);
		?>
	</div>
	<div style="float: left; width: 50%;">
		<p style="margin: 0 0 15px 0;"><?php echo Yii::$app->request->post('material_code'); ?></span>
	</div>
	<div style="width: 40%;">
		<p style="margin: 0 -35px 15px 0; text-align: right;"><?php echo str_pad(number_format((float)Yii::$app->request->post('net_weight'), 2, '.', ''), 8, '0', STR_PAD_LEFT); ?>KG</p>
	</div>	
</div>

<style>
	.product-name {
		width: 100%;
		text-align: center;
		font-weight: bolder;
		font-size: 20px;
		margin: 5px;
	}
	.product-details {
		font-size: 12px;
	}
	.net-weight {
		font-size: 35px;
	}
	.barcode {
		border: 2px solid #000;
		width: 100%;
		height: 100%;
		margin-bottom: 20px;
		padding: 5px 5px 5px 5px;
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
