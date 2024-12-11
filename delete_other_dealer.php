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
mysql_query("DELETE from dealers_suppliers where id='".$_REQUEST['id']."'");
mysql_query("DELETE from other_dealers_products where dealer_id='".$_REQUEST['id']."'");
header('Location: other_delnsupliers.php');

?>