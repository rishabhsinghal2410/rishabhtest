<?
	// Manages Review Operations
	//include("validaterequest.php");
	require_once("./db.php");
	require_once("./util.php");
	session_start();

	/**
	 * 'va' -> add new view.
	 * 'vg' -> get view count on any review.
	 * 'gr' -> get review content as JSON.
	 * 'sc' -> save a comment.
	 */

	if ($_GET['f'] == "va") {
		addNewView();
	} else if ($_GET['f'] == "vg") {
		getViews();
	} else if ($_GET['f'] == "gr") {
		getReview();
	} else if ($_GET['f'] == "sc") {
		saveComment();
	}

	function saveComment() {
        $reviewId = $_GET['review_id'];
		if (isset($_SESSION['uname'])) {
		    $commentedBy = $_SESSION['uname'];
		} else {
		    $commentedBy = "Anonymous";
		}
		$comment = $_GET['comment'];
		$id = generateUniqueId('review_comment');
		$dated=getCurrentDate();
		$query="INSERT INTO review_comment (id, review_id, user_comment, commented_by_user, commented_date, state) VALUES ($id, $reviewId, '$comment', '$commentedBy', '$dated', 2)";
		mysql_query($query) or die(mysql_error());
	}

	function addNewView() {
	    $reviewId = $_GET['review_id'];
		if (isset($_SESSION['uname'])) {
		    $viewedBy = $_SESSION['uname'];
		} else {
		    $viewedBy = "Anonymous";
		}
		$viewedDate = getCurrentDate();
		$ipAddress = getUserIpAddress();
		$tableName = "review_hits";
		$id = generateUniqueId($tableName);
		$query = "INSERT INTO " . $tableName . " (id, review_id, viewed_by, view_date, ip_viewed_from, state) VALUES ($id, $reviewId, '$viewedBy', '$viewedDate', '$ipAddress', 2)";
		echo $query;
		mysql_query($query) or die(mysql_error());
	}

	function getViews($reviewId) {
		$query = "SELECT count(*) cnt from review_hits rh where rh.review_id=$reviewId";
		$numresults = mysql_query($query);
	    $numrows=mysql_num_rows($numresults);
        $result = mysql_query($query) or die(mysql_error());
	    $row= mysql_fetch_array($result);
		$views = 1;
	    if($numrows > 0) {
		    $views = $row['cnt'];
	    }
		return $views;
	}

	function getReviewPiks($reviewId) {
	    $query = "SELECT id, pic_url, cover_pic from review_pic rp where rp.state=2 and rp.review_id=$reviewId";
		$result = mysql_query($query) or die(mysql_error());
		$numRows=mysql_num_rows($result);
		$pikArr = array();   
	    $i=0;
		while ($i < $numRows) {
	        $row = mysql_fetch_array($result);
			$pik=array("pikId"=>$row['id'], "pikUrl"=>$row['pic_url'], "coverPik"=>$row['cover_pic']);
		    array_push($pikArr, $pik);
			$i++;
		}
		return $pikArr;
	}
	
	function getReviewComment($reviewId) {
	    $query = "SELECT u.first_name, rc.user_comment, rc.commented_date from review_comment rc join user u on (u.username=rc.commented_by_user) where rc.state=2 and rc.review_id=$reviewId order by rc.commented_date desc";
		$commentArr = array();
		$result = mysql_query($query) or die(mysql_error());
		$numRow=mysql_num_rows($result);
	    $i=0;
		while ($i < $numRow) {
			$row = mysql_fetch_array($result);
		    $comment=array("userId"=>$row['first_name'], "text"=>$row['user_comment'], "timestamp"=>date("M jS, Y", strtotime($row['commented_date'])));
		    array_push($commentArr, $comment);
			$i++;
		}
		return $commentArr;
	}

	function getReview() {
	    $reviewId=$_GET['rid'];
        $reviewQuery = "SELECT review_header, review_content, landing_url, rc.facebook_id, u.first_name, u.id, rfl.affiliate_key, rfl.affiliate_id from review_content rc join user u on (u.username=rc.user_created) left join ref_affiliate_link rfl on (rfl.affiliate_site=rc.parent_site) where rc.state=2 and rc.id=$reviewId";
        // execute
		$numresultsRQ=mysql_query($reviewQuery);
		$numrowsRQ=mysql_num_rows($numresultsRQ);
		if ($numrowsRQ < 0) {
		    // Return error for invalid reviewID
		} else {
		    $resultRQ = mysql_query($reviewQuery) or die(mysql_error());
		    $rowRQ = mysql_fetch_array($resultRQ);
			$hitCount=getViews($reviewId);
			$arr=array("Id"=>$reviewId,
					 "Comments"=>getReviewComment($reviewId),
                     "Images"=>getReviewPiks($reviewId),
	                 "description"=>trim($rowRQ['review_content']),
	                 "hits"=>"$hitCount",
                     "landingUrl"=>generateLandingUrl($rowRQ['landing_url'], $rowRQ['affiliate_key'], $rowRQ['affiliate_id'], $reviewId),
	                 "Reviewer"=>array("name"=>$rowRQ['first_name'], "id"=>$rowRQ['id']),
					 "Categories"=>getSelectedCategories($reviewId)
                 );
			if(isset($_SESSION['uname']) && isset($_SESSION['type']) && $_SESSION['type'] == 1) {
			    $arr += array("Facebook"=>array("id"=>($rowRQ['facebook_id'] != null ? 1 : 0),
				                                "url"=>generateFBUrl($rowRQ['facebook_id'])));
			}
            echo json_encode(array("ReviewContent"=>$arr));
		}
	}

	function generateFBUrl($postId) {
	    $idArr = explode("_", $postId);
	    return "https://www.facebook.com/" . $idArr[0] . "/posts/" . $idArr[1];
	}

	function getSelectedCategories($reviewId) {
	    $selectedCatQuery = "SELECT c.id id, c.name name from ref_category c join review_by_category rbc on rbc.category_id=c.id where rbc.review_id=$reviewId and rbc.selected=1";
		$resultCS = mysql_query($selectedCatQuery);
		$numrowsCS=mysql_num_rows($resultCS);
		$selCat = array();
		$i=0;
		while ($i < $numrowsCS) {
		    $rowsCS=mysql_fetch_array($resultCS);
			array_push($selCat, array("id"=>$rowsCS['id'], "text"=>$rowsCS['name']));
			$i++;
		}
		return $selCat;
	}

?>