<?php
include('../includes/db.php');  // Include the database connection
$id = $_GET['id'];  // Get event ID from the URL

// Delete the event from the database
$sql = "DELETE FROM events WHERE id = $id";
mysqli_query($conn, $sql);

header('Location: manage_events.php');  // Redirect back to event management page
?>
