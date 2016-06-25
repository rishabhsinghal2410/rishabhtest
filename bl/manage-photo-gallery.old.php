<?
	// Manages PhotoGallery Operations
	//include("validaterequest.php");
	require_once("./db.php");
	require_once("./util.php");
	extract($_POST);
    session_start();	
	if ($_GET['method'] == "ADD") {
		addNewPost();
	} else if ($_GET['method'] == "UPDATE") {
		editExistingPost();
	} else if ($_GET['method'] == "DELETE") {
		deleteExistingPost();
	}

	function getHashtags($string) {  
        $hashtags= FALSE;  
        preg_match_all("/(#\w+)/u", $string, $matches);  
        if ($matches) {
            $hashtagsArray = array_count_values($matches[0]);
            $hashtags = array_keys($hashtagsArray);
        }
        return $hashtags;
    }

	function addNewPost() {
		$id = generateUniqueId("review_content");
		$path = "./bl/images/" . $fileName;
		$title = $_POST['title'];
		$descr = $_POST['descr'];
		$hashTags = getHashtags($descr);
		$landing_url = $_POST['landing_url'];
		$user=$_SESSION['uname'];
		$myFile = $_FILES['photos'];
		$fileCount = count($myFile["name"]);
		$fileNames = array();
		for ($i=0;$i<$fileCount;$i++) {
		    $fileName = time() . $i . "_" . $myFile['name'][$i];
			$path = dirname(__FILE__) . "/../images/" . $fileName;
			move_uploaded_file($myFile['tmp_name'][$i], $path);
			$path = "./images/" . $fileName;
			array_push($fileNames, $path);
		}
		$user_uploaded = $_SESSION['uname'];
		$reviewId = insertReviewContent($review_header, $descr, $landing_url, $fileNames[0], $user_uploaded);
		insertReviewPiks($reviewId, $fileNames);
		saveHashTags($reviewId, $hashTags);
		header("Location: ../index.php?msg=Added Successfully");
	}

	function saveHashTags($reviewId, $hashTags) {
        $query = "INSERT INTO hashtags (review_id, hash_tag, created_date, is_deleted) VALUES ";
		$dated=getCurrentDate();
		for ($i=0;$i<sizeof($hashTags);$i++) {
		    $hashTag = $hashTags[$i];
			$query .= "($reviewId, '$hashTag', '$dated', 0)";
			if (($i+1) != sizeof($hashTags)) {
			    $query .= ", ";
			}
		}
		if (sizeof($hashTags) > 0) {
		    mysql_query($query) or die(mysql_error());
	    }
	}

	function insertReviewContent($review_header, $description, $landing_url, $cover_pic, $user_uploaded) {
	    $id = generateUniqueId("review_content");
		$dated=getCurrentDate();
		$user=$_SESSION['uname'];
		$parentSite=str_replace('.com', '', str_ireplace('www.', '', parse_url($landing_url, PHP_URL_HOST)));
		$query = "INSERT INTO review_content (id, review_header, review_content, landing_url, cover_pic, user_created, date_uploaded, parent_site) VALUES ($id, '$title', '$description', '$landing_url', '$cover_pic', '$user', '$dated', '$parentSite')";
		mysql_query($query) or die(mysql_error());
		return $id;
	}

	function insertReviewPiks($reviewId, $fileNames) {
	    $query = "INSERT INTO review_pic (review_id, pic_url, uploaded_date, is_deleted) VALUES ";
		$dated=getCurrentDate();
		for ($i=0;$i<sizeof($fileNames);$i++) {
		    $fileName = $fileNames[$i];
			$query .= "($reviewId, '$fileName', '$dated', 0)";
			if (($i+1) != sizeof($fileNames)) {
			    $query .= ", ";
			}
			
		}
		if (sizeof($fileNames) > 0) {
		    mysql_query($query) or die(mysql_error());
	    }
	}

	function editExistingPost() {
        $reviewId=$_POST['review-id'];
		$descr = $_POST['descr'];
		$hashTags = getHashtags($descr);
		$deletedPikIds=$_POST['deleted-piks'];
		$coverPik=$_POST['cover-pik'];
		$user=$_SESSION['uname'];
		$myFile = $_FILES['photos'];
		$fileCount = sizeof($_FILES);
		if ($fileCount == 1 && $myFile["size"][0] == 0) {
		    $fileCount = 0;
		}
		$fileNames = array();
		for ($i=0;$i<$fileCount;$i++) {
		    $fileName = time() . $i . "_" . $myFile['name'][$i];
			$path = dirname(__FILE__) . "/../images/" . $fileName;
			move_uploaded_file($myFile['tmp_name'][$i], $path);
			$path = "./images/" . $fileName;
			array_push($fileNames, $path);
		}
		if (strlen(trim($deletedPikIds)) > 0) {
		    $deletedPikIdArr = explode(",", $deletedPikIds);
		} else {
		    $deletedPikIdArr = array();
		}
		$user_uploaded = $_SESSION['uname'];
		begin();
		updateReviewContent($reviewId, $descr, $coverPik);
		deleteObjects($deletedPikIdArr, "review_pic");
		insertReviewPiks($reviewId, $fileNames);
		refreshHashTags($reviewId, $hashTags);
		commit();
		header("Location: ../my-post.php?msg=Updated Successfully");
	}

	function refreshHashTags($reviewId, $hashTags) {
	    $query = "DELETE FROM hashtags WHERE review_id=" . $reviewId;
		mysql_query($query) or die(mysql_error());
		saveHashTags($reviewId, $hashTags);
	}

	function updateReviewContent($reviewId, $descr, $coverPikId) {
		$coverPikUrl = '';
		if ($coverPikId != '' && $coverPikId > 0) {
	        $query = "select * from review_pic where id=" . $coverPikId;
		    $result = mysql_query($query) or die(mysql_error());
		    $numRows=mysql_num_rows($result);
		    if ($numRows > 0) {
		        $row = mysql_fetch_array($result);
			    $coverPikUrl = $row['pic_url'];
				$query="UPDATE review_pic SET cover_pic=0 WHERE review_id=" . $reviewId;
				mysql_query($query) or die(mysql_error());
				$query="UPDATE review_pic SET cover_pic=1 WHERE id=" . $coverPikId;
				mysql_query($query) or die(mysql_error());
		    }
		}
		if ($coverPikUrl != '') {
		    $query="UPDATE review_content set review_content='" . $descr . "', cover_pic='" . $coverPikUrl . "' WHERE id=" . $reviewId;
        } else {
		    $query="UPDATE review_content set review_content='" . $descr . "' WHERE id=" . $reviewId;
		}
		mysql_query($query) or die(mysql_error());
	}

    function deleteObjects($ids, $tableName) {
        for ($i=0;$i<sizeof($ids);$i++) {
		    deleteObject($ids[$i], $tableName);
		}
    }

	function deleteObject($id, $tableName) {
	    $query = "UPDATE " . $tableName . " SET is_deleted=1 WHERE id=" . $id;
		mysql_query($query) or die(mysql_error());
	}

	function deleteObjectByReviewId($reviewId, $tableName) {
	    $query = "UPDATE " . $tableName . " SET is_deleted=1 WHERE review_id=" . $reviewId;
		mysql_query($query) or die(mysql_error());
	}

	function deleteExistingPost() {
	    $reviewId = $_POST['review-id'];
		begin();
		deleteObject($reviewId, "review_content");
		deleteObjectByReviewId($reviewId, "review_pic");
		deleteObjectByReviewId($reviewId, "review_hits");
		deleteObjectByReviewId($reviewId, "review_site_visited");
		deleteObjectByReviewId($reviewId, "review_comment");
		deleteObjectByReviewId($reviewId, "hashtags");
		commit();
		header("Location: ../my-post.php?msg=Deleted Successfully");
	}

?>