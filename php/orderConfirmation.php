<?php
session_start();
require 'dbStore.php'; // Anslutning till store-databasen

if(!isset($_SESSION['user'])){
    header('Location: index.php');
}

$orderId = $_SESSION['latest_order_id'];

// Hämta webbplatsens wallet-id från filen sitewallet.txt
$walletFile = '../payment/sitewallet.txt';
if (!file_exists($walletFile)) {
    echo "<p class='error-message'>Site wallet not found. Please contact support.</p>";
    exit;
}

$siteWalletId = trim(file_get_contents($walletFile));
$cartItems = $_SESSION['cartItems'];
$totalAmount = $_SESSION['totalAmount'];

// Visa order-ID och webbplatsens wallet-id
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Order Confirmation</h1>
        <p>Your order has been successfully reserved! Send the <?php echo $totalAmount ?> Simplecoins to our wallet <br></p>
        <p><strong>Site Wallet ID:</strong> <?php echo $siteWalletId; ?></p>
        <p> Use the wallet ID to complete your payment.</p>
        <a href="/php">Return to Home</a>
    </div>
</body>
</html>
