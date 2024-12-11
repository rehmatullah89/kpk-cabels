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

    function isEmail($email) {
        return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
    }
    if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

    $qry = "SELECT * FROM messages where id='".$_REQUEST['id']."'";
    $result = mysql_query($qry);
    $obj = mysql_fetch_object($result);
    if (isset($_REQUEST['id'])) {
        $qry2 = "UPDATE messages SET status='1' where id='".$_REQUEST['id']."' ";
        mysql_query($qry2);
    }

    if (isset($_POST['submit'])) {
        $qry1 = "INSERT INTO replies SET message_id='".$_REQUEST['id']."',reply_title='".$_POST['reply_msg']."',reply_text='".$_POST['reply_txt']."' ";
        mysql_query($qry1);
        $reply_msg_title = $_POST['reply_msg'];
        $reply_msg = $_POST['reply_txt'];

        if (isEmail($obj->sender_email)) {
            $admin_address = "rehmatullahbhatti@gmail.com";
            $e_subject = $reply_msg_title;
            $e_body = "Hi, Greetings by admin " . PHP_EOL . PHP_EOL;
            $e_content = "\"$reply_msg\"" . PHP_EOL . PHP_EOL;
            $e_reply = "You can contact admin via email: $obj->sender_email";
            $msg = wordwrap( $e_body . $e_content . $e_reply, 70 );
            $headers = "From: $admin_address" . PHP_EOL;
            $headers .= "Reply-To: $obj->sender_email" . PHP_EOL;
            $headers .= "MIME-Version: 1.0" . PHP_EOL;
            $headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
            $headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;
            mail($admin_address, $e_subject, $msg, $headers);
        }
        header("location: messages.php");
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
                    <h1 class="page-header">Reply to Customer</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Reply to cusometer # <?php echo $_REQUEST['id']; ?>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" method="post" action="">
                                       
                                        <div class="form-group">
                                            <label><?php echo $obj->message_title; ?></label>
                                            <div><?php echo $obj->message; ?></div>
                                        </div>
                                        <div class="form-group">
                                            <label>Reply Title:</label>
                                            <input class="form-control" placeholder="Enter Reply title" name="reply_msg" type="text" required>
                                        </div>
                                       <div class="form-group">
                                            <label>Reply:</label>
                                           <textarea class="form-control" rows="4" cols="62" name="reply_txt">
                                           </textarea>
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-default">Submit Reply </button>
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
