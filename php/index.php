<?php
session_start();
require 'dbLogin.php';

$error = '';


if(isset($_SESSION['user'])){
    header('Location: store.php');
}

$maxAttempts = 3; 
$lockoutDuration = 20;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_SESSION['failed_login_attempts'])) {
        $_SESSION['failed_login_attempts'] = 0;
    }

    if ($_SESSION['failed_login_attempts'] >= $maxAttempts) {
        $_SESSION['lockout_time'] = time() + $lockoutDuration;
    }

    if(isset($_SESSION['lockout_time']) && $_SESSION['lockout_time'] > time()){
        $_SESSION['failed_login_attempts'] = 0;
        die("Account is temporarily locked for 5 Please try again later.");
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM login WHERE username = '$username'";
    $stmt = $pdo->query($sql); // Using query() instead of prepare() makes it more vulnerable
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    /*$stmt = $pdo->prepare("SELECT * FROM login WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);*/
    //echo $user['password'];

    // Verify the user and password
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['username']; // Store username in session
        header('Location: store.php'); // Redirect to the store
        exit;
    } else {
        $_SESSION['failed_login_attempts']++;
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
        <form action="index.php" method="POST" class="login-form">
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
