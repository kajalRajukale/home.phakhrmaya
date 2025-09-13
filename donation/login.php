<?php
session_start();

// Set your password here
$adminUser = "admin";
$adminPassword = 'only-for-sb';


// If already logged in, redirect to protected page
if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    header("Location: admin.php"); // change to your protected page
    exit;
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';


    if ($username === $adminUser && $password === $adminPassword) {
        $_SESSION['authenticated'] = true;
        $_SESSION['username'] = $username;
        header("Location: admin.php"); // redirect after login
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
</head>
<body>
  <h2>Login</h2>

  <?php if (!empty($error)): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
  <?php endif; ?>

  <form method="post" action="login.php">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required>
    <br><br>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <br><br>

    <button type="submit">Login</button>
  </form>
</body>
</html>
