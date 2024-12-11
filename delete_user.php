<?php
require_once('config.php');
	//Connect to mysql server
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	if(!$link) {
		die('Failed to connect to server: ' . mysql_error());
	}
	
	//Select database
	$db = mysql_select_db(DB_DATABASE);
	if(!$db) {
		die('Unable to select database');
	}
	
$id = $_REQUEST['id'];
$query = "DELETE FROM members WHERE member_email_id='$id' AND member_email_id!='rehmat@google.com'";
mysql_query($query);
header('Location: users.php');

?>