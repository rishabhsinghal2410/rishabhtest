<?
	session_start();
	if (isset($_GET['tag'])) {
	  $tag = $_GET['tag'];
	  $_SESSION['tag'] = $_GET['tag'];
	}
	if (isset($_GET['id'])) {
	  $_SESSION['id'] = $_GET['id'];
	}
	if (isset($_GET['cat'])) {
	  $_SESSION['cat'] = $_GET['cat'];
	}
	include('feed.php');
	//header("Location: ./bl/manage-feed.php?f=gf&sid=0");
?>