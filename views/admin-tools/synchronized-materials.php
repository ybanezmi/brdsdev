<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TrxTransactions */
/* @var $customer_list app\models\MstCustomer */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Synch Materials';
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
	#material-list_id{
		display: none;
	}
</style>

<div id="main-content">
	<div class="create-receiving">
		<div class="wrapper-150">
			<h1 class="page-title">Synch Materials</h1>

		<div id="sync-status"></div>
		<div id="sync-progress">
			<div class="process-loading">Synchronize Database</div>
			<img src="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/images/loading.gif" />
			<div class="process-loading" style="font-size:18px;">Please wait...</div>
		</div>

			<div class="one-column help-bg-gray pdt-one-column" style="width:50%" >	

	<?php 
			$js = 'function beforeValidate(form) {if ( form.data("back") {this.validateOnSubmit = false;this.beforeValidate = "";form.submit();return false;}return true;}';
			$form = ActiveForm::begin([
			'fieldConfig' => [
			'template' => '<div class="control-group">{label}<div class="f-full-size">{input}</div><div class=\"col-lg-8\">{error}</div></div>',
			]
			]); ?>

																	 
			<?= $form->field($customer_model, 'name')->dropDownList($customer_list, 
			['class'	=> 'uborder help-80percent',
			'prompt'	=> '-- Select a customer --',
			'onchange'	=> 'getMateriaList(getFieldValueById("mstcustomer-name"));
			hideHTMLById("material-list_id"); hideHTMLById("list-materials");'])->label('CUSTOMER PRODUCT', ['class' => 'control-label-f']); 
			?>

			<select id="material-list_id"><option></option></select>
		
			<div class="one-column-button pdt-one-column-button" style="wdith:100%;">
			<div class="submit-button ie6-submit-button">
			<button class="btn btn-primary" style="width:35%;" id="syncAllMaterials">Sync All Materials</button>
			<button class="btn btn-primary" style="width:35%;" id="view_materials" name="view_materials">View Details</button>
			<button class="btn btn-primary" style="width:35%;" id="material_only">Material Only</button>
			<button class="btn btn-primary back cancel-button" style="width:35%;" name="back">Back To Main</button>
			</div>
			</div>

			<div id="list-materials">

			</div>
    <?php ActiveForm::end(); ?>

	<script type="text/javascript">
	

	function view_materials() {
		var pname=encodeURIComponent(document.getElementById("mstcustomer-name").value);
		var url = window.location.origin+'/brdsdev/web/admin-tools/get-material-by?id='+pname;
		var method = 'GET';
		var params = '';
		var container_id = 'list-materials' ;
		var loading_text = 'Processing...' ;
		if(pname == ''){
			alert('Please select materials')
		}else{
			ajax_view (url, method, params, container_id, loading_text) ;
		}
	}

	function syncAllMaterials() {
		var pname=encodeURIComponent(document.getElementById("mstcustomer-name").value);
		var url = brdsapi_site_url+"/brdsapi/materials_customer/"+pname+"/bigblue";
		var method = 'GET';
		var params = '';
		var container_id = 'sync-status' ;
		var loading_text = 'processing' ;
		if(pname == ''){
			alert('Please select materials')
		}else{
			ajax (url, method, params, container_id, loading_text) ;
		}
	}

	function syncMaterialOnly() {
		var pname=encodeURIComponent(document.getElementById("material-list_id").value);
		var url = brdsapi_site_url+"/brdsapi/materials_only/"+pname+"/bigblue";
		var method = 'GET';
		var params = '';
		var container_id = 'sync-status' ;
		var loading_text = 'processing' ;
		if(pname == ''){
			alert('Please select materials')
		}else{
			ajax (url, method, params, container_id, loading_text) ;
		}
	}

	document.getElementById("syncAllMaterials").addEventListener("click", function(e) {
		e.preventDefault();
		syncAllMaterials();
	});

	document.getElementById("material_only").addEventListener("click", function(e) {
		e.preventDefault();
		syncMaterialOnly();
	});

	document.getElementById("view_materials").addEventListener("click", function(e) {
		e.preventDefault();
		view_materials();

	});

	</script>
				
			</div>
		</div>
	</div>
</div>
