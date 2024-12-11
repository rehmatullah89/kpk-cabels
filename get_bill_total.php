<?php
error_reporting(0);
	session_start();
	if (!isset($_SESSION['count'])) {
		$_SESSION['count'] =1;
		$_SESSION['products'][$_SESSION['count']] = array();
	}
	else
		$_SESSION['count']++;
	
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
			$toatl_amount = 0;
			$total_estimated_amount = 0;
			$id = $_REQUEST['id'];//product id
			$quantity = $_REQUEST['value'];//product quantity
			$customer_name = $_REQUEST['cname'];//customer name
			$customer_phone = $_REQUEST['cphone'];//customer phone number
			
			$q2="SELECT * FROM product_stock where id='$id' AND coil_stock>0";
			$res=mysql_query($q2);
			$num_rows = mysql_num_rows($res);
			$obj = mysql_fetch_object($res);
			if ($quantity > $obj->coil_stock) {
			 	echo '<script type="text/javascript"> alert("Ther are only '.$obj->coil_stock.' number of products available for '.$obj->product_name.'."); </script>';
					exit();
			} 
			

if ($_SESSION['count'] == 1) {
	$product_array = array('id' => $id,'value' => $quantity);
	$_SESSION['products'][$_SESSION['count']]=$product_array;
}
else{
	$found =0;
	if (!empty($_SESSION['products'])) {
		foreach ($_SESSION['products'] as $key => $value) {
			if ($value['id'] == $id) {
				$found =1;
				$_SESSION['products'][$key]['value']=$quantity;
			}
		}
	}

	if ($found == 0) {
		$product_array = array('id' => $id,'value' => $quantity);
		$_SESSION['products'][$_SESSION['count']]=$product_array;
	}
}
		/*-----calculate total bill amount-----*/
		$qry2 = "SELECT * FROM unit_rates";
 	    $result2 = mysql_query($qry2);
        $obj2 = mysql_fetch_object($result2);
		
		foreach ($_SESSION['products'] as $key => $value) {
				 $q2="SELECT * FROM product_stock where id='".$value['id']."' AND coil_stock>0";
				 $res=mysql_query($q2);
				 $obj = @mysql_fetch_object($res);
				 $toatl_amount = $toatl_amount + ($value['value']*$obj->coil_price);

				if ($obj->wire_type == 0) {
		            $aluminium_wt = (($obj->gauge_size*33*33)/260000)*$obj->number_cores;
		            $alum_price = $aluminium_wt* $obj2->aluminium_rate;
		            if ($obj->number_cores >1) {
		                $pvc_weight = $obj->coil_weight - $aluminium_wt; 
		                $pvc_price = $pvc_weight* (($obj2->pvc_rate + $obj2->pvc_lead_rate)/2); 
		            }
		            else{    
		                $pvc_weight = $obj->coil_weight - $aluminium_wt; 
		                $pvc_price = $pvc_weight* $obj->pvc_rate; 
		            }
		            $total_estimated_price = ($alum_price + $pvc_price + $obj2->labor_rate)*$value['value']; 
		            $total_estimated_amount += $total_estimated_price;
		       }
		       else{
		            $aluminium_wt = (($obj->gauge_size*33*33)/80000)*$obj->number_cores;
		            $alum_price = $aluminium_wt* $obj2->copper_rate;
		            if ($obj->number_cores >1) {
		                $pvc_weight = $obj->coil_weight - $aluminium_wt; 
		                $pvc_price = $pvc_weight* (($obj2->pvc_rate + $obj2->pvc_lead_rate)/2); 
		            }
		            else{    
		                $pvc_weight = $obj->coil_weight - $aluminium_wt; 
		                $pvc_price = $pvc_weight* $obj->pvc_rate; 
		            }
		            $total_estimated_price = ($alum_price + $pvc_price + $obj2->labor_rate)*$value['value']; 
		            $total_estimated_amount += $total_estimated_price;
		       }

		}
		//echo $customer_name."&".$customer_phone."&total=".$toatl_amount."<br/>";		
		$total_vals = array('total_bill_amount' => $toatl_amount, 'total_estimated_amount' => $total_estimated_amount );
		//echo $total_vals;
		echo json_encode( $total_vals );
		/*----end caluculate total bill ------*/
?>        			
											
