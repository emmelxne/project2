<form action="add_ticket.php" method="POST">
    <input type="text" name="event_name" placeholder="Event Name" required>
    <input type="number" name="price" placeholder="Ticket Price" required>
    <select name="status">
        <option value="available">Available</option>
        <option value="sold_out">Sold Out</option>
    </select>
    <input type="submit" value="Add Ticket">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../includes/db.php');  // Include the database connection

    $event_name = $_POST['event_name'];
    $price = $_POST['price'];
    $status = $_POST['status'];

    // Insert new ticket into the database
    $sql = "INSERT INTO tickets (event_name, price, status) VALUES ('$event_name', '$price', '$status')";
    mysqli_query($con, $sql);

    header('Location: manage_tickets.php');  // Redirect to ticket management page
}
?>
