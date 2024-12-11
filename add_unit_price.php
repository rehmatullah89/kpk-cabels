<?php
require_once('auth.php');
error_reporting(0);
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
	$qry = "SELECT * FROM unit_rates limit 1";
	$result = mysql_query($qry);
    $c_rows = mysql_num_rows($result);
	$obj = mysql_fetch_object($result);
	
	if(isset($_POST['submit'])){
		$copper_rate = $_POST['copper_rate'];
		$aluminium_rate = $_POST['aluminium_rate'];
		$pvc_rate = $_POST['pvc_rate'];
		$pvc_lead_rate = $_POST['pvc_lead_rate'];
		$labor_rate = $_POST['labor_rate'];
		if($c_rows>0)
			$q1="UPDATE unit_rates SET copper_rate='$copper_rate',aluminium_rate='$aluminium_rate',pvc_rate='$pvc_rate',pvc_lead_rate='$pvc_lead_rate',labor_rate='$labor_rate'";
        else
			$q1="Insert INTO unit_rates SET copper_rate='$copper_rate',aluminium_rate='$aluminium_rate',pvc_rate='$pvc_rate',pvc_lead_rate='$pvc_lead_rate',labor_rate='$labor_rate'";
		mysql_query($q1);		

	}
?>
<!DOCTYPE html>
<html lang="en">

<?php include("head.php"); ?>
<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include("headers/header-unitprice.php"); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Add Unit Price Rate</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Add Item's Unit Price Rates
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" method="post" action="">
                                       
                                        <div class="form-group">
                                            <label>Copper Unit Price:</label>
                                            <input class="form-control" type="number" placeholder="Enter copper unit/kg rate" name="copper_rate" value="<?php if(isset($obj->copper_rate)) echo $obj->copper_rate; ?>" <?php if ($_SESSION['SESS_USER_ROLE'] != 'super_admin') echo 'readonly'; ?> required>
                                        </div>
                                        <div class="form-group">
                                            <label>Aluminium Unit Price:</label>
                                            <input class="form-control" placeholder="Enter Aluminium unit/kg rate" name="aluminium_rate" type="number" value="<?php if(isset($obj->aluminium_rate)) echo $obj->aluminium_rate; ?>" <?php if ($_SESSION['SESS_USER_ROLE'] != 'super_admin') echo 'readonly'; ?> required>
                                        </div>
                                       <div class="form-group">
                                            <label>PVC Unit Price</label>
                                           <input class="form-control" type="number" name="pvc_rate" placeholder="Entter PVC unit/kg rate" value="<?php if(isset($obj->pvc_rate)) echo $obj->pvc_rate; ?>" <?php if ($_SESSION['SESS_USER_ROLE'] != 'super_admin') echo 'readonly'; ?> required>
                                        </div>
                                       <div class="form-group">
                                            <label>PVC for Lead Unit Price</label>
                                           <input class="form-control" name="pvc_lead_rate" type="number" placeholder="Entter PVC for lead unit/kg rate" value="<?php if(isset($obj->pvc_lead_rate)) echo $obj->pvc_lead_rate; ?>" <?php if ($_SESSION['SESS_USER_ROLE'] != 'super_admin') echo 'readonly'; ?> required>
                                        </div>
									   <div class="form-group">
                                            <label>Labor Rate:</label>
                                            <input class="form-control" name="labor_rate" type="number" placeholder="Enter Labor cost" value="<?php if(isset($obj->labor_rate)) echo $obj->labor_rate; ?>" <?php if ($_SESSION['SESS_USER_ROLE'] != 'super_admin') echo 'readonly'; ?> required>
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-default">Save Unite Price Rates</button>
                                        <button type="reset" class="btn btn-default">Reset Form</button>
                                    </form>
                                </div>
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
