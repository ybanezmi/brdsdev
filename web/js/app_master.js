
var site_url = "/";

$(function () {
	 $("form#w0").on("beforeSubmit", function (event, messages, deferreds, attribute) {
       // $("button[type=\"submit\"]").attr("disabled","disabled");
    });
	/*date picker*/
	/*
	if (jQuery().datePicker) {
		$( "#datepicker-1, #datepicker-2" ).datepicker({
			showOn: "button",
			buttonImage: "../images/calendar.gif",
			buttonImageOnly: true,
			buttonText: "Select date"
		});
	}*/

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
    window.location = base_url;
}

function gotoReceiving() {
    window.location = "/";
}

/* function to set value to any HTML field by id */
function setFieldValueById(id, value, onchange) {
	if (document.getElementById(id)) {
		document.getElementById(id).value = value;

		// trigger onchange event on change value of field
		if (onchange) {
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
}

/* function to get value of any HTML field by name */
function setFieldValueByName(name, value, onchange) {
	if (document.getElementsByName(name)[0]) {
		document.getElementsByName(name)[0].value = value;

		// trigger onchange event on change value of field
		if (onchange) {
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

/* function to set field value to uppercase */
function setFieldValueToUpperCaseById(id, value) {
    setFieldValueById(id, value.toUpperCase());
}

/* function to filter non-numeric field value */
function filterNonNumericFieldValue(id) {
    setFieldValueById(id, getFieldValueById(id).replace(/\D/g,''));
}

/* function to hide HTML element by id */
function hideHTMLById(id) {
	document.getElementById(id).style.display = "none";
}

/* function to show HTML element by id */
function showHTMLById(id) {
	document.getElementById(id).style.display = "block";
}

// For todays date;
Date.prototype.today = function () {
    return (((this.getMonth()+1) < 10)?"0":"") + (this.getMonth()+1) + ((this.getDate() < 10)?"0":"") + this.getDate()
        + this.getFullYear().toString().substring(2,4);
}

// For the time now
Date.prototype.timeNow = function () {
     return ((this.getMinutes() < 10)?"0":"") + this.getMinutes() + ((this.getSeconds() < 10)?"0":"") + this.getSeconds();
}

/* function to generate timestamp */
function getTimestamp() {
    var currentDate = new Date();
    var dateTime = currentDate.today() + currentDate.timeNow();
	return dateTime;
}

/* function to check material sled */
function checkMaterialSled() {
	if (null != getMaterialSled() && getMaterialSled() != 0 && getFieldValueById("trxtransactiondetails-manufacturing_date").length > 0
	   && getFieldValueById("trxtransactiondetails-expiry_date").length == 0) {
		setFieldValueById("trxtransactiondetails-expiry_date",
			calculateDate(getFieldValueById("trxtransactiondetails-manufacturing_date"),getMaterialSled(),"add"));
	}

    if (null != getMaterialSled() && getMaterialSled() != 0 && getFieldValueById("trxtransactiondetails-expiry_date").length > 0
       && getFieldValueById("trxtransactiondetails-manufacturing_date").length == 0) {
        setFieldValueById("trxtransactiondetails-manufacturing_date",
            calculateDate(getFieldValueById("trxtransactiondetails-expiry_date"),getMaterialSled(),"subtract"));
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

	var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

	var dd = ('0' + newDate.getDate()).slice(-2);
	var mm = newDate.getMonth();
	var y = newDate.getFullYear();

	var formattedDate = dd + '-' + monthNames[mm] + '-' + y;

	return formattedDate;
}

/* function to search material by barcode/description */
/*
function searchMaterial() {
	var material_val = material_list_barcode[getFieldValueById("material_barcode")];
	if (null == material_val) {
		material_val = material_list_desc[getFieldValueById("material_barcode")];
	}

	return material_val;
}
*/

/* function to retrieve sled of material */
function getMaterialSled() {
	var material_sled_val = material_sled[getFieldValueById("trxtransactiondetails-material_code")];

	return material_sled_val;
}

/* function to retrieve pallet_ind of material */
function getMaterialPalletInd() {
    var material_pallet_ind_val = material_pallet_ind[getFieldValueById("trxtransactiondetails-material_code")];

    return material_pallet_ind_val;
}

/* function to retrieve unit of material conversion */
function getMaterialConversionUnit() {
	if (!material_conversion['conversion_flag']) {
	    return 'KG';
	} else {
        return material_conversion[getFieldValueById('trxtransactiondetails-net_unit')]['unit'];
	}
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
				material_total_weight = Math.ceil(parseInt(getFieldValueById("trxtransactiondetails-net_weight")) * (material_conversion[getFieldValueById('trxtransactiondetails-net_unit')]['num'] /
					   material_conversion[getFieldValueById('trxtransactiondetails-net_unit')]['den']));
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
	if (typeof transaction_details[getFieldValueById("trxtransactiondetails-pallet_no")] != 'undefined'
	   && transaction_details[getFieldValueById("trxtransactiondetails-pallet_no")]['status'] == 'closed') {
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
        }
        setFieldValueById("trxtransactiondetails-pallet_weight", parseInt(trx_pallet_weight));
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

function getQueryVariable(variable) {
  var query = window.location.search.substring(1);
  var vars = query.split("&");
  for (var i=0;i<vars.length;i++) {
    var pair = vars[i].split("=");
    if (pair[0] == variable) {
      return pair[1];
    }
  }
  alert('Query Variable ' + variable + ' not found');
}

/* function to retrieve material conversion */
function getMaterialConversion() {
    load('get-material-conversion?id=' + getFieldValueById("trxtransactiondetails-material_code"), function(xhr) {
        var jsonData = JSON.parse(xhr.responseText);
        material_conversion = jsonData;

        if (!jsonData.conversion_flag) {
            // remove select element
            if (document.getElementById('trxtransactiondetails-net_unit')) {
                document.getElementById('net-wt').removeChild(document.getElementById('trxtransactiondetails-net_unit'));
            }

            // add span element
            if (!document.getElementById('net-unit')) {
                var spanElem = document.createElement('span');
                spanElem.id = "net-unit";
                spanElem.innerHTML = "KG";

                document.getElementById('net-wt').appendChild(spanElem);
            }
        } else {
            // remove span element
            if (document.getElementById('net-unit')) {
                document.getElementById('net-unit').remove();
            }

            // add select element
            var selectElem = document.getElementById('trxtransactiondetails-net_unit');
            if (!selectElem) {
                selectElem = document.createElement('select');
                selectElem.id = "trxtransactiondetails-net_unit";
                selectElem.setAttribute('name', 'TrxTransactionDetails[net_unit]');
                selectElem.setAttribute('class', 'uborder help-20percent');

                document.getElementById('net-wt').appendChild(selectElem);
            }

            // clear options
            var i = 0;
            selectElem.options.length = 0;
            if (typeof jsonData.unit_1 != 'undefined' && jsonData.unit_1.unit != 'KG') {
                var option  = document.createElement('option');
                option.value = "unit_1";
                option.text = jsonData.unit_1.unit;
                selectElem.add(option, selectElem[i+1]);
                i++;
            }

            if (typeof jsonData.unit_2 != 'undefined' && jsonData.unit_2.unit != 'KG') {
                var option  = document.createElement('option');
                option.value = "unit_2";
                option.text = jsonData.unit_2.unit;
                selectElem.add(option, selectElem[i+1]);
                i++;
            }

            if (typeof jsonData.unit_3 != 'undefined' && jsonData.unit_3.unit != 'KG') {
                var option  = document.createElement('option');
                option.value = "unit_3";
                option.text = jsonData.unit_3.unit;
                selectElem.add(option, selectElem[i+1]);
                i++;
            }
        }
    });
}

function searchMaterial(value) {
    load('get-material?id=' + customer_code + '&desc=' + value, function(xhr) {
        var jsonData = JSON.parse(xhr.responseText);

        var x  = document.getElementById('trxtransactiondetails-material_code');

        // clear options
        x.options.length = 0;

        // set prompt value
        var promptOption = document.createElement('option');
        promptOption.text = "-- Select a product --";
        x.add(promptOption);

        if(null != jsonData){
            for(var i = 0; i < jsonData.item_code.length; i++){
                var option  = document.createElement('option');
                option.value = jsonData.item_code[i];
                option.text = jsonData.description[i];
                x.add(option, x[i+1]);
            }
        }

        // set initial value
        setFieldValueById('trxtransactiondetails-material_code', jsonData.item_code[0], true);
    });
}

/* function to repopulate packaging type based on material pallet_ind */
function populatePackagingType() {
    load('get-packaging-type?id=' + getMaterialPalletInd(), function(xhr) {
        var jsonData = JSON.parse(xhr.responseText);
        var x  = document.getElementById('trxtransactiondetails-packaging_code');

        // clear options
        x.options.length = 0;

        if(null != jsonData){
            for(var i = 0; i < jsonData.material_code.length; i++){
                var option  = document.createElement('option');
                option.value = jsonData.material_code[i];
                option.text = jsonData.description[i];
                x.add(option, x[i+1]);
            }
        }
    });
}

/* function to repopulate kitting type based on material pallet_ind */
function populateKittingType() {
    load('get-kitting-type?id=' + getMaterialPalletInd(), function(xhr) {
        var jsonData = JSON.parse(xhr.responseText);
        var x  = document.getElementById('trxtransactiondetails-kitting_code');

        // clear options
        x.options.length = 0;

        // set prompt value
        var promptOption = document.createElement('option');
        promptOption.text = "-- Select a kitting type --";
        x.add(promptOption);

        if(null != jsonData){
            for(var i = 0; i < jsonData.material_code.length; i++){
                var option  = document.createElement('option');
                option.value = jsonData.material_code[i];
                option.text = jsonData.description[i];
                x.add(option, x[i+1]);
            }
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
		document.getElementById('trxtransactiondetails-transaction_id').innerHTML='';

		var jsonData = JSON.parse(xhr.responseText);
		var x  = document.getElementById('trxtransactiondetails-transaction_id');
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
		    	setFieldValueByName("created_date", jsonData.created_date_formatted); // @TODO: incorrect date format
		    	setFieldValueByName("transaction_id", jsonData.id);
		    	setFieldValueByName("sap_no", jsonData.sap_no);
		    	setFieldValueByName("plant_location", jsonData.plant_location);
		    	setFieldValueByName("storage_location", jsonData.storage_location);
		    	setFieldValueByName("truck_van", jsonData.truck_van);
		    	setFieldValueByName("pallet_count", jsonData.pallet_count);
		    	setFieldValueByName("total_weight", jsonData.total_weight);

		    	remarks = jsonData.remarks;
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
    var grossWeight = 0;
    var palletTare = 0;
    var productTare = 0;
    var palletPackagingTare = 0;

    if (!isNaN(parseFloat(getFieldValueById('gross_weight')))) {
	    grossWeight = parseFloat(getFieldValueById('gross_weight'));
    }

    if (!isNaN(parseFloat(getFieldValueById('pallet_tare')))) {
    	palletTare = parseFloat(getFieldValueById('pallet_tare'));
    }

    if (!isNaN(parseFloat(getFieldValueById('product_tare_total')))) {
        productTare = parseFloat(getFieldValueById('product_tare_total'));
    }

    if (!isNaN(parseFloat(getFieldValueById('pallet_packaging_tare')))) {
        palletPackagingTare = parseFloat(getFieldValueById('pallet_packaging_tare'));
    }

	var netWeight = grossWeight - (palletTare + productTare + palletPackagingTare);
	if (!isNaN(netWeight) && netWeight > 0) {
		setFieldValueById('net_weight', netWeight);
	} else {
		setFieldValueById('net_weight', '0');
	}
}

/* function to calculate total product tare */
function calculateTotalProductTare() {
	var productTare = getFieldValueById('product_tare');
	var units = getFieldValueById('units');

	if (!isNaN(productTare) && null != productTare && productTare.length > 0
		&& !isNaN(units) && null != units && units.length > 0) {
		setFieldValueById('product_tare_total', parseFloat(productTare) * parseFloat(units));
	} else {
		setFieldValueById('product_tare_total', '0');
	}
}

/* function to view transaction summary */
function viewTransactionSummary(transaction_id) {
	if (null != transaction_id && "" != transaction_id && "-- Select a transaction --" != transaction_id) {
		window.open("view-entries?id=" + transaction_id,'_blank');
	} else {
		alert('Please select a transaction.');
	}
}

/* function to view pallet details */
function viewPalletDetails(transaction_id, pallet_no) {
	if (null != transaction_id && "" != transaction_id && "-- Select a transaction --" != transaction_id) {
		if (null != pallet_no && "" != pallet_no) {
			window.location = "view-entries?TrxTransactionDetailsSearch[pallet_no]=" + pallet_no + "&id=" + transaction_id;
		} else {
			alert('Please enter pallet no.');
		}
	} else {
		alert('Please select a transaction.');
	}
}

/* synchronize js*/
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
			toggleSync();
			document.getElementById(container_id).innerHTML = xhr.responseText;
		} else {
			toggleSync();
			document.getElementById(container_id).innerHTML = loading_text;


		}
	}
	xhr.open(method, url, true);
	xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xhr.send(params);
}

function toggleSync() {
    var e = document.getElementById("sync-progress");
    var m = document.getElementById("sync-bg");
    e.style.display = (e.style.display == "block") ? "none" : "block";
    m.style.display = (m.style.display == "block") ? "none" : "block";
}


function ajax_dispatch (url, method, params, container_id, loading_text) {
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