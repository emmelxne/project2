<?php
include('../includes/db.php');  // Include the database connection
$id = $_GET['id'];  // Get feedback ID from the URL

// Delete the feedback from the database
$sql = "DELETE FROM feedback WHERE feedback_id = $id";
mysqli_query($conn, $sql);

header('Location: manage_feedback.php');  // Redirect back to feedback management page
?>
