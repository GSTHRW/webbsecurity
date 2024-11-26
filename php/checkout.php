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
    echo "Order placed successfully!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
</head>
<body>
    <h1>Checkout</h1>
    <form action="checkout.php" method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <button type="submit">Place Order</button>
    </form>
</body>
</html>
