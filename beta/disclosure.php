<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<script src="./js/openbox.js" type="text/javascript"></script>
    <title>PikReview!</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/comment-box.css" rel="stylesheet">
	<link href="css/footer.css" rel="stylesheet">

    <!-- Custom CSS -->
    <!--link href="css/3-col-portfolio.css" rel="stylesheet"-->
	<link href="css/lightbox-form.css" rel="stylesheet">
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

</script>
</head>

<body style="padding-top:50px;">
    <? include('header.php') ?>
    <!-- Page Content -->
    <div class="container">

        <!-- Page Header -->
        <div class="row" style="height:65px;">
            <div class="col-lg-12">
                <h1 id="header-text" class="page-header" style="margin-top:10px;">Disclaimer!
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Projects Row -->
		<div id="loginDiv" class="row">
		<div class="col-xs-2 col-lg-3"></div>
		<div class="col-xs-8 col-lg-6">
            PikReview.com is a participant in the Amazon Associates Program, an affiliate advertising program designed to provide a means for sites to earn advertising fees by advertising and linking to amazon.in		
		</div>
		<div>&nbsp;</div>
		<div class="col-xs-2 col-lg-3"></div>
		</div>
		
		<br />
        <hr>

        <!-- Footer -->
        <? 
		    $_SESSION['footer-menu'] = 5;
		    include("footer.php");
		?>
    </div>
</body>
</html>
