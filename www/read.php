<?php
include('db.php');

// Query to fetch all bookings
$sql = "SELECT * FROM ticket";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"]. " - Email: " . $row["user_email"]. " - Total Price: RM" . $row["total_price"]. "<br>";
    }
} else {
    echo "No bookings found.";
}

$conn->close();
?>
