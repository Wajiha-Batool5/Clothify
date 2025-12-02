<?php
/**
 * Migration/backfill script to add missing columns and populate category/price/description for existing products.
 * Run from CLI: `php .\scripts\update_products_metadata.php` or via browser.
 */
chdir(__DIR__ . '/..');
require_once __DIR__ . '/../config/db.php';

$conn = get_db_connection();
if (!$conn) {
    echo "DB connection failed. Check config/db.php.\n";
    exit(1);
}

// helper to check column existence
function column_exists($conn, $table, $column) {
    // Prepared statements don't accept identifiers in this context on some MariaDB versions.
    // Use a safely escaped direct query instead.
    $tableEsc = $conn->real_escape_string($table);
    $colEsc = $conn->real_escape_string($column);
    $sql = "SHOW COLUMNS FROM `{$tableEsc}` LIKE '{$colEsc}'";
    $res = $conn->query($sql);
    if (!$res) return false;
    $exists = ($res->num_rows > 0);
    $res->free();
    return $exists;
}

$table = 'products';

// add missing columns safely
if (!column_exists($conn, $table, 'price')) {
    $conn->query("ALTER TABLE `$table` ADD COLUMN `price` DECIMAL(10,2) DEFAULT 0.00");
    echo "Added column: price\n";
}
if (!column_exists($conn, $table, 'description')) {
    $conn->query("ALTER TABLE `$table` ADD COLUMN `description` TEXT");
    echo "Added column: description\n";
}
if (!column_exists($conn, $table, 'category')) {
    $conn->query("ALTER TABLE `$table` ADD COLUMN `category` VARCHAR(100) DEFAULT ''");
    echo "Added column: category\n";
}

// Backfill existing rows: set category from image path and description from name if empty; set price to 0.00 when NULL.
$res = $conn->query("SELECT id, name, image, price, description, category FROM $table");
$updated = 0;
while ($row = $res->fetch_assoc()) {
    $id = (int)$row['id'];
    $image = $row['image'] ?? '';
    $name = $row['name'] ?? '';
    $price = $row['price'];
    $description = $row['description'];
    $category = $row['category'];

    // derive category
    $cat = '';
    if ($image) {
        $parts = explode('/', str_replace('\\','/', $image));
        $raw = strtolower($parts[0] ?? '');
        if (strpos($raw, 'coord') !== false || strpos($raw, 'co-ord') !== false) {
            $cat = 'co-ords';
        } elseif (strpos($raw, 'party') !== false) {
            $cat = 'party-wear';
        } elseif (strpos($raw, 'wedding') !== false) {
            $cat = 'wedding-wear';
        } else {
            $cat = $raw ?: 'uncategorized';
        }
    }

    $needsUpdate = false;
    $updates = [];
    $params = [];

    if (($price === null || $price === '') && column_exists($conn, $table, 'price')) {
        $updates[] = '`price` = ?';
        $params[] = '0.00';
        $needsUpdate = true;
    }
    if (($description === null || $description === '') && column_exists($conn, $table, 'description')) {
        $updates[] = '`description` = ?';
        $params[] = 'Imported product: ' . ($name ?: 'Product');
        $needsUpdate = true;
    }
    if (($category === null || $category === '') && column_exists($conn, $table, 'category')) {
        $updates[] = '`category` = ?';
        $params[] = $cat;
        $needsUpdate = true;
    }

    if ($needsUpdate && !empty($updates)) {
        $sql = 'UPDATE ' . $table . ' SET ' . implode(', ', $updates) . ' WHERE id = ? LIMIT 1';
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            // bind params dynamically (all strings then id)
            $types = str_repeat('s', count($params)) . 'i';
            $params[] = $id;
            $stmt->bind_param($types, ...$params);
            if ($stmt->execute()) {
                $updated++;
            }
            $stmt->close();
        }
    }
}

echo "Backfill complete. $updated rows updated.\n";

echo "Done. If you want to run the importer again, run: php .\\scripts\\import_images_to_db.php\n";

?>
