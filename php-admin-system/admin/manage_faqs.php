<?php
include('../includes/db.php');  // Include the database connection

// Fetch all FAQs from the database
$result = mysqli_query($conn, "SELECT * FROM faqs");

echo "<h2>Manage FAQs</h2>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<p>{$row['question']} - <a href='edit_faq.php?id={$row['faq_id']}'>Edit</a> | <a href='delete_faq.php?id={$row['faq_id']}'>Delete</a></p>";
}
?>
