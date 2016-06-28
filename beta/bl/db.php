<?
	/* Important COnfigurations to be made for database to function properly */
	$cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
	$cleardb_server = $cleardb_url["host"];
	$cleardb_username = $cleardb_url["user"];
	$cleardb_password = $cleardb_url["pass"];
	$cleardb_db = substr($cleardb_url["path"],1);
	$databasehost = $cleardb_server; //Host of the mySQL database 
	$databaseuser = $cleardb_username;      //User name of the mySQL database. Its "root" by default 
	$databasepassword = $cleardb_password;      //Password for the mySQL databse access to the databaseuser  
	$databasename = $cleardb_db; //Specify the database to use 
	function begin() {
		@mysql_query("BEGIN");
	}
	function commit() {
		@mysql_query("COMMIT");
	}
	function rollback() {
		@mysql_query("ROLLBACK");
	}
	$connection = mysql_connect("$databasehost","$databaseuser","$databasepassword");
	$db = mysql_select_db("$databasename", $connection);
?>