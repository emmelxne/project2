<?php
$host = "localhost";
$username = "root";
$password = "mysql";
$database = "php_admin_system";

// Create connection
$con = mysqli_connect($host, $username, $password, $database);

// Check connection
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}
?>
