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
	#loading{
		position: fixed;
		z-index: 9999;
		left:40%;
		top:150px;
		text-align: center;
		visibility: hidden;
	}
	.process-loading{
		font-size:20px;
		margin-bottom: 20px;
		margin-top: 20px;
	}
</style>

<div id="main-content">
	<div class="create-receiving">
		<div class="wrapper-150">
			<h1 class="page-title">Synch Packaging Materials</h1>
			<div id="ajaxstat"></div>
		<div id="loading">
			<div class="process-loading">Synchronize Database</div>
			<img src="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/images/loading.gif" />
			<div class="process-loading" style="font-size:18px;">Please wait...</div>
		</div>

		<div class="one-column help-bg-gray pdt-one-column" style="width:50%" >

    
																		 
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
	var brdsapi_site_url = "http://192.168.1.122";

	function ajax (url, method, params, container_id, loading_text) {
	    try { // For: chrome, firefox, safari, opera, yandex, ...
	    	xhr = new XMLHttpRequest();
	    } catch(e) {
		    try{ // for: IE6+
		    	xhr = new ActiveXObject("Microsoft.XMLHTTP");
		    } catch(e1) { // if not supported or disabled
			    alert("Not supported!");
			}
		}
		xhr.onreadystatechange = function() {
			if(xhr.readyState == 4) {
				document.getElementById(container_id).innerHTML = xhr.responseText;
			} else { 
				document.getElementById(container_id).innerHTML = loading_text;
			}
		}
		xhr.open(method, url, true);
		xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		xhr.send(params);
	}		

	function pullPackage() {
		var pname=encodeURIComponent(document.getElementById("mstpackaging-name").value);
		var url = brdsapi_site_url+"/brdsapi/packaging_materials/"+pname+"/bigblue";
		var method = 'GET';
		var params = '';
		var container_id = 'ajaxstat' ;
		var loading_text = 'processing' ;
		if(null == pname){
			alert('Please select packaging materials')
		}else{
			ajax (url, method, params, container_id, loading_text) ;
		}
	}

	document.getElementById("synch_all").addEventListener("click", function(e) {
		e.preventDefault();
		pullPackage();
	});


	</script>


				
			</div>
		</div>
	</div>
</div>
