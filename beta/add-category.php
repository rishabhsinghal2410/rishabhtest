<?
    session_start();
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
  </style>
  <link rel="stylesheet" href="./css/3.1.1/bootstrap.min.css">
  <script src="./js/core-ajax.js" type="text/javascript"></script>
  <script src="./js/cat-functions.js" type="text/javascript"></script>
  <title>PikReview!</title>

    <!-- Bootstrap Core CSS -->
	<link href="css/shop-homepage.css" rel="stylesheet">
	<link href="css/footer.css" rel="stylesheet">

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


</script>
<link rel="stylesheet" href="./css/header.css">
</head>
<body style="padding-top:50px;background-color: rgb(246, 243, 243);" onload="renderTree();">
    <? include('./header.php') ?>
    <!-- Page Content -->
    <div class="container">

        <!-- Page Header -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" style="margin-top:10px;">Add Category<br /><small style="font-size:16px;">Admin only!</small>
                </h1>
            </div>
        </div>
        <!-- /.row -->
	    <div class="row">
		  <div id="categories"></div>
		  
		</div>
        <hr>
      <div class="modal fade bs-new_category-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
	          <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <label>Add New Category</label>
	          </div>
	        <div class="modal-body">
              <div class="row">
		        <div class="col-xs-12 col-lg-12" style="text-align:center;">
				  <form action="./bl/manage-admin-operations.php?method=ADDCAT" method="post" class="form-horizontal" id="newCategoryFrm">
					<div class="form-group">
					  <label class="col-xs-5 col-lg-3 control-label">Name of category:</label>
					  <div class="col-xs-7 col-lg-8">
						<input type="text" class="form-control" name="category_name"
						  data-fv-uri-message="The website address is not valid"
						  placeholder="New category name."
						  data-bv-notempty="true"
						  data-bv-notempty-message="Category name is required and cannot be empty" />
					  </div>
					  <div class="col-lg-1"></div>
					</div>
					<div class="form-group">
					  <label class="col-xs-5 col-lg-3 control-label"></label>
					  <div class="col-xs-7 col-lg-8">
						<input id="parent_category" type="hidden" name="parent_category" />
					  </div>
					  <div class="col-lg-1"></div>
					</div>
					<div class="form-actions">
					  <label class="col-xs-3 col-lg-3 control-label">&nbsp;</label>
					  <div class="col-xs-8 col-lg-7"><button type="submit" class="btn btn-success btn-large">Add new category!</button>
					  <div class="col-xs-1 col-lg-2"></div>
				    </div>
		          </div>
			    </form>
	          </div>
	        </div>
          </div>
        </div>
      </div>
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
<script src="./js/1.11.3/jquery.min.js"></script>
<script src="./js/3.3.5/bootstrap.min.js"></script>
<script src="./js/bootstrapValidator.js"></script> 
<script>
$(document).ready(function() {
    $('#newCategoryFrm').bootstrapValidator();
});
</script>
</html>
