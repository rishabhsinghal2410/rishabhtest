
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" style="background-color:#fff;border-color:#cc181e;border-width:0 0 2px;" role="navigation">
	<div class="container container-max">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<!--<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>-->
			<?
                require_once("./bl/util.php");
	            if (checkUserAgent('mobile')) {
            ?>
			<table>
			    <td width="40%"><span class="navbar-brand" style="background-color:#cc181e;color:white;text-decoration:none;font-weight:bold;">PikReview!</span></td>
				<td width="60%"><form action="./search.php"><input type="text" class="form-control" name="tag" placeholder="I am looking for..." value="<? if (isset($_SESSION['tag'])) { echo $_SESSION['tag'];} ?>" /></form></td>
			</table>
			<? } else { ?>
			    <span class="navbar-brand" style="background-color:#cc181e;"><a href="./" style="color:white;text-decoration:none;font-weight:bold;">PikReview!</a></span>
			<? } ?>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		    <form class="navbar-form navbar-left" role="search" action="./search.php" style="width:55%">
                <div class="form-group" style="width:95%">
				    <div class="icon-addon addon-lg">
                      <!--<input type="text" placeholder="Email" class="form-control" id="email">-->
                      <span class="glyphicon glyphicon-search"></span>
                    <input type="text" class="form-control" name="tag" placeholder="I am looking for..." value="<? if (isset($_SESSION['tag'])) { echo $_SESSION['tag'];} ?>" style="width:100%">
                <!--<button type="submit" class="btn"><i class="icon-search"></i></button>-->
				    </div>
				</div>
            </form>
			<div class="nav navbar-nav navbar-center" style="padding-top:9px;"> 
				  <a href="https://www.facebook.com/Pikreview" target="_blank" style="padding-top:9px; background-color:transparent;"><img src="./css/icons/facebook.ico" /></a>
				  <a href="https://www.instagram.com/pikreview_official/" target="_blank"><img src="./css/icons/instagram.ico" /></a>
			</div>
			<ul class="nav navbar-nav navbar-right">
				<li>
					<a href="./main.php">Feed</a>
				</li>
				<li>
					<a href="./post-review.php">Post a review</a> <!--style="cursor:pointer" onclick="openbox('New Review', 1)"-->
				</li>
				<? if (isset($_SESSION['uname'])) { ?>
				<li><a href="./my-post.php">My Post</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown" class="dropdown-toggle"><? echo ucfirst($_SESSION['name']); ?><span class="caret"></span>
					<ul class="dropdown-menu">
						<? if (isset($_SESSION['uname']) && isset($_SESSION['type']) && $_SESSION['type'] == 1) { ?>
				        <li><a href="./add-category.php">Add Category</a></li>
				        <? } ?>
				        <li><a href="./logout.php">SignOut</a></li>
				    </ul>
					</a>
				</li>
				<? } else { ?>
				<li><a href="./login.php">Sign In</a></li>
				<? } ?>
			</ul>
		</div>
		<!-- /.navbar-collapse -->
	</div>
	<!-- /.container -->
</nav>
<? if (checkUserAgent('mobile')) { ?>
		<!-- Brand and toggle get grouped for better mobile display -->
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div style="text-align:center;">
			<ul class="nav nav-tabs" role="tablist" style="border-bottom-color:#ccc;">
				<li role="presentation" style="width:10%;text-align:center;padding-top:8px;">
				    <span class="glyphicon glyphicon-filter" style="font-size: 25px;"></span>
				</li>
				<li role="presentation" style="width:40%;border-right:1px solid #ccc;color:black">
					<a href="./search.php?cat=2" style="color:black">Women</a>
				</li>
				<li role="presentation" style="width:40%;">
					<a href="./search.php?cat=1" style="color:black">Men</a>
				</li>
				<!--li class="dropdown" role="presentation" >
					<a href="#" data-toggle="dropdown" class="dropdown-toggle">More Catagories<span class="caret"></span>
					<ul class="dropdown-menu">
						<li><a href="./cat.php?c=2">Kids</a></li>
				        <li><a href="./cat.php?c=2">Electronics</a></li>
				    </ul>
					</a>
				</li-->
				
			</ul>
		</div>
<? } ?>