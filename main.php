<?
	session_start();
	unset($_SESSION['id']);
	unset($_SESSION['tag']);
	unset($_SESSION['user']);
	$_SESSION['footer-menu'] = 1;
	include('feed.php');
?>
