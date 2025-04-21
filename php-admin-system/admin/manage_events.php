<?php
include('../includes/db.php');  // Include the database connection

$result = mysqli_query($conn, "SELECT * FROM events");

echo "<h2>Manage Events</h2>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<p>{$row['title']} - <a href='edit_event.php?id={$row['id']}'>Edit</a> | <a href='delete_event.php?id={$row['id']}'>Delete</a></p>";
}
?>
