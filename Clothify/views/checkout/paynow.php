<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pay Now - Clothify</title>
    <link rel="stylesheet" href="../../assets/css/paynow.css">
</head>
<body>

<div class="paynow-wrapper">
    <div class="paynow-card">
        <h2>Pay Now</h2>

        <!-- Order Summary -->
        <div class="order-summary">
            <h3>Order Summary</h3>
            <div id="order-items">
                <p>No items in cart</p>
            </div>
            <div class="order-total">
                Total: Rs. <span id="total-amount">0</span>
            </div>
        </div>

        <!-- Payment Method -->
        <div class="payment-method">
            <h3>Payment Method</h3>
            <label><input type="radio" name="payment" value="card" checked> Credit/Debit Card</label>
            <label><input type="radio" name="payment" value="paypal"> PayPal</label>
        </div>

        <!-- Card Details -->
        <div class="card-details">
            <h3>Card Information</h3>
            <div class="form-group">
                <label>Cardholder Name</label>
                <input type="text" id="card-name">
            </div>
            <div class="form-group">
                <label>Card Number</label>
                <input type="text" id="card-number">
            </div>
            <div class="form-inline">
                <div class="form-group">
                    <label>Expiry</label>
                    <input type="text" id="expiry">
                </div>
                <div class="form-group">
                    <label>CVV</label>
                    <input type="text" id="cvv">
                </div>
            </div>
        </div>

        <!-- PayPal Info -->
        <div class="paypal-info" style="display:none;">
            <p>You will be redirected to PayPal after clicking Pay Now.</p>
        </div>

        <!-- Pay Button -->
        <button class="pay-btn" id="pay-btn">Pay Now</button>

    </div>
</div>

<script src="paynow.js"></script>
</body>
</html>
