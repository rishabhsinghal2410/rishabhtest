var reviewContent = null;
function populateCommentSection(comments) {
	commentStr="<li><div class=\"commenterImage\"><span>$userid$: </span></div><div class=\"commentText\"><p class=\"small-text\">$user_comment$</p></div><span class=\"date sub-text\">on $timestamp$</span></li>" //
	var list = "";
	for( i=0;i<comments.length;i++){
        var comment = comments[i];
        var str = commentStr;
		str=str.replace('$userid$', comment.userId);
		str=str.replace('$user_comment$', comment.text);
		str=str.replace('$timestamp$', comment.timestamp);
		list = list + str;
	}
	document.getElementById('commentUl').innerHTML=list;
}

function addNewComment() {
	commentStr="<li><div class=\"commenterImage\"><span>$userid$:</span></div><div class=\"commentText\"><p class=\"\">$user_comment$</p><span class=\"date sub-text\">on March 5th, 2014</span></div></li>" //
	var list = document.getElementById('commentUl').innerHTML;
	var str = commentStr;
	commentText = document.getElementById('user_comment').value;
	if (commentText == null || commentText.trim() == "") {
	    return;
	}
	reviewId = document.getElementById('txtReviewId').value;
	str=str.replace('$userid$', "You");
	str=str.replace('$user_comment$', commentText);
	list = list + str;
	var commentUl = document.getElementById('commentUl');
	//commentUl.style.background
	commentUl.innerHTML=list;
	//document.getElementById('idCommentFrm').submit();
	var url = "./bl/manage-review.php?f=sc&comment=" + commentText + "&review_id=" + reviewId;
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
	xmlHttp.onreadystatechange = showLISaved;
	xmlHttp.open("GET", url, true);
	xmlHttp.send(null);
	document.getElementById('user_comment').value="";
	return true;
}

function showLISaved() {
    
}
var openBoxHttp;
var feedHttp;
var fbPostHttp;

function renderData(reviewId) {
    var url = "./bl/manage-review.php?f=gr&rid=" + reviewId;
	openBoxHttp = null;
    openBoxHttp = makeRequest(url, function(){populateBox(reviewId);});
}

function populateBox(reviewId) {
    //content='{"ReviewContent":{"Comments":[{"userId":"ashish","text":"Another test comment from DB insert"},{"userId":"anuj","text":"Test comment from DB insert"}],"Images":[{"pikUrl":".\/bl\/images\/1,jpg"},{"pikUrl":".\/bl\/images\/1,jpg"}],"description":"Test review content","hits":"0","landingUrl":"http:\/\/www.google.com","reviewer":"anuj"}}';
	if (isResponseReady(openBoxHttp)) { // .readyState == 4 || xmlHttp.readyState==200
	    content = openBoxHttp.responseText
        reviewContent=JSON.parse(content);
		//$('#modalDescr').html(reviewContent.ReviewContent.description);
        populateCommentSection(reviewContent.ReviewContent.Comments);
		populateData('spanHits', reviewContent.ReviewContent.hits);
	    document.getElementById("txtReviewId").value=reviewId;
		renderImageGallery(reviewContent.ReviewContent.Images);
		var url = "./bl/manage-review.php?f=va&review_id=" + reviewId;
		buyNowBtn = document.getElementById('aBuyNow');
		buyNowBtn.setAttribute("href", reviewContent.ReviewContent.landingUrl);
        buyNowBtn.setAttribute("target", "_blank");
		var userUploadedLink = document.getElementById("userUploaded");
		userUploadedLink.innerHTML=reviewContent.ReviewContent.Reviewer.name;
		userUploadedLink.href="./search.php?id=" + reviewContent.ReviewContent.Reviewer.id;
		if (editPostEnabled) {
		    populateEditPostPanel(reviewContent, reviewId);
		}
		if (isAdmin) {
		    var btnHtml = reviewContent.ReviewContent.Facebook.id == 0 ? "<a class=\"btn btn-primary\" onclick=\"postToFB(" + reviewId + ")\">Post to FB</a>" : "<a class=\"btn btn-primary\" href=\"" + reviewContent.ReviewContent.Facebook.url + "\" target=\"blank\">View on FB</a>";
		    $('#fbPost').html(btnHtml);
		}
        makeRequest(url, function(){return null;});
	}
}

function renderImageGallery(images) {
    var imageDiv = "<div class=\"item %CLASS_ACTIVE%\"><img src=\"%IMAGE_URL%\" width=\"460\" height=\"345\"></div>";
	var slideOl = "<li data-target=\"#myCarousel\" data-slide-to=\"%COUNT%\" class=\"%CLASS%\"></li>";
	var imageGallery = "";
	var slideIcons = "";
	for( i=0;i<images.length;i++){
        var image = images[i];
        var str = imageDiv;
		var str1 = slideOl;
		if (i==0) {
		    str=str.replace('%CLASS_ACTIVE%', "active");
			str1 = str1.replace('%CLASS%', "active");
		} else {
		    str=str.replace('%CLASS_ACTIVE%', "");
			str1 = str1.replace('%CLASS%', "");
		}
		str=str.replace('%IMAGE_URL%', image.pikUrl);
		str1 = str1.replace('%COUNT%', i);
		imageGallery = imageGallery + str;
		slideIcons = slideIcons + str1;
	}
	document.getElementById('imageGallery').innerHTML=imageGallery;
	document.getElementById('totalSlide').innerHTML=slideIcons;
}

function resetEditableContent(reviewContent) {
    if (reviewContent != null) {
	    populateEditPostPanel(reviewContent);
	}
}

function populateEditPostPanel(reviewContent) {
    $('#descr').text(reviewContent.ReviewContent.description);
	$('#product-url').val(reviewContent.ReviewContent.landingUrl);
    populateImagesForEdit(reviewContent.ReviewContent.Images);
	$('#review-id').val(reviewContent.ReviewContent.Id);
	$('#deleteReviewId').val(reviewContent.ReviewContent.Id);
	$('#sel_categories').select2("data", eval(reviewContent.ReviewContent.Categories));
	registerEditEvents();
}

function populateImagesForEdit(images) {
    var editImageDiv = "<div class=\"col-xs-4\"><div class=\"show-image\"><img id=\"%IMAGE_ID%\" class=\"img-responsive %CLASS_SELECTED% link\" src=\"%IMAGE_URL%\" style=\"border:solid 1px grey; margin:10px;\" /><span class=\"glyphicon glyphicon-remove-circle %CLASS_SELECTED% link\"></span><span class=\"glyphicon glyphicon-repeat hide link\"></span></div></div>";
	var imageGallery = "";
	for( i=0;i<images.length;i++){
        var image = images[i];
        var str = editImageDiv;
		if (image.coverPik == 1) {
		    str=replaceAll(str, '%CLASS_SELECTED%', "selected");
		} else {
		    str=replaceAll(str, '%CLASS_SELECTED%', "");
		}
		str=str.replace('%IMAGE_URL%', image.pikUrl);
		str=str.replace('%IMAGE_ID%', image.pikId);
		imageGallery = imageGallery + str;
	}
	document.getElementById('editableImages').innerHTML=imageGallery;

}

function populateData(elementId, text) {
    document.getElementById(elementId).innerHTML=text
}

var page = 0;
var inProgress;
var loadingImageHtml = "<img src='./images/loading.gif' />";
function makeFeedRequest() {
    if (page != -1 && !inProgress) {
        var url="./bl/manage-feed.php?f=gf&v=json&p=" + page;
		$('#loadStatus').html(loadingImageHtml);
		feedHttp = null;
		inProgress = true;
	    feedHttp = makeRequest(url, function(){handleFeedResponse();});
		page += 1;
	}
}

function handleFeedResponse() {
    if (isResponseReady(feedHttp)) { // .readyState == 4 || xmlHttp.readyState==200
        content = feedHttp.responseText
        feed=JSON.parse(content);
		appendFeed(feed);
		inProgress = false;
	}
}

var a = "<table width=\"100%\"><tr><td width=\"50%\" align=\"right\" style=\"padding-right: 5px;\"><span class=\"glyphicon glyphicon-eye-open\">%VIEWS%</span></td><td width=\"50%\" align=\"left\" style=\"padding-left: 5px;\"></label><label style=\"right: 0px;left:90%\"><button class=\"btn\" type=\"button\" disabled>Views <span class=\"badge\">%VIEWS%</span></button></label></td></tr></table>"

//<table width=\"100%\" style=\"display:none\"><tr><td width=\"50%\" align=\"right\" style=\"padding-right: 5px;\"><label><a class=\"btn btn-primary\" href=\"%LANDING_URL%\" target=\"_blank\">Buy Now</a></td><td width=\"50%\" align=\"left\" style=\"padding-left: 5px;\"></label><label style=\"right: 0px;left:90%\"><button class=\"btn\" type=\"button\" disabled>Views <span class=\"badge\">%VIEW%</span></button></label></td></tr></table> -- disable esc and click outside modal : data-backdrop=\"static\" data-keyboard=\"false\"

function appendFeed(feed) {
    var itemDiv = "<div class=\"panel panel-default\" style=\"border-radius:10px;margin-bottom: 5px;border:none\"><a class=\"showDialog link\" data-toggle=\"modal\" data-target=\".bs-example-modal-lg\" onclick=\"renderData(%DATA_ID%);\"><img class=\"img-responsive\" src=\"%IMAGE_URL%\" style=\"border-top-left-radius:10px;border-top-right-radius:10px;\" /></a><div class=\"descr\"><div class=\"row\"><div class=\"col-lg-12 col-xs-12\"><p class=\"truncable-txt\">%DESCRIPTION%</p></div></div><div class=\"row social-icons\"><div class=\"col-lg-6 col-xs-6\"><em class=\"glyphicon glyphicon-eye-open\" style=\"color: #a7a7a7;font-size:13px;\"></em><em style=\"color: #999;font-size: 13px;font-weight: normal;\"> %VIEWS%</em></div><div class=\"col-lg-6 col-xs-6\" style=\"text-align:right;\"><span><a href=\"#\" style=\"font-size:13px;\"\"></a></span></div></div></div><div class=\"row\"><div class=\"col-lg-12 col-xs-12\" class=\"text-align:center\"><a class=\"item-link\" target=\"_blank\" href=\"%LANDING_URL%\"><div class=\"checkout-item\">Check this Item!</div></a></div></div></div></div>";
    var emptyDiv = "<h4><span class=\"label label-default\">No more items to show!<span></h4>";
	var itemList = document.getElementById('feed').innerHTML;
	var loadStatus = document.getElementById('loadStatus');
	var feed=feed[0].Feed;
	var item;
	if (feed.length == 0) {
	    page = -1;
		$('#loadStatus').html(emptyDiv);
	} else {
	    for( i=0;i<feed.length;i++) {
			var itemDivStr = itemDiv;
			item = feed[i];
			itemDivStr=itemDivStr.replace('%DATA_ID%', item.id);
			itemDivStr=itemDivStr.replace('%IMAGE_URL%', item.coverPik);
			itemDivStr=itemDivStr.replace('%LANDING_URL%', item.landingUrl);
			itemDivStr=itemDivStr.replace('%DESCRIPTION%', item.description);
			itemDivStr=itemDivStr.replace('%VIEWS%', item.views);
			$('#feed').append(itemDivStr);
	    }
		$('#loadStatus').html("");
		//truncateIfNeeded();
    }
}

function replaceAll(str, find, replace) {
  return str.replace(new RegExp(find, 'g'), replace);
}

function postToFB(reviewId) {
    var url = "./bl/manage-social-media.php?f=ptf&rid=" + reviewId;
    $('#fbPost').html(loadingImageHtml);
	fbPostHttp = null;
    fbPostHttp = makeRequest(url, function(){handleFBPostResponse();});
}

function handleFBPostResponse() {
    if (isResponseReady(fbPostHttp)) {
        content = fbPostHttp.responseText
        fbPostResponse=JSON.parse(content);
		if (fbPostResponse.Status == "SUCCESS") {
		    $('#fbPost').html("<a class=\"btn btn-primary\" href=\"" + fbPostResponse.Url + "\" target=\"blank\">View on FB</a>");
		} else if (fbPostResponse.Status == "ERROR") {
		    $('#fbPost').html("<span style=\"color:red\">An error occured while posting to FB, please try later.</span>");
		}
	}
}
