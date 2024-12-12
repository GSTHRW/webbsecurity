<?php
session_start();
require 'dbStore.php';

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("CSRF token validation failed.");
}

if(!isset($_SESSION['user'])){
    header('Location: index.php');
}

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
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Your Cart</h1>
        <div class="cart-list">
            <?php foreach ($cartItems as $item): ?>
                <div class="cart-item-container">
                    <h2 class="cart-item-name"><?= htmlspecialchars($item['name']); ?></h2>
                    <p class="cart-item-quantity">Quantity: <?= $_SESSION['cart'][$item['id']]; ?></p>
                    <p class="cart-item-price">Total Price: $<?= $item['price'] * $_SESSION['cart'][$item['id']]; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="checkout.php" class="proceed-to-checkout">Proceed to Checkout</a>
        <a href="store.php" class="proceed-to-checkout">Continue shopping</a>
    </div>
</body>
</html>
