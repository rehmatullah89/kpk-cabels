<?php
require_once('auth.php');
//error_reporting(0);
if (isset($_SESSION['add_bill_success'])) {
      echo "<script type='text/javascript'>alert('".$_SESSION['add_bill_success']."')</script>";
    unset($_SESSION['add_bill_success']); 
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

    $qry = "SELECT * FROM customers_bill where bill_void=1";
        $result = mysql_query($qry);
?>
<!DOCTYPE html>
<html lang="en">

<?php include("head.php"); ?>

<body>

    <div id="wrapper">

        <!-- Navigation -->
 
    <?php include("headers/header-voidbills.php"); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">All Bills</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
           
            <!-- /.row -->
            <div class="row" style="margin-right:-200px;">
                <div class="col-lg-8">
                   <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           View / Pay / Print Bills
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Bill No.</th>
                                            <th>Bill Date</th>
                                            <th>Customer Name</th>
                                            <th>Phone</th>
                                            <th>Total Bill</th>
                                            <th>Amount Paid</th>
                                            <th>Balance</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                         </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i=1;
                                      while ($row = mysql_fetch_array($result)) { ?>
                                       <tr class="odd gradeX">
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo date('d/m/Y',strtotime($row['bill_date'])); ?></td>
                                            <td><?php echo $row['customer_name']; ?></td>
                                            <td><?php echo $row['customer_phone']; ?></td>
                                            <td style="color:blue;"><?php echo $row['total_bill_amount']; ?></td>
                                            <td style="color:green;"><?php echo $row['amount_paid']; ?></td>
                                            <td style="color:red;"><b><?php echo $row['total_bill_amount']-$row['amount_paid']; ?><b/></td>
                                            <td><?php echo ($row['bill_status'] == '0' ? 'Pending' : 'Paid'); ?></td>
                                            <td class="center">
                                            <div calss="btn-group btn-group-sm">
                                             <a href="print_void_bill.php?id=<?php  echo $row['id'];?>" class="btn btn-success btn-xs">Detail / Print </a>
                                            </div> 
                                            </td>
                                        </tr>                                             
<?php                                       }  
                                    ?>
                                        
                                         
                                    </tbody>
                                </table>
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
</body>

</html>
