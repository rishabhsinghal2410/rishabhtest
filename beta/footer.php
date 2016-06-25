<?
    require_once("./bl/util.php");
	if (!checkUserAgent('mobile')) {
?>
<footer>
	<div class="row">
		<div class="col-lg-12">
			<p>Copyright &copy; PikReview.com 2015</p>
		</div>
		<a href="./disclosure.php">Disclosure</a>
	</div>
</footer><!--navbar-inverse-->
<? } else { 
$footerMenu = 0;
if (isset($_SESSION['footer-menu'])) {
    $footerMenu = $_SESSION['footer-menu'];
}
?>
<div class="footer navbar-fixed-bottom" style="height:50px;">
    <table width="100%" style="height:100%" border="0">
	  <tr style="height:100%">
	    <td width="25%" class="menu <? if ($footerMenu == 1) { echo "current"; } ?>"><a href="./main.php" class="white"><span class="glyphicon glyphicon-home <? if ($footerMenu == 1) { echo "footer-menu"; } ?>" style="font-size: 25px;"></span>
		<br /><span class="text <? if ($footerMenu == 1) { echo "footer-menu-main"; } ?>">Home</span></a></td>
		
		<!--<td width="20%" class="menu <? if ($footerMenu == 2) { echo "current"; } ?>"><a href="#" class="white" onclick="showHide('category-box')"><span class="glyphicon glyphicon-filter <? if ($footerMenu == 2) { echo "footer-menu"; } ?>" style="font-size: 25px;"></span>
		<br /><span class="text <? if ($footerMenu == 2) { echo "footer-menu-main"; } ?>">Filter</span></a></td>-->
		
		<td width="25%" class="menu <? if ($footerMenu == 3) { echo "current"; } ?>"><a href="post-review.php" class="white"><span class="glyphicon glyphicon-camera /**footer-menu-main**/" style="font-size: 25px;"></span>
		<br /><span class="text">Post</span></a></td>
		
		<td width="25%" class="menu <? if ($footerMenu == 4) { echo "current"; } ?>"><a href="./my-post.php" class="white"><span class="glyphicon glyphicon-user <? if ($footerMenu == 4) { echo "footer-menu"; } ?>" style="font-size: 25px;"></span>
		<br /><span class="text <? if ($footerMenu == 4) { echo "footer-menu-main"; } ?>">My Post</span></a></td>
		<? if (isset($_SESSION['uname'])) { ?>
		
		<td width="25%" class="menu"><a href="./logout.php" class="white"><span class="glyphicon glyphicon-log-out" style="font-size: 25px;"></span>
		<br /><span class="text">Logout</span></a></td>
		<? } else { ?>
		
		<td width="25%" class="menu <? if ($footerMenu == 5) { echo "current"; } ?>"><a href="./login.php" class="white"><span class="glyphicon glyphicon-log-in <? if ($footerMenu == 5) { echo "footer-menu"; } ?>" style="font-size: 25px;"></span>
		<br /><span class="text <? if ($footerMenu == 5) { echo "footer-menu-main"; } ?>">Login</span></a></td>
		<? } ?>
	  </tr>
	</table>
</div>
<? } ?>