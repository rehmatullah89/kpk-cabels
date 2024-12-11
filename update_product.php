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
        die('Unable to select database');
    }
    
    $id = $_REQUEST['id'];
    $qry = "SELECT * FROM product_stock where id='".$id."'  limit 1";
    $result = mysql_query($qry);
    $obj = mysql_fetch_object($result); 

    if(isset($_POST['submit'])){
        $product_name = $_POST['product_name'];
        $coil_stock = $_POST['coil_stock'];
        $coil_price = $_POST['coil_price'];
        $web_coil_price = $_POST['web_coil_price'];
        $gauge_size = $_POST['gauge_size'];
        $number_cores = $_POST['number_cores'];
        $coil_weight = $_POST['coil_weight'];
        $wire_type = $_POST['wire_type'];
        $wire_twist_type = $_POST['wire_twist_type'];
        $wire_color = $_POST['wire_color'];
        $q1="Update product_stock SET product_name='$product_name',coil_stock='$coil_stock',coil_weight='$coil_weight',wire_type='$wire_type',coil_price='$coil_price',web_coil_price='$web_coil_price',gauge_size='$gauge_size',number_cores='$number_cores',wire_twist_type='$wire_twist_type',wire_color='$wire_color' where id='$id'";
        mysql_query($q1);
        mysql_query("INSERT INTO action_history SET user='".$_SESSION['SESS_FIRST_NAME']."', action='updated product: $product_name'");
        header("location: products.php");
    }
?>
<!DOCTYPE html>
<html lang="en">

<?php include("head.php"); ?>
<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include("header.php"); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Update Product</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Update Product Information!
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" method="post" action="">
                                       
                                        <div class="form-group">
                                            <label>Product Name:</label>
                                            <input class="form-control" value="<?php echo ($obj->product_name != '' ? $obj->product_name : ''); ?>" placeholder="Enter product name" name="product_name" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Coil Stock Quantity:</label>
                                            <input class="form-control" placeholder="Enter Coil Stock" type="number" name="coil_stock" value="<?php echo ($obj->coil_stock != '' ? $obj->coil_stock : ''); ?>" required>
                                        </div>
                                       <div class="form-group">
                                            <label>Coil Unit Price</label>
                                           <input class="form-control" name="coil_price" value="<?php echo ($obj->coil_price != '' ? $obj->coil_price : ''); ?>" type="number"  placeholder="Enter Coil software Price" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Coil Web Price</label>
                                           <input class="form-control" name="web_coil_price" value="<?php echo ($obj->web_coil_price != '' ? $obj->web_coil_price : ''); ?>" type="number"  placeholder="Enter Coil website Price" required>
                                        </div>
                                       <div class="form-group">
                                            <label>Gauge size:</label>
                                            <input class="form-control" name="gauge_size" value="<?php echo ($obj->gauge_size != '' ? $obj->gauge_size : ''); ?>" type="number" placeholder="Enter Gauage Size"  required>
                                        </div>
                                        <div class="form-group">
                                            <label>Coil Weight:(per/Kg)</label>
                                            <input class="form-control" name="coil_weight" type="number" step="0.01" value="<?php echo ($obj->coil_weight != '' ? $obj->coil_weight : ''); ?>"   required>
                                        </div>
                                        <div class="form-group">
                                            <label>Wire Core:</label>
                                            <select class="form-control" name="number_cores">
                                                <option value="1" <?php if ($obj->number_cores == '1') echo ' selected="selected"'; ?>> 1 Core </option>
                                                <option value="2" <?php if ($obj->number_cores == '2') echo ' selected="selected"'; ?>> 2 Core</option>
                                                <option value="3" <?php if ($obj->number_cores == '3') echo ' selected="selected"'; ?>> 3 Core</option>
                                                <option value="4" <?php if ($obj->number_cores == '4') echo ' selected="selected"'; ?>> 4 Core</option>
                                                <option value="5" <?php if ($obj->number_cores == '5') echo ' selected="selected"'; ?>> 5 Core</option>
                                                <option value="6" <?php if ($obj->number_cores == '6') echo ' selected="selected"'; ?>> 6 Core</option>
                                                <option value="7" <?php if ($obj->number_cores == '7') echo ' selected="selected"'; ?>> 7 Core</option>
                                            </select>
                                        </div>
                                         <div class="form-group">
                                            <label>Wire Manufacturing Type:</label>
                                            <select class="form-control" name="wire_type">
                                                <option value="0" <?php if ($obj->wire_type == '0') echo ' selected="selected"'; ?>> Aluminium </option>
                                                <option value="1"  <?php if ($obj->wire_type == '1') echo ' selected="selected"'; ?>> Copper </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Wire Twist Type:</label>
                                            <select class="form-control" name="wire_twist_type">
                                                <option value="0" <?php if ($obj->wire_twist_type == '0') echo ' selected="selected"'; ?>> Non-Twisted </option>
                                                <option value="1"  <?php if ($obj->wire_twist_type == '1') echo ' selected="selected"'; ?>> Twisted </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Wire Color:</label>
                                            <input class="form-control" value="<?php echo ($obj->wire_color != '' ? $obj->wire_color : ''); ?>" placeholder="Enter Wire Color" name="wire_color" required>
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-default">Save Product</button>
                                        <button type="reset" class="btn btn-default">Reset Form</button>
                                </div>
                                </form>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                              
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
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
