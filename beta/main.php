<?
	session_start();
	include("./bl/util.php");
	unset($_SESSION['id']);
	unset($_SESSION['tag']);
	unset($_SESSION['user']);
	unset($_SESSION['cat']);
	unset($_SESSION['state']);
	$state=2;
	$_SESSION['footer-menu'] = 1;
	if (checkUserAgent('mobile')) {
	  include('feed.php');
	} else {
	  include('newFeed.php');
	}
?>
