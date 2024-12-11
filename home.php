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
    $qry = "SELECT * FROM product_stock ORDER BY date_added DESC Limit 10";
        $result = mysql_query($qry);

    $qry1 = "SELECT product_name,coil_stock FROM product_stock where coil_stock<'10'";
        $result1 = mysql_query($qry1);

    $qry2 = "SELECT * FROM messages";
    $result2 = mysql_query($qry2);
    $num_rows = mysql_num_rows($result2);

    $qry3 = "SELECT * FROM customers_bill";
    $result3 = mysql_query($qry3);
    $bill_cunt = mysql_num_rows($result3);

    $qry4 = "SELECT * FROM product_stock";
    $result4 = mysql_query($qry4);
    $product_count = mysql_num_rows($result4);

?>
<!DOCTYPE html>
<html lang="en">
<?php include("head.php"); ?>

<body>

    <div id="wrapper">

        <!-- Navigation -->
 
    <?php include("headers/header-home.php"); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">KPK Sale/ Inventory/ Products Details</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $num_rows;?></div>
                                    <div>All Messages!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left"><a href="messages.php">View all Messages!</a></span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo  $bill_cunt; ?></div>
                                    <div>All Bills!</div>
                                </div>
                            </div>
                        </div>
                        <a href="all_bills.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $product_count; ?></div>
                                    <div>All Products!</div>
                                </div>
                            </div>
                        </div>
                        <a href="products.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-support fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"></div>
                                    <div><b>Generate Report!</b></div>
                                </div>
                            </div>
                        </div>
                        <a href="report.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
                   <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>Stock Available</h4>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                  <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Coil Stock</th>
                                            <th>Coil Price</th>
                                            <th>Gauge Size</th>
                                            <th>Croe</th>
                                            <th>Coil Weight</th>
                                            <th>Wire Type</th>                                            
                                            <th>Date Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                      while ($row = mysql_fetch_array($result)) { ?>
                                       <tr class="odd gradeX">
                                            <td><?php echo $row['product_name']; ?></td>
                                            <td><?php echo $row['coil_stock']; ?></td>
                                            <td><?php echo $row['coil_price']; ?></td>
                                            <td><?php echo $row['gauge_size']; ?></td>
                                            <td><?php echo $row['number_cores']; ?></td>
                                            <td><?php echo $row['coil_weight']; ?></td>
                                            <td><?php echo ($row['wire_type'] == 0 ? "Aluminium" : 'Copper'); ?></td>
                                            <td><?php echo date('Y/m/d',strtotime($row['date_added'])); ?></td>
                                           
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
                     <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>This Month Sale Report</h4>
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
                                        $qry="";
                                        $date_from = date('Y-m-01');
                                        $date_till = date('Y-m-d');
                                        $qry12 = "SELECT * FROM customers_bill where ( DATE_FORMAT(bill_date,'%Y-%m-%d') BETWEEN '$date_from' and '$date_till') ORDER by bill_date DESC Limit 100";
                                        $result12 = mysql_query($qry12);
                                        if($result12)
                                        while ($row = mysql_fetch_array($result12)) { ?>
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
                                   ?>
                       
                                    </tbody>
                                </table>   
                        
                            </div>
                            <!-- /.table-responsive -->
                        
                        </div>
                        <!-- /.panel-body -->
                    </div>    
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
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Items Less in Stock
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                               
                                <?php 
                                    while ($row1 = mysql_fetch_array($result1)) {
                                        $product_name = $row1['product_name'];
                                        $coil_stock = $row1['coil_stock'];
                                        echo "<a href='#' class='list-group-item'>
                                    <i class='fa fa-warning fa-fw'></i>$product_name
                                    <span class='pull-right text-muted small'><em># of: $coil_stock</em>
                                    </span>
                                </a>";
                                    }

                                ?>    
                                
                            

                            </div>
                           </div>
                        <!-- /.panel-body -->
                    </div>
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
       $( document ).ready(function() { 
            $('div.sidebar li a').click(function() {
                /*   var d = document.getElementById("dashboard");
                  d.className += 'active';*/
                  document.getElementById("dashboard").className = "active";
                   $(this).preventDefault();
                  //alert(document.getElementById("dashboard").className);
            });
        });
    </script>
</body>

</html>
