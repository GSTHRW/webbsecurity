<?php
require 'db.php';

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Store</title>
</head>
<body>
    <h1>Products</h1>
    <?php foreach ($products as $product): ?>
        <div>
            <h2><?= $product['name']; ?></h2>
            <p>Price: $<?= $product['price']; ?></p>
            <p>Days old: <?= $product['age']; ?></p>
            <form action="cart.php" method="POST">
                <button type="submit">Add to Cart</button>
            </form>
        </div>
    <?php endforeach; ?>
</body>
</html>