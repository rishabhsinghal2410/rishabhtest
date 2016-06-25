<?
	function defaultViewsIfNull($viewCount) {
	    if ($viewCount == null) {
		    return 1;
		}
		return $viewCount;
	}

    function generateLandingUrl($landingUrl, $affiliateKey, $affiliateId, $reviewId) {
	    $affiliateUrl = $landingUrl;
		if (!($affiliateKey==null || $affiliateId==null)) {
		    $contains = strpos($affiliateUrl,'?');
		    if ($contains === false) {
		        $affiliateUrl .= "?";
			} else {
			    $affiliateUrl .= "&";
			}
			$affiliateUrl .= $affiliateKey . "=" . $affiliateId;
		}
        $gotoUrl = "./goto.php?rid=" . $reviewId . "&url=" . urlencode($affiliateUrl);
		return $gotoUrl;
	}

	function generateUniqueId($tableName) {
		$query = "select max(id) id from " . $tableName;
		$numresults = mysql_query($query);
		//echo $numresults
		$numrows = mysql_num_rows($numresults);
		$result = mysql_query($query) or die("Couldn't execute query");
		$row = mysql_fetch_array($result);
		if($row == 0) {
			return false;
		} else {
			return $row['id'] + 1;
		}
	}

	function getCurrentDate() {
        return date('Y-m-d h:m:s');
	}

	function getUserIpAddress() {
	    $_SERVER['REMOTE_ADDR'];
	}

	function checkUserAgent($type = NULL) {
        $user_agent = strtolower ( $_SERVER['HTTP_USER_AGENT'] );
        if ( $type == 'bot' ) {
                // matches popular bots
                if ( preg_match ( "/googlebot|adsbot|yahooseeker|yahoobot|msnbot|watchmouse|pingdom\.com|feedfetcher-google/", $user_agent ) ) {
                        return true;
                        // watchmouse|pingdom\.com are "uptime services"
                }
        } else if ( $type == 'browser' ) {
                // matches core browser types
                if ( preg_match ( "/mozilla\/|opera\//", $user_agent ) ) {
                        return true;
                }
        } else if ( $type == 'mobile' ) {
                // matches popular mobile devices that have small screens and/or touch inputs
                // mobile devices have regional trends; some of these will have varying popularity in Europe, Asia, and America
                // detailed demographics are unknown, and South America, the Pacific Islands, and Africa trends might not be represented, here
                if ( preg_match ( "/phone|iphone|itouch|ipod|symbian|android|htc_|htc-|palmos|blackberry|opera mini|iemobile|windows ce|nokia|fennec|hiptop|kindle|mot |mot-|webos\/|samsung|sonyericsson|^sie-|nintendo/", $user_agent ) ) {
                        // these are the most common
                        return true;
                } else if ( preg_match ( "/mobile|pda;|avantgo|eudoraweb|minimo|netfront|brew|teleca|lg;|lge |wap;| wap /", $user_agent ) ) {
                        // these are less common, and might not be worth checking
                        return true;
                }
        }
        return false;
    }
	
?>