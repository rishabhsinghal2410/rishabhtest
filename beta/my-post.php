<?
    include('./bl/validate-request.php');
	include("./bl/util.php");
	session_start();
	unset($_SESSION['id']);
	unset($_SESSION['tag']);
	unset($_SESSION['user']);
	unset($_SESSION['cat']);
	unset($_SESSION['state']);
	$state=2;
	$_SESSION['user'] = $_SESSION['uname'];
	$_SESSION['header'] = "Awesome content shared by you!";
	$_SESSION['header_small'] = "";
	$_SESSION['footer-menu'] = 4;
	if (checkUserAgent('mobile')) {
	  include('feed.php');
	} else {
	  include('newFeed.php');
	}
?>