<?php
include('../includes/db.php');  // Include the database connection
$id = $_GET['id'];  // Get event ID from the URL

// Fetch the event data from the database
$result = mysqli_query($con, "SELECT * FROM events WHERE id = $id");
$row = mysqli_fetch_assoc($result);
?>

<form action="edit_event.php?id=<?php echo $id; ?>" method="POST">
    <input type="text" name="title" value="<?php echo $row['title']; ?>" required>
    <textarea name="description"><?php echo $row['description']; ?></textarea>
    <input type="datetime-local" name="date" value="<?php echo $row['date']; ?>" required>
    <input type="text" name="location" value="<?php echo $row['location']; ?>" required>
    <input type="submit" value="Update Event">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $location = $_POST['location'];

    // Update the event in the database
    $sql = "UPDATE events SET title = '$title', description = '$description', date = '$date', location = '$location' WHERE id = $id";
    mysqli_query($con, $sql);

    header('Location: manage_events.php');  // Redirect back to event management page
}
?>
