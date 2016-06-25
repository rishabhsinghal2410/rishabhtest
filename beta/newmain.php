<?
	session_start();
	unset($_SESSION['id']);
	unset($_SESSION['tag']);
	unset($_SESSION['user']);
	unset($_SESSION['cat']);
	$_SESSION['footer-menu'] = 1;
	include('newFeed.php');
?>
