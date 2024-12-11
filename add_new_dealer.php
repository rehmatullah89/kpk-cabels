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
    
    if(isset($_POST['submit'])){
        $dealer_name = $_POST['dealer_name'];
        $dealer_phone = $_POST['dealer_phone'];
        $dealer_email = $_POST['dealer_email'];
        $dealer_web = $_POST['dealer_web'];
        $dealer_comp = $_POST['dealer_comp'];
        $other_info = $_POST['other_info'];
        mysql_query("Insert INTO dealers_suppliers SET dealer_name='$dealer_name',phone='$dealer_phone',email='$dealer_email',website='$dealer_web',company='$dealer_comp',other_info='$other_info'");
        $_SESSION['add_dealer_success'] = "Dealer/ Supplier has been added successfully!"; 
        header("location: other_delnsupliers.php");
    }
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
                    <h1 class="page-header">Add New Dealer/ Supplier</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Add Dealer or Supplier Information here!
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" method="post" action="">
                                       
                                        <div class="form-group">
                                            <label>Dealer Name:</label>
                                            <input class="form-control" placeholder="Enter dealer name" name="dealer_name" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Phone :</label>
                                            <input class="form-control" placeholder="Enter dealer Phone" name="dealer_phone" >
                                        </div>
                                        <div class="form-group">
                                            <label>Email:</label>
                                            <input class="form-control" type="email" placeholder="Enter dealer Email" name="dealer_email" >
                                        </div>
                                        <div class="form-group">
                                            <label>Website:</label>
                                            <input class="form-control" placeholder="Enter dealer Website" name="dealer_web" >
                                        </div>
                                        <div class="form-group">
                                            <label>Company Name:</label>
                                            <input class="form-control" placeholder="Enter dealer Company" name="dealer_comp" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Other Information about dealer</label>
                                            <input class="form-control" placeholder="Enter any Information about dealer"  name="other_info" >
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-default">Save Info</button>
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
