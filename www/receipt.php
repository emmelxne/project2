<?php
include('db.php');

$ticket_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$ticket = null;

if ($ticket_id > 0) {
    $sql = "SELECT * FROM ticket WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $ticket_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $ticket = $result->fetch_assoc();
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Receipt</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="receipt.css">
</head>
<body class="p-4">
  <div class="container">
    <h2 class="mb-4">Ticket Receipt</h2>
    <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php elseif (isset($_SESSION['error'])): ?>
      <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>


    <?php if (isset($_GET['updated']) && $_GET['updated'] == '1'): ?>
      <div class="alert alert-success">🎉 Tickets updated successfully!</div>
    <?php elseif (isset($_GET['created']) && $_GET['created'] == '1'): ?>
      <div class="alert alert-info">🧾 Ticket created successfully.</div>
    <?php endif; ?>

    <?php if ($ticket): ?>
      <div class="card p-4 shadow-sm mb-3">
        <p><strong>Email:</strong> <?= htmlspecialchars($ticket['user_email']) ?></p>
        <p><strong>Adults:</strong> <?= intval($ticket['adults']) ?></p>
        <p><strong>Children:</strong> <?= intval($ticket['children']) ?></p>
        <p><strong>Students:</strong> <?= intval($ticket['students']) ?></p>
        <p><strong>Seniors:</strong> <?= intval($ticket['seniors']) ?></p>
        <p><strong>Total Price:</strong> RM<?= number_format($ticket['total_price'], 2) ?></p>
        <p><strong>Status:</strong> <?= ucfirst(htmlspecialchars($ticket['payment_status'])) ?></p>
      </div>

    <div class="d-flex gap-2">
      <?php if ($ticket['payment_status'] === 'paid'): ?>
          <a href="index.html" class="btn btn-primary">Back to Home</a>
      <?php else: ?>
          <a href="payment.php?id=<?= $ticket_id ?>&amount=<?= $ticket['total_price'] ?>" class="btn btn-success">Proceed to Payment</a>

          <form action="update.php" method="post">
              <input type="hidden" name="id" value="<?= $ticket_id ?>">
              <input type="hidden" name="user_email" value="<?= htmlspecialchars($ticket['user_email']) ?>">
              <button type="submit" class="btn btn-back">Back</button>
          </form>

          <a href="delete.php?id=<?= $ticket_id ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this ticket?');">Delete Ticket</a>
      <?php endif; ?>
    </div>

    <?php else: ?>
      <div class="alert alert-danger"> Invalid ticket ID or ticket not found.</div>
    <?php endif; ?>
  </div>
</body>
</html>
