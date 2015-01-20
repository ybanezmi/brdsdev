$(function() {
	/*date picker*/
	if (jQuery().datePicker) {
		$( "#datepicker-1, #datepicker-2" ).datepicker({
			showOn: "button",
			buttonImage: "../images/calendar.gif",
			buttonImageOnly: true,
			buttonText: "Select date"
		});
	}
	
	/*modal view*/
	$("#forgotpassword, #openpallet, #closepallet, #rejectpallet, #createto").modal('hide');

	/*dropdown menu*/
	$('.dropdown-toggle').dropdown();

	/*temporary direct page*/
	$( ".cancel-button" ).click(function(e){
		e.preventDefault();
		goBack();
	});
	
	$( ".backto" ).click(function(e){
		e.preventDefault();
		goBack();
	});

	$( ".back-to-main" ).click(function(e){
		e.preventDefault();
		gotoMain();
	});

	$( ".disabled-button" ).click(function(e){
		e.preventDefault();
	});

	$( ".goto-recieving" ).click(function(e){
		e.preventDefault();
		gotoReceiving();
	});

});


/*function emporary direct page*/
function goBack() {
    window.history.back();
}

function backto() {
    window.history.back();
}

function gotoMain() {
    window.location = "/front-ends/bigblueui/converted/brds/admin.php";
}

function gotoReceiving() {
    window.location = "/front-ends/bigblueui/converted/brds/receiving.php";
}

/* function to set value to any HTML field by id */
function setFieldValueById(id, value) {
	if (document.getElementById(id)) {
		document.getElementById(id).value = value;
		
		// trigger onchange event on change value of field
		var ctrl = document.getElementById(id);
		if (document.createEvent && ctrl.dispatchEvent) {
		    var evt = document.createEvent("HTMLEvents");
		    evt.initEvent("change", true, true);
		    ctrl.dispatchEvent(evt); // for DOM-compliant browsers
		} else if (ctrl.fireEvent) {
		    ctrl.fireEvent("onchange"); // for IE
		}
	}
}

/* function to get value of any HTML field by name */
function setFieldValueByName(name, value) {
	if (document.getElementsByName(name)[0]) {
		document.getElementsByName(name)[0].value = value;
		
		// trigger onchange event on change value of field
		var ctrl = document.getElementsByName(name)[0];
		if (document.createEvent && ctrl.dispatchEvent) {
		    var evt = document.createEvent("HTMLEvents");
		    evt.initEvent("change", true, true);
		    ctrl.dispatchEvent(evt); // for DOM-compliant browsers
		} else if (ctrl.fireEvent) {
		    ctrl.fireEvent("onchange"); // for IE
		}
	}
}

/* function to get the inner html of any HTML element */
function getInnerHTMLById(id) {
	if (document.getElementById(id)) {
		return document.getElementById(id).innerHTML;
	}
}

/* function to set the inner html of any HTML element */
function setInnerHTMLById(id, value) {
	if (document.getElementById(id)) {
		document.getElementById(id).innerHTML = value;
	}
}

/* function to get value of any HTML field by id */
function getFieldValueById(id) {
	return document.getElementById(id).value;
}

/* function to get value of any HTML field by name */
function getFieldValueByName(name) {
	return document.getElementsByName(name)[0].value;
}

/* function to hide HTML element by id */
function hideHTMLById(id) {
	document.getElementById(id).style.display = "none";
}

/* function to show HTML element by id */
function showHTMLById(id) {
	document.getElementById(id).style.display = "block";
}

/* function to generate timestamp */
function getTimestamp() {
	if (!Date.now) {
	    Date.now = function() { return new Date().getTime(); };
	}
	
	return Date.now();
}

/* function to check material sled */
function checkMaterialSled() {
	if (null != getMaterialSled() && getFieldValueById("trxtransactiondetails-manufacturing_date").length > 0) {
		setFieldValueById("trxtransactiondetails-expiry_date",
			calculateDate(getFieldValueById("trxtransactiondetails-manufacturing_date"),getMaterialSled(),"add"));
	}
}

/* function to add/subtract days in a date string */
function calculateDate(strDate, days, type) {
	var newDate = new Date(strDate);
	if (type == 'add') {
		newDate.setDate(newDate.getDate() + days);
	} else if (type == 'subtract') {
		newDate.setDate(newDate.getDate() - days);
	} else {
		// do nothing
	}
	
	var dd = newDate.getDate();
	var mm = newDate.getMonth() + 1;
	var y = newDate.getFullYear();
	
	var formattedDate = mm + '/' + dd + '/' + y;
	
	return formattedDate;
}

/* function to search material by barcode/description */
function searchMaterial() {
	var material_val = material_list_barcode[getFieldValueById("material_barcode")];
	if (null == material_val) {
		material_val = material_list_desc[getFieldValueById("material_barcode")];
	}
	
	return material_val;
}

/* function to retrieve sled of material */
function getMaterialSled() {
	var material_sled_val = material_sled[getFieldValueById("trxtransactiondetails-material_code")];
	
	return material_sled_val;
}

/* function to retrieve unit of material conversion */
function getMaterialConversionUnit() {
	var material_conv_unit = "KG";
	if (null != material_conversion[getFieldValueById("trxtransactiondetails-material_code")]) {
		material_conv_unit = material_conversion[getFieldValueById("trxtransactiondetails-material_code")]['unit_1'];
		if (material_conv_unit === "CBM" || material_conv_unit === "BXS") {
			material_conv_unit = "QTY";
		}
	}
	
	
	return material_conv_unit;
}

/* function to get total weight of material */
function getMaterialTotalWeight() {
	var material_total_weight = getFieldValueById("trxtransactiondetails-net_weight");
	if (null != material_total_weight && material_total_weight.length > 0) {
		switch(getMaterialConversionUnit()) {
			case 'KG':
				// do nothing 
				break;
			case 'CBM':
			case 'BXS':
				material_total_weight = Math.ceil(parseInt(getFieldValueById("trxtransactiondetails-net_weight")) * (material_conversion[getFieldValueById("trxtransactiondetails-material_code")]['num_1'] /
					   material_conversion[getFieldValueById("trxtransactiondetails-material_code")]['den_1']));
				break;
			default:
				// do nothing
				break;
		}
	} else {
		material_total_weight = 0;
	}
	
	return material_total_weight;
}

/* function to check if the pallet can be processed */
function checkTransactionStatus() {
	if (transaction_details[getFieldValueById("trxtransactiondetails-pallet_no")]['status'] == 'closed') {
      return false;
    } else {
      return true;
    } 
}

/* function to check existing pallet kitted unit of transaction detail */
function checkTransactionKittedUnit() {
    if (checkTransactionStatus()) {
      if (null != transaction_details[getFieldValueById("trxtransactiondetails-pallet_no")]) {
          var trx_kitted_unit = transaction_details[getFieldValueById("trxtransactiondetails-pallet_no")]['kitted_unit'];
          
          // set fixed value
          setFieldValueById("trxtransactiondetails-kitted_unit", trx_kitted_unit);
          
      } else {
          // set to blank
          setFieldValueById("trxtransactiondetails-kitted_unit", "");
          
      }
    } else {
      alert('Pallet ' + getFieldValueById("trxtransactiondetails-pallet_no") + ' is already closed.');
      document.getElementById("trxtransactiondetails-kitted_unit").value = "";
      document.getElementById("trxtransactiondetails-pallet_weight").value = "0";
    }
}

/* function to check pallet weight of transaction_detail */
function checkTransactionPalletWeight() {
    if (checkTransactionStatus()) {
        var trx_pallet_weight = 0;
        // add current net weight
        if (null != getMaterialTotalWeight()) {
            trx_pallet_weight = trx_pallet_weight + parseInt(getMaterialTotalWeight());
        }
        if (null != transaction_details[getFieldValueById("trxtransactiondetails-pallet_no")]) {
            trx_pallet_weight = trx_pallet_weight + parseInt(transaction_details[getFieldValueById("trxtransactiondetails-pallet_no")]['pallet_weight']);
            
            // set initial value
            setFieldValueById("trxtransactiondetails-pallet_weight", parseInt(trx_pallet_weight));
        } else {
            // unset initial value
            setFieldValueById("trxtransactiondetails-pallet_weight", 0);
        }
	}
}

/* function to check pallet type of transaction_detail */
function checkTransactionPalletType() {
	if (checkTransactionStatus() && null != transaction_details[getFieldValueById("trxtransactiondetails-pallet_no")]) {
		setFieldValueById("material-pallet_type", transaction_details[getFieldValueById("trxtransactiondetails-pallet_no")]['pallet_type']);
	}
}

/* function to validate pallet type of material and transaction_detail */
function validateTransactionPalletType() {
	if (null != transaction_details[getFieldValueById("trxtransactiondetails-pallet_no")] && getFieldValueById("trxtransactiondetails-pallet_type").length > 0) {
		var pallet_type = transaction_details[getFieldValueById("trxtransactiondetails-pallet_no")]['pallet_type'];
		if (pallet_type !== getFieldValueById("trxtransactiondetails-pallet_type")) {
			document.getElementsByClassName("field-trxtransactiondetails-pallet_no")[0].className = "form-group field-trxtransactiondetails-pallet_no required has-error";
			alert('Pallet type is different with the customer product pallet type.');
		} else {
			document.getElementsByClassName("field-trxtransactiondetails-pallet_no")[0].className = "form-group field-trxtransactiondetails-pallet_no required has-success";
		}
	}
}

/* function to validate pallet status */
function validateTransactionPallet(id) {
	load('validate-pallet?id=' + id, function(xhr) {
		var jsonData = JSON.parse(xhr.responseText);
		if (!jsonData.valid) {
			document.getElementsByClassName("field-trxtransactiondetails-pallet_no")[0].className = "form-group field-trxtransactiondetails-pallet_no required has-error";
			alert('Pallet # is already closed');
		} else {
			document.getElementsByClassName("field-trxtransactiondetails-pallet_no")[0].className = "form-group field-trxtransactiondetails-pallet_no required has-success";
		}
	});
}

/* function to retrieve pallet weight of transaction_detail */
function getTransactionPalletWeight() {
	var trx_pallet_weight = 0;
	if (null != transaction_details[getFieldValueById("trxtransactiondetails-pallet_no")]) {
		var trx_pallet_weight = transaction_details[getFieldValueById("trxtransactiondetails-pallet_no")]['pallet_weight'];
	}
	
	return trx_pallet_weight;
}

/* function to retrieve transaction list */
function getTransactionList(code){
	load('get-transaction-list?id=' + code,function(xhr) {
		document.getElementById('transaction-list').innerHTML='';

		var jsonData = JSON.parse(xhr.responseText);
		var x  = document.getElementById('transaction-list');
		//setFieldValueByName('transaction-list', ['']);
		
		// set prompt value
		var promptOption = document.createElement('option');
		promptOption.text = "-- Select a transaction --";
		x.add(promptOption);
		
		if(null != jsonData){
			for(var i = 0; i < jsonData.length; i++){
				var option  = document.createElement('option');
				option.text = jsonData[i];
				x.add(option, x[i+1]);
			}
		}

	});
}

/* function to retrieve transaction */
function getTransaction(id) {
	load("get-transaction?id=" + id, function(xhr) {
		if (null != xhr.responseText && xhr.responseText.length > 0) {
			var jsonData = JSON.parse(xhr.responseText);
	    
		    if (null != jsonData) {
		    	// show transaction details panel
		    	showHTMLById("trx-details");
		    	
		    	// set corresponding field values
		    	setFieldValueByName("customer_name", jsonData.customer_name);
		    	setFieldValueByName("customer_code", jsonData.customer_code);
		    	setFieldValueByName("created_date", jsonData.created_date); // @TODO: incorrect date format
		    	setFieldValueByName("transaction_id", jsonData.id);
		    	setFieldValueByName("sap_no", jsonData.sap_no);
		    	setFieldValueByName("plant_location", jsonData.plant_location);
		    	setFieldValueByName("storage_location", jsonData.storage_location);
		    	setFieldValueByName("truck_van", jsonData.truck_van); // @TODO: add remarks onclick attribute
		    	setFieldValueByName("pallet_count", jsonData.pallet_count);
		    	setFieldValueByName("total_weight", jsonData.total_weight);
		    	
		    } else {
		    	// hide transaction details panel
		    	hideHTMLById("trx-details");
		    }
		} else {
			// hide transaction details panel
	    	hideHTMLById("trx-details");
		}
	    
	    
	});
}

/* function used for ajax requests */
function load(url, callback) {
    var xhr;
     
    if(typeof XMLHttpRequest !== 'undefined') xhr = new XMLHttpRequest();
    else {
        var versions = ["MSXML2.XmlHttp.5.0", 
                        "MSXML2.XmlHttp.4.0",
                        "MSXML2.XmlHttp.3.0", 
                        "MSXML2.XmlHttp.2.0",
                        "Microsoft.XmlHttp"]
 
             for(var i = 0, len = versions.length; i < len; i++) {
                try {
                    xhr = new ActiveXObject(versions[i]);
                    break;
                }
                catch(e){}
             } // end for
        }
         
        xhr.onreadystatechange = ensureReadiness;
         
        function ensureReadiness() {
            if(xhr.readyState < 4) {
                return;
            }
             
            if(xhr.status !== 200) {
                return;
            }
 
            // all is well  
        if(xhr.readyState === 4) {
            callback(xhr);
        }           
    }
     
    xhr.open('GET', url, true);
    xhr.send('');
}

/* function to retrieve account info */
function getAccountInfo(id) {
	load('get-account-info?id=' + id,function(xhr) {
		document.getElementById('modal-content').innerHTML=xhr.responseText;
	});
}

/* number extension for values with leading zeroes */
Number.prototype.padLeft = function(base,chr) {
    var  len = (String(base || 10).length - String(this).length)+1;
    return len > 0? new Array(len).join(chr || '0')+this : this;
}

/* function to retrieve material list by customer */
function getMaterialList(code) {
	load('get-material-list?item_code=' + code, function(xhr) {
		var jsonData = JSON.parse(xhr.responseText);
		var x  = document.getElementById('material');
		
		// clear options
		x.options.length = 0;
		
		// set prompt value
		var promptOption = document.createElement('option');
		promptOption.value = "";
		promptOption.innerHTML = "-- Select a material --";
		x.add(promptOption);
		
		if(null != jsonData){
			for(var i = 0; i < jsonData.length; i++){
				var option  = document.createElement('option');
				option.value = jsonData[i]['item_code'];
				option.innerHTML = jsonData[i]['description'];
				x.add(option, x[i+1]);
			}
		}
	});
}

/* function to calculate net weight */
function calculateNetWeight() {
	var grossWeight = parseInt(getFieldValueById('gross_weight'));
	var palletTare = parseInt(getFieldValueById('pallet_tare'));
	var productTare = parseInt(getFieldValueById('product_tare_total'));
	var palletPackagingTare = parseInt(getFieldValueById('pallet_packaging_tare'));
	
	var netWeight = grossWeight - (palletTare + productTare + palletPackagingTare);
	
	if (!isNaN(netWeight)) {
		setFieldValueById('net_weight', netWeight);
	} else {
		setFieldValueById('net_weight', '0');
	}
}
