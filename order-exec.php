<?php
/*echo "<pre>";
print_r($_POST);
die();*/
//error_reporting(0);
require_once('auth.php');
if (isset($_SESSION['count']) || isset($_SESSION['products'])) {
    unset($_SESSION['count']);
    unset($_SESSION['products']);
}  
require_once('config.php');
    //Connect to mysql server
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
    if(!$link) {
        die('Failed to connect to server: ' . mysql_error());
    }
    
    //Select database
    $db = mysql_select_db(DB_DATABASE);
    if(!$db) {
        die("Unable to select database");
    }
    
     //Function to sanitize values received from the form. Prevents SQL injection
    function clean($str) {
        $str = @trim($str);
        if(get_magic_quotes_gpc()) {
            $str = stripslashes($str);
        }
        return mysql_real_escape_string($str);
    }
    ////////////////////////////////////////////
    $c_name = clean($_POST['customer_name']);
    $c_phone = clean($_POST['customer_phone']);
    $c_address = clean($_POST['customer_address']);
    $c_city = clean($_POST['customer_city']);
    $total_bill = clean($_POST['total_bill']);
    $product_quantity_arr = array();
    $product_name_arr = array();
    $product_price_arr = array();
    $product_stock_arr = array();
    
    //other products of dealers
    $other_products_arr = array();
    $ot_total = 0;
   
    foreach ($_POST as $key => $value) {
     if (strpos($key,'quantity') !== false){
        if (!empty($value)) {
          $id = explode('_', $key);
          $product_quantity_arr[$id[1]] = $value;
          $product_name_arr[$id[1]] = $_POST['product_'.$id[1]];
          $product_price_arr[$id[1]] = $_POST['price_'.$id[1]];
          $product_stock_arr[$id[1]] = $_POST['stock_'.$id[1]];
        }
      }
      if (strpos($key,'opqntity') !== false){
        if (!empty($value)) {
          $oid = explode('_', $key);
          $other_products_arr[] = array('op_name' =>$_POST['opname_'.$oid[1]] ,'op_price' =>$_POST['opprice_'.$oid[1]] ,'op_quantity' =>$_POST['opqntity_'.$oid[1]] ,'op_dealer' =>$_POST['opdealer_'.$oid[1]] ,'op_details' =>$_POST['opdetails_'.$oid[1]] ); 
          $ot_total+=$_POST['opprice_'.$oid[1]];
        }
      }
    }

$bill_id="";
if (!empty($product_quantity_arr)) {
   $grand_total = $total_bill + $ot_total;
   $q1="Insert INTO customers_bill SET customer_name='$c_name',customer_phone='$c_phone',customer_address='$c_address',customer_city='$c_city',total_bill_amount='$grand_total'";
   mysql_query($q1);
   $bill_id = mysql_insert_id();
   if (!empty($bill_id)) {
        mysql_query("INSERT INTO action_history SET user='".$_SESSION['SESS_FIRST_NAME']."', action='Created Bill No: $bill_id'");
    }

   foreach ($product_name_arr as $key => $value) {
       $p_quant = $product_quantity_arr[$key];
       $p_price = $product_price_arr[$key];
	   $p_stock = $product_stock_arr[$key];
       $remain_stock = $p_stock - $p_quant;

	   $q2="Insert INTO bill_details SET product_id='$key',	product_name='$value',product_unit_price='$p_price',quantity='$p_quant',bill_no='$bill_id'";
   	   mysql_query($q2);

       // update inventory
       $q3="Update product_stock SET coil_stock='$remain_stock' where id='$key'";
       mysql_query($q3);   	
   }
}   
if (!empty($other_products_arr)) {
    if (empty($bill_id)) {
      $grand_total = $total_bill + $ot_total;
      mysql_query("INSERT INTO customers_bill SET customer_name='$c_name',customer_phone='$c_phone',customer_address='$c_address',customer_city='$c_city',total_bill_amount='$grand_total'");
      $bill_id = mysql_insert_id();
      if (!empty($bill_id)) {
        mysql_query("INSERT INTO action_history SET user='".$_SESSION['SESS_FIRST_NAME']."', action='Created Bill No: $bill_id'");
      }
    }

    foreach ($other_products_arr as $key => $data) {
       mysql_query("INSERT INTO other_dealers_products SET prod_name='".$data['op_name']."',prod_price='".$data['op_price']."',prod_quantity='".$data['op_quantity']."',prod_dealer='".$data['op_dealer']."',prod_details='".$data['op_details']."',bill_no='$bill_id'"); 
    }
}

   $_SESSION['add_bill_success'] = "Bill has been created successfully!";
   header("location: all_bills.php");
    

?>