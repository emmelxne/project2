<?php
$conn = new mysqli("localhost", "root", "", "ticket_system", 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "✅ Connected to AMPPS MySQL on port 3307!";
?>
