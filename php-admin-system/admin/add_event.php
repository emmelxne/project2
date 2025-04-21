<form action="add_event.php" method="POST">
    <input type="text" name="title" placeholder="Event Title" required>
    <textarea name="description" placeholder="Event Description"></textarea>
    <input type="datetime-local" name="date" required>
    <input type="text" name="location" placeholder="Event Location">
    <input type="submit" value="Add Event">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../includes/db.php');  // Include the database connection

    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $location = $_POST['location'];

    // Insert new event into the database
    $sql = "INSERT INTO events (title, description, date, location) VALUES ('$title', '$description', '$date', '$location')";
    mysqli_query($conn, $sql);

    header('Location: manage_events.php');  // Redirect to event management page
}
?>
