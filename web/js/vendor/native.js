//toggle functions
function _toggleshow(obj) {
	var el = document.getElementById(obj);
	if ( el.style.display != 'none' ) {
		el.style.display = 'none';
	}
	else {
		el.style.display = 'block';
	}
}
function _togglehidden2(obj) {
	var el = document.getElementById(obj);
	if ( el.style.display != 'block' ) {
		el.style.display = 'block';
	}
	else {
		el.style.display = 'none';
	}
}

function _togglehidden(obj,obj2) {
	var el = document.getElementById(obj);
	if ( el.style.display != 'block' ) {
		el.style.display = 'block';
		document.getElementById(obj2).focus();
	}
	else {
		el.style.display = 'none';
	}
}
