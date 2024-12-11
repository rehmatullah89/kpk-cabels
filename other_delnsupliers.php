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
    $qry = "SELECT * FROM dealers_suppliers";
        $result = mysql_query($qry);
?>
<!DOCTYPE html>
<html lang="en">

<?php include("head.php"); ?>

<body>

    <div id="wrapper">

        <!-- Navigation -->
 
    <?php include("headers/header-other_dealers.php"); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Other Dealers/ Suppliers / Manufacturers List</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
           
            <!-- /.row -->
            <div class="row" style="margin-right:-250px;">
                <div class="col-lg-8">
                   <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b style="color:red">Click to: </b> <a href="add_new_dealer.php"><i>Add Dealer / Supplier / Manufacturer </i></a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Dealer Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Website</th>
                                            <th>Company</th>
                                            <th>Other Information</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                      while ($row = mysql_fetch_array($result)) { ?>
                                       <tr class="odd gradeX">
                                            <td><?php echo $row['dealer_name']; ?></td>
                                            <td><?php echo $row['phone']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td><?php echo $row['website']; ?></td>
                                            <td><?php echo $row['company']; ?></td>
                                            <td><?php echo $row['other_info']; ?></td>
                                            <td class="center">
                                            <div calss="btn-group btn-group-sm">
                                             <a href="edit_other_dealer_products.php?id=<?php  echo $row['id'];?>" class="btn btn-outline btn-primary btn-xs">View/ Modify products List</a>
                                             <?php if ($_SESSION['SESS_USER_ROLE'] == 'super_admin') { ?>
                                             <a href="delete_other_dealer.php?id=<?php  echo $row['id'];?>" class="btn btn-outline btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this Supplier and his products?');">Delete Dealer & Products</a>
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
