<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $total = array_sum(array_map(function ($id, $qty) use ($pdo) {
        $stmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn() * $qty;
    }, array_keys($_SESSION['cart']), $_SESSION['cart']));

    $stmt = $pdo->prepare("INSERT INTO orders (user_name, user_email, total) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $total]);
    $orderId = $pdo->lastInsertId();

    foreach ($_SESSION['cart'] as $id => $qty) {
        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->execute([$orderId, $id, $qty]);
    }

    $_SESSION['cart'] = [];
    echo "<p class='success-message'>Order placed successfully!</p>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Checkout</h1>
        <form action="checkout.php" method="POST" class="checkout-form">
            <div class="form-group">
                <input type="text" name="name" placeholder="Full Name" required class="form-input">
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required class="form-input">
            </div>
            <button type="submit" class="checkout-button">Place Order</button>
        </form>
    </div>
</body>
</html>
