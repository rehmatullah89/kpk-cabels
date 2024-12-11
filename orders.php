<?php
require_once('auth.php');
error_reporting(0);
require_once('config.php');
if (isset($_SESSION['count']) || isset($_SESSION['products'])) {
    unset($_SESSION['count']);
    unset($_SESSION['products']);
}    
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
    $qry = "SELECT * FROM product_stock ORDER BY number_cores";
        $result = mysql_query($qry);

    $qry2 = "SELECT * FROM unit_rates";
    $result2 = mysql_query($qry2);
    $obj = mysql_fetch_object($result2);

?>
<!DOCTYPE html>
<html lang="en">

<?php include("head.php"); ?>

<body>

    <div id="wrapper">

        <!-- Navigation -->
 
    <?php include("headers/header-orders.php"); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Create Bill</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
           
            <!-- /.row -->
            <div class="row" style="margin-right:-300px;">
                <div class="col-lg-8">
                   <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Please Fill required Information
                        </div>
                        <form method="post" action="order-exec.php">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                
                                <div class="form-group">
                                        <label>Customer Name:</label>
                                        <input class="form-control" style='width:20em; display:inline;' placeholder="Enter Customer name" name="customer_name" id="customer_name" required>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <label>Customer Phone#:</label>
                                        <input class="form-control" style='width:20em; display:inline;' placeholder="Enter Customer Phone" name="customer_phone" id="customer_phone" required>
                                </div>
                                <div class="form-group">
                                        <label>Customer Address:</label>
                                        <input class="form-control" style='width:20em; display:inline;' placeholder="Enter Customer Address" name="customer_address" id="customer_address" required>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <label>Customer City:</label>
                                        <input class="form-control" style='width:20em; display:inline;' placeholder="Enter Customer City" name="customer_city" id="customer_city" required>
                                </div>
                                <hr/>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <tbody>
                                <?php
                                    $previous_core = "";
                                    while ($row = mysql_fetch_array($result)) { 
                                        if ($row['number_cores'] != $previous_core) {
                                            if (!empty($previous_core))
                                                    echo "</tr>";
                                            echo "<tr class='odd gradeX'><th style='width:50px; border: 1px solid grey; background-color: #EEEEEE;'>Core ".$row['number_cores']."</th>";
                                            $previous_core = $row['number_cores'];
                                        }

                                ?>
                                        	<td style='width:50px;'>
                                            <?php echo $row['product_name']; ?><br/><input type="number"  id="<?php echo $row['id']; ?>" name="quantity_<?php echo $row['id']; ?>" class="myInput" min="0">
                                            <input type="hidden"  name="product_<?php echo $row['id']; ?>" value="<?php echo $row['product_name']; ?>" />
                                            <input type="hidden"  name="price_<?php echo $row['id']; ?>" value="<?php echo $row['coil_price']; ?>" />
                                            <input type="hidden"  name="stock_<?php echo $row['id']; ?>" value="<?php echo $row['coil_stock']; ?>" />
                                            <?php
                                                if ($row['wire_type'] == 0) {
                                                    $aluminium_wt = (($row['gauge_size']*33*33)/260000)*$row['number_cores'];
                                                    $alum_price = $aluminium_wt* $obj->aluminium_rate;
                                                    if ($row['number_cores'] >1) {
                                                        $pvc_weight = $row['coil_weight'] - $aluminium_wt; 
                                                        $pvc_price = $pvc_weight* (($obj->pvc_rate + $obj->pvc_lead_rate)/2); 
                                                    }
                                                    else{    
                                                        $pvc_weight = $row['coil_weight'] - $aluminium_wt; 
                                                        $pvc_price = $pvc_weight* $obj->pvc_rate; 
                                                    }
                                                    $total_estimated_price = $alum_price + $pvc_price + $obj->labor_rate; 
                                                    /*echo "<div style='display:block;'><b>e:".$total_estimated_price."<b/><br/>";
                                                    echo "<b>a:".$row['coil_price']."<b/></div>";*/
                                                }
                                                else{
                                                    $copper_wt = (($row['gauge_size']*33*33)/80000)*$row['number_cores'];
                                                    $copper_price = $copper_wt* $obj->copper_rate;
                                                    if ($row['number_cores'] >1) {
                                                        $pvc_weight = $row['coil_weight'] - $copper_wt; 
                                                        $pvc_price = $pvc_weight* (($obj->pvc_rate + $obj->pvc_lead_rate)/2); 
                                                    }
                                                    else{    
                                                        $pvc_weight = $row['coil_weight'] - $copper_wt; 
                                                        $pvc_price = $pvc_weight* $obj->pvc_rate; 
                                                    }
                                                    $total_estimated_price = $copper_price + $pvc_price + $obj->labor_rate; 
                                                    /*echo "<div style='display:block;'><b>e:".$total_estimated_price."<b/><br/>";
                                                    echo "<b>a:".$row['coil_price']."<b/></div>";*/
                                                }
                                            ?>            
                                            </td>
                                           
                                                                                     
<?php                               }  
                                ?>
                                        
                                         
                                    </tbody>
                                </table>
                            </div>
                            <input type="hidden" name="total_bill" id="total_bill"/>
							<div><b>Total Bill Amount (For own store products only):</b><div style="display: inline; color:red;" id="bill_amt"></div><br/>
							<b>Estimated Amount (For own store products only):</b><div style="display: inline; color:red;" id="est_amt"></div>
							<br/><br/>
                            <h3 style="color:red;">Add Other Dealers/Suppliers Products in Bill</h3>
                            <table  class="table table-striped table-bordered table-hover" id="mytable">
                               <thead>
                                   <tr><th>Product Name</th><th>Product Price</th><th>Quantity</th><th>Dealer/Supplier Name</th><th>Other Details</th></tr>
                               </thead> 
                               <tbody>
                                   <tr><td><input type="text" name="opname_0" class="form-control"></td><td><input type="number" name="opprice_0" class="form-control"></td><td><input type="number" name="opqntity_0" class="form-control"></td><td><input type="text" name="opdealer_0" class="form-control"></td><td><input type="text" name="opdetails_0" class="form-control"></td></tr>
                               </tbody>                      
                            </table>
                            <button type="button" id="add_new_line" class="btn btn-success">Add New Line</button><button type="button" id="remove_line" class="btn btn-danger">Remove Line</button>
                            <div align="right"><input type="submit"  value="Submit Bill" onclick="return confirm('Are you sure you want to Create this Bill?');"/></div>
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
    

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>
<script >
 var i=1;
$(document).ready(function(){
    $("#add_new_line").on('click', function (){
        $('#mytable > tbody:last').append('<tr><td><input type="text" name="opname_'+i+'" id="opname_'+i+'" class="form-control"></td><td><input type="number" name="opprice_'+i+'" id="opprice_'+i+'" class="form-control"></td><td><input type="number" name="opqntity_'+i+'" id="opqntity_'+i+'" class="form-control"></td><td><input type="text" name="opdealer_'+i+'" id="opdealer_'+i+'" class="form-control"></td><td><input type="text" name="opdetails_'+i+'" id="opdetails_'+i+'" class="form-control"></td></tr>');    
        i=i+1;
    });
    
    $('#remove_line').on('click',function() {
                   if (i>1){
                    $('#mytable tr:last').remove();
                    i=i-1;
                }
    });  
});

 $("input.myInput").bind('change', function () {
    var id = $(this).attr('id');
    var value = $(this).val();
    var c_name = document.getElementById("customer_name").value;
    var c_phone = document.getElementById("customer_phone").value;
    if (c_name=="" || c_phone==""){
        alert("Customer Name/Phone must not be empty!");
        $(this).val("");
        return;
    }
    $.ajax({
            url: "get_bill_total.php?id="+id+"&value="+value+"&cname="+c_name+"&cphone="+c_phone,
            type: 'POST',
            success: function(data){
                 obj = JSON.parse(data);
                $("#bill_amt").html(obj.total_bill_amount);
                $("#est_amt").html(obj.total_estimated_amount);
                $("#total_bill").val(obj.total_bill_amount);
            }
        
         });  
});
</script>
</body>
</form>
</html>
