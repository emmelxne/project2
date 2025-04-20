<?php
include('db.php');
session_start();

$ticket_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$amount = isset($_GET['amount']) ? $_GET['amount'] : 'RM0.00';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ticket_id = isset($_POST['ticket_id']) ? intval($_POST['ticket_id']) : 0;

    if ($ticket_id > 0) {
        $sql = "UPDATE ticket SET payment_status = 'paid' WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $ticket_id);
            if ($stmt->execute()) {
                $_SESSION['success'] = "Payment completed successfully!";
                $stmt->close();
                $conn->close();
                header("Location: receipt.php?id=$ticket_id");
                exit();
            } else {
                $error = "Failed to update ticket status.";
            }
        } else {
            $error = "Database error.";
        }
    } else {
        $error = "Invalid ticket ID.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Page</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="payment.css">
</head>
<body class="p-4">
  <div class="container">
    <h1 class="text-center mb-4">Payment Information</h1>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form id="paymentForm" method="POST" action="">
      <input type="hidden" name="ticket_id" value="<?= $ticket_id ?>">

      <div class="mb-3">
        <label for="fullName" class="form-label">Full Name</label>
        <input type="text" class="form-control" id="fullName" name="fullName" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>

      <div class="mb-3">
        <label for="cardNumber" class="form-label">Card Number</label>
        <input type="text" class="form-control" id="cardNumber" name="cardNumber" required>
      </div>

      <div class="row mb-3">
        <div class="col">
          <label for="expiryDate" class="form-label">Expiry Date (MM/YY)</label>
          <input type="text" class="form-control" id="expiryDate" name="expiryDate" placeholder="MM/YY" required>
        </div>
        <div class="col">
          <label for="cvv" class="form-label">CVV</label>
          <input type="text" class="form-control" id="cvv" name="cvv" required>
        </div>
      </div>

      <div class="mb-3">
        <label for="amount" class="form-label">Total Amount</label>
        <input type="text" class="form-control" id="amount" name="amount" value="<?= htmlspecialchars($amount) ?>" readonly>
      </div>

      <button type="submit" class="btn btn-primary">Submit Payment</button>
      <a href="ticket.html" class="btn btn-secondary">Back</a>
     
    </form>
  </div>
</body>
</html>
