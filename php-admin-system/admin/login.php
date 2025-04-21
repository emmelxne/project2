<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../includes/db.php');  // Include database connection

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check if the user exists in the database
    $sql = $con->query("SELECT * FROM admins WHERE username = '$username'");
    $result = $sql->fetch_assoc();


    if ($result<>NULL) {
        $pw = $result['password'];
        if($pw<>$password){
            echo "Invalid username or password.";
        }else{
            session_start();
            $_SESSION['admin_username'] = $username;
            header("Location: admin_panel.php");
            exit;   
        }
    } else {
        echo "Invalid username or password.";
    }
}
?>

<!-- Login form -->
<form action="login.php" method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="submit" value="Login">
</form>
