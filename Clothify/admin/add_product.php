<?php 
include "../config/db.php";

// Fetch categories for dropdown
$categories = $conn->query("SELECT * FROM categories");

// Handle form submission
if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];

    // Handle image upload
    $image = 'default.png';
    if(isset($_FILES['image']) && $_FILES['image']['name'] != '') {
        $image = time().'_'.$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/'.$image);
    }

    $stmt = $conn->prepare("INSERT INTO products(name, category_id, price, stock, description, image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sidiss", $name, $category_id, $price, $stock, $description, $image);
    $stmt->execute();
    $stmt->close();
    header("Location: edit_product.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="sidebar">
        <h2>Clothify Admin</h2>
        <a href="index.php">Dashboard</a>
        <a href="add_product.php">Add Product</a>
        <a href="edit_product.php">Edit Products</a>
        <a href="view_orders.php">Orders</a>
        <a href="manage_users.php">Users</a>
    </div>

    <div class="container">
    <header>Add Product</header>

    <div class="form-wrapper">
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Product Name" required>
            <select name="category_id" required>
                <option value="">Select Category</option>
                <?php while($cat = $categories->fetch_assoc()) { ?>
                    <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                <?php } ?>
            </select>

            <input type="number" step="0.01" name="price" placeholder="Price" required>
            <input type="number" name="stock" placeholder="Stock Quantity" required>
            <textarea name="description" placeholder="Product Description" rows="4" required></textarea>

            <label class="custom-file-label" for="image" id="fileLabel">Choose Image</label>
            <input type="file" name="image" id="image">

            <input type="submit" name="submit" value="Add Product">
        </form>
    </div>
</div>

<script>
const fileInput = document.getElementById('image');
const fileLabel = document.getElementById('fileLabel');

fileInput.addEventListener('change', () => {
    fileLabel.textContent = fileInput.files.length > 0 ? fileInput.files[0].name : 'Choose Image';
});
</script>
</body>
</html>