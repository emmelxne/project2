<?php
include('../includes/db.php');  // Include the database connection
$id = $_GET['id'];  // Get ticket ID from the URL

// Fetch the ticket data from the database
$result = mysqli_query($con, "SELECT * FROM tickets WHERE ticket_id = $id");
$row = mysqli_fetch_assoc($result);
?>

<form action="edit_ticket.php?id=<?php echo $id; ?>" method="POST">
    <input type="text" name="event_name" value="<?php echo $row['event_name']; ?>" required>
    <input type="number" name="price" value="<?php echo $row['price']; ?>" required>
    <select name="status">
        <option value="available" <?php if ($row['status'] == 'available') echo 'selected'; ?>>Available</option>
        <option value="sold_out" <?php if ($row['status'] == 'sold_out') echo 'selected'; ?>>Sold Out</option>
    </select>
    <input type="submit" value="Update Ticket">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_name = $_POST['event_name'];
    $price = $_POST['price'];
    $status = $_POST['status'];

    // Update the ticket in the database
    $sql = "UPDATE tickets SET event_name = '$event_name', price = '$price', status = '$status' WHERE ticket_id = $id";
    mysqli_query($con, $sql);

    header('Location: manage_tickets.php');  // Redirect back to ticket management page
}
?>
