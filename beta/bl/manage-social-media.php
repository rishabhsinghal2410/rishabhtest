<?php
   require_once __DIR__ . '/../facebook/autoload.php';
   require_once("./db.php");
   session_start();

   	/**
	 * 'ptf' -> Post to FB.
	 */
	if ($_GET['f'] == "ptf") {
		echo postToFB();
	}

	function postToFB() {
	    $reviewId = $_GET['rid'];
		if (!(isset($_SESSION['uname']) && isset($_SESSION['type']) && $_SESSION['type'] == 1)) {
            return json_encode(array("Status"=>"ERROR", "Message"=>"You are not privileged to perform this operation."));
		}
		if ($reviewId == null || $reviewId <= 0) {
		    return json_encode(array("Status"=>"ERROR", "Message"=>"Please specify a ReviewId to post."));
		}
		// GET rerview data from DB.
		$reviewData = getReview($reviewId);
	    $fb = new Facebook\Facebook([
		    'app_id' => '701644943304133',
		    'app_secret' => 'd3b1b668cfc3e8425f17decd3334950d',
		    'default_graph_version' => 'v2.5',
	    ]);

		$fb->setDefaultAccessToken('CAAJZBJHGapcUBAN2uaQB1ZBU80WYSByKsDgGsgvDL01ZBQQSMKVrRoeR0jgIrW2RaFOAunmdjMwPTsWTsCQR8DRXywBToFFzeGtwOUvcNrnFkuCX2RwP7mHZCURufkKRbgQSqJNIUJOxZCpRD9oYMOnSUPpoB4WXriDbZBf3LH97ZCZAnSv6hBr9WH0zBZC6UZC9gZD');

		$linkData = [
		#'link' => 'http://www.pikreview.com',
		'message' => $reviewData["content"],
		#'picture' => ("http://www.pikreview.com/beta/" . $reviewData["image"]),
		];

		try {
		    // Returns a `Facebook\FacebookResponse` object
		    $response = $fb->post('/me/feed', $linkData);
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		    return json_encode(array("Status"=>"ERROR", "Message"=>$e->getMessage()));
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		    return json_encode(array("Status"=>"ERROR", "Message"=>$e->getMessage()));
		}
		$graphNode = $response->getGraphNode();
		updatePostStatusTORC($reviewId, $graphNode['id']);
		return json_encode(array("Status"=>"SUCCESS", "Url"=>generateFBUrl($graphNode['id'])));
	}

	function updatePostStatusTORC($reviewId, $postId) {
	    // TODO: handle same review publish multiple times to FB. 
        $query = "UPDATE review_content SET facebook_id='$postId' WHERE id=$reviewId";
		mysql_query($query) or die(mysql_error());
	}

	function generateFBUrl($postId) {
	    $idArr = explode("_", $postId);
	    return "https://www.facebook.com/" . $idArr[0] . "/posts/" . $idArr[1];
	}

	function getReview($reviewId) {
	    $reviewQuery = "SELECT rc.review_content, rc.cover_pic from review_content rc where rc.id=$reviewId and rc.is_deleted=0";
        // execute
		$numresultsRQ=mysql_query($reviewQuery);
		$numrowsRQ=mysql_num_rows($numresultsRQ);
		if ($numrowsRQ < 0) {
		    // Return error for invalid reviewID
		} else {
		    $resultRQ = mysql_query($reviewQuery) or die(mysql_error());
		    $rowRQ = mysql_fetch_array($resultRQ);
			return array("content"=>$rowRQ['review_content'], "image"=>$rowRQ['cover_pic']);
		}
	}

?>
