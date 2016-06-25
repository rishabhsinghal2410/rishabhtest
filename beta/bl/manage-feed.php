<?
	// Manages Review Operations
	//include("validaterequest.php");
	require_once($baseUrl . "./db.php");
	require_once($baseUrl . "./util.php");
	session_start();

	/**
	 * 'gf' -> get main feed.
	 * 'gc' -> get list of all categories.
	 */

	if ($_GET['f'] == "gf") {
		$feed = getMainFeed();
		if ($_GET['v'] == "json") {
		  echo json_encode($feed);
		} else if ($_GET['v'] == "html") {
		  echo transformFeedArrToHtml($feed);
		} else if ($_GET['v'] == "array") {
		  echo var_dump($feed);
		} else {
		  echo "Please select a display type [HTML/JSON].";
		}
	} else if ($_GET['f'] == "gc") {
	    $type = $_GET['t'];
	    echo json_encode(getAllCategories($type));
	}

	function getMainFeedByState($state) {
	    $query = createFeedQuery($state, 0);
		mysql_query($query) or die(mysql_error());
		$numresults=mysql_query($query);
		$numrows=mysql_num_rows($numresults);
		$result = mysql_query($query) or die("Couldn't execute query");
		$arrFeed=array();
		if ($numrows == 0) {
		    array_push($arrFeed, array("Feed"=>array()));
		} else {
			$contentArr=array();
		    $i=0;
			while($i < $numrows) {
			    $row = mysql_fetch_array($result);
			    $rowArr=array("id"=>$row['id'], "description"=>preg_replace('/#(\w+)/', ' <a href="./search.php?tag=$1">#$1</a>', stripslashes($row['review_content'])), "coverPik"=>$row['cover_pic'], 
				"landingUrl"=>generateLandingUrl($row['landing_url'], $row['affiliate_key'], $row['affiliate_id'], $row['id']),
				"views"=>defaultViewsIfNull($row['cnt']));
				array_push($contentArr, $rowArr);
				$i++;
			}
			array_push($arrFeed, array("Feed"=>$contentArr));
		}
		return $arrFeed;
	}

	function createFeedQuery($state, $startId) {
	    $query = "SELECT rc.*, hc.cnt, rfl.affiliate_key, rfl.affiliate_id FROM review_content rc LEFT JOIN (SELECT COUNT(*) cnt, review_id FROM review_hits GROUP BY review_id) hc ON (rc.id = hc.review_id) LEFT JOIN ref_affiliate_link rfl on (rfl.affiliate_site=rc.parent_site) ";
		$whereClause = " WHERE rc.state=$state";
		/*if ($startId > 0) {
		    $whereClause .= " and rc.id > $startId";
		}*/
		if (isset($_SESSION['user'])) {
		    unset($_SESSION['id']);
			$user = $_SESSION['user'];
			$whereClause .= " and rc.user_created='$user'";
		} else if (isset($_SESSION['id'])) {
		    unset($_SESSION['user']);
		    $id = $_SESSION['id'];
			$whereClause .= " and rc.user_created IN (select username from user where id=$id)";
		}
		if (isset($_SESSION['tag'])) {
		    unset($_SESSION['id']);
			unset($_SESSION['cat']);
		    $tag = mysql_real_escape_string($_SESSION['tag']);
			$whereClause .= " and (rc.id IN (select review_id from hashtags where hash_tag = '#$tag') OR rc.review_content like '%$tag %')";
		}
		if (isset($_SESSION['cat'])) {
		    unset($_SESSION['id']);
			unset($_SESSION['tag']);
		    $catId = $_SESSION['cat'];
			$whereClause .= " and rc.id IN (select review_id from review_by_category where category_id IN (select rcat.id from ref_category rcat join ref_category_group rcg on (rcat.id=rcg.category_id) where rcg.category_group_id = $catId))";
		}
		$query .= $whereClause;
		$query .= " order by rc.id desc LIMIT $startId , 8";
		return $query;
	}

	function getMainFeed() {
	    $page = $_GET['p'];
		$startId = $page * 8;
		$state = 2;
		if (isset($_GET['s'])) {
		    $state = $_GET['s'];
		}
        $query = createFeedQuery($state, $startId);
		mysql_query($query) or die(mysql_error());
		$numresults=mysql_query($query);
		$numrows=mysql_num_rows($numresults);
		$result = mysql_query($query) or die("Couldn't execute query");
		$arrFeed=array();
		if ($numrows == 0) {
		    array_push($arrFeed, array("Feed"=>array()));
		} else {
			$contentArr=array();
		    $i=0;
			while($i < $numrows) {
			    $row = mysql_fetch_array($result);
			    $rowArr=array("id"=>$row['id'], "description"=>preg_replace('/#(\w+)/', ' <a href="./search.php?tag=$1">#$1</a>', stripslashes($row['review_content'])), "coverPik"=>$row['cover_pic'], 
				"landingUrl"=>generateLandingUrl($row['landing_url'], $row['affiliate_key'], $row['affiliate_id'], $row['id']),
				"views"=>defaultViewsIfNull($row['cnt']));
				array_push($contentArr, $rowArr);
				$i++;
			}
			array_push($arrFeed, array("Feed"=>$contentArr));
		}
		return $arrFeed;
	}

	/**
	 * Return all category based on provided MODE.
	 * 1 -> Array.
	 * 2 -> Tree.
	 */
	function getAllCategories($mode) {
	    if ($mode == 1) {
		    $query = "SELECT * FROM ref_category;";
			mysql_query($query) or die(mysql_error());
		    $numResults=mysql_query($query);
			$numRows=mysql_num_rows($numResults);
			$categories=array();
		    $i=0;
			while($i < $numRows) {
			    $row = mysql_fetch_array($numResults);
			    array_push($categories, array("id"=>$row['id'], "name"=>$row['name']));
				$i++;
			}
			return $categories;
		} else if ($mode == 2) {
		    $query = "SELECT root.id AS root_id, root.name AS root_name, down1.id AS down1_id, down1.name AS down1_name, down2.id AS down2_id, down2.name AS down2_name FROM ref_category AS root LEFT OUTER JOIN ref_category AS down1 ON down1.parent_id = root.id LEFT OUTER JOIN ref_category AS down2 ON down2.parent_id = down1.id WHERE root.parent_id IS NULL ORDER BY root_name, down1_name, down2_name";
			mysql_query($query) or die(mysql_error());
		    $numResults=mysql_query($query);
			$numRows=mysql_num_rows($numResults);
			$categories=array();
		    $i=0;
			$level0Id = 0;
			$level1Id = 0;
			$level2Id = 0;
			$categoriesTree = array();
			$level1Children = array();
			$rootChildren = array();
			$leafArr = array();
			while($i < $numRows) {
			    $row = mysql_fetch_array($numResults);
				$leafArr = array();
				if ($row['down2_id'] != null) {
				    $leafArr = array("id"=>$row['down2_id'], "text"=>$row['down2_name']);
				}
				if ($level1Id == 0 || $level1Id == $row['down1_id']) {
				    if (sizeof($leafArr) > 0) {
				        array_push($level1Children, $leafArr);
					}
					$level1Id = $row['down1_id'];
					$level1Name = $row['down1_name'];
				} else {
				    array_push($rootChildren, array("id"=>$level1Id, "text"=>$level1Name, "children"=>$level1Children));
					// Reset level 1 children as level 1 element has changed.
					$level1Children = array();
					// Add leaf node (level 2) from current (level 1 changed) DB row.
					if (sizeof($leafArr) > 0) {
					    array_push($level1Children, $leafArr);
					}
					// read new ID/Name of level 1.
					$level1Id = $row['down1_id'];
					$level1Name = $row['down1_name'];
				}
				if ($rootId != $row['root_id']) {
				    if ($rootId == 0) {
					    $rootId = $row['root_id'];
						$rootName = $row['root_name'];
					} else {
					    array_push($categoriesTree, array("id"=>$rootId, "text"=>$rootName, "children"=>$rootChildren));
						$rootChildren = array();
						$rootId = $row['root_id'];
						$rootName = $row['root_name'];
					}
				}
				$i++;
			}
			if ($numRows > 0) {
			  if (sizeOf($level1Children) > 0) {
			      array_push($rootChildren, array("id"=>$level1Id, "text"=>$level1Name, "children"=>$level1Children));
			  }
		      array_push($categoriesTree, array("id"=>$rootId, "text"=>$rootName, "children"=>$rootChildren));
			}
			return $categoriesTree;
		}
	}

	function transformFeedArrToHtml($feedArr) {
        $feedPostTemplate = '<li><div id="post-%review_id_div%"><div class="post-home"><div style="border-radius:10px;border:none"><a class="showDialog link" data-toggle="modal" data-target=".bs-example-modal-lg" onclick="renderData(%review_id%);"><img class="img-responsive" src="%review_image_tn%" style="border-top-left-radius:10px;border-top-right-radius:10px;"/></a><div class="descr"><div class="row"><div class="col-lg-12 col-xs-12"><p class="">%review_content%</p></div></div><div class="row social-icons"><div class="col-lg-6 col-xs-6"><em class="glyphicon glyphicon-eye-open" style="color: #a7a7a7;font-size:13px;"></em><em style="color: #999;font-size: 13px;font-weight: normal;">%review_view_count%</em></div><div class="col-lg-6 col-xs-6" style="text-align:right;"><span><a href="#" style="font-size:13px;"/></span></div></div></div><div class="row"><div class="col-lg-12 col-xs-12"><a class="item-link" target="_blank" href="%review_landing_url%"><div class="checkout-item">Check this Item!</div></a></div></div></div></div></div></li>';
		
		$feedHtml = "";
		$posts = $feedArr[0];
		$posts = $posts["Feed"];
		//echo var_dump($posts);
		foreach ($posts as $post) {
		    //echo var_dump($post);
		    $postHtml = $feedPostTemplate;
			$postHtml = str_replace("%review_id_div%", $post["id"], $postHtml);
	        $postHtml = str_replace("%review_id%", $post["id"], $postHtml);
			$postHtml = str_replace("%review_image_tn%", $post["coverPik"], $postHtml);
			$postHtml = str_replace("%review_content%", $post["description"], $postHtml);
			$postHtml = str_replace("%review_view_count%", $post["views"], $postHtml);
			$postHtml = str_replace("%review_landing_url%", $post["landingUrl"], $postHtml);
			$feedHtml .= $postHtml;
			//echo $feedPostTemplate;
		}
		return $feedHtml;
	}

?>