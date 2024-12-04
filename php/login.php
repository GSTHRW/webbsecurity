<?php
session_start();
require 'dbLogin.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

   
    $stmt = $pdo->prepare("SELECT * FROM login WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify the user and password
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['username']; // Store username in session
        header('Location: store.php'); // Redirect to the store
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <?php if ($error): ?>
            <p class="error-message"><?= htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST" class="login-form">
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required class="form-input">
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required class="form-input">
            </div>
            <button type="submit" class="login-button">Login</button>
        </form>
        <a href="createUser.php" class="signup-button">Sign Up</a>
    </div>
</body>
</html>
