<?php
include('db.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);

$user_email = $_POST['user_email'] ?? '';
$adults = intval($_POST['adults'] ?? 0);
$children = intval($_POST['children'] ?? 0);
$students = intval($_POST['students'] ?? 0);
$seniors = intval($_POST['seniors'] ?? 0);
$payment_status = 'pending';

if (empty($user_email)) {
    die("Email is required.");
}

// Check if the user already has an unpaid ticket
$checkSql = "SELECT * FROM ticket WHERE user_email = ? AND payment_status = 'pending' LIMIT 1";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("s", $user_email);
$checkStmt->execute();
$result = $checkStmt->get_result();

if ($result->num_rows > 0) {
    // 🧾 User has an existing unpaid ticket: append quantities
    $existing = $result->fetch_assoc();
    $ticket_id = $existing['id'];

    // Append new values to existing
    $new_adults = $existing['adults'] + $adults;
    $new_children = $existing['children'] + $children;
    $new_students = $existing['students'] + $students;
    $new_seniors = $existing['seniors'] + $seniors;

    // Recalculate total
    $total_price = ($new_adults * 27) + ($new_children * 17) + ($new_students * 18) + ($new_seniors * 18);

    // Update the ticket
    $updateSql = "UPDATE ticket SET adults=?, children=?, students=?, seniors=?, total_price=? WHERE id=?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("iiiiii", $new_adults, $new_children, $new_students, $new_seniors, $total_price, $ticket_id);

    if ($updateStmt->execute()) {
        header("Location: receipt.php?id=" . $ticket_id . "&updated=1");
        exit();
    } else {
        echo "Error updating ticket: " . $updateStmt->error;
    }
    $updateStmt->close();
} else {
    // 👶 First time user – insert new ticket
    $total_price = ($adults * 27) + ($children * 17) + ($students * 18) + ($seniors * 18);

    $insertSql = "INSERT INTO ticket (user_email, adults, children, students, seniors, total_price, payment_status) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertSql);
    $insertStmt->bind_param("siiiiis", $user_email, $adults, $children, $students, $seniors, $total_price, $payment_status);

    if ($insertStmt->execute()) {
        $ticket_id = $insertStmt->insert_id;
        header("Location: receipt.php?id=" . $ticket_id);
        exit();
    } else {
        echo "Error creating ticket: " . $insertStmt->error;
    }
    $insertStmt->close();
}

$checkStmt->close();
$conn->close();
?>
