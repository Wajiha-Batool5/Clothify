<?php
/**
 * Product model - simple DB accessor.
 * Expects `get_db_connection()` to be available from `config/db.php`.
 */
class Product
{
    public static function find(int $id)
    {
        if ($id <= 0) {
            return null;
        }

        if (!function_exists('get_db_connection')) {
            return null;
        }

        $conn = get_db_connection();
        if (!$conn) {
            return null;
        }

        $stmt = $conn->prepare('SELECT id, name, price, image, description, category FROM products WHERE id = ? LIMIT 1');
        if (!$stmt) {
            return null;
        }
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if (!$row) {
            return null;
        }

        // add default empty features and ensure category exists
        $row['features'] = [];
        if (!isset($row['category'])) $row['category'] = '';

        return $row;
    }

    public static function all()
    {
        if (!function_exists('get_db_connection')) {
            return null;
        }
        $conn = get_db_connection();
        if (!$conn) {
            return null;
        }
        $res = $conn->query('SELECT id, name, price, image, description, category FROM products ORDER BY id ASC');
        if (!$res) return [];
        $out = [];
        while ($row = $res->fetch_assoc()) {
            $row['features'] = []; // default empty features
            if (!isset($row['category'])) $row['category'] = '';
            $out[] = $row;
        }
        return $out;
    }

    public static function byCategory($category)
    {
        if (!function_exists('get_db_connection')) {
            return null;
        }
        $conn = get_db_connection();
        if (!$conn) {
            return null;
        }
        
        $stmt = $conn->prepare('SELECT id, name, price, image, description, category FROM products WHERE category = ? ORDER BY id ASC');
        if (!$stmt) {
            return [];
        }
        
        $stmt->bind_param('s', $category);
        $stmt->execute();
        $res = $stmt->get_result();
        $out = [];
        while ($row = $res->fetch_assoc()) {
            $row['features'] = [];
            if (!isset($row['category'])) $row['category'] = '';
            $out[] = $row;
        }
        $stmt->close();
        return $out;
    }
}
