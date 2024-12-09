<?php

require 'dbLogin.php';


function validate($data) {
    $data = trim($data);
    return $data;
}

function isPasswordStrong($password) {
    // Check if password meets strength requirements
    $length = strlen($password) >= 8; // Minimum length
    $uppercase = preg_match('/[A-Z]/', $password); // At least one uppercase letter
    $lowercase = preg_match('/[a-z]/', $password); // At least one lowercase letter
    $number = preg_match('/[0-9]/', $password); // At least one number
    $specialChar = preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password); // At least one special character

    return $length && $uppercase && $lowercase && $number && $specialChar;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = validate($_POST['username']);
    $password = validate($_POST['password']);
    $adress = validate($_POST['adress']);

    $result = registerUser($username, $password, $adress, $pdo);

    if ($result === 'User registered successfully!') {
        $success = $result;
    } else {
        $error = $result;
    }
}

function registerUser($username, $password, $adress, $pdo) {
    // Validate and sanitize inputs
    $username = validate($username);
    $password = validate($password);
    $adress = validate($adress);

    // Check if the username already exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM login WHERE username = ?");
    $stmt->execute([$username]);
    $userExists = $stmt->fetchColumn() > 0;

    if ($userExists) {
        return 'Username already taken';
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $stmt = $pdo->prepare("INSERT INTO login (username, password, address) VALUES (?, ?, ?)");
    $stmt->execute([$username, $hashedPassword, $adress]);

    return 'User registered successfully!';
}




?>
<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Sign Up</h1>
        <?php if ($error): ?>
            <p class="error-message"><?= htmlspecialchars($error); ?></p>
        <?php elseif ($success): ?>
            <p class="success-message"><?= htmlspecialchars($success); ?></p>
        <?php endif; ?>
        <form action="createUser.php" method="POST" class="signup-form">
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required class="form-input">
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required class="form-input">
            </div>
            <div class="form-group">
                <input type="adress" name="adress" placeholder="Adress" required class="form-input">
            </div>
            <button type="submit" class="signup-button">Sign Up</button>
        </form>
    </div>
</body>
</html>


