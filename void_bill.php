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
	
$bill_id = $_REQUEST['id'];
mysql_query("UPDATE customers_bill SET bill_void='1' where id='".$bill_id."'");

$query = mysql_query("SELECT * from bill_details where bill_no='".$bill_id."'");
while ($row = mysql_fetch_array($query)) {
	$total_quantity = 0;
	$data = mysql_fetch_object(mysql_query("SELECT * from product_stock where id='".$row['product_id']."'"));
	$total_quantity = $data->coil_stock + $row['quantity'];
	mysql_query("UPDATE product_stock SET coil_stock='".$total_quantity."' where id='".$row['product_id']."'");
}
mysql_query("INSERT INTO action_history SET user='".$_SESSION['SESS_FIRST_NAME']."', action='Voided Bill No: $bill_id'");
header('Location: all_bills.php');

?>