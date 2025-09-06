<?php 

$server = "localhost";
$username = "sandiipc_t_yulsa";
$password = "TeamYulsa@123";
$dbname = "sandiipc_acc_firm";

$conn = new mysqli($server, $username, $password, $dbname);

if($conn->connect_error){
    die("Connection failed: " .$conn->connect_error);
}else{
    // echo "Connected successfully !";
}

$base_url = '';
?>