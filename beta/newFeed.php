<?
	require("./config.php");
	require_once("./bl/db.php");
	require_once("./bl/util.php");
	if (strcmp(phpversion(), "5.4.0") >= 0) {
	  if (session_status() == PHP_SESSION_NONE) {
	    session_start();  
	  }
	} else {
	  if (session_id() == '') {
	    session_start();
	  }
	}
	$editable = false;
	$isAdmin = false;
    if (isset($_SESSION['user']) && strcmp($_SESSION['user'], $_SESSION['uname']) == 0) {
        $editable = true;
    }
	if (isset($_SESSION['uname']) && isset($_SESSION['type']) && $_SESSION['type'] == 1) { 
	    $editable = true;
		$isAdmin = true;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="Keywords" content="Online Shopping, India, PikReview, Original Reviews, Actual Review, Review with photo, Review with Pics."/>
<meta name="Description" content="PikReview.com - What you see is what you get."/>
  <style>
  .morecontent span {
    display: none;
}
.morelink {
    display: block;
}
  .header {
    margin: 10px 0 10px;
	background-color:cornsilk;
	text-align:center;
	width:100%;
	height:auto;
	border-radius:10px;
  }
  .main-header {
      font-weight:500;
  }
  .sub-header {
      font-weight:500;
  }
  .descr {
    margin-top: 5px;
	padding-left:5px;
	padding-right:5px;
	font-size:13px;
	border-bottom: thin solid #eee;
	font-family: 'Helvetica Neue', Helvetica, 'Hiragino Kaku Gothic Pro', Meiryo, arial, sans-serif;
	line-height: 17px;
  }
  .social-icons {
	padding-bottom:2px;
	padding-top:2px;
	padding-left:5px;
	padding-right:5px;
  }
  .carousel-inner > .item > img,
  .carousel-inner > .item > a > img {
      width: 70%;
      margin: auto;
  }
  .item {
    display: inline-block;
    padding: .25rem;
    width: 100%;
  }
  
  .hide {
    display:none;
  }
  .show {
    display:block;
  }
  .pane-label {
    position: fixed;
    padding: 0;
    font-size: 70%;
    left: 0px;
    bottom: 50%;
    margin: 0;
  }
  .nav-pills > li.active > a, .nav-pills > li.active > a:hover, .nav-pills > li.active > a:focus {
    color:white;
    background-color:#fcd900;
    }
  <?
    require_once("./bl/util.php");
	if (!checkUserAgent('mobile')) {
?>
  #category-box {
    position: fixed;
	left: 44px;
    top: 27%;
	height:auto;
	width:400px;
	border:thin groove;
	background-color:white;
	border-radius: 8px;
  }
  <? } else if (checkUserAgent('mobile')) { ?>

  #category-box {
    position: fixed;
    bottom: 8%;
	height:auto;
	width:92%;
	border:thin groove;
	background-color:white;
	border-radius: 8px;
  }
  
  <? } ?>  

  .action {
    text-align:center;
	padding:2px;
  }
  </style>
  <link rel='stylesheet' id='responsive-style-css'  href='./pinstrap/css/style.css' type='text/css' media='all' /> 
  <link rel="stylesheet" href="./css/tile-layout.css" />
  <link rel="stylesheet" href="./css/footer.css" />
  <link rel="stylesheet" href="./css/select2.css" />
  <link rel="stylesheet" href="./css/select2-bootstrap.css" />
  <link rel="stylesheet" href="./css/truncate.css" />
  <script src="./js/core-ajax.js" type="text/javascript"></script>
  <script src="./js/openbox.js" type="text/javascript"></script>
  <link rel="stylesheet" href="./css/3.1.1/bootstrap.min.css" />
  <title>PikReview - genuine review with actual pics | Online product reviews | product reviews</title>
    <!-- Bootstrap Core CSS -->
	<link href="css/comment-box.css" rel="stylesheet">
    <link href="css/shop-homepage.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

<script type="text/javascript">
	if (typeof(jQuery) != 'undefined') {
     	jQuery.noConflict();
	}
	<?
	   print ( "var state = $state;\n");
	   if ($editable) {
	       echo "var editPostEnabled = true;";
	   } else {
	       echo "var editPostEnabled = false;";
	   }
	   if ($isAdmin) {
	       echo "var isAdmin = true;";
	   } else {
	       echo "var isAdmin = false;";
	   }
	?>

	function showHide(elementId) {
	    var element = $('#' + elementId);
		if (element.hasClass('hide')) {
		    element.removeClass('hide');
			element.addClass('show');
		} else {
		    element.removeClass('show');
			element.addClass('hide');
		}
	}

	function hide(elementId) {
	    var element = $('#' + elementId);
		element.removeClass('show');
		element.addClass('hide');
	}
</script>
<link rel="stylesheet" href="./css/header.css">
</head>
<body style="padding-top:50px;background-color:#E9E9E9;">
    <? include('header.php') ?>

    <!-- Page Content -->
    <div class="container main-container container-max">

        <!-- Page Header -->
        <div class="row">
            <div class="col-lg-12">
				<label class="header" style="font-size:16px;"><span class="main-header"><span style="font-weight:bold">PikReview</span> is an online product discovery and review sharing platform, here <span style="font-weight:bold">what you see is what you get!</span><br /></span>
				<span class="sub-header"><span style="font-weight:bold"> See</span> real reviews <span style="font-weight:bold">Shop</span> genuine products and <span style="font-weight:bold">Share</span> your PikReviews.</span></label>
            </div>
        </div>
        <!-- /.row -->
		<div class="row">
		<div class="span12">
		  <div id="main" role="main">
		  <ul id="tiles" class="unstyled">
		  <?
		      $baseUrl = "./bl/";
		      //include_once("./bl/db.php");
			  include("./bl/manage-feed.php");
			  $feed = getMainFeedByState($state);
			  echo transformFeedArrToHtml($feed);
		  ?>
		  </ul>
		  </div>
		</div>
		
		</div>
		<div class="row">
		    <div class="col-md-5"></div>
			<div class="col-md-4 col-xs-12 portfolio-item item" id="loadStatus">
			<a id="inifiniteLoader"><img src="./images/loading.gif"></a>
			</div>
			<div class="col-md-3"></div>
		</div>
		
		<?
	        if (!checkUserAgent('mobile') && false) {
        ?>
		<div class="pane-label" style="border:groove;">
		    <div style="width:100%;">
			<div style="width:95%;text-align:center">
			<div style="display:block;border:2px solid;border-color:#428bca;border-radius:5px;">
			<a class="btn btn-social-icon" onclick="showHide('category-box')"><span class="fa fa-filter"></span></a>
			</div>
			</div>
			</div>
			<div style="display:block;padding:1px;margin:1px;">
			<a class="btn btn-social-icon btn-twitter"><span class="fa fa-twitter"></span></a>
			</div>
			<div style="display:block;padding:1px;margin:1px;">
			<a class="btn btn-social-icon btn-facebook"><span class="fa fa-facebook"></span></a>
			</div>
			<div style="display:block;padding:1px;margin:1px;">
			<a class="btn btn-social-icon btn-google"><span class="fa fa-google"></span></a>
			</div>
		</div>
		<? } ?>
		<div id="category-box" class="hide">
		  <div style="border-bottom: thin solid;">
		  Hello
		  <button type="button" class="close" aria-label="Close" style="padding-right:2px;" onclick="hide('category-box')"><span aria-hidden="true">X</span></button>
		  </div>
		  <div class="action">
			<a class="btn btn-primary">Apply</a>
			<a class="button">Clear filter</a>
		  </div>
		</div>
        <hr />
        <? include("footer.php") ?>

    </div>
	<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
	<div class="modal-header">
	  <div id="viewPostHeader">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
        <label><a id="aBuyNow" class="btn btn-primary" href="#">Buy Now</a></label>
	    <label style="right: 0px;left:90%"><button class="btn" type="button" disabled>Views <span id="spanHits" class="badge">4</span></button></label>
		<? 
		   if ($editable) {
		?>
		<label><button class="btn btn-primary" type="button" onclick="postMode('edit')">Edit</button></label>
		<? } ?>
		<? 
		   if ($isAdmin) {
		?>
		<label id="fbPost"></label>
		<? } ?>
	  </div>
	  <? if ($editable) { ?>
      <div id="editPostHeader" class="hide">
	    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
        <button class="btn btn-primary" onclick="submitFrm(1, 'frmPostUpdate')">Update</button>
		<button class="btn btn-primary" onclick="submitFrm(2)">Delete</button>
	    <label><button class="btn" type="button" onclick="postMode('view')">Cancel</button></label>
      </div>
	  <? } ?>
    </div>
	<div class="modal-body">
    <div class="row">
      <div id="viewPostBody">
		<div class="col-md-7">
		  <div><span></span></div>
		  <div id="myCarousel" class="carousel slide" data-ride="carousel">
		  <!-- Indicators -->
			<ol id="totalSlide" class="carousel-indicators">
			  <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			</ol>
			<!-- Wrapper for slides -->
			<div id="imageGallery" class="carousel-inner" role="listbox">
			  <div class="item active"><img src="images/spinner.gif" width="460" height="200"></div>
			</div>
			<!-- Left and right controls -->
			<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
			  <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			  <span class="sr-only"></span>
			</a>
			<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
			  <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			  <span class="sr-only"></span>
			</a>
		  </div>
		  <h4>More by <a id="userUploaded" href="#"></a></h4>
		</div>
		<div class="col-md-5">
		<div class="detailBox">
		  <div class="titleBox">
			<form id="idCommentFrm" class="form-inline" role="form" action="./bl/manage-review.php?f=sc" method="post">
				<div class="form-group">
					<textarea id="user_comment" class="form-control" type="text" name="comment" placeholder="Your comments" rows="2"cols="30"></textarea>
					<input id="txtReviewId" type="hidden" name="review_id" />
				</div>
				<div class="form-group">
					<input type="button" value="Add" class="btn btn-primary" onclick="addNewComment()"  />
				</div>	
			</form>
		  </div>
		  <div class="actionBox">
			<ul id="commentUl" class="commentList">
			</ul>
		  </div>
		</div>
	   </div>
	  </div>
	  <? if ($editable) { ?>
	  <form id="frmPostUpdate" method="post" class="form-horizontal"
            data-bv-message="This value is not valid"
            data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
            data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
            data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" action="./bl/manage-post.php?f=upd" enctype="multipart/form-data">
	  <div id="editPostBody" class="hide">
	    <div class="row">
	      <div class="col-lg-6" id="editableImages">
		    
		  </div>
		  <div class="col-lg-6" id="editableImages">
		    
		  </div>
		</div>
		<br />
		<div class="row">
		    <div class="form-group">
			  <label class="col-xs-5 col-lg-3 control-label">Select piks:</label>
			  <div class="col-xs-7 col-lg-8">
				<input class="form-control" name="photos[]" type="file" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|images/*" multiple />
				<input type="hidden" name="deleted-piks" id="deleted-piks" />
				<input type="hidden" name="cover-pik" id="cover-pik" />
				<input type="hidden" name="review-id" id="review-id" />
			  </div>
			  <div class="col-lg-1"></div>
			</div>
		</div>
		<br />
		<div class="row">
		  <div class="form-group">
			<label class="col-xs-5 col-lg-3 control-label">Assign categories:</label>
			<div class="col-xs-7 col-lg-8">
			  <div class="select2-wrapper">
				<input class="form-control select2" id="sel_categories" placeholder="Start typing to filter..." name="product_categories"
                        data-bv-notempty="true"
						data-bv-notempty-message="Please assign atleast one category."
				/>
			  </div>
			</div>
			<div class="col-lg-1"></div>
		  </div>
        </div>
		<div class="row">
		  <div class="form-group">
			<label class="col-xs-5 col-lg-3 control-label">Description:</label>
			<div class="col-xs-7 col-lg-8">
			  <textarea id="descr" rows="5" class="form-control" name="descr" placeholder="Please provide details of how you feel about your purchase. You may add #HashTags to categorize it."
						data-bv-notempty="true"
						data-bv-notempty-message="A small descripion would add more value to the people viewing it :)" ></textarea>
			</div>
			<div class="col-lg-1"><input type="hidden" name="state" value="2" /></div>
		  </div>
        </div>
		<div class="row">
		    <div class="form-actions hide">
                <div class="col-xs-8 col-lg-7"><button id="submitUpdate" type="submit" class="btn btn-success btn-large">Save</button>
				<div class="col-xs-1 col-lg-2"></div>
            </div>
		  </div>
		</div>
	   </div>
	   </form>
	   <div class="hide">
	   <form method="post" action="./bl/manage-post.php?f=del">
	   <input type="hidden" id="deleteReviewId" name="review-id" />
	   <button id="submitDelete" type="submit" class="btn btn-success btn-large">Save</button>
	   </form>
	   </div>
	   <? } ?>
	  </div>
    </div>
  </div>
</div>
</div>
</div>

</body>
  <script src="./js/1.11.3/jquery.min.js"></script>
  <script src="./js/jquery-1.10.2.min.js"></script>
  <!--script type='text/javascript' src='./pinstrap/js/bootstrap.js'></script-->
  <script src="./js/3.3.5/bootstrap.min.js"></script>
  <script type='text/javascript' src='./pinstrap/js/strap-extras.js'></script>
  <script type='text/javascript' src='./pinstrap/js/jquery.imagesloaded.js'></script>
  <script type='text/javascript' src='./pinstrap/js/jquery.wookmark.js'></script>
  <script src="./js/bootstrapValidator.js"></script> 
<script>
function postMode(mode) {
 if (mode == "edit") {
   $('#editPostHeader').removeClass('hide');
   $('#viewPostHeader').addClass('hide');
   $('#editPostBody').removeClass('hide');
   $('#viewPostBody').addClass('hide');
 } else if (mode == "view") {
   $('#viewPostHeader').removeClass('hide');
   $('#editPostHeader').addClass('hide');
   $('#viewPostBody').removeClass('hide');
   $('#editPostBody').addClass('hide');
   resetEditableContent(reviewContent);
 }
}
/*$(window).scroll(function () {
	if (($(document).height() - ($(window).height() + $(window).scrollTop())) <= 200) {
		console.log("Event Fired");
		makeFeedRequest();
	}
});
makeFeedRequest();*/
function registerEditEvents() {
$('img.link').click(function() {
  if (!$(this).hasClass('deleted')) {
     $('.selected').prop('title', 'Click to make it cover pik!');
     $('.selected').addClass('link');
	 $('.selected').removeClass('selected');
     $(this).parent().children().addClass('selected');
	 $(this).parent().children().removeClass('link');
     $(this).prop('title', '');
	 $('#cover-pik').val($(this).attr('id'));
   }
});

$('span.glyphicon-remove-circle').click(function() {
    deleteIcon=$(this);
	imageElement=deleteIcon.prev();
	undoIcon=deleteIcon.next();
	imageElement.addClass('deleted');
	deleteIcon.addClass('hide');
	undoIcon.removeClass('hide');
	undoIcon.removeClass('deleted');
	imageElement.removeClass('link');
	rePopulateDeletedImages();
});

$('span.glyphicon-repeat').click(function() {
    undoIcon=$(this);
	deleteIcon=undoIcon.prev()
	imageElement=undoIcon.prev().prev(); 
	imageElement.removeClass('deleted');
	imageElement.addClass('link');
	undoIcon.addClass('hide');
	deleteIcon.removeClass('hide');
	rePopulateDeletedImages();
});
}
function rePopulateDeletedImages() {
    var ids = "";
	$('img.deleted').each(function() {
	    if (ids.length > 0) {
		    ids += ",";
		}
		ids += $(this).attr('id');
    });
	$('#deleted-piks').val(ids);
}

function submitFrm(formId, formName) {
    switch (formId) {
	    case 1: // edit form
		var updateForm = $('#'+formName);
        updateForm.bootstrapValidator({
		    fields: {
                product_categories: {
                    trigger: 'change'
			    }
		    }
		});
	    $('#submitUpdate').click();
	    break;
		case 2: // delete form.
		$('#submitDelete').click();
	}
    
}
</script>
<script src="./js/select2.js"></script>
<script src="./js/cat-functions.js" type="text/javascript"></script>
<script src="./js/jquery.dotdotdot.min.js" type="text/javascript"></script>
<script src="./js/truncate-text.js" type="text/javascript"></script>
<script>
generateCategoryList();
jQuery(document).ready(function($) {
        var count = 1;
		var isProgress = false;
        $(window).scroll(function(){
          if  ($(window).scrollTop() == $(document).height() - $(window).height()){
		    if (!isProgress) {
		      isProgress = true;
              loadArticle(count);
              count++;
			}
          }
        });

        function loadArticle(pageNumber) {
                $('a#inifiniteLoader').show('slow');
                $.ajax({
                    //url: document.location.origin + "/template/bl/manage-feed.php?f=gf&v=html&p="+ pageNumber + "s=" + state,
					url: document.location.origin + "/beta/bl/manage-feed.php?f=gf&v=html&p="+ pageNumber, // Live site.
                    type:'GET',
                    success: function(content) {
                        $("#tiles").append(content);
						truncateText(100);
						$('a#inifiniteLoader').hide('1000');
						isProgress = false;
                    }
                });
            return false;
        }
    });

</script>

</html>
