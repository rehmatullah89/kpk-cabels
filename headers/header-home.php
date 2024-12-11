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
    $qry123 = "SELECT * FROM messages where status=0 ORDER BY message_date DESC";
        $result123 = mysql_query($qry123);
?>

       <nav id="navbar-default_check" class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="home.php"><span class="top-info">Welcome <b><?php echo $_SESSION['SESS_FIRST_NAME']." ".$_SESSION['SESS_LAST_NAME'];?></b></span></a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <?php
                            while ($row = mysql_fetch_array($result123)) {  ?> 
                        <li>
                            <a href="reply_message.php?id=<?php  echo $row['id'];?>">
                                <div>
                                    <strong><?php echo $row['sender_name']; ?></strong>
                                    <span class="pull-right text-muted">
                                        <em><?php echo date('Y-m-d',strtotime($row['message_date'])); ?></em>
                                    </span>
                                </div>
                                <div><?php echo $row['message_title']; ?></div>
                            </a>
                        </li>
                        <li class="divider"></li>
                      
                        <?php    }
                        ?>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="messages.php">
                                <strong>Read All Messages</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
               <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="users.php"><i class="fa fa-user fa-fw"></i> User's List</a>
                        </li>
                        <li><a href="add_user.php"><i class="fa fa-gear fa-fw"></i> Create New User</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group ">
                                <img src="./bootstrap/img/logo.png">
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="home.php" id="dashboard" class="active"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li id="products">
                            <a href=""><i class="fa fa-bar-chart-o fa-fw"></i> Product Details </a>
                            <ul class="nav nav-second-level" id="nav-second-level">
                                <li>
                                    <a href="add_unit_price.php" id="unit_price">Add Unit Price</a>
                                </li>
                                <li>
                                    <a href="add_product.php" id="add_product">Add Product</a>
                                </li>
                                <li>
                                    <a href="products.php" id="list_product">Price / Product List</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href=""><i class="fa fa-edit fa-fw"></i> Bills Section</a>
                            <ul class="nav nav-second-level" id="nav-second-level">
                                <li>
                                    <a href="orders.php">Create Bill</a>
                                </li>
                                <li>
                                    <a href="all_bills.php">View All Bills</a>
                                </li>
                                                                <li>
                                    <a href="all_void_bills.php">View Void Bills</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="other_delnsupliers.php"><i class="fa fa-star"></i> Other Dealers/Suppliers</a>
                        </li>
                        <li>
                            <a href="report.php"><i class="fa fa-table fa-fw"></i> Report</a>
                        </li>
						<li>
                            <a href="history.php"><i class="fa fa-history"></i> History</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>