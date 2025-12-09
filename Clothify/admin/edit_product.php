<?php 
include "../config/db.php";

// Handle product deletion
if(isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Optional: delete product image from uploads folder
    $imgRes = $conn->query("SELECT image FROM products WHERE id=$id");
    if($imgRes->num_rows > 0){
        $row = $imgRes->fetch_assoc();
        if($row['image'] != 'default.png' && file_exists('uploads/'.$row['image'])){
            unlink('uploads/'.$row['image']);
        }
    }

    $conn->query("DELETE FROM products WHERE id=$id");
    header("Location: edit_product.php"); // refresh the page after deletion
    exit;
}

// Handle product update
if(isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];

    $image = $_POST['current_image']; // keep old if no new image
    if(isset($_FILES['image']) && $_FILES['image']['name'] != '') {
        $image = time().'_'.$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/'.$image);
    }

    $stmt = $conn->prepare("UPDATE products SET name=?, category_id=?, price=?, stock=?, description=?, image=? WHERE id=?");
    $stmt->bind_param("sidissi", $name, $category_id, $price, $stock, $description, $image, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: edit_product.php");
}

// Fetch products and categories
$products = $conn->query("SELECT p.*, c.name as cat_name FROM products p JOIN categories c ON p.category_id=c.id");
$categories = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Products</title>
    <link rel="stylesheet" href="admin.css">
    <style>
        /* Modal styling */
        .modal { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center; }
        .modal-content { background:#fff0f6; padding:20px; border-radius:10px; width:400px; max-width:90%; position:relative; }
        .close { position:absolute; top:10px; right:15px; cursor:pointer; font-size:22px; font-weight:bold; color:#900c3f; }
    </style>
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
    <header>Edit Products</header>

    <table>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Actions</th>
        </tr>
        <?php while($p = $products->fetch_assoc()) { 
            $img = $p['image'] ? "uploads/{$p['image']}" : "uploads/default.png";
        ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><img src="<?= $img ?>" alt="Product"></td>
            <td><?= $p['name'] ?></td>
            <td><?= $p['cat_name'] ?></td>
            <td><?= $p['price'] ?></td>
            <td><?= $p['stock'] ?></td>
            <td>
                <button class="btn editBtn" 
                    data-id="<?= $p['id'] ?>"
                    data-name="<?= $p['name'] ?>"
                    data-category="<?= $p['category_id'] ?>"
                    data-price="<?= $p['price'] ?>"
                    data-stock="<?= $p['stock'] ?>"
                    data-description="<?= $p['description'] ?>"
                    data-image="<?= $p['image'] ?>">Edit</button>
                <a class="btn" href="edit_product.php?action=delete&id=<?= $p['id'] ?>" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

<!-- Modal -->
<div class="modal" id="editModal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" id="modal_id">
            <input type="hidden" name="current_image" id="modal_image">
            <input type="text" name="name" id="modal_name" placeholder="Product Name" required>
            <select name="category_id" id="modal_category" required>
                <option value="">Select Category</option>
                <?php $categories->data_seek(0); while($cat=$categories->fetch_assoc()){ ?>
                <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                <?php } ?>
            </select>
            <input type="number" step="0.01" name="price" id="modal_price" placeholder="Price" required>
            <input type="number" name="stock" id="modal_stock" placeholder="Stock Quantity" required>
            <textarea name="description" id="modal_description" rows="4" placeholder="Product Description" required></textarea>
            <input type="file" name="image">
            <input type="submit" name="update" value="Update Product">
        </form>
    </div>
</div>

<script>
const modal = document.getElementById('editModal');
const closeBtn = document.querySelector('.close');
const editBtns = document.querySelectorAll('.editBtn');

editBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        modal.style.display = 'flex';
        document.getElementById('modal_id').value = btn.dataset.id;
        document.getElementById('modal_name').value = btn.dataset.name;
        document.getElementById('modal_category').value = btn.dataset.category;
        document.getElementById('modal_price').value = btn.dataset.price;
        document.getElementById('modal_stock').value = btn.dataset.stock;
        document.getElementById('modal_description').value = btn.dataset.description;
        document.getElementById('modal_image').value = btn.dataset.image;
    });
});

closeBtn.addEventListener('click', () => modal.style.display = 'none');
window.addEventListener('click', e => { if(e.target == modal) modal.style.display = 'none'; });
</script>
</body>
</html>
