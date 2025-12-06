<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pay Now - Clothify</title>
    <link rel="stylesheet" href="paynow.css">
</head>
<body>

<div class="paynow-wrapper">
    <div class="paynow-card">
        <h2>Pay Now</h2>

        <!-- Dynamic Order Summary -->
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
                <input type="text" placeholder="John Doe">
            </div>
            <div class="form-group">
                <label>Card Number</label>
                <input type="text" placeholder="1234 5678 9012 3456">
            </div>
            <div class="form-inline">
                <div class="form-group">
                    <label>Expiry</label>
                    <input type="text" placeholder="MM/YY">
                </div>
                <div class="form-group">
                    <label>CVV</label>
                    <input type="text" placeholder="123">
                </div>
            </div>
        </div>

        <!-- PayPal Info -->
        <div class="paypal-info" style="display:none;">
            <p>After clicking Pay Now, you will be redirected to PayPal to complete your payment securely.</p>
        </div>

        <!-- Pay Now Button -->
        <button class="pay-btn" id="pay-btn">Pay Now</button>

        <!-- Confirmation Placeholder -->
        <div class="confirmation" id="confirmation" style="display:none;">
            <h3>Payment Confirmation</h3>
            <p>Order Number: <strong id="order-number">#12345</strong></p>
            <p>Total Paid: <strong>Rs. <span id="paid-total">0</span></strong></p>
            <p>Expected Delivery: <strong>3-5 business days</strong></p>
        </div>

    </div>
</div>

<script src="paynow.js"></script>
</body>
</html>
