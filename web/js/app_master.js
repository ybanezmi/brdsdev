
var site_url = "/";
var decimalPlaces = 3;

$(function () {

        $("input.display").on("click", function(e){
            e.preventDefault();

            var $curclick = $(this).val();
            var $serval   = $(".search_box input.search").val();
            var $tableid  = $("table#ship-details");

            SearchCode($serval,$tableid,$curclick)

        });

function SearchCode(searchTerm, tableid, buttons) {

    if(buttons == 'CLEAR'){
        $(".search_box input.search").val("").focus();
        $('.bb').removeClass('curloc');
    } else {

        if(searchTerm) {
            var tableid = tableid || "body";

            if(!$('.bb').hasClass('curloc')){

             tableid.find('input.barcode').each(function(index) {
                    $(this).removeClass('matched');
                    $(this).siblings('.upc_1, .upc_2').removeClass('matched');

                    var bc = $(this).val();
                    var upc1 = $(this).siblings('.upc_1').val();
                    var upc2 = $(this).siblings('.upc_2').val();

                    var bf = '';
                    var upf1 = '';
                    var upf2 = '';

                    console.log(searchTerm);
                    console.log(upc2);


                    if(bc == searchTerm) {
                        bf = $(this).addClass('matched');
                        console.log('barcode');
                    }
                    else if(upc1 == searchTerm ){
                        upf1 = $(this).siblings('.upc_1').addClass('matched');
                        console.log('upc1');
                    }

                    else if(upc2 == searchTerm ){
                        upf2 = $(this).siblings('.upc_2').addClass('matched');
                        console.log('upc2');
                    }

                    if(bc == searchTerm) {
                        $('.bb').removeClass('curloc');


                        $('.matched').eq(0).siblings('.bb').addClass('curloc').focus();

                        temp = $(this).val();
                        cc=1;
                        getindex = index+1;
                    }

                    else if(upc1 == searchTerm) {
                        $('.bb').removeClass('curloc');


                        $('.matched').eq(0).siblings('.bb').addClass('curloc').focus();

                        temp = $(this).siblings('.upc_1').val();
                        cc=1;
                        getindex = index+1;
                    }

                     else if(upc2 == searchTerm) {
                        $('.bb').removeClass('curloc');


                        $('.matched').eq(0).siblings('.bb').addClass('curloc').focus();

                        temp = $(this).siblings('.upc_2').val();
                        cc=1;
                        getindex = index+1;
                    }



                });

            } else {

                if(temp == searchTerm){
                    $('.bb').removeClass('curloc');

                    tableid.find('input.matched').each(function(index) {
                        getindex = index+1;
                    });

                    if(getindex == 1){
                        cc=0;
                    }

                    $('.matched').eq(cc).siblings('.bb').addClass('curloc').focus();

                    cc+=1;

                    if(cc == getindex){
                        cc=0;
                    }

                } else {

                tableid.find('input.barcode').each(function(index) {
                    $(this).removeClass('matched');
                    $(this).siblings('.upc_1, .upc_2').removeClass('matched');

                    var bc = $(this).val();
                    var upc1 = $(this).siblings('.upc_1').val();
                    var upc2 = $(this).siblings('.upc_2').val();

                    var bf = '';
                    var upf1 = '';
                    var upf2 = '';

                    if(bc == searchTerm) {
                        bf = $(this).addClass('matched');
                    }
                    else if(upc1 == searchTerm ){
                        upf1 = $(this).siblings('.upc_1').addClass('matched');
                    }

                    else if(upc2 == searchTerm ){
                        upf2 = $(this).siblings('.upc_2').addClass('matched');
                    }

                    if(bc == searchTerm) {
                        $('.bb').removeClass('curloc');


                        $('.matched').eq(0).siblings('.bb').addClass('curloc').focus();

                        temp = $(this).val();
                        cc=1;
                        getindex = index+1;
                    }

                    else if(upc1 == searchTerm) {
                        $('.bb').removeClass('curloc');


                        $('.matched').eq(0).siblings('.bb').addClass('curloc').focus();

                        temp = $(this).siblings('.upc_1').val();
                        cc=1;
                        getindex = index+1;
                    }

                     else if(upc2 == searchTerm) {
                        $('.bb').removeClass('curloc');


                        $('.matched').eq(0).siblings('.bb').addClass('curloc').focus();

                        temp = $(this).siblings('.upc_2').val();
                        cc=1;
                        getindex = index+1;
                    }



                });

                }
            }
        } else {
            alert('Field is empty');
        }
    }

}


    $('.print-tag-form form, .dispatch-form form').bind("keypress", function(e) {
      if (e.keyCode == 13) {
        e.preventDefault();
        return false;
      }
    });

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


/*function temporary direct page*/
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

function getFieldValueRadioByName(name) {
	var radioFields = document.getElementsByName(name);
	var radioValue = '';
	
	for(var i = 0; i < radioFields.length; i++){
		if(radioFields[i].checked){
			radioValue = radioFields[i].value;
			break;
		}
	}
	
	return radioValue;
}

/* function to get value of any HTML field by name */
function getFieldValueByName(name) {
	return document.getElementsByName(name)[0].value;
}

/* function to set field value to uppercase */
function setFieldValueToUpperCaseById(id) {
    setFieldValueById(id, getFieldValueById(id).toUpperCase());
}

/* function to filter non-numeric field value */
function filterNonNumericFieldValue(id) {
    setFieldValueById(id, getFieldValueById(id).replace(/[^\d.-]/g,''));
}

/* function to convert to decimal format */
function convertToDecimalFormat(value, numberOfDecimals) {
    var decimal = '.';

    for (var i = 0; i < numberOfDecimals; i++) {
        decimal = decimal + '0';
    }
    /* if the user didn't add a dot, we add one with 3 zeros */
    if (value.indexOf('.') == -1) value += decimal;
    /* Otherwise, we check how many numbers there are after the dot
       and make sure there's at least 3*/
    if (value.substring(value.indexOf('.') + 1).length < numberOfDecimals)
        while (value.substring(value.indexOf('.') + 1).length < numberOfDecimals)
            value += '0';
    return value;
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
function checkMaterialSled(dateType) {
    var materialSled = getMaterialSled();
	if (null != materialSled && materialSled != 0 && dateType == "manufacturing_date") {
		setFieldValueById("trxtransactiondetails-expiry_date",
			calculateDate(getFieldValueById("trxtransactiondetails-manufacturing_date"),materialSled,"add"));
	}

    if (null != materialSled && materialSled != 0 && dateType == "expiry_date") {
        setFieldValueById("trxtransactiondetails-manufacturing_date",
            calculateDate(getFieldValueById("trxtransactiondetails-expiry_date"),materialSled,"subtract"));
    }
}

/* function to add/subtract days in a date string */
function calculateDate(strDate, days, type) {
    var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    var date = strDate.split('-');
    var year = date[2];
    var month = monthNames.indexOf(date[1]);
    var day = date[0];
	var newDate = new Date(year, month, day);

	if (type == 'add') {
		newDate.setDate(newDate.getDate() + parseInt(days));
	} else if (type == 'subtract') {
		newDate.setDate(newDate.getDate() - parseInt(days));
	} else {
		// do nothing
	}

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
			    material_total_weight = convertToDecimalFormat(material_total_weight, decimalPlaces);
                setFieldValueById("trxtransactiondetails-net_weight", material_total_weight);
				break;
		    case 'PCS':
			case 'CBM':
			case 'BXS':
			case 'BAG':
				material_total_weight = parseFloat(getFieldValueById("trxtransactiondetails-net_weight")) * (material_conversion[getFieldValueById('trxtransactiondetails-net_unit')]['den'] /
					   material_conversion[getFieldValueById('trxtransactiondetails-net_unit')]['num']);
			    material_total_weight = material_total_weight.toFixed(decimalPlaces);
				break;
			default:
				material_total_weight = convertToDecimalFormat(material_total_weight, decimalPlaces);
                setFieldValueById("trxtransactiondetails-net_weight", material_total_weight);
				break;
		}
	} else {
		material_total_weight = "0.000";
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
            var trx_kitting_code = transaction_details[getFieldValueById("trxtransactiondetails-pallet_no")]['kitting_code'];

            // set fixed value
            setFieldValueById("trxtransactiondetails-kitting_code", trx_kitting_code);
            setFieldValueById("trxtransactiondetails-kitted_unit", trx_kitted_unit);
        }
    } else {
      alert('Pallet ' + getFieldValueById("trxtransactiondetails-pallet_no") + ' is already closed.');
      document.getElementById("trxtransactiondetails-kitted_unit").value = "";
      document.getElementById("trxtransactiondetails-pallet_weight").value = "0.000";
    }
}

/* function to check pallet weight of transaction_detail */
function checkTransactionPalletWeight() {
    if (checkTransactionStatus()) {
        var trx_pallet_weight = "0.000";
        // add current net weight
        if (null != getMaterialTotalWeight()) {
            trx_pallet_weight = parseFloat(trx_pallet_weight) + parseFloat(getMaterialTotalWeight());
        }

        if (null != transaction_details[getFieldValueById("trxtransactiondetails-pallet_no")]) {
            trx_pallet_weight = parseFloat(trx_pallet_weight) + parseFloat(transaction_details[getFieldValueById("trxtransactiondetails-pallet_no")]['pallet_weight']);
        }
        setFieldValueById("trxtransactiondetails-pallet_weight", trx_pallet_weight.toFixed(decimalPlaces));
	}
}

/* new function to validate pallet type of material and transaction_detail */
function validatePalletType(palletNo, materialCode, transactionId) {
    if (palletNo && transactionId) {
        load('validate-pallet?id=' + palletNo + '&material_code=' + materialCode + '&transaction_id=' + transactionId, function(xhr) {
            var jsonData = JSON.parse(xhr.responseText);

            if (null != jsonData) {
                if (jsonData.error) {
                    alert(jsonData.error);
                    setFieldValueById("trxtransactiondetails-pallet_no", "");
                } else {
                    checkTransactionKittedUnit();
                    checkTransactionPalletWeight();
                    checkTransactionPalletType();
                }
            }
        });
    }
}

/* new function to validate kitting type of material and transaction_detail */
function validateKittingType(palletNo, materialCode, transactionId) {
    if (palletNo && transactionId) {
        load('validate-pallet?id=' + palletNo + '&material_code=' + materialCode + '&transaction_id=' + transactionId, function(xhr) {
            var jsonData = JSON.parse(xhr.responseText);

            if (null != jsonData) {
                if (jsonData.error) {
                    alert(jsonData.error);
                    setFieldValueById("trxtransactiondetails-kitted_unit", "");
                }
            }
        });
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
            document.getElementById('net-weight').innerHTML = "NET WT";

            // remove unit span element
            if (document.getElementById('unit-label')) {
            	document.getElementById('unit-label').remove();
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
                selectElem.setAttribute('class', 'uborder help-25percent');
                selectElem.setAttribute('onchange', 'calculateTotalWeight()');

                document.getElementById('net-wt').appendChild(selectElem);
            }

            // clear options
            var i = 0;
            selectElem.options.length = 0;
            if (typeof jsonData.unit_1 != 'undefined' && jsonData.unit_1.unit != 'KG') {
                var option  = document.createElement('option');
                option.value = "unit_1";
                option.text = jsonData.unit_1.unit + ' (' +  jsonData.unit_1.den / jsonData.unit_1.num + ' KG)';
                selectElem.add(option, selectElem[i+1]);
                i++;
            }

            if (typeof jsonData.unit_2 != 'undefined' && jsonData.unit_2.unit != 'KG') {
                var option  = document.createElement('option');
                option.value = "unit_2";
                option.text = jsonData.unit_2.unit + ' (' +  jsonData.unit_2.den / jsonData.unit_2.num + ' KG)';
                selectElem.add(option, selectElem[i+1]);
                i++;
            }

            if (typeof jsonData.unit_3 != 'undefined' && jsonData.unit_3.unit != 'KG') {
                var option  = document.createElement('option');
                option.value = "unit_3";
                option.text = jsonData.unit_3.unit + ' (' +  jsonData.unit_3.den / jsonData.unit_3.num + ' KG)';
                selectElem.add(option, selectElem[i+1]);
                i++;
            }

            document.getElementById('net-weight').innerHTML = "QUANTITY";
        }
    });
}

function searchMaterial(value, customer_code, id) {
    load('get-material?id=' + customer_code + '&desc=' + value, function(xhr) {
        var jsonData = JSON.parse(xhr.responseText);

        var x  = document.getElementById(id);

        // clear options
        x.options.length = 0;

        // set prompt value
        var promptOption = document.createElement('option');
        promptOption.text = "-- Select a product --";
        x.add(promptOption);

		if(jsonData) {
			var i  = 1;
			for(var key in jsonData)
			{
				var option  = document.createElement('option');
				option.value = key;
				option.text = jsonData[key];

				x.add(option, x[i]);
				i++;
			}
        }

    });
}

/* function to repopulate packaging type based on material pallet_ind */
function populatePackagingType() {
    load('get-packaging-type?id=' + getMaterialPalletInd() + '&plant_location=' + plant_location, function(xhr) {
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
    load('get-kitting-type?id=' + getMaterialPalletInd() + '&plant_location=' + plant_location, function(xhr) {
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
	var trx_pallet_weight = '0.000';
	if (null != transaction_details[getFieldValueById("trxtransactiondetails-pallet_no")]) {
		var trx_pallet_weight = parseFloat(transaction_details[getFieldValueById("trxtransactiondetails-pallet_no")]['pallet_weight']);
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

/* function to retrieve transaction list by transaction type */
function getTransactionListByType(code, brds_type, sap_type){
    var transaction_type = 'brds';
    if (sap_type) {
        transaction_type = 'sap';
    }
    load('get-transaction-list?id=' + code + '&type=' + transaction_type,function(xhr) {
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

function isEmpty(obj) {
    for(var prop in obj) {
        if(obj.hasOwnProperty(prop))
            return true;
    }
    return false;
}

function removeOptions(selectbox)
{
    var i;
    for(i=selectbox.options.length-1;i>=0;i--)
    {
        selectbox.remove(i);
    }
}


/* function to retrieve transaction list */
function getMateriaList(code){
    load('get-material-list?id=' + code,function(xhr) {
      if (null != xhr.responseText && xhr.responseText.length > 0) {
        var jsonData = JSON.parse(xhr.responseText);
        var x  = document.getElementById('material-list_id');
        var promptOption = document.createElement('option');
        removeOptions(x);

        if(isEmpty(jsonData)){
            for(var i = 0; i < jsonData.length; i++){
                var option  = document.createElement('option');
                option.value = jsonData[i].item_code;
                /*option.text = jsonData[i].description;*/
                option.text = jsonData[i].item_code + ' - ' + jsonData[i].description;
                x.add(option, x[i+1]);
            }
            x.style.display = "block";
            promptOption.text = "-- Select a materials --";
            promptOption.value = "";
            promptOption.selected = true;
            x.add(promptOption, x[0]);
        } else {
            x.style.display = "none";
        }
    } else {
        document.getElementById.style.display = "none";
    }



    });
}

/*determine if obj is empty*/

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

/* function to retrieve transaction by transaction type */
function getTransactionByType(id, brds_type, sap_type) {
    var transaction_type = 'brds';
    if (sap_type) {
        transaction_type = 'sap';
    }
    load("get-transaction?id=" + id + '&type=' + transaction_type, function(xhr) {
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

/* function to retrieve pallet details for View & Close Pallet page */
function getPalletDetails(id) {
    load("get-pallet-details?id=" + id, function(xhr) {
        if (null != xhr.responseText && xhr.responseText.length > 0) {
            var jsonData = JSON.parse(xhr.responseText);

            if (null != jsonData) {
                // show pallet details panel
                showHTMLById("pallet-details");

                // set corresponding field values
                setFieldValueByName("transaction_id", jsonData.transaction_id);
                setFieldValueByName("inbound_no", jsonData.inbound_no);
                setFieldValueByName("customer", jsonData.customer_name);
                setFieldValueByName("material_code", jsonData.material_code);
                setFieldValueByName("batch", jsonData.batch);
                setFieldValueByName("pallet_count", jsonData.pallet_count);
                setFieldValueByName("net_weight", jsonData.net_weight);
                setFieldValueByName("total_weight", jsonData.total_weight);
                setFieldValueByName("pallet_weight", jsonData.pallet_weight);
                setFieldValueByName("kitted_unit", jsonData.kitted_unit);
                setFieldValueByName("manufacturing_date", jsonData.manufacturing_date);
                setFieldValueByName("expiry_date", jsonData.expiry_date);
                setFieldValueByName("pallet_type", jsonData.pallet_type);
                setFieldValueByName("transfer_order", jsonData.transfer_order);
                setFieldValueByName("status", jsonData.status);
                setFieldValueByName("creator", jsonData.creator);
                setFieldValueByName("created_date", jsonData.created_date);
                setFieldValueByName("updater", jsonData.updater);
                setFieldValueByName("updated_date", jsonData.updated_date);

            } else {
                // hide pallet details panel
                hideHTMLById("pallet-details");
            }
        } else {
            // hide pallet details panel
            hideHTMLById("pallet-details");
        }
    });
}

/* function to retrieve pallet details for Edit Receiving page */
function getPalletDetailsForEdit(id) {
    load("get-pallet-details?id=" + id, function(xhr) {
        if (null != xhr.responseText && xhr.responseText.length > 0) {
            var jsonData = JSON.parse(xhr.responseText);

            if (null != jsonData) {
                setFieldValueById('mstcustomer-name', jsonData.customer_code, true);
                setTimeout (function() {
                  setFieldValueById('trxtransactiondetails-transaction_id', jsonData.transaction_id);
                }, 200);
            } else {
                // hide pallet details panel
                hideHTMLById("pallet-details");
            }
        } else {
            // hide pallet details panel
            hideHTMLById("pallet-details");
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

function calculateNOWorNEVER(){
    var grossWeight = 0;
    var palletTare = 0;
    var productTare = 0;
    var units = 0;
    var productTareTotal = 0;
    var palletPackagingTare = 0;
    var netWeight = 0;

    if (!isNaN(parseFloat(getFieldValueById('gross_weight')))) {
        grossWeight = parseFloat(getFieldValueById('gross_weight'));
    }

    if (!isNaN(parseFloat(getFieldValueById('pallet_tare')))) {
        palletTare = parseFloat(getFieldValueById('pallet_tare'));
    }

    if (!isNaN(parseFloat(getFieldValueById('product_tare')))) {
        productTare = parseFloat(getFieldValueById('product_tare'));
    }

    if (!isNaN(parseFloat(getFieldValueById('units')))) {
        units = parseFloat(getFieldValueById('units'));
    }

    if (!isNaN(parseFloat(getFieldValueById('product_tare_total')))) {
        productTareTotal = parseFloat(getFieldValueById('product_tare_total'));
    }

    if (!isNaN(parseFloat(getFieldValueById('pallet_packaging_tare')))) {
        palletPackagingTare = parseFloat(getFieldValueById('pallet_packaging_tare'));
    }

    if (!isNaN(parseFloat(getFieldValueById('net_weight')))) {
        netWeight = parseFloat(getFieldValueById('net_weight'));
    }

    ptt = (parseFloat(productTare) * parseFloat(units)).toFixed(3);
    ppt = (parseFloat(palletTare) + parseFloat(ptt)).toFixed(3);
    nt  = (parseFloat(grossWeight) - parseFloat(ppt)).toFixed(3);

    setFieldValueById('product_tare_total', ptt);
    setFieldValueById('pallet_packaging_tare', ppt);

    if(nt >= 0) {
        setFieldValueById('net_weight', nt);
    } else {
        setFieldValueById('net_weight', '0');
        alert('NET WEIGHT should not be negative value, NET WEIGHT has changed to ZERO!');
    }

}

/* function to view transaction summary */
function viewTransactionSummary(transaction_id, transaction_type) {
	if (null != transaction_id && "" != transaction_id && "-- Select a transaction --" != transaction_id) {
		window.location = "view-entries?id=" + transaction_id + "&transaction_type=" + transaction_type;
	} else {
		alert('Please select a transaction.');
	}
}

/* function to view pallet details */
function viewPalletDetails(pallet_no, transaction_id) {
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

function createToSelectPallet(pallet_no)
{
	if(!pallet_no)
	{
		alert('Please enter pallet no.');
	}
	else
	{
		window.location = "create-to?TrxTransactionDetailsSearch[pallet_no]=" + pallet_no;
	}
}

/* synchronize js*/
var brdsdev_site_url = "http://192.168.1.121";
var brdsapi_site_url = "http://192.168.1.122/brdsapi/";

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
			toggleSync('hide');
			document.getElementById(container_id).innerHTML = xhr.responseText;
		} else {
			toggleSync('show');
			document.getElementById(container_id).innerHTML = loading_text;


		}
	}
	xhr.open(method, url, true);
	xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//xhr.setRequestHeader("Access-Control-Allow-Origin",brdsapi_site_url);
	xhr.send(params);
}

function ajax_view (url, method, params, container_id, loading_text) {
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
            document.getElementById(container_id).style.display = 'block';
            document.getElementById(container_id).innerHTML = xhr.responseText;
        } else {

            document.getElementById(container_id).style.display = 'block';
            document.getElementById(container_id).innerHTML = loading_text;


        }
    }
    xhr.open(method, url, true);
    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//xhr.setRequestHeader("Access-Control-Allow-Origin","");
    xhr.send(params);
}

function toggleSync(display_type) {
    var e = document.getElementById("sync-progress");
    var m = document.getElementById("sync-bg");
	
	if(display_type)
	{
		var syncDisplay = ('show' == display_type) ? 'block' : 'none';
		
		if('show' == display_type)
		{
			syncDisplay = 'block';
		}
		
		e.style.display = syncDisplay;
		m.style.display = syncDisplay;
	}
	else
	{
		e.style.display = (e.style.display == "block") ? "none" : "block";
		m.style.display = (m.style.display == "block") ? "none" : "block";
	}
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

function onSelectMaterial(shouldNotClear) {
    if (!shouldNotClear) {
        clearAllFields();
    }
    if (getFieldValueById("trxtransactiondetails-material_code") != '-- Select a product --') {
        setFieldValueById("material_code",getFieldValueById("trxtransactiondetails-material_code"));
    }
    populatePackagingType();
    populateKittingType();
    getMaterialConversion();
    populateBatchDropdown(getFieldValueById("trxtransactiondetails-material_code"), getQueryVariable('id'));
}

function clearAllFields() {
    setFieldValueById("trxtransactiondetails-batch", "");
    setFieldValueById("trxtransactiondetails-manufacturing_date", "");
    setFieldValueById("trxtransactiondetails-expiry_date", "");
    setFieldValueById("trxtransactiondetails-net_weight", "");
    setFieldValueById("trxtransactiondetails-total_weight", "");
    setFieldValueById("trxtransactiondetails-pallet_no", "");
    setFieldValueById("trxtransactiondetails-kitted_unit", "");
    setFieldValueById("trxtransactiondetails-pallet_weight", "");
}

function calculateTotalWeight() {
    filterNonNumericFieldValue("trxtransactiondetails-net_weight");
    setFieldValueById("trxtransactiondetails-total_weight", getMaterialTotalWeight());
    var palletWeight = parseFloat(getMaterialTotalWeight()) + parseFloat(getTransactionPalletWeight());
    setFieldValueById("trxtransactiondetails-pallet_weight", palletWeight.toFixed(decimalPlaces));

    // add unit span element
	var spanElem = document.getElementById('unit-label');
	if (!spanElem) {
        spanElem = document.createElement('span');
        spanElem.id = 'unit-label';
	}

	spanElem.innerHTML = ' (' + (material_conversion[getFieldValueById('trxtransactiondetails-net_unit')]['den'] /
					   material_conversion[getFieldValueById('trxtransactiondetails-net_unit')]['num']) + ' KG)';
}

var useFlag = 0;
function toggleUse(id) {
    var btnLabel = document.getElementById('btn-use').innerHTML;
    if (!useFlag) {
        useFlag = 1;
        document.getElementById('batch-dropdown').style.display = 'block';
        document.getElementById('batch-dropdown').children[1].children[0].disabled = false;
        document.getElementById('batch-dropdown').children[1].children[0].setAttribute('class', 'uborder help-25percent');
        document.getElementById('batch-text').style.display = 'none';
        document.getElementById('batch-text').children[1].children[0].disabled = true;
        document.getElementById('batch-text').children[1].children[0].setAttribute('class', 'uborder help-25percent disabled');
    } else {
        useFlag = 0;
        document.getElementById('batch-dropdown').style.display = 'none';
        document.getElementById('batch-dropdown').children[1].children[0].disabled = true;
        document.getElementById('batch-dropdown').children[1].children[0].setAttribute('class', 'uborder help-25percent disabled');
        document.getElementById('batch-text').style.display = 'block';
        document.getElementById('batch-text').children[1].children[0].disabled = false;
        document.getElementById('batch-text').children[1].children[0].setAttribute('class', 'uborder help-25percent');
    }
    populateManufacturingExpiryDateFromBatch($("#trxtransactiondetails-batch:enabled").val(), getFieldValueById("material_code"));
}

function populateBatchDropdown(material, transactionId) {
    if (material && transactionId) {
        load('get-batch?id=' + material + '&desc=' + transactionId, function(xhr) {
            var jsonData = JSON.parse(xhr.responseText);
            var x = document.getElementById('batch-dropdown').children[1].children[0];

            // clear options
            x.options.length = 0;

            if (null != jsonData && jsonData.length > 0) {
                // show use buttons
                document.getElementById('btn-use').style.display = 'inline-block';
                document.getElementById('btn-use-cancel').style.display = 'inline-block';
                for(var i = 0; i < jsonData.length; i++){
                    var option  = document.createElement('option');
                    option.value = jsonData[i];
                    option.text = jsonData[i];

                    if (i == 0) {
                        option.selected = true;
                    }

                    x.add(option, x[i+1]);
                }
            } else {
                // hide use buttons
                document.getElementById('btn-use').style.display = 'none';
                document.getElementById('btn-use-cancel').style.display = 'none';
            }
        });
    } else {
        if (useFlag) {
            toggleUse();
        }
        // hide use buttons
        document.getElementById('btn-use').style.display = 'none';
        document.getElementById('btn-use-cancel').style.display = 'none';
    }
}

function populateManufacturingExpiryDateFromBatch(batch, materialCode) {
    if (batch) {
        var populateUrl = 'get-manufacturing-expiry-date-from-batch?id=' + batch;
        if (materialCode) {
            populateUrl = populateUrl + '&code=' + materialCode;
        }
        load(populateUrl, function(xhr) {
            var jsonData = JSON.parse(xhr.responseText);

            if (null != jsonData) {
                // set material
                if (jsonData.material_code) {
                    setFieldValueById('trxtransactiondetails-material_code', jsonData.material_code, false);
                    setFieldValueById('material_code', jsonData.material_code, false);
                    setFieldValueById('trxtransactiondetails-batch', batch);
                }

                // set manufacturing date
                if (jsonData.manufacturing_date) {
                    setFieldValueById('trxtransactiondetails-manufacturing_date', jsonData.manufacturing_date);
                } else {
                    setFieldValueById('trxtransactiondetails-manufacturing_date', '');
                }

                // set expiry date
                if (jsonData.expiry_date) {
                    setFieldValueById('trxtransactiondetails-expiry_date', jsonData.expiry_date);
                } else {
                    setFieldValueById('trxtransactiondetails-expiry_date', '');
                }
            } else {
                setFieldValueById('trxtransactiondetails-expiry_date', '');
                setFieldValueById('trxtransactiondetails-manufacturing_date', '');
            }
        });
    }
}

function scanPalletBarcode(materialCodeId, netWTId) {
    if (materialCodeId) {
        var barcode = getFieldValueById(materialCodeId).substring(0, 12);
        var netWT = getFieldValueById(materialCodeId).substring(12, 20).replace(/^0+/, '');

        setFieldValueById(materialCodeId, barcode, true);
        setFieldValueById(netWTId, netWT, true);
    }
}

function goBack() {
    var referrer = document.referrer;
    if(referrer != '') {
        window.location = referrer;
    } else {
        window.history.back();
    }
}

$(document).ready(function() {
    $("*").dblclick(function(e) {
        e.preventDefault();
    });
});
