<?php

require 'dbLogin.php';


function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    return $data;
}

function isPasswordStrong($password) {

    if(isPasswordBlacklisted($password)){
        return false;
    }
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
    $user_email = validate($_POST['user_email']);
    $full_name = validate($_POST['full_name']);
    $adress = validate($_POST['adress']);

    $result = registerUser($username, $password, $user_email, $full_name, $adress, $pdo);


    createWallet();

    if ($result === 'User registered successfully!') {
        header('Location: index.php');
        exit;
    } else {
        $error = $result;
    }
    
}

function registerUser($username, $password, $user_email, $full_name, $adress, $pdo) {
    // Validate and sanitize inputs
    $username = validate($username);
    $password = validate($password);
    $user_email = validate($user_email);
    $full_name = validate($full_name);
    $adress = validate($adress);

    // Check if the username already exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM login WHERE username = ?");
    $stmt->execute([$username]);
    $userExists = $stmt->fetchColumn() > 0;

    if ($userExists) {
        return 'Username already taken';
    }

    // Check if the email already exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM login WHERE user_email = ?");
    $stmt->execute([$user_email]);
    $emailExists = $stmt->fetchColumn() > 0;

    if ($emailExists) {
        return 'Email already in use';
    }

    /*
    if (!isPasswordStrong($password)) {
        return 'Password does not meet strength requirements';
    }*/

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $stmt = $pdo->prepare("INSERT INTO login (username, password, address, user_email, full_name) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$username, $hashedPassword, $user_email, $full_name, $adress]);

    return 'User registered successfully!';
}


function isPasswordBlacklisted($password) {
    $filePath = 'unsecurepswd.txt'; // Filens namn

    // Läs filen till en array, varje rad blir ett element i arrayen
    $blacklistedPasswords = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Kontrollera om lösenordet finns i listan (case-insensitiv jämförelse)
    return in_array(strtolower($password), array_map('strtolower', $blacklistedPasswords));
}

function createWallet(){


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
                <input type="user_email" name="user_email" placeholder="Email" required class="form-input">
            </div>
            
            <div class="form-group">
                <input type="full_name" name="full_name" placeholder="Full name" required class="form-input">
            </div>
            

            <div class="form-group">
                <input type="adress" name="adress" placeholder="Adress" required class="form-input">
            </div>

          
            <button type="submit" class="signup-button">Sign Up</button>

            <a href="index.php" class="signup-button">Go to Login page</a>
        </form>
    </div>
</body>
</html>


