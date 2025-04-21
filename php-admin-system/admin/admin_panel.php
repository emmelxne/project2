<?php
session_start();

?>

<h2>Welcome, <?php echo $_SESSION['admin_username']; ?>!</h2>
<a href="manage_events.php">Manage Events</a><br>
<a href="manage_tickets.php">Manage Tickets</a><br>
<a href="manage_feedback.php">Manage Feedback</a><br>
<a href="manage_faqs.php">Manage FAQs</a><br>
<a href="edit_about_us.php">Edit About Us</a><br>
<a href="logout.php">Logout</a>
