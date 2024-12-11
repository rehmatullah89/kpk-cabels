<?php
session_start();
    //Include database connection details
    require_once('config.php');
    
    //Array to store validation errors
    $errmsg_arr = array();
    
    //Validation error flag
    $errflag = false;
    
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
    
    //Function to sanitize values received from the form. Prevents SQL injection
    function clean($str) {
        $str = @trim($str);
        if(get_magic_quotes_gpc()) {
            $str = stripslashes($str);
        }
        return mysql_real_escape_string($str);
    }
     //***********************
    //Sanitize the POST values
    date_default_timezone_set('Asia/Karachi');
    $first_name = clean($_POST['first_name']);
    $last_name = clean($_POST['last_name']);
    $email_address = clean($_POST['email_id']);
    $password = md5(clean($_POST['password']));
    $user_role = clean($_POST['user_role']);
    $current_time_stamp = date("Y-m-d H:i:s"); 
    
    $qry = "INSERT INTO members(firstname, lastname, member_email_id , passwd, user_type, date_created) VALUES('$first_name' ,'$last_name','$email_address','$password','$user_role','$current_time_stamp')";
    $result = @mysql_query($qry);

    //Check whether the query was successful or not
    if($result) {
        $_SESSION['register_user'] = $first_name." has been registered successfully!"; 
        header("location: users.php");
        exit();
    }else {
        die("Query failed");
    }
?>