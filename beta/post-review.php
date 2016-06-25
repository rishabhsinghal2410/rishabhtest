<?
	include('./bl/validate-request.php');
	require("./config.php");
	require("./bl/db.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
  <style>
  .carousel-inner > .item > img,
  .carousel-inner > .item > a > img {
      width: 70%;
      margin: auto;
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

  </style>
  <link rel="stylesheet" href="./css/3.1.1/bootstrap.min.css">
  <script src="./js/core-ajax.js" type="text/javascript"></script>
  <script src="./js/cat-functions.js" type="text/javascript"></script>
  <title>PikReview!</title>

    <!-- Bootstrap Core CSS -->
	<link href="css/shop-homepage.css" rel="stylesheet">
	<link href="css/footer.css" rel="stylesheet">
	<link rel="stylesheet" href="./css/select2.css">
	<link rel="stylesheet" href="./css/select2-bootstrap.css">

    <!-- Custom CSS -->
    <!--link href="css/3-col-portfolio.css" rel="stylesheet"-->
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
	
	var loader;
	
	function upload(files) {
		files.parentElement.parentElement.parentElement.submit();
		loader = setInterval('checkIframeLoaded();', 500);
	}
	
function checkIframeLoaded() {
    // Get a handle to the iframe element
    iframe = document.getElementById('uploadPik');

    var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

    // Check if loading is complete
    if (iframeDoc.readyState  == 'complete' ) {

        //iframe.contentWindow.alert("Hello");

        alert("I am loaded");

        // The loading is complete, call the function we want executed once the iframe is loaded
        //afterLoading();
		if (loader) {
		  clearInterval(loader);
		}
        return;
    } 

    // If we are here, it is not loaded. Set things up so we check   the status again in 100 milliseconds
}
</script>
<link rel="stylesheet" href="./css/header.css">
</head>
<body style="padding-top:50px;background-color: rgb(246, 243, 243);">
    <? include('header.php') ?>
    <!-- Page Content -->
    <div class="container">

        <!-- Page Header -->
        <div class="row">
            <div class="col-lg-12">
                <!--<h1 class="page-header" style="margin-top:10px;">Post a review<br /><small style="font-size:16px;">Hey <? //echo $_SESSION['name']; ?>, share your product review with fellow PikReviewers!</small>
                </h1>-->
				<label class="header">
				<div class="row">
				<div class="col-lg-3"></div>
				<div class="col-lg-6 col-xs-12"><label style="font-size:16px;"><span class="main-header"><span style="font-weight:bold">4 easy steps</span> to share a PikReview of any online purchase.</span><br />
				<span class="sub-header">
				  <span><span style="font-weight:">#Click</span> - </span>
				  <span><span style="font-weight:">#Categorize</span> - </span>
				  <span><span style="font-weight:">#Link </span> - </span>
				  <span><span style="font-weight:">#Tag </span></span>
				  </span></label></div>
				<div class="col-lg-3"></div>
				</div>
				</label>
            </div>
        </div>
        <!-- /.row -->
	    <div class="row">
		  <div class="col-xs-12 col-lg-12" style="text-align:center;">
		  <form id="frmPost" method="post" class="form-horizontal"
            data-bv-message="This value is not valid"
            data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
            data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
            data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" action="./bl/manage-post.php?f=new" enctype="multipart/form-data">

			<div class="form-group">
				<label class="col-xs-5 col-lg-3 control-label">Select Piks:</label>
				<div class="col-xs-7 col-lg-8">
					<input type="file" multiple accept="image/x-png, image/gif, image/jpeg" class="form-control" name="photos[]" />
				</div>
				<div class="col-lg-1"></div>
			 </div>

			<div class="form-group">
				<label class="col-xs-5 col-lg-3 control-label">Assign categories:</label>
				<div class="col-xs-7 col-lg-8">
				  <div class="select2-wrapper">
					<input class="form-control select2" id="sel_categories" name="product_categories"
					    placeholder="Start typing to filter..."
                        data-bv-notempty="true"
						data-bv-notempty-message="Please assign atleast one category" />
		          </div>
				</div>
				<div class="col-lg-1"></div>
			</div>

			<div class="form-group">
				<label class="col-xs-5 col-lg-3 control-label">Product Link:</label>
				<div class="col-xs-7 col-lg-8">
					<input type="url" class="form-control" name="landing_url"
                        data-fv-uri-message="The website address is not valid"
						placeholder="Link of the product you are posting for."
						data-bv-notempty="true"
						data-bv-notempty-message="Link is required and cannot be empty" />
				</div>
				<div class="col-lg-1"></div>
			</div>
			<div class="form-group">
				<label class="col-xs-5 col-lg-3 control-label">Description:</label>
				<div class="col-xs-7 col-lg-8">
					<textarea rows="5" class="form-control" name="descr" placeholder="Please provide details of how you feel about your purchase. You may add #HashTags to categorize it."
						data-bv-notempty="true"
						data-bv-notempty-message="A small descripion would add more value to the people viewing it :)" ></textarea>
				</div>
				<div class="col-lg-1"></div>
			</div>
			<div class="form-actions">
			    <label class="col-xs-3 col-lg-3 control-label"><input type="hidden" name="state" value="2" /></label>
                <div class="col-xs-8 col-lg-7"><button type="submit" class="btn btn-success btn-large">Post</button>
				<div class="col-xs-1 col-lg-2"></div>
            </div>
          </form> 
		  </div>
		</div>
		</div>
        <hr>
		<div style="display:none">
		</div>
        <? 
		    $_SESSION['footer-menu'] = 3;
		    include("footer.php");
		?>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <!--script src="js/jquery.js"></script-->

    <!-- Bootstrap Core JavaScript -->
    <!--script src="js/bootstrap.min.js"></script-->
</body>
<script src="./js/jquery-1.10.2.min.js"></script>
<script src="./js/3.3.5/bootstrap.min.js"></script>
<script src="./js/bootstrapValidator.js"></script> 
<script src="./js/select2.js"></script>
<script>
    generateCategoryList();
</script>
<script>
$(document).ready(function() {
    $('#frmPost').bootstrapValidator({
	    fields: {
            product_categories: {
                trigger: 'change'
			}
		}
	});
});
</script>
</html>
