<?php
session_start();

// Hardcoded admin credentials
$admin_user = "admin";
$admin_pass = "admin888"; 

$error = "";                   // Will store error message if login fails

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ✅ Get username & password from form input
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // ✅ Check if the credentials match the hardcoded ones
    if ($username === $admin_user && $password === $admin_pass) {
        $_SESSION['is_admin'] = true;           // ✅ Set session to true
        header("Location: admin_faq.php");      // ✅ Redirect to admin panel
        exit();
    } else {
        $error = "Invalid username or password.";  // ❌ Set error if login fails
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center vh-100">
    <form method="post" class="border p-4 bg-light rounded shadow" style="min-width: 300px;">
        <h4 class="mb-3 text-center">Admin Login</h4>

        <!-- ❗ Show error message if credentials are wrong -->
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <!-- 🧍 Username Input -->
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required />
        </div>

        <!-- 🔒 Password Input -->
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required />
        </div>

        <!-- ✅ Submit Button -->
        <button class="btn btn-primary w-100">Login</button>
    </form>
</body>
</html>
