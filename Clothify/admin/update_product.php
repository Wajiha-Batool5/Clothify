<?php
include "../config/db.php";

$id = $_GET['id'];

$product = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();

if(isset($_POST['update'])){
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    if($_FILES['image']['name'] != ""){
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/$image");
    } else {
        $image = $product['image'];
    }

    $sql = "UPDATE products SET 
            name='$name',
            price='$price',
            description='$description',
            image='$image'
            WHERE id=$id";

    if($conn->query($sql)){
        echo "Updated!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<h2>Edit Product</h2>

<form method="POST" enctype="multipart/form-data">
    Name: <input type="text" name="name" value="<?= $product['name'] ?>"><br><br>
    Price: <input type="number" name="price" value="<?= $product['price'] ?>"><br><br>

    Description:
    <textarea name="description"><?= $product['description'] ?></textarea>
    <br><br>

    Image: <input type="file" name="image"><br>
    <img src="uploads/<?= $product['image'] ?>" width="100"><br><br>

    <button name="update">Update</button>
</form>

</body>
</html>
