function makeRequest(url, callBackFn, params) {
	var xmlHttp = null;
	if (typeof XMLHttpRequest != "undefined") {
		xmlHttp= new XMLHttpRequest();
	}
	else if (window.ActiveXObject) {
		xmlHttp= new ActiveXObject("Microsoft.XMLHTTP");
	}
	if (xmlHttp==null){
		alert ("Browser does not support XMLHTTP Request");
		return;
	}
	xmlHttp.onreadystatechange = callBackFn;
	xmlHttp.open("GET", url, true);
	xmlHttp.send(null);
	return xmlHttp;
}

function isResponseReady(catOptionReq) {
    if (catOptionReq !=  null && (catOptionReq.readyState == 4 || catOptionReq.readyState==200)) {
	    return true;
	}
	return false;
}