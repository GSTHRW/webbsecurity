<?php
require 'db.php';

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Store</title>
    <link rel="stylesheet" href="php/styles.css">
</head>
<body>
    <div class="container">
        <h1>Products</h1>
        <div class="product-list">
            <?php foreach ($products as $product): ?>
                <div class="product-container">
                    <h2 class="product-name"><?= htmlspecialchars($product['name']); ?></h2>
                    <p class="product-price">Price: $<?= htmlspecialchars($product['price']); ?></p>
                    <p class="product-age">Days old: <?= htmlspecialchars($product['age']); ?></p>
                    <form action="cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']); ?>">
                        <button class="add-to-cart" type="submit">Add to Cart</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
