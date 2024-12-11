<?php
require_once('auth.php');
//error_reporting(0);
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
                    <h1 class="page-header">Create New User</h1>
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
                                    <form role="form" method="post" action="add_user-exec.php">
                                       
                                        <div class="form-group">
                                            <label>First Name:</label>
                                            <input class="form-control" placeholder="Enter your First Name" name="first_name" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Last Name:</label>
                                            <input class="form-control" placeholder="Enter your Last Name" name="last_name" required>
                                        </div>
                                       <div class="form-group">
                                            <label>Email Address</label>
                                           <input class="form-control" name="email_id" type="email" placeholder="Please, provide your e-mail address" x-moz-errormessage="This is not a valid e-mail"  required>
                                        </div>
                                       <div class="form-group">
                                            <label>Password:</label>
                                            <input class="form-control" name="password" id="password" type="password" placeholder="Enter password" min="5" max="15" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Confirm Password:</label>
                                            <input class="form-control" name="password_confirm" id="password_confirm" type="password" placeholder="Please Confirm your password" oninput="check(this)" min="5" max="15"  required>
                                        </div>
                                       
                                        <div class="form-group">
                                            <label>User Role:</label>
                                            <select class="form-control" name="user_role">
                                                <option value="super_admin"> Administrator</option>
                                                <option value="admin_user"> User</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-default">Save User</button>
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
