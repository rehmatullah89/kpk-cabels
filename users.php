<?php
require_once('auth.php');
//error_reporting(0);
if (isset($_SESSION['register_user'])) {
      echo "<script type='text/javascript'>alert('".$_SESSION['register_user']."')</script>";
    unset($_SESSION['register_user']); 
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
    $qry = "SELECT * FROM members";
        $result = mysql_query($qry);
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
                    <h1 class="page-header">Users List</h1>
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
                            Edit / Delete / Modify Users
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                      while ($row = mysql_fetch_array($result)) { ?>
                                       <tr class="odd gradeX">
                                            <td><?php echo $row['firstname']." ".$row['lastname']; ?></td>
                                            <td><?php echo $row['member_email_id']; ?></td>
                                            <td><?php echo ($row['user_type'] == 'super_admin' ? "Administrator" : 'User'); ?></td>
                                            <td class="center"><?php echo ($row['status'] == 0 ? "In-active" : 'Active'); ?></td>
                                            <td class="center">
                                            <div calss="btn-group btn-group-sm">
                                             <?php if (($_SESSION['SESS_USER_ROLE'] == 'admin_user') && ($_SESSION['SESS_MEMBER_ID'] == $row['member_email_id'])){ ?> 
                                             <a href="update_user.php?id=<?php  echo $row['member_email_id'];?>" class="btn btn-outline btn-primary btn-xs">Edit</a>
                                             <?php } if ($_SESSION['SESS_USER_ROLE'] == 'super_admin') { ?>
<a href="update_user.php?id=<?php  echo $row['member_email_id'];?>" class="btn btn-outline btn-primary btn-xs">Edit</a>
                                             <a href="delete_user.php?id=<?php  echo $row['member_email_id'];?>" class="btn btn-outline btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
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

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>

</body>

</html>
