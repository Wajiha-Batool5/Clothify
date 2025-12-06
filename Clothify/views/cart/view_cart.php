<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <link rel="stylesheet" href="addtocart.css">
</head>
<body>

    <div class="cart-container">
        <h2>Your Cart</h2>

        <!-- Dynamic cart items will appear here -->
        <div id="cartItems"></div>

        <button class="checkout-btn">Checkout</button>
    </div>

<script>
    // Function to display selected item dynamically
    function addToCart(name, price, img) {
        document.getElementById("cartItems").innerHTML = `
            <div class="cart-item">
                <img src="${img}" alt="">
                <div class="item-details">
                    <h4>${name}</h4>
                    <p>Price: Rs. <span id="price">${price}</span></p>

                    <div class="qty-box">
                        <button class="qty-btn" onclick="changeQty(-1)">-</button>
                        <span id="quantity">1</span>
                        <button class="qty-btn" onclick="changeQty(1)">+</button>
                    </div>

                    <p>Total: Rs. <span id="total">${price}</span></p>
                </div>
            </div>
        `;
    }

    function changeQty(num) {
        let qty = parseInt(document.getElementById("quantity").innerText);
        let price = parseInt(document.getElementById("price").innerText);

        qty += num;
        if (qty < 1) qty = 1;

        document.getElementById("quantity").innerText = qty;
        document.getElementById("total").innerText = qty * price;
    }

    // Sample item — remove in production, call addToCart dynamically
    addToCart("Product", 1500, "https://via.placeholder.com/90");
</script>

</body>
</html>
