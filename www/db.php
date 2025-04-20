<?php
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "ticket_system";
$port = 3307;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "error",
        "message" => "Database connection failed: " . $conn->connect_error
    ]);
    exit();
}
