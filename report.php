<?php
require_once('auth.php');
//error_reporting(0);
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="./bootstrap/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<style>
.form-horizontal .controls {
margin-left:10px !important;
}

form {
margin: 0 0 -10px !important;
}
.input-group {
position: relative !important;
display: table !important;
border-collapse: separate !important;
}
</style>
</head>
<?php include("head.php"); ?>

<body>

    <div id="wrapper">

        <!-- Navigation -->
 
    <?php include("headers/header-report.php"); ?>
    <div class="inside bot-indent" id="printableArea">
        <div id="page-wrapper">
            <!-- /.row -->
           
            <!-- /.row -->
            <div class="row" style="margin-right:-250px;">
                <div class="col-lg-8">
                   <div class="row">
                <div class="col-lg-12"><br/>
				<h4>Generate Report (Search By: Name / City / Date Duration) </h4><br/><br/>
                    <div class="panel panel-default">
                        <div class="panel-heading">
<form action="" class="form-horizontal" method="post">    
	<div style="display:inline; font-weight:bold; margin-left: 95px;"> 
    Customer name: <input type="text" name="customer_name" style="height:26px; margin-bottom:10px; display:inline;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    Customer City: <input type="text" name="customer_city" style="height:26px; margin-bottom:10px; display:inline;">
    </div>
							
    
        <fieldset>
            <div class="control-group">
                <div class="controls input-append date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-format="yyyy-mm-dd">
                    <label class="control-label">Start Date:&nbsp;</label>
                    <input size="16" type="text" style="height:30px; display:inline;" name="date1" value="" readonly>
                    <span class="add-on" style="height:30px;"><i class="icon-remove"></i></span>
            		<span class="add-on" style="height:30px;"><i class="icon-th"></i></span>
                </div>
                <div class="controls input-append date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-format="yyyy-mm-dd">
                    <label class="control-label">End Date:&nbsp;</label>
                    <input size="16" type="text" style="height:30px; display:inline;" name="date2" value="" readonly>
                    <span class="add-on" style="height:30px;"><i class="icon-remove"></i></span>
                    <span class="add-on" style="height:30px;"><i class="icon-th"></i></span>
                </div>
            </div>
		 </fieldset>
  


                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Index</th>
                                            <th>Bill No#</th>
											<th>Bill Date</th>											
                                            <th>Customer Name</th>
											<th>Customer Phone</th>
                                            <th>Total Bill</th>
                                            <th>Amount Paid</th>
                                            <th>Balance</th>
                                         </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i=1;
									 if (isset($_POST['submit'])) {
										
										$qry="";
                                        $customer_name = $_POST['customer_name'];
									 	$customer_city = $_POST['customer_city'];
										$date_from = $_POST['date1'];
										$date_till = $_POST['date2'];
										if(!empty($customer_name) && empty($date_from) && empty($date_till) && empty($customer_city))
										$qry = "SELECT * FROM customers_bill where customer_name LIKE '%".$customer_name."%' ORDER by bill_date DESC";
										else if(empty($customer_name) && empty($date_from) && empty($date_till) && !empty($customer_city))
                                        $qry = "SELECT * FROM customers_bill where customer_city LIKE '%".$customer_city."%' ORDER by bill_date DESC";
                                        else if(!empty($customer_name) && !empty($date_from) && !empty($date_till))
										$qry = "SELECT * FROM customers_bill where customer_name LIKE '%".$customer_name."%' and ( DATE_FORMAT(bill_date,'%Y-%m-%d') BETWEEN '$date_from' and '$date_till') ORDER by bill_date DESC";
										else if(empty($customer_city) && empty($customer_name) && !empty($date_from) && !empty($date_till))
										$qry = "SELECT * FROM customers_bill where ( DATE_FORMAT(bill_date,'%Y-%m-%d') BETWEEN '$date_from' and '$date_till') ORDER by bill_date DESC";
										else
											echo '<script type="text/javascript"> alert("Please fill correct informatin to get report!"); </script>';
										
										$result2 = mysql_query($qry);
										if($result2)
										while ($row = mysql_fetch_array($result2)) { ?>
                                       <tr class="odd gradeX" nowrap>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $row['id']; ?></td>
											<td><?php echo date('Y-m-d',strtotime($row['bill_date'])); ?></td>
											<td><?php echo $row['customer_name']; ?></td>
                                            <td><?php echo $row['customer_phone']; ?></td>
                                            <td><?php echo $row['total_bill_amount']; ?></td>
											<td><?php echo $row['amount_paid']; ?></td>
											<td><?php echo ($row['total_bill_amount']-$row['amount_paid']); ?></td>
                                            
                                        </tr>                                            
<?php                                   }
									}  
                                    ?>
                       
                                    </tbody>
                                </table>
								<input type="submit" name="submit" value="Get Report" />  </form>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
                    <!-- /.panel -->
                    <div class="panel panel-default">
                      
                      
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    <!-- /.panel -->
                </div>

                <!-- /.col-lg-8 -->
                <div class="col-lg-4">
                   
                    <!-- /.panel -->
                </div>

                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>


    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>
	<script type="text/javascript" src="./jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="./bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="./bootstrap/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="./bootstrap/js/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
<script type="text/javascript">
    $('.form_date').datetimepicker({
        language:  'en',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
	
</script>
</body>

</html>
