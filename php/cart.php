<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'];
    $_SESSION['cart'][$productId] = ($_SESSION['cart'][$productId] ?? 0) + 1;
}

$cartItems = [];
if (!empty($_SESSION['cart'])) {
    $ids = implode(',', array_filter(array_keys($_SESSION['cart'])));
    $stmt = $pdo->query("SELECT * FROM products WHERE id IN ($ids)");
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
</head>
<body>
    <h1>Your Cart</h1>
    <?php foreach ($cartItems as $item): ?>
        <div>
            <h2><?= $item['name']; ?></h2>
            <p>Quantity: <?= $_SESSION['cart'][$item['id']]; ?></p>
            <p>Price: $<?= $item['price'] * $_SESSION['cart'][$item['id']]; ?></p>
        </div>
    <?php endforeach; ?>
    <a href="checkout.php">Proceed to Checkout</a>
</body>
</html>
