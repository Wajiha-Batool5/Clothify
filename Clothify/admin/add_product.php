<?php
include __DIR__ . '/../config/db.php';
include __DIR__ . '/../controllers/ProductController.php';
session_start();

$productController = new ProductController($conn);
$message = '';

if(isset($_POST['submit'])) {

    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // IMAGE UPLOAD HANDLING
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
        $file_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];

        // Get category slug/folder name
        $stmt = $conn->prepare("SELECT slug FROM categories WHERE id = ?");
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $cat = $result->fetch_assoc();
        $category_folder = $cat['slug'];

        // Create folder if it doesn't exist
        $upload_dir = __DIR__ . "/../../assets/images/products/$category_folder/";
        if(!is_dir($upload_dir)){
            mkdir($upload_dir, 0777, true);
        }

        // Rename file to unique name
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $new_file_name = uniqid() . '.' . $ext;

        // Move uploaded file to products folder
        $destination = $upload_dir . $new_file_name;
        if(move_uploaded_file($tmp_name, $destination)){
            // Save path relative to project
            $image_path = "$category_folder/$new_file_name";

            // Insert into DB
            $stmt2 = $conn->prepare("INSERT INTO products (name, category_id, price, description, image, image_path) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt2->bind_param("sidsss", $name, $category_id, $price, $description, $new_file_name, $image_path);
            if($stmt2->execute()){
                $message = "Product added successfully!";
            } else {
                $message = "Database error: ".$stmt2->error;
            }
            $stmt2->close();
        } else {
            $message = "Failed to move uploaded file.";
        }

    } else {
        $message = "Please select an image.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Products</title>
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
    <header>Add Products</header>

<form method="post" enctype="multipart/form-data">
    <label>Name:</label><br>
    <input type="text" name="name" required><br>

    <label>Category:</label><br>
    <select name="category_id" required>
        <?php
        $categories = $conn->query("SELECT * FROM categories")->fetch_all(MYSQLI_ASSOC);
        foreach($categories as $cat){
            echo "<option value='{$cat['id']}'>{$cat['name']}</option>";
        }
        ?>
    </select><br>

    <label>Price:</label><br>
    <input type="number" name="price" step="0.01" required><br>

    <label>Description:</label><br>
    <textarea name="description"></textarea><br>

    <label>Image:</label><br>
    <input type="file" name="image" accept="image/*" required><br><br>

    <input type="submit" name="submit" value="Add Product">
</form>
</div>