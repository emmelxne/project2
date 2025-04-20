<?php
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login.php");
    exit();
}

// ✅ Wrap everything inside PHP
$host = "127.0.0.1:3307";
$user = "faquser";
$password = "mysql";
$dbname = "bit102_ass";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ADD
if (isset($_POST['add_faq'])) {
    $question = $_POST['question'] ?? '';
    $answer = $_POST['answer'] ?? '';
    $category = $_POST['category'] ?? '';

    if (!empty($question) && !empty($answer) && !empty($category)) {
        $stmt = $conn->prepare("INSERT INTO faqs (question, answer, category) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $question, $answer, $category);
        $stmt->execute();
        header("Location: admin_faq.php");
        exit();
    }
}

// DELETE
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM faqs WHERE id=$id");
    header("Location: admin_faq.php");
    exit();
}

// UPDATE
if (isset($_POST['update_faq'])) {
    $id = $_POST['edit_id'];
    $question = $_POST['edit_question'] ?? '';
    $answer = $_POST['edit_answer'] ?? '';
    $category = $_POST['edit_category'] ?? '';

    if (!empty($question) && !empty($answer) && !empty($category)) {
        $stmt = $conn->prepare("UPDATE faqs SET question=?, answer=?, category=? WHERE id=?");
        $stmt->bind_param("sssi", $question, $answer, $category, $id);
        $stmt->execute();
        header("Location: admin_faq.php");
        exit();
    }
}

$result = $conn->query("SELECT * FROM faqs");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage FAQs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="faq.css">
</head>
<body class="p-4">

<div class="container">
    <h2 class="mb-4">Admin FAQ Management</h2>
    <a href="logout.php" class="btn btn-danger float-end">Logout</a>

    <form method="POST" class="mb-4 border p-3">
        <h5>Add New FAQ</h5>
        <input type="text" name="question" class="form-control mb-2" placeholder="Question" required>
        <textarea name="answer" class="form-control mb-2" placeholder="Answer" required></textarea>
        <select name="category" class="form-control mb-2" required>
            <option value="Tickets">Tickets</option>
            <option value="Visit">Visit</option>
            <option value="Accessibility">Accessibility</option>
        </select>
        <button type="submit" name="add_faq" class="btn btn-success">Add FAQ</button>
    </form>

    <h5>Existing FAQs</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Question</th>
                <th>Answer</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <form method="POST">
                        <td><input type="text" name="edit_question" value="<?= htmlspecialchars($row['question']) ?>" class="form-control" required></td>
                        <td><input type="text" name="edit_answer" value="<?= htmlspecialchars($row['answer']) ?>" class="form-control" required></td>
                        <td>
                            <select name="edit_category" class="form-control" required>
                                <option value="Tickets" <?= $row['category'] == 'Tickets' ? 'selected' : '' ?>>Tickets</option>
                                <option value="Visit" <?= $row['category'] == 'Visit' ? 'selected' : '' ?>>Visit</option>
                                <option value="Accessibility" <?= $row['category'] == 'Accessibility' ? 'selected' : '' ?>>Accessibility</option>
                            </select>
                        </td>
                        <td>
                            <input type="hidden" name="edit_id" value="<?= $row['id'] ?>">
                            <button type="submit" name="update_faq" class="btn btn-warning btn-sm">Update</button>
                            <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </form>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
