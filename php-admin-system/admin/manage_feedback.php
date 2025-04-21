<?php
include('../includes/db.php');  // Include the database connection

// Fetch all feedback from the database
$result = mysqli_query($con, "SELECT * FROM feedback");

echo "<h2>Manage Feedback</h2>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<p>{$row['name']} - {$row['message']} - <a href='delete_feedback.php?id={$row['feedback_id']}'>Delete</a></p>";
}
?>
