<form action="add_faq.php" method="POST">
    <input type="text" name="question" placeholder="FAQ Question" required>
    <textarea name="answer" placeholder="FAQ Answer"></textarea>
    <input type="submit" value="Add FAQ">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../includes/db.php');  // Include the database connection

    $question = $_POST['question'];
    $answer = $_POST['answer'];

    // Insert new FAQ into the database
    $sql = "INSERT INTO faqs (question, answer) VALUES ('$question', '$answer')";
    mysqli_query($conn, $sql);

    header('Location: manage_faqs.php');  // Redirect to FAQ management page
}
?>
