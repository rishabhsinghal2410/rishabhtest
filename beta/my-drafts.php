<?
    include('./bl/validate-request.php');
	session_start();
	$_SESSION['user'] = $_SESSION['uname'];
	$_SESSION['header'] = "Your drafts!";
	$_SESSION['header_small'] = "";
	$_SESSION['footer-menu'] = 4;
	$state=1;
	include('newFeed.php');
?>