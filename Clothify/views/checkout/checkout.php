<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Clothify</title>
    <link rel="stylesheet" href="checkout.css">
</head>
<body>

<div class="checkout-container">
    <h2>Checkout</h2>

    <form class="checkout-form">
        <div class="form-group">
            <label for="fullname">Full Name</label>
            <input type="text" id="fullname" placeholder="John Doe" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" placeholder="+92 300 1234567" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" placeholder="example@email.com" required>
        </div>

        <div class="form-group">
            <label for="address">Shipping Address</label>
            <textarea id="address" placeholder="Enter your address" rows="3" required></textarea>
        </div>

        <div class="form-group">
            <label>Payment Method</label>
            <div class="payment-methods">
                <label><input type="radio" name="payment" value="card" checked> Credit/Debit Card</label>
                <label><input type="radio" name="payment" value="cod"> Cash on Delivery</label>
                <label><input type="radio" name="payment" value="paypal"> PayPal</label>
            </div>
        </div>

        <button type="submit" class="pay-btn">Pay Now</button>
    </form>
</div>

</body>
</html>
