<?php
include('../includes/db.php');  // Include the database connection
$id = $_GET['id'];  // Get ticket ID from the URL

// Delete the ticket from the database
$sql = "DELETE FROM tickets WHERE ticket_id = $id";
mysqli_query($conn, $sql);

header('Location: manage_tickets.php');  // Redirect back to ticket management page
?>
