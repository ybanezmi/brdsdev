<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TrxTransactions */
/* @var $customer_list app\models\MstCustomer */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Dispatching';
?>
<!-- <!-- <div id="main-content">
	<div class="help-150"><h1 class="page-title page-title-bt">Dispatching</h1></div>
	<ul class="list-sub-menu">
		<li><a href="<?php //echo Yii::$app->getUrlManager()->getBaseUrl();?>/dispatching/dispatch"> <span>Dispatch</span></a></li>
		<li><a href="<?php //echo Yii::$app->getUrlManager()->getBaseUrl();?>/dispatching/print"> <span>Print Dispatch</span></a></li>
	</ul>

</div> --> 


<div id="main-content">
	<div class="create-receiving">
		<div class="wrapper-150">
			<h1 class="page-title">Dispatching</h1>
		<div class="one-column help-bg-gray pdt-one-column" style="width:50%" >
																	 
	<form action="#" id="w0" method="post">
	<div class="form-group field-mstpackaging-name required">
		<div class="control-group">
		<label class="control-label-f" for="mstpackaging-name">Enter Document Number</label>

		<div class="f-full-size">
			<input type="text" class="uborder help-55percent" name="dispatch_number" id="dispatch_number" maxlength="8" />
		</div><div class="\&quot;col-lg-8\&quot;"><div class="help-block"></div></div>
		</div>
	</div>
	<div class="one-column-button pdt-one-column-button" style="wdith:100%;">
	<div class="submit-button ie6-submit-button">
		<button type="submit" class="btn btn-primary" style="width:50%; float:none;" id="getdispatch">Go Search</button>
		<button type="submit" class="btn btn-primary back cancel-button" style="width:50%; float:none;" id="back">Back To Main</button>
	</div>
	</div>
	</form>
	
	<div id="dispatch-status"></div>

	<script type="text/javascript">
	function pullDispatch() {
		var pname=encodeURIComponent(document.getElementById("dispatch_number").value);
		var url = brdsapi_site_url+"/brdsapi/dispatching/00"+pname+"/bigblue";
		var method = 'GET';
		var params = '';
		var container_id = 'dispatch-status' ;
		var loading_text = 'please wait..' ;

		if(pname == ''){
			alert('Please enter document number')
		}
		else if(pname.length == 8){
			if(isNaN(pname)){
				alert('Must input numbers') ;
			} else {
				ajax_dispatch (url, method, params, container_id, loading_text) ;
			}
		} else {
			alert('Must input 8 numeric number')
		}
	}

	document.getElementById("getdispatch").addEventListener("click", function(e) {
		e.preventDefault();
		pullDispatch();
	});

	</script>

				
			</div>
		</div>
	</div>
</div>






