<?
    require_once("./bl/util.php");
	if (!checkUserAgent('mobile')) {
?>
<footer>
	<div class="row">
		<div class="col-lg-12">
			<p>Copyright &copy; PikReview.com 2015</p>
		</div>
	</div>
</footer><!--navbar-inverse-->
<? } else { ?>
<div class="footer navbar-fixed-bottom" style="height:50px;">
    <table width="100%" style="height:100%" border="0">
	  <tr style="height:100%">
	    <td width="25%" class="menu <? if (isset($_SESSION['footer-menu']) && $_SESSION['footer-menu'] == 1) { echo "current"; } ?>"><a href="./main.php" class="white"><span class="glyphicon glyphicon-home" style="font-size: 25px;"></span>
		<br /><span class="text">Home</span></a></td>
		<!--td width="20%" class="menu <? if (isset($_SESSION['footer-menu']) && $_SESSION['footer-menu'] == 2) { echo "current"; } ?>"><a href="#" class="white"><span class="glyphicon glyphicon-search" style="font-size: 25px;"></span>
		<br /><span class="text">Search</span></a></td-->
		<td width="25%" class="menu <? if (isset($_SESSION['footer-menu']) && $_SESSION['footer-menu'] == 3) { echo "current"; } ?>"><a href="post-review.php" class="white"><span class="glyphicon glyphicon-camera" style="font-size: 25px;"></span>
		<br /><span class="text">New Post</span></a></td>
		<td width="25%" class="menu <? if (isset($_SESSION['footer-menu']) && $_SESSION['footer-menu'] == 4) { echo "current"; } ?>"><a href="./my-post.php" class="white"><span class="glyphicon glyphicon-user" style="font-size: 25px;"></span>
		<br /><span class="text">My Post</span></a></td>
		<? if (isset($_SESSION['uname'])) { ?>
		<td width="25%" class="menu"><a href="./logout.php" class="white"><span class="glyphicon glyphicon-log-out" style="font-size: 25px;"></span>
		<br /><span class="text">Logout</span></a></td>
		<? } else { ?>
		<td width="25%" class="menu <? if (isset($_SESSION['footer-menu']) && $_SESSION['footer-menu'] == 5) { echo "current"; } ?>"><a href="./login.php" class="white"><span class="glyphicon glyphicon-log-in" style="font-size: 25px;"></span>
		<br /><span class="text">Login</span></a></td>
		<? } ?>
	  </tr>
	</table>
</div>
<? } ?>