<?php 

// Detect if we're on cPanel hosting or local development
$is_cpanel = (strpos($_SERVER['HTTP_HOST'], 'sandiipc') !== false || 
              strpos($_SERVER['HTTP_HOST'], 'teamyulsa.com') !== false ||
              strpos($_SERVER['HTTP_HOST'], 'yulsa_main') !== false);

if ($is_cpanel) {
    // cPanel hosting configuration
    $server = "localhost";
    $username = "sandiipc_t_yulsa";
    $password = "TeamYulsa@123";
    $dbname = "sandiipc_acc_firm";
    $base_url = '/yulsa_main';
} else {
    // Local development configuration
    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "acc_firm";
    $base_url = '/ACCOUNTING_FIRM';
}

$conn = new mysqli($server, $username, $password, $dbname);

if($conn->connect_error){
    die("Connection failed: " .$conn->connect_error);
}else{
    // echo "Connected successfully !";
}
?>