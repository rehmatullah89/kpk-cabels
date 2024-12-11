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

    $dealer_id = $_REQUEST['id'];
    if(isset($_POST['submit'])){
       mysql_query("DELETE from other_dealers_products where dealer_id='".$_REQUEST['id']."'");
        $other_products_arr = array();
        foreach ($_POST as $key => $value) {
            if (strpos($key,'prodname') !== false){
                $id = explode('_', $key);
                $other_products_arr[] = array('op_name' =>$_POST['prodname_'.$id[1]] ,'op_price' =>$_POST['prodprice_'.$id[1]] ,'op_details' =>$_POST['proddetails_'.$id[1]]); 
            }
        }
        if (!empty($other_products_arr)) {
            $ijk = 1;
            foreach ($other_products_arr as $key => $data) {
                $qry1 = "INSERT INTO other_dealers_products SET prod_name='".$data['op_name']."', prod_price='".$data['op_price']."', prod_details='".$data['op_details']."', dealer_id='$dealer_id'";
                mysql_query($qry1);
            }
        }
        //header("location: other_delnsupliers.php");
    }

    $qry = "SELECT * FROM other_dealers_products where dealer_id='".$_REQUEST['id']."'";
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
                    <h1 class="page-header">View/ Add Products for dealer: (<i style="color:red;"><?php  echo @mysql_result(mysql_query("Select dealer_name from dealers_suppliers where id='".$_REQUEST['id']."'"),0,0); ?></i>)</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
           
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
                   <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            view /edit / add products for this dealer!
                        </div>
                        <!-- /.panel-heading -->
                        <form action="" method="post">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Product Price</th>
                                            <th>Product Details</th>
                                            <th>Date Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i=0;
                                      while ($row = mysql_fetch_array($result)) { ?>
                                       <tr class="odd gradeX">
                                            <td><input class="form-control" placeholder="Enter Product Name"  name="prodname_<?php echo $i;?>" value="<?php echo $row['prod_name']; ?>" required></td>
                                            <td><input class="form-control" placeholder="Enter Product Price"  name="prodprice_<?php echo $i;?>" value="<?php echo $row['prod_price']; ?>" required></td>
                                            <td><input class="form-control" placeholder="Enter Product Details"  name="proddetails_<?php echo $i;?>" value="<?php echo $row['prod_details']; ?>" required></td>
                                            <td><?php echo date('Y/m/d',strtotime($row['date_added'])); ?></td>
                                        </tr>                                             
                                        <?php  $i++;                                    
                                      }  
                                    ?>
                                        
                                         
                                    </tbody>
                                </table>
                                <button type="button" id="add_new_line" class="btn btn-success">Add New Line</button><button type="button" id="remove_line" class="btn btn-danger">Remove Line</button>
                            <div align="right">
                            <button formaction="other_delnsupliers.php">Back</button>    
                            <input type="submit" name="submit"  value="Submit Products Sheet" /></div>
                            </div>
                            <!-- /.table-responsive -->
                        
                        </div>
                        </form>
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

    <!-- Morris Charts JavaScript -->
    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>
    <script type="text/javascript">
         var count='<?php echo $i; ?>';
         i=0;
        $(document).ready(function(){
            $("#add_new_line").on('click', function (){
                i = i + parseInt(count) + parseInt("1");
                $('#dataTables-example > tbody:last').append('<tr><td><input type="text" name="prodname_'+i+'" id="prodname_'+i+'" class="form-control" required></td><td><input type="number" name="prodprice_'+i+'" id="prodprice_'+i+'" class="form-control" required></td><td><input type="text" name="proddetails_'+i+'" id="proddetails_'+i+'" class="form-control" required></td><td></td></tr>');
            });
            
            $('#remove_line').on('click',function() {
                           if (i>1){
                            $('#dataTables-example tr:last').remove();
                            i=i-1;
                        }
            });  
        });
    </script>
</body>

</html>
