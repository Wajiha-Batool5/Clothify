// Load total from sessionStorage (you can change to PHP session if needed)
let totalAmount = sessionStorage.getItem("cart_total");
let cartItems = JSON.parse(sessionStorage.getItem("cart_items") || "[]");

// Display cart items
const orderItemsDiv = document.getElementById("order-items");
orderItemsDiv.innerHTML = "";

if (cartItems.length > 0) {
    cartItems.forEach(item => {
        orderItemsDiv.innerHTML += `
            <p>${item.name} — Qty: ${item.quantity} — Rs. ${item.price}</p>
        `;
    });
} else {
    orderItemsDiv.innerHTML = "<p>No items in cart</p>";
}

// Show total amount
document.getElementById("total-amount").innerText = totalAmount || 0;

// Pay button logic
document.getElementById("pay-btn").addEventListener("click", function () {

    // (Optional) simple validation for card payments
    let payment = document.querySelector("input[name='payment']:checked").value;

    if (payment === "card") {
        let name = document.getElementById("card-name").value;
        let number = document.getElementById("card-number").value;
        let expiry = document.getElementById("expiry").value;
        let cvv = document.getElementById("cvv").value;

        if (!name || !number || !expiry || !cvv) {
            alert("Please fill all card details!");
            return;
        }
    }

    // Redirect to confirmation page + pass total
    window.location.href = "../confirmation/confirmation.php?total=" + totalAmount;
});
