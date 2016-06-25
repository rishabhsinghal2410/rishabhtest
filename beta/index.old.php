<?
	require("./config.php");
	//include("./bl/validaterequest.php");	
	require("./bl/db.php");
	session_start();
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
  <title>PikReview</title>
    <!-- Bootstrap Core CSS -->
	<link href="css/comment-box.css" rel="stylesheet">
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

    <? include('header.php') ?>

    <!-- Page Content -->
    <div class="container">

        <!-- Page Header -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <small></small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

	<?
		
		if (isset($_SESSION['user'])) {
		    $user = $_SESSION['user'];
		    $query = "select * from review_content rc where rc.user_created='$user' order by date_uploaded desc";
			unset($_SESSION['user']);
		} else if (isset($_SESSION['tag'])) {
		    $tag = $_SESSION['tag'];
			$query = "select * from review_content rc where rc.id IN (select review_id from hashtags where hash_tag = '#$tag') order by rc.date_uploaded desc";
			unset($_SESSION['tag']);
		} else if (isset($_SESSION['id'])) {
		    $id = $_SESSION['id'];
			$query = "select * from review_content rc where rc.user_created IN (select username from user where id=$id) order by rc.date_uploaded desc";
			unset($_SESSION['id']);
		} else {
		    $query = "select * from review_content order by date_uploaded desc";
		}
		$numresults=mysql_query($query);
		$numrows=mysql_num_rows($numresults);
		$result = mysql_query($query) or die("Couldn't execute query");
		if ($numrows == 0) {
			echo "Nothing to show, please upload one :)";
		} else { 
			$j=1;
			$i = 0;
			$count = 0;
			while($i < $numrows) {
		?>
		
        <!-- Projects Row -->
        <div class="row">
		<? 
				$j = 0;
				while($i < $numrows && $j < 4) { 
					$row = mysql_fetch_array($result);
					//$ids[] = $row['id'];
				?>
            <div class="col-md-3 portfolio-item thumbnail">
                <a title="<? echo $row['description']; ?>" class="showDialog" data-toggle="modal" data-target=".bs-example-modal-lg" data-id="<? echo $row['id']; ?>">
                    <img class="img-responsive" src="<? echo $row['cover_pic']; ?>" alt=""/>
                </a>
				<br />
				<table width="100%">
				<tr>
				  <td width="50%" align="right"><label><a class="btn btn-primary" href="<? echo $row['landing_url'] ?>" target="_blank">Buy Now</a></label></td>
				  <td><td width="50%">&nbsp;<label style="right: 0px;left:90%"><button class="btn btn-primary" type="button">Hits <span class="badge">4</span></button></label></td></td>
				</tr>
				</table>
				<p><? echo preg_replace('/#(\w+)/', ' <a href="./search.php?tag=$1">#$1</a>', $row['review_content']); ?></p>
            </div>
			<?  
					$j++;
					$i++;
				}
			?>
			</div>
			<? } } ?>
            
        <hr>

        <!-- Pagination -->
        <!--div class="row text-center">
            <div class="col-lg-12">
                <ul class="pagination">
                    <li>
                        <a href="#">&laquo;</a>
                    </li>
                    <li class="active">
                        <a href="#">1</a>
                    </li>
                    <li>
                        <a href="#">2</a>
                    </li>
                    <li>
                        <a href="#">3</a>
                    </li>
                    <li>
                        <a href="#">4</a>
                    </li>
                    <li>
                        <a href="#">5</a>
                    </li>
                    <li>
                        <a href="#">&raquo;</a>
                    </li>
                </ul>
            </div>
        </div-->
        <!-- /.row -->
        <!-- Footer -->
        <? include("footer.php") ?>

    </div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
	<div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
      <label><a id="aBuyNow" class="btn btn-primary" href="#">Buy Now</a></label>
	    <label style="right: 0px;left:90%"><button class="btn btn-primary" type="button">Hits <span id="spanHits" class="badge">4</span></button></label>
    </div>
	<div class="modal-body">
    <div class="row">
	
    <div class="col-md-7">
	  <div><span></span></div>
      <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
        <ol id="totalSlide" class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        </ol>
        <!-- Wrapper for slides -->
        <div id="imageGallery" class="carousel-inner" role="listbox">
          <div class="item active"><img src="images/1.jpg" width="460" height="200"></div>
        </div>
        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          <span class="sr-only"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          <span class="sr-only"></span>
        </a>
      </div>
      <h4>More by <a id="userUploaded" href="#">Ashish</a></h4>
	</div>
	<div class="col-md-5">
	<div class="detailBox">
      <div class="titleBox">
        <form id="idCommentFrm" class="form-inline" role="form" action="./bl/manage-review.php?f=sc" method="post">
            <div class="form-group">
                <textarea id="user_comment" class="form-control" type="text" name="comment" placeholder="Your comments" rows="2"cols="30"></textarea>
				<input id="txtReviewId" type="hidden" name="review_id" />
            </div>
            <div class="form-group">
				<input type="button" value="Add" class="btn btn-primary" onclick="addNewComment()"  />
            </div>	
        </form>
      </div>
        <!--div class="commentBox">
          <p class="taskDescription">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
        </div-->
      <div class="actionBox">
        <ul id="commentUl" class="commentList">
        </ul>
      </div>
	</div>
	</div>
  </div>
  </div>
</div>
</div>
</div>

</body>
  <script src="./js/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script>
	    $(document).ready(function(){
          $(".showDialog").click(function(){ // Click to only happen on announce links
            renderData($(this).data('id'));
            //$('#createFormId').modal('show');
          });
        });
	</script>
</html>
