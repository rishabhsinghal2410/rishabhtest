var catOptionReq = null;
var catTreeReq = null;
/*function makeRequest(url, callBackFn, params) {
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
}*/

function addNewCategory(parentId) {
    $('#parent_category').val(parentId)
}

function createCategoryTree(branches) {
    var root = document.createElement("ul");
	var rootLi = document.createElement("li");
    var text = document.createTextNode("PikReview ");
    rootLi.appendChild(text);
	var rootBtn = document.createElement("a");
	rootBtn.setAttribute("href", '#');
	rootBtn.setAttribute("class", "showDialog link");
	rootBtn.setAttribute("data-toggle", "modal");
	rootBtn.setAttribute("data-target", ".bs-new_category-modal-lg");
	rootBtn.setAttribute("onclick", "addNewCategory(0)");
	var rootSpan = document.createElement("span");
	rootSpan.setAttribute('class', 'glyphicon glyphicon-plus');
	rootBtn.appendChild(rootSpan)
	rootLi.appendChild(rootBtn);
	root.appendChild(rootLi);
	root.appendChild(jsonToTree(branches));
	return root;
}

function jsonToTree(branches) {
	var ul = document.createElement("ul");
    for (var i=0, n=branches.length; i<n; i++) {
      var branch = branches[i];
      var li = document.createElement("li");
      var text = document.createTextNode(branch.name + " ");
      li.appendChild(text);

      if (branch.children) {
		var btn = document.createElement("a");
		btn.setAttribute("href", '#');
		btn.setAttribute("class", "showDialog link");
		btn.setAttribute("data-toggle", "modal");
		btn.setAttribute("data-target", ".bs-new_category-modal-lg");
		btn.setAttribute("onclick", "addNewCategory(" + branch.id + ")");
		var span = document.createElement("span");
		span.setAttribute('class', 'glyphicon glyphicon-plus');
		btn.appendChild(span)
		li.appendChild(btn);
	    li.appendChild(jsonToTree(branch.children));
      }
      ul.appendChild(li);
    }
    return ul;
}

function renderTree() {
  var url = "./bl/manage-feed.php?f=gc&t=2"
  catTreeReq = makeRequest(url, populateTree);
}

function generateCategoryList() {
  var url = "./bl/manage-feed.php?f=gc&t=2";
  catOptionReq = makeRequest(url, populateOptions);
}

function log(text) {
  $('#logs').append(text + '<br>');
}

function populateOptions() {
    if (isResponseReady(catOptionReq)) {
	   content = catOptionReq.responseText
       categoriesList=JSON.parse(content);
	   $('#sel_categories').select2({
		   multiple: true,
		   data: eval(content)
	   }).on("change", function(e) {
           // mostly used event, fired to the original element when the value changes
           //log("change val=" + e.val);
		   $('#sel_categories').val(e.val);
       });
	}
}

function createOption(category) {
    var option = document.createElement("option");
	option.value=category.id;
	var text = document.createTextNode(category.name);
	option.appendChild(text);
	return option;
}

function createOptionGroup(category) {
    if (category.children && category.children.length > 0) {
        var optGroup = document.createElement("optgroup");
	    optGroup.label=category.name;
	    var option = document.createElement("option");
	    option.value=category.id;
	    var text = document.createTextNode("All - " + category.name);
	    option.appendChild(text);
	    optGroup.appendChild(option);
	    for (i=0;i<category.children.length;i++) {
	        optGroup.appendChild(createOptionGroup(category.children[i]));
		}
		return optGroup;
	} else {
	    return createOption(category);
	}
}

function populateTree() {
    if (isResponseReady(catTreeReq)) {
	    content = catTreeReq.responseText
        treeObj=JSON.parse(content);
        var treeEl = document.getElementById("categories");
        var ul = document.createElement("ul");
        treeEl.appendChild(createCategoryTree(treeObj));
	}
}
