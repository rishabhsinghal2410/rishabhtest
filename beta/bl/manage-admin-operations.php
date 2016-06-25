<?
    require_once("./db.php");
	require_once("./util.php");
	extract($_POST);
    session_start();	
	if ($_GET['method'] == "ADDCAT") {
		addNewCategory();
		header("Location: ../add-category.php?msg=Added Successfully!");
	}

	function addNewCategory() {
	    $categoryNames = $_POST['category_name'];
		$parentCategory = $_POST['parent_category'];
		$categoryNameArr = explode(":", $categoryNames);
		$categoryId = generateUniqueId('ref_category');
		if ($parentCategory != 0) {
		    $query = "select count(*) from ref_category where id=" . $parentCategory;
			$result = mysql_query($query) or die(mysql_error());
		    $numRows=mysql_num_rows($result);
			foreach ($categoryNameArr as &$catName) {
		      if ($numRows > 0) {
			    $catQuery = "INSERT INTO ref_category (id, name, parent_id) values ($categoryId, '$catName', $parentCategory)";
				$result = mysql_query($catQuery) or die(mysql_error());
				$categoryId += 1;
			  }
			}
		} else {
		  foreach ($categoryNameArr as &$catName) {
		    $catQuery = "INSERT INTO ref_category (id, name) values ($categoryId, '$catName')";
			$result = mysql_query($catQuery) or die(mysql_error());
			$categoryId += 1;
		  }
		}
	}
?>