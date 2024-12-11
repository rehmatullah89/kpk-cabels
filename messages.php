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
    $qry = "SELECT * FROM messages ORDER BY message_date DESC";
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
                    <h1 class="page-header">Messages</h1>
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
                            View / Reply Messages
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>index</th>
                                            <th>Sender</th>
                                            <th>Title</th>
                                            <th>Message</th>
                                            <th>Email</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i=1;
                                      while ($row = mysql_fetch_array($result)) { ?>
                                       <tr class="odd gradeX">
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $row['sender_name']; ?></td>
                                            <td><?php echo $row['message_title']; ?></td>
                                                        <?php if ($row['status'] == 0){ ?>
                                                <td style="color:#FF6C60;"><?php echo $row['message']; ?></td>                                                
                                            <?php } 
                                                else {?>
                                                    <td style="color:#6DBB4A;"><?php echo $row['message']; ?></td>
                                                    <?php } ?>
                                            <td><?php echo $row['sender_email']; ?></td>
                                            <td><?php echo date('Y-m-d',strtotime($row['message_date'])); ?></td>
                                            <td class="center">
                                            <div calss="btn-group btn-group-sm">
                                             <a href="reply_message.php?id=<?php  echo $row['id'];?>" class="btn btn-outline btn-primary btn-xs">Reply</a>
                                            <?php if ($_SESSION['SESS_USER_ROLE'] == 'super_admin') { ?>
                                             <a href="delete_message.php?id=<?php  echo $row['id'];?>" class="btn btn-outline btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
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
