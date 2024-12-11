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
    $bid = $_REQUEST['id'];
    $obj = mysql_fetch_object(mysql_query("SELECT * FROM customers_bill where id='$bid'"));
    $result2 = mysql_query("SELECT * FROM bill_details where bill_no='$bid'");
    $result3 = mysql_query("SELECT * FROM other_dealers_products where bill_no='$bid'");

    if (isset($_POST['submit'])) {
        if (!empty($_POST['cash_amount'])){
            $p_amount = $obj->amount_paid + $_POST['cash_amount'];

            if ($p_amount >= $obj->total_bill_amount) {
                $q1="Update customers_bill SET amount_paid='".$p_amount."',bill_status='1' where id='$bid'";
            }
            else
    			$q1="Update customers_bill SET amount_paid='".$p_amount."' where id='$bid'";
			$result1 = mysql_query($q1);
		
			$q2="INSERT into payment_history SET bill_id='".$bid."',amount_paid='".$_POST['cash_amount']."'";
			mysql_query($q2);
            mysql_query("INSERT INTO action_history SET user='".$_SESSION['SESS_FIRST_NAME']."', action='Paid Bill No: $bid'");
		}

        if (!empty($_POST['check_amount']) && !empty($_POST['check_number']) && !empty($_POST['bank_name']) && !empty($_POST['check_date'])){
            $c_amount = $obj->amount_paid + $_POST['check_amount'];
			
            if ($c_amount >= $obj->total_bill_amount) {
                $q1="Update customers_bill SET amount_paid='".$c_amount."',payment_method='".$_POST['check_number']."',bill_status='1' where id='$bid'";
            }
            else
                $q1="Update customers_bill SET amount_paid='".$c_amount."',payment_method='".$_POST['check_number']."' where id='$bid'";
  			$result1 = mysql_query($q1);
			 
			$q2="INSERT into payment_history SET bill_id='".$bid."',amount_paid='".$_POST['check_amount']."',bank_name='".$_POST['bank_name']."',check_date='".$_POST['check_date']."',checkno='".$_POST['check_number']."'";
			mysql_query($q2);
            mysql_query("INSERT INTO action_history SET user='".$_SESSION['SESS_FIRST_NAME']."', action='Paid Bill No: $bid'");
		}
        
        if($result1){
             echo "<script type='text/javascript'>alert('Bill Paid Successfully!')</script>";
             header("location: all_bills.php");
         }else
            echo "<script type='text/javascript'>alert('You have an Error please try again!')</script>";
    }

?>
<!DOCTYPE html>
<html lang="en">
<style type="text/css">
  @page 
  {
    size: auto;   /* auto is the current printer page size */
    margin-top: 25mm;  /* this affects the margin in the printer settings */
    margin-bottom: 25mm;  /* this affects the margin in the printer settings */
  }

  body 
  {
     background-color:#FFFFFF; 
     margin: 0px;  /* the margin on the content before printing */
  }
 
</style>

<?php include("head.php"); ?>

<body>

    <div id="wrapper">

        <!-- Navigation -->
 
    <?php include("headers/header-payprint.php"); ?>
    <div class="inside bot-indent" id="printableArea">
        <div id="page-wrapper">
            <br/>
            <div class="row">
                <div class="col-lg-12">
                    <h5 ><b>Bill No#:</b><i><?php echo $bid; ?></i></h5>
                    <h5 ><b>Customer Name:</b><i><?php echo ucfirst($obj->customer_name); ?></i></h5>
                    <h5 ><b>Customer Phone:</b><i><?php echo $obj->customer_phone; ?></i></h5>
                    <h5 ><b>Customer Address:</b><i><?php echo $obj->customer_address; ?></i></h5>
                    <h5 ><b>Customer City:</b><i><?php echo $obj->customer_city; ?></i></h5>
                </div>

                <!-- /.col-lg-12 -->
            </div><br/>
            <!-- /.row -->
           
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
                   <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                         <div style="display:inline; font-weight:bold;"> Current Date:<?php echo date('Y-m-d');?></div><div style="padding-left: 250px; font-weight: bold; display:inline; ">Bill Date:&nbsp <?php echo date('Y-m-d',strtotime($obj->bill_date));?></div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Quantity</th>
                                            <th>Prodduct Name</th>
                                            <th>Unit Price</th>
                                            <th>Product(s) Amount</th>
                                         </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $net_amt=0;
                                      while ($row = mysql_fetch_array($result2)) { ?>
                                       <tr class="odd gradeX">
                                            <td><?php echo $row['quantity']; ?></td>
                                            <td><?php echo $row['product_name']; ?></td>
                                            <td><?php echo $row['product_unit_price']; ?></td>
                                            <td><?php echo ($row['quantity'])*($row['product_unit_price']); ?></td>
                                        <?php $net_amt += (($row['quantity'])*($row['product_unit_price'])); ?>
                                        </tr>                                            
<?php                                       }  
                                        while ($row1 = mysql_fetch_array($result3)) { ?>
                                       <tr class="odd gradeX">
                                            <td><?php echo $row1['prod_quantity']; ?></td>
                                            <td><?php echo $row1['prod_name']; ?></td>
                                            <td><?php echo round($row1['prod_price']/$row1['prod_quantity']); ?></td>
                                            <td><?php echo $row1['prod_price']; ?></td>
                                        <?php $net_amt += $row1['prod_price']; ?>
                                        </tr>                                            
<?php                                       }  
                                    ?>
         <tr><td><b>Bill Paid:</b></td><td><b style="color:red;"><?php echo $obj->amount_paid; ?></b></td><td><b>Total Bill:</b></td><td><b><?php echo $net_amt; ?></b></td></tr> 
                                    </tbody>
                                </table>
                                <?php
                                if ($obj->amount_paid > 0 && !empty($obj->amount_paid)) {?>
                                <br/><h3 style="color:red"> Payment History </h3>
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Index</th>
                                                <th>Amount Paid</th>
                                                <th>Payment Details</th>
                                                <th>Payment Date</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                            $pay_hist = mysql_query("SELECT * from payment_history where bill_id='".$bid."'");
                                            $i=1;
                                            while ($row = mysql_fetch_array($pay_hist)) { ?>
                                                <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $row['amount_paid']; ?></td>
                                                <td><?php 
                                                    if (!empty($row['checkno'])) {
                                                        echo "<span style='color:green;'>Check No:</span><i style='color:blue;'>".$row['checkno']."</i><br/>"."<span style='color:green;'>Bank Name:</span><i style='color:blue;'>".$row['bank_name']."</i><br/>"."<span style='color:green;'>Check Date:</span><i style='color:blue;'>".$row['check_date']."</i>";
                                                    }
                                                    else
                                                        echo "<i style='color:red;'>Paid via Cash</i>";
                                                ?></td>
                                                <td><?php echo $row['paid_date']; ?></td>
                                             </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                               <?php }?>
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
                <input type="button" id="print_button" onclick="printDiv('printableArea')" value="print Bill!" />   
                </div>
                </div>
                <br/>
                <?php 
                    if ($obj->amount_paid < $net_amt) {
                 ?>
                <form action="" method="post" id="pay_box_hide">
                <table style="width:800px; padding:10px; border:1px solid;" class="table">
                <tr><td border="1"><h4 style="display: inline-block; color:red;">Balance Amount : <?php echo $net_amt-$obj->amount_paid; ?><h4/></td><td>
                <input type="radio" name="group1" id="cash_id" value="0" checked> Pay Via Cash<br>
                <input type="radio" name="group1" id="check_id" value="1">Pay Via Check 
                </td><td><div id="pay_cash">Pay Cash:<input type="number" name="cash_amount" id="cash_amount"  min="1"/></div><div id="pay_check"> Check Amount:<input type="text" name="check_amount" id="check_amount" /><br/>&nbsp;Bank Name:&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="bank_name" id="bank_name" /><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Check#:&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="check_number" id="check_number" /><br/>&nbsp;Check Date:&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="check_date" id="check_date" /></div></td><td><input type="submit" name="submit" value="Pay Bill" onclick="return confirm('Are you sure you want to pay this bill?');" /></td></tr>
                </table>
                </form>
                <?php    
                    }
                ?> 
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
<script>
$('div#pay_check').hide();
    $("input:radio[name='group1']").click(function() {      
    
    if ($("input:radio[name='group1']:checked").val() == 0){
        $('div#pay_cash').show();
        $('div#pay_check').hide();
    }
    if ($("input:radio[name='group1']:checked").val() == 1){
        $('div#pay_check').show();
        $('div#pay_cash').hide();
    }

});
    
    function printDiv(divName) {
         document.getElementById('print_button').style.display = 'none';    
         document.getElementById('pay_box_hide').style.display = 'none';    
         var printContents = document.getElementById(divName).innerHTML;
         var originalContents = document.body.innerHTML;

         document.body.innerHTML = printContents;

         window.print();

         document.body.innerHTML = originalContents;
    }
</script>
</body>

</html>
