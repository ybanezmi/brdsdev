<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TrxTransactions */
/* @var $customer_list app\models\MstCustomer */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Synch Packaging Materials';
?>

<style type="text/css">
	#sync-progress{
		position: fixed;
		z-index: 9999;
		left:40%;
		top:150px;
		text-align: center;
		display: none;
	}
	.process-loading{
		font-size:20px;
		margin-bottom: 20px;
		margin-top: 20px;
	}
	#sync-status{
		padding-left: 20px;
 		padding-top: 10px;
	}
</style>

<div id="main-content">
	<div class="create-receiving">
		<div class="wrapper-150">
			<h1 class="page-title">Synch Packaging Materials</h1>

		<div id="sync-status"></div>
		<div id="sync-progress">
			<div class="process-loading">Synchronize Database</div>
			<img src="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/images/loading.gif" />
			<div class="process-loading" style="font-size:18px;">Please wait...</div>
		</div>

		<div class="one-column help-bg-gray pdt-one-column" style="width:50%" >

    <div id="bar_blank">
   <div id="bar_color"></div>
  </div>

	<form action="#" id="w0" method="post">
	<div class="form-group field-mstpackaging-name required">
		<div class="control-group">
		<label class="control-label-f" for="mstpackaging-name">Packaging Materials</label>

		<div class="f-full-size">
			<select id="mstpackaging-name" class="uborder help-55percent" name="MstPackaging[name]" >
				<option value="">-- Select a packaging materials --</option>
				<option value="ZCUS">ZCUS</option>
				<option value="VERP">VERP</option>
			</select>
		</div><div class="\&quot;col-lg-8\&quot;"><div class="help-block"></div></div>
		</div>
	</div>
	<div class="one-column-button pdt-one-column-button" style="wdith:100%;">
	<div class="submit-button ie6-submit-button">
		<button type="submit" class="btn btn-primary" style="width:50%; float:none;" id="synch_all">Sync Packaging Materials</button>
		<button type="submit" class="btn btn-primary back cancel-button" style="width:50%; float:none;" id="back">Back To Main</button>
	</div>
	</div>
	</form>


	<script type="text/javascript">

	function syncPackage() {
		var pname=encodeURIComponent(document.getElementById("mstpackaging-name").value);
		var url = brdsapi_site_url+"packaging_materials/"+pname+"/bigblue";
		var method = 'GET';
		var params = '';
		var container_id = 'sync-status' ;
		var loading_text = 'processing' ;
		if(pname == ''){
			alert('Please select packaging materials')
		}else{
			ajax (url, method, params, container_id, loading_text) ;
		}
	}

	document.getElementById("synch_all").addEventListener("click", function(e) {
		e.preventDefault();
		syncPackage();
	});

	</script>



			</div>
		</div>
	</div>
</div>
