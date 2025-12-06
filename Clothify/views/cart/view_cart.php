<?php
session_start();
if(!isset($_SESSION['user_id'])){
    die("Please login to view your cart. <a href='../auth/login.php'>Login</a>");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <link rel="stylesheet" href="../../assets/css/addtocart.css">
</head>
<body>

<div class="cart-container">
    <h2>Your Cart</h2>
    <div id="cartItems"></div>
    <button class="checkout-btn" id="checkoutBtn">Checkout</button>
</div>

<script>
const cartContainer = document.getElementById("cartItems");

function fetchCart() {
    fetch('../../api/get_cart.php')
    .then(res => res.json())
    .then(cartItems => {
        renderCart(cartItems);
    });
}

function renderCart(cartItems) {
    cartContainer.innerHTML = '';

    if(cartItems.length === 0){
        cartContainer.innerHTML = '<p>Your cart is empty.</p>';
        document.getElementById("checkoutBtn").style.display = 'none';
        return;
    } else {
        document.getElementById("checkoutBtn").style.display = 'inline-block';
    }

    cartItems.forEach(item => {
        const div = document.createElement('div');
        div.classList.add('cart-item');
        div.innerHTML = `
            <img src="../../assets/images/products/${item.image}" alt="">
            <div class="item-details">
                <h4>${item.name}</h4>
                <p>Price: Rs. <span class="price">${item.price}</span></p>

                <div class="qty-box">
                    <button class="qty-btn" onclick="changeQty(${item.product_id}, -1)">-</button>
                    <span class="quantity" id="qty-${item.product_id}">${item.quantity}</span>
                    <button class="qty-btn" onclick="changeQty(${item.product_id}, 1)">+</button>
                </div>

                <p>Total: Rs. <span class="total" id="total-${item.product_id}">${item.price * item.quantity}</span></p>

                <button class="remove-btn" onclick="removeItem(${item.product_id})">Remove</button>
            </div>
        `;
        cartContainer.appendChild(div);
    });
}

// Update quantity via AJAX
function changeQty(productId, num){
    const qtyEl = document.getElementById(`qty-${productId}`);
    let qty = parseInt(qtyEl.innerText);
    qty += num;
    if(qty < 1) qty = 1;

    // Send update to DB
    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append('quantity', qty);

    fetch('../../api/update_cart.php', {
        method: 'POST',
        body: formData
    }).then(() => fetchCart());
}

// Remove item via AJAX
function removeItem(productId){
    if(confirm("Remove this item from cart?")){
        fetch(`../../api/remove_cart_item.php?product_id=${productId}`)
        .then(() => fetchCart());
    }
}

// Checkout button
document.getElementById("checkoutBtn").addEventListener('click', () => {
    window.location.href = '../../checkout/checkout.php';
});

// Initial load
fetchCart();
</script>

</body>
</html>
