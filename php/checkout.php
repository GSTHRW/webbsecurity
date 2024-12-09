<?php
session_start();

require 'dbStore.php'; // Anslutning till store-databasen

// Kontrollera om kundvagnen är tom
if (empty($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    echo "<p class='error-message'>Your cart is empty. Please add items to proceed.</p>";
    header("Refresh: 3; url=/cart");
    exit;
}

$total = 0;
$cartItems = [];

// Hämta produktinformation från databasen och beräkna totalbeloppet
foreach ($_SESSION['cart'] as $id => $qty) {
    $stmt = $pdo->prepare("SELECT name, price FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($product) {
        $productTotal = $product['price'] * $qty;
        $total += $productTotal;
        $cartItems[] = [
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $qty,
            'total' => $productTotal
        ];
    }
}

// Om användaren klickar på "Confirm and Pay"

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {
        /*
        // Lägg till order i store-databasens orders-tabell
        $stmt = $pdoStore->prepare("INSERT INTO orders (username, address, total) VALUES (?, ?, ?)");
        $stmt->execute([$username, $address, $total]);

        // Hämta det senaste order-ID:t
        $orderId = $pdoStore->lastInsertId();

        // Lägg till varje produkt i order_items-tabellen
        foreach ($cartItems as $item) {
            $stmt = $pdoStore->prepare("INSERT INTO order_items (product_id, quantity, order_id) VALUES (?, ?, ?)");
            $stmt->execute([$id, $item['quantity'], $orderId]);
        }
*/
        // Töm kundvagnen och spara order-ID i session
        $_SESSION['cartItems'] = $cartItems;
        $_SESSION['totalAmount'] = $total;
        
        $_SESSION['latest_order_id'] = $orderId;



        // Skicka användaren till bekräftelsesidan
        header("Location: orderConfirmation.php");
        exit;
    } catch (Exception $e) {
        error_log("Order error: " . $e->getMessage());
        echo "<p class='error-message'>Something went wrong while processing your order. Please try again later.</p>";
        header("Refresh: 5; url=/php/checkout");
        exit;
    }
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
        <h2>Order Summary</h2>
        <table class="order-summary">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo number_format($item['price'], 2); ?> $</td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo number_format($item['total'], 2); ?> $</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right;">Total:</td>
                    <td><?php echo number_format($total, 2); ?> $</td>
                </tr>
            </tfoot>
        </table>

        <form method="POST" action="checkout.php">
            <input type="hidden" name="username" value="testuser"> <!-- Replace with actual user data -->
            <input type="hidden" name="address" value="testaddress"> <!-- Replace with actual address -->
            <button type="submit" id="confirmAndPayButton" class="confirmAndPayButton">Confirm and Pay</button>
        </form>
    </div>
</body>
</html>
