<?php 

$server = "localhost";
$username = "root";
$password = "";
$dbname = "acc_firm";

$conn = new mysqli($server, $username, $password, $dbname);

if($conn->connect_error){
    die("Connection failed: " .$conn->connect_error);
}else{
    // echo "Connected successfully !";
}

$base_url = '';
?>