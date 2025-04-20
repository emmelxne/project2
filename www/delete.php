<?php
include('db.php');
session_start();

$ticket_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$referer = $_SERVER['HTTP_REFERER'] ?? 'index.php'; // redirect back

if ($ticket_id > 0) {
    $checkSql = "SELECT payment_status FROM ticket WHERE id = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("i", $ticket_id);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if ($row['payment_status'] === 'pending') {
            $sql = "DELETE FROM ticket WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $ticket_id);
            if ($stmt->execute()) {
                $_SESSION['success'] = "Ticket deleted successfully.";
            } else {
                $_SESSION['error'] = "Failed to delete ticket.";
            }
            $stmt->close();
        } else {
            $_SESSION['error'] = "Only pending tickets can be deleted.";
        }
    } else {
        $_SESSION['error'] = "Ticket not found.";
    }

    $checkStmt->close();
}

$conn->close();
header("Location: ticket.html"); // Redirect back to previous page
exit();
