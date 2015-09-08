<style type="text/css">
	h1.item-head{ font-size:20px;}
	h3.item-head-3{ font-size:15px; line-height: 18px; padding:0; margin: 0 0 8px 0; }
	div.item-item{ font-size:15px; font-family: tahoma, sans-serif, arial, verdana ; }
	.label-t{ font-size:14px; font-weight: bold;}
	.block { background: #ccc; padding:10px; margin-bottom: 10px; }
</style>

<?php if(!empty($materal_list) && !empty($material_conv)) { ?>
<h1 class="item-head">Material Details</h1>
<?php foreach ($materal_list as $materal_list_key => $materal_list_info) { ?>
<?php //foreach ($material_conv as $material_conv_key => $material_conv_info) { ?>
<div class="block">
	<h3 class="item-head-3">ITEM #: <?= $materal_list_info['item_code'] ?> - <?= $materal_list_info['description'] ?></h3>
	<div class="item-item"><span class="label-t">Barcode</span>: <?= $materal_list_info['barcode'] ?></div>
	<div class="item-item"><span class="label-t">Pallet Indicator</span>: <?= $materal_list_info['pallet_ind'] ?></div>
	<div class="item-item"><span class="label-t">SLED</span>: <?= $materal_list_info['sled'] ?></div>
	<div class="item-item"><span class="label-t">SLED Unit</span>: <?= $materal_list_info['sled_unit'] ?></div>
	<div class="item-item"><span class="label-t">Status</span>: <?= $materal_list_info['status'] ?></div>
	<!-- <hr />
	<div>
		<span class="label-t">Unit:</span> <?php // $material_conv_info['unit_1'] ?> 
		<span class="label-t">Numerator:</span> <?php // $material_conv_info['num_1'] ?> 
		<span class="label-t">Denominator:</span> <?php // $material_conv_info['den_1'] ?> 
	</div>
	<div>
		<span class="label-t">Unit:</span> <?php // $material_conv_info['unit_2'] ?> 
		<span class="label-t">Numerator:</span> <?php // $material_conv_info['num_2'] ?> 
		<span class="label-t">Denominator:</span> <?php // $material_conv_info['den_2'] ?> 
	</div>
	<div>
		<span class="label-t">Unit:</span> <?php // $material_conv_info['unit_3'] ?> 
		<span class="label-t">Numerator:</span> <?php // $material_conv_info['num_3'] ?> 
		<span class="label-t">Denominator:</span> <?php // $material_conv_info['den_3'] ?> 
	</div> -->
</div>
<?php } } /*}*/ else { ?>
<h3 class="item-head-3" style="color:#990000; padding-top:10px;">No records found</h3>

<?php } ?>