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
$qry = "SELECT * FROM members where member_email_id='".$id."'  limit 1";
$result = mysql_query($qry);
$obj = mysql_fetch_object($result); 
if (isset($_POST['submit'])) {

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email_id = $_POST['email_id'];
    $user_role = $_POST['user_role'];
    $user_status = $_POST['user_status'];
    if ((!empty($_POST['password']) && !empty($_POST['password_confirm'])) && $_POST['password'] == $_POST['password_confirm']) {
        $password = md5($_POST['password']);
         $password_confirm = md5($_POST['password_confirm']);
          $q1="UPDATE members SET member_email_id='$email_id',firstname='$first_name',lastname='$last_name',user_type='$user_role',status='$user_status',passwd='$password' where member_email_id='$id' AND member_email_id!='rehmat@google.com'";
            mysql_query($q1);   
            header("location: users.php");    
    }
    else{
        $q1="UPDATE members SET member_email_id='$email_id',firstname='$first_name',lastname='$last_name',user_type='$user_role',status='$user_status' where member_email_id='$id' AND member_email_id!='rehmat@google.com'";
            mysql_query($q1);
            header("location: users.php");
    }
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
                    <h1 class="page-header">Edit / Update User</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Add New Basic / Admin User
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" method="post" action="">
                                       
                                        <div class="form-group">
                                            <label>First Name:</label>
                                            <input class="form-control" placeholder="Enter your First Name" name="first_name" value="<?php echo ($obj->firstname != '' ? $obj->firstname : ''); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Last Name:</label>
                                            <input class="form-control" placeholder="Enter your Last Name" name="last_name" value="<?php echo ($obj->lastname != '' ? $obj->lastname : ''); ?>" required>
                                        </div>
                                       <div class="form-group">
                                            <label>Email Address</label>
                                           <input class="form-control" name="email_id" type="email" value="<?php echo ($obj->member_email_id != '' ? $obj->member_email_id : ''); ?>" placeholder="Please, provide your e-mail address" x-moz-errormessage="This is not a valid e-mail"  required>
                                        </div>
                                       <div class="form-group">
                                            <label>Password:</label>
                                            <input class="form-control" name="password" id="password" type="password" placeholder="Enter password" min="5" max="15">
                                        </div>
                                        <div class="form-group">
                                            <label>Confirm Password:</label>
                                            <input class="form-control" name="password_confirm" id="password_confirm" type="password" placeholder="Please Confirm your password" oninput="check(this)" min="5" max="15" >
                                        </div>
                                       
                                        <div class="form-group">
                                            <label>User Role:</label>
                                            <select class="form-control" name="user_role" >
                                                <option value="super_admin" <?php if ($obj->user_type == 'super_admin') echo ' selected="selected"'; ?> <?php if ($_SESSION['SESS_USER_ROLE'] != 'super_admin') echo 'disabled'; ?>> Administrator</option>
                                                <option value="admin_user" <?php if ($obj->user_type == 'admin_user') echo ' selected="selected"'; ?> > User</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>User Status:</label>
                                            <select class="form-control" name="user_status">
                                                <option value="0" <?php if ($obj->status == '0') echo ' selected="selected"'; ?> <?php if ($_SESSION['SESS_USER_ROLE'] != 'super_admin') echo 'disabled'; ?>> In-active</option>
                                                <option value="1" <?php if ($obj->status == '1') echo ' selected="selected"'; ?> >Active</option>
                                            </select>
                                        </div>
                                        <input type="submit" class="btn btn-default" value="Update User" name="submit" />
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
    <script language='javascript' type='text/javascript'>
        function check(input) {
            if (input.value != document.getElementById('password').value) {
              input.setCustomValidity('Password Must be Matching.');
            } else {
            // input is valid -- reset the error message
              input.setCustomValidity('');
            }
        }
    </script>
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
