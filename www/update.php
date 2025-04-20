<?php
include('db.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Accept data via POST or GET
$ticket_id = $_POST['id'] ?? $_GET['id'] ?? 0;
$user_email = $_POST['user_email'] ?? $_GET['user_email'] ?? '';
$ticket = null;

// Load existing ticket
if ($ticket_id && $user_email) {
    $sql = "SELECT * FROM ticket WHERE id = ? AND user_email = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("is", $ticket_id, $user_email);
        $stmt->execute();
        $result = $stmt->get_result();
        $ticket = $result->fetch_assoc();
        $stmt->close();
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $adults = intval($_POST['adults'] ?? 0);
    $children = intval($_POST['children'] ?? 0);
    $students = intval($_POST['students'] ?? 0);
    $seniors = intval($_POST['seniors'] ?? 0);
    $total_price = ($adults * 27) + ($children * 17) + ($students * 18) + ($seniors * 18);

    $sql = "UPDATE ticket SET adults = ?, children = ?, students = ?, seniors = ?, total_price = ? WHERE id = ? AND user_email = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("iiiiiis", $adults, $children, $students, $seniors, $total_price, $ticket_id, $user_email);
        if ($stmt->execute()) {
            header("Location: receipt.php?id=$ticket_id&updated=1");
            exit();
        } else {
            echo "Error updating ticket: " . $stmt->error;
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Update Ticket</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="ticket.css">
</head>
<body class="p-4">
  <div class="container">
    <h2 class="mb-4">Update Ticket Quantity</h2>

    <?php if ($ticket): ?>
      <form method="post" action="update.php">
        <input type="hidden" name="id" value="<?= $ticket_id ?>">
        <input type="hidden" name="user_email" value="<?= htmlspecialchars($user_email) ?>">

        <div class="mb-3">
          <label>Adults:</label>
          <input type="number" name="adults" class="form-control" value="<?= $ticket['adults'] ?>" min="0" required>
        </div>
        <div class="mb-3">
          <label>Children:</label>
          <input type="number" name="children" class="form-control" value="<?= $ticket['children'] ?>" min="0" required>
        </div>
        <div class="mb-3">
          <label>Students:</label>
          <input type="number" name="students" class="form-control" value="<?= $ticket['students'] ?>" min="0" required>
        </div>
        <div class="mb-3">
          <label>Seniors:</label>
          <input type="number" name="seniors" class="form-control" value="<?= $ticket['seniors'] ?>" min="0" required>
        </div>

        <button type="submit" name="update" class="btn btn-primary">Update Ticket</button>
        <a href="receipt.php?id=<?= $ticket_id ?>" class="btn btn-secondary">Cancel</a>
      </form>
    <?php else: ?>
      <div class="alert alert-danger">Ticket not found or invalid access.</div>
    <?php endif; ?>
  </div>
</body>
</html>
