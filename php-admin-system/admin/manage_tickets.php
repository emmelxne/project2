<?php
include('../includes/db.php');  // Include the database connection

// Fetch all tickets from the database
$result = mysqli_query($con, "SELECT * FROM tickets");

echo "<h2>Manage Tickets</h2>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<p>{$row['ticket_id']} - {$row['event_name']} - {$row['status']} - <a href='edit_ticket.php?id={$row['ticket_id']}'>Edit</a> | <a href='delete_ticket.php?id={$row['ticket_id']}'>Delete</a></p>";
}
?>
