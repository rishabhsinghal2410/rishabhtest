<?
	//include('./bl/validate-request.php');
	require("./config.php");
	require("./bl/db.php");
	if (strcmp(phpversion(), "5.4.0") >= 0) {
	  if (session_status() == PHP_SESSION_NONE) {
	    session_start();  
	  }
	} else {
	  if (session_id() == '') {
	    session_start();
	  }
	}
	if (isset($_SESSION['uname'])) {
	    header("Location: ./main.php");
	}
?>
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

<body>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1702849756624256',
      xfbml      : true,
      version    : 'v2.5'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
<script>
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      testAPI();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into Facebook.';
    }
  }

    function statusChangeCallbackSignUp(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      testAPISignUp();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into Facebook.';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }
  function checkLoginStateSignUp() {
    FB.getLoginStatus(function(response) {
      statusChangeCallbackSignUp(response);
    });
  }
  
  
  window.fbAsyncInit = function() {
  FB.init({
    appId      : '{your-app-id}',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.5' // use graph api version 2.5
  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });
  
FB.getLoginStatusSignUp(function(response) {
    statusChangeCallbackSignUp(response);
  });
  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me?fields=id,name,email', function(response) {
      console.log('Successful login for: ' + response.name);
	  console.log('Successful login with email: ' + response.email);
      document.getElementById('email').innerHTML = response.email;
	  document.getElementById('password').innerHTML = response.id;
	  window.location.href = "submit-login.php";
    });
  }
  
  function testAPISignUp() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me?fields=id,name,email', function(response) {
      console.log('Successful login for: ' + response.name);
	  console.log('Successful login with email: ' + response.email);
      document.getElementById('email').innerHTML = response.email;
	  document.getElementById('password').innerHTML = response.id;
	  document.getElementById('confirmPassword').innerHTML =  response.id;
	  document.getElementById('firstName').innerHTML = response.name
	  document.getElementById('lastName').innerHTML = response.name
	  document.getElementById('contact-no').innerHTML = '1234567890';
	  window.location.href = "submit-register.php";
    });
  }
</script>
    <? include('header.php') ?>
    <!-- Page Content -->
    <div class="container">

        <!-- Page Header -->
        <div class="row">
            <div class="col-lg-12">
                <h1 id="header-text" class="page-header" style="margin-top:10px;">Login!
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Projects Row -->
		<div id="loginDiv" class="row">
		<div class="col-xs-2 col-lg-3"></div>
		<div class="col-xs-8 col-lg-6">
		<form id="loginForm" method="post" class="form-horizontal"
            data-bv-message="This value is not valid"
            data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
            data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
            data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" action="./submit-login.php">
			<?
			if (isset($_GET['err'])) {
			$err = $_GET['err']; ?>
			<div class="form-group">
			    <label class="col-xs-12 col-lg-8 control-label"style="color:#a94442;"><? switch($err) { case 1: echo "Invalid email/password!"; break; }?> </label>
				<fb:login-button scope="public_profile,email" onlogin="checkLoginStateSignUp();"> Sign up using facebook
</fb:login-button>
			</div>
			<? } ?>			
			<!--div class="form-group">
			    <div class="col-xs-4 col-lg-3"></div>
			    <div class="col-xs-8 col-lg-4">
			        <fb:login-button class="control-label" scope="public_profile,email" onlogin="checkLoginState();">Login using facebook</fb:login-button>
			    </div>
				<div class="col-lg-4"></div>
			</div-->
			<div class="form-group">
				<label class="col-xs-4 col-lg-3 control-label">Email</label>
				<div class="col-xs-8 col-lg-5">
					<input class="form-control" name="email" type="email" id="email" placeholder="Username"
                        data-bv-notempty="true"
						data-bv-notempty-message="Email Address is required and cannot be empty"

						data-bv-emailaddress="true"
                        data-bv-emailaddress-message="The input is not a valid email address" />
				</div>
				<div class="col-lg-4"></div>
			</div>

			<div class="form-group">
				<label class="col-xs-4 col-lg-3 control-label">Password</label>
				<div class="col-xs-8 col-lg-5">
					<input type="password" class="form-control" name="password" id="password" placeholder="Password"
						data-bv-notempty="true"
						data-bv-notempty-message="The password is required and cannot be empty" />
				</div>
				<div class="col-lg-4"></div>
			</div>
			<div class="form-actions">
			    <label class="col-xs-3 col-lg-3 control-label">&nbsp;</label>
                <div class="col-xs-8 col-lg-7"><button type="submit" class="btn btn-success btn-large">Login</button>
                <button id="btnSignup" type="button" class="btn">Signup</button>
				</div>
<fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
</fb:login-button>
<div id="status">
</div>
				<div class="col-xs-1 col-lg-2"></div>
            </div>
        </form> 
		</div>
		<div class="col-xs-2 col-lg-3"></div>
		</div>
		<div id="registrationDiv" class="row" style="display:none">
		<div class="col-xs-1 col-lg-3"></div>
		<div class="col-xs-10 col-lg-6">
		<form id="registrationForm" method="post" class="form-horizontal"
            data-bv-message="This value is not valid"
            data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
            data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
            data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" action="./submit-register.php">
			<div class="form-group">
				<label class="col-xs-3 col-lg-3 control-label">Email</label>
				<div class="col-xs-8 col-lg-5">
					<input class="form-control" name="email" type="email" id="email" placeholder="Email Address"
                        data-bv-notempty="true"
						data-bv-notempty-message="Email Address is required and cannot be empty"

						data-bv-emailaddress="true"
                        data-bv-emailaddress-message="The input is not a valid email address" />
				</div>
				<div class="col-xs-1 col-lg-4"></div>
			</div>

			<div class="form-group">
				<label class="col-xs-3 col-lg-3 control-label">Password</label>
				<div class="col-xs-8 col-lg-5">
					<input type="password" class="form-control" name="password" id="password" placeholder="Password"
						data-bv-notempty="true"
						data-bv-notempty-message="The password is required and cannot be empty"

						data-bv-different="true"
						data-bv-different-field="username"
						data-bv-different-message="The password cannot be the same as username" />
				</div>
				<div class="col-xs-1 col-lg-4"></div>
			</div>
			<div class="form-group">
				<label class="col-xs-3 col-lg-3 control-label">Re-enter</label>
				<div class="col-xs-8 col-lg-5">
					<input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Retype password"
						data-bv-notempty="true"
						data-bv-notempty-message="The confirm password is required and cannot be empty"

						data-bv-identical="true"
						data-bv-identical-field="password"
						data-bv-identical-message="The password and its confirm are not the same"

						data-bv-different="true"
						data-bv-different-field="username"
						data-bv-different-message="The password cannot be the same as username" />
				</div>
				<div class="col-xs-1 col-lg-2"></div>
			</div>
			<div class="form-group">
				<label class="col-xs-3 col-lg-3 control-label">First Name</label>
				<div class="col-xs-8 col-lg-5">
					<input type="text" class="form-control" name="firstName" id="firstName" placeholder="First name"
						data-bv-notempty="true"
						data-bv-notempty-message="The first name is required and cannot be empty" />
				</div>
				<div class="col-xs-1 col-lg-4"></div>
			</div>
			<div class="form-group">
				<label class="col-xs-3 col-lg-3 control-label">Last Name</label>
			     <div class="col-xs-8 col-lg-5">
					<input type="text" class="form-control" name="lastName" id="lastName" placeholder="Last name"
						data-bv-notempty="true"
						data-bv-notempty-message="The last name is required and cannot be empty" />
				</div>
				<div class="col-xs-1 col-lg-4"></div>
			</div>
			<div class="form-group">
				<label class="col-xs-3 col-lg-3 control-label">Mobile</label>
				<div class="col-xs-8 col-lg-5">
				    <div class="input-group">
				        <span class="input-group-addon">IN</span>
					    <input type="text" class="form-control" name="contact-no" id="contact-no" placeholder="Mobile No" maxlength="14" 
							data-bv-numeric="true" 
							data-bv-numeric-message="Please enter valid phone numbers" 
							data-bv-phone-country11="IN"
							data-bv-stringlength="true"
							data-bv-stringlength-min="10"
							data-bv-stringlength-max="10"
							data-bv-stringlength-message="Contact number must be 10 characters long" />
					</div>
				</div>
				<div class="col-xs-1 col-lg-4"></div>
			</div>
			<div class="form-actions">
			    <label class="col-xs-3 col-lg-3 control-label">&nbsp;</label>
                <div class="col-xs-8 col-lg-5"><button type="submit" class="btn btn-success btn-large">Signup</button>
                <button id="logIn" type="button" class="btn">Login</button></div>
				<div class="col-xs-1 col-lg-4"></div>
            </div>
        </form>
		</div>
		<div class="col-xs-1 col-lg-3"></div>
		</div>
        <hr>

        <!-- Footer -->
        <? 
		    $_SESSION['footer-menu'] = 5;
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
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="./js/bootstrapValidator.js"></script> 

<script>
$(document).ready(function() {
    $('#loginForm').bootstrapValidator();
});
$(document).ready(function() {
    $('#registrationForm').bootstrapValidator();
});
$("#btnSignup").click(function() {
   $("#registrationDiv").removeAttr('style');
   $("#loginDiv").attr('style', 'display:none');
   $("#header-text").text("Signup!");
   $('#registrationForm').bootstrapValidator('resetForm', true);
});
$("#logIn").click(function() {
   $("#loginDiv").removeAttr('style');
   $("#registrationDiv").attr('style', 'display:none');
   $("#header-text").text("Login!");
   $('#loginForm').bootstrapValidator();
});
</script>
</html>
