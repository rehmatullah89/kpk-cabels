<?php
require_once('auth.php');
//error_reporting(0);
if (isset($_SESSION['add_product_success'])) {
      echo "<script type='text/javascript'>alert('".$_SESSION['add_product_success']."')</script>";
    unset($_SESSION['add_product_success']); 
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
    $qry = "SELECT * FROM product_stock";
        $result = mysql_query($qry);
?>
<!DOCTYPE html>
<html lang="en">

<?php include("head.php"); ?>

<body>

    <div id="wrapper">

        <!-- Navigation -->
 
    <?php include("headers/header-products.php"); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Products List</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
           
            <!-- /.row -->
            <div class="row" style="margin-right:-200px;">
                <div class="col-lg-8">
                   <div class="row" style="margin-right:-200px;">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Edit / Delete / Modify Products
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Coil Stock</th>
                                            <th>Coil Price</th>
                                            <th>Web Price</th>
                                            <th>Gauge Size</th>
                                            <th>Croe</th>
                                            <th>Coil Weight</th>
                                            <th>Wire Type</th>                                            
                                            <th>Wire Color</th>                                            
                                            <th>Date Stock</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                      while ($row = mysql_fetch_array($result)) { ?>
                                       <tr class="odd gradeX">
                                            <td><?php echo $row['product_name']; ?></td>
                                            <td><?php echo $row['coil_stock']; ?></td>
                                            <td><?php echo $row['coil_price']; ?></td>
                                            <td><?php echo $row['web_coil_price']; ?></td>
                                            <td><?php echo $row['gauge_size']; ?></td>
                                            <td><?php echo $row['number_cores']; ?></td>
                                            <td><?php echo $row['coil_weight']; ?></td>
                                            <td><?php echo ($row['wire_twist_type'] == 0 ? "Non-Twisted" : 'Twisted'); ?> /<?php echo ($row['wire_type'] == 0 ? "Aluminium" : 'Copper'); ?></td>
                                            <td><?php echo $row['wire_color']; ?></td>
                                            <td><?php echo date('Y/m/d',strtotime($row['date_added'])); ?></td>
                                            
                                            <td class="center">
                                            <div calss="btn-group btn-group-sm">
                                             <a href="update_product.php?id=<?php  echo $row['id'];?>" class="btn btn-outline btn-primary btn-xs">Edit</a>
                                             <?php if ($_SESSION['SESS_USER_ROLE'] == 'super_admin') { ?>
                                             <a href="delete_product.php?id=<?php  echo $row['id'];?>" class="btn btn-outline btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                                            <?php } ?>
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
