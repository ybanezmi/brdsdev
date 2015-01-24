<?php
	//use Dinesh\Barcode\DNS1D;
?>
<div class="barcode">
	<p class="product-name"><?php echo Yii::$app->request->post('material_description'); ?></p>
	<table style="width: 100%; display: inline; margin-bottom: 15px;">
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
			echo Yii::$app->DNS1D->getBarcodeSVG($barcode, 'C39', 3, 80);
		?>
	</div>
	<div style="float: left; width: 50%;">
		<p style="margin: 0 0 15px 48px;"><?php echo Yii::$app->request->post('material_code'); ?></span>
	</div>
	<div style="width: 40%;">
		<p style="margin: 0 -15px 15px 0; text-align: right;"><?php echo str_pad(number_format((float)Yii::$app->request->post('net_weight'), 2, '.', ''), 8, '0', STR_PAD_LEFT); ?>KG</p>
	</div>	
</div>
<div class="info">
	<div>
		<label>Product Name: </label>
		<span class="product-name"><?php echo Yii::$app->request->post('material_description'); ?></span>
	</div>
	<div>
		<label>Net Weight: </label>
		<span class="net-weight"><?php echo number_format((float)Yii::$app->request->post('net_weight'), 2, '.', ','); ?>KG</span>
		<p style="margin: 0 0 0 100px;"><?php echo str_pad(number_format((float)Yii::$app->request->post('net_weight'), 2, '.', ''), 8, '0', STR_PAD_LEFT); ?>KG</p>
	</div>
	<div>
		<label>Product Code: </label>
		<span><?php echo substr(Yii::$app->request->post('material_code'), 0, 8); ?></span><span class="red"><?php echo substr(Yii::$app->request->post('material_code'), 8, 11); ?></span>
	</div>
	
	<div>
		<label>Net Weight: </label>
		<span class="underline"><?php echo substr(Yii::$app->request->post('material_code'), 0, 8); ?></span><span class="red underline"><?php echo substr(Yii::$app->request->post('material_code'), 8, 11); ?></span> <span class="red">Product Code: </span>
	</div>
</div>

<style>
	.product-name {
		width: 100%;
		text-align: center;
		font-weight: bolder;
		font-size: 25px;
		margin: 10px;
	}
	.net-weight {
		font-size: 50px;
	}
	.barcode {
		border: 2px solid #000;
		width: 100%;
		margin-bottom: 40px;
	}
	.red {
		color: red;
	}
	.underline {
		text-decoration: underline;
	}
	.info div {
		margin-bottom: 20px;
	}
</style>
