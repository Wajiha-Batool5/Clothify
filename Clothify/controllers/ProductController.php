<?php

function getProductsByCategory($conn, $categoryId) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE category_id = ?");
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    return $stmt->get_result();
}
