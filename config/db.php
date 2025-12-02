<?php
/**
 * Simple MySQL connection helper for XAMPP (default root user, empty password).
 * Update credentials below if your setup differs.
 */
function get_db_connection()
{
    static $conn = null;

    if ($conn !== null) {
        return $conn;
    }

    // --- Edit these to match your XAMPP MySQL credentials ---
    $host = '127.0.0.1';
    $port = 3307; // your MySQL port
    $user = 'root';
    $pass = ''; // set to your MySQL root password if any
    $db   = 'clothify'; // the database name created by seed_products.sql

    // Try to connect but handle exceptions gracefully so application can fallback
    try {
        $conn = new mysqli($host, $user, $pass, $db, $port);
        if ($conn->connect_errno) {
            error_log('DB connection failed: ' . $conn->connect_error);
            return null;
        }
        $conn->set_charset('utf8mb4');
        return $conn;
    } catch (mysqli_sql_exception $e) {
        // log and return null so pages fall back to hardcoded data
        error_log('DB connection exception: ' . $e->getMessage());
        return null;
    }
}
# Database connection file