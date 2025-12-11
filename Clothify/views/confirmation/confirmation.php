<?php
// Read total from URL
$total = isset($_GET['total']) ? $_GET['total'] : 0;

// Create random order number
$orderNumber = "ORD-" . rand(100000, 999999);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation - Clothify</title>
    <link rel="stylesheet" href="../../assets/css/confirmation.css">
</head>
<body>

<div class="confirm-wrapper">
    <div class="confirm-card">

        <h2>Payment Successful</h2>
        <p class="thank-you">Thanks for your purchase!</p>

        <p><strong>Order Number:</strong> <?php echo $orderNumber; ?></p>
        <p><strong>Total Paid:</strong> Rs. <?php echo $total; ?></p>
        <p><strong>Delivery Time:</strong> 3 to 5 business days</p>

        <a href="http://localhost/project/Clothify/index.php" class="back-home">Return to Home</a>
    </div>
</div>

</body>
</html>
