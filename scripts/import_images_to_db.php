<?php
/**
 * Scan assets/images/products and import images as products into DB.
 * Run from browser or CLI: http://localhost/.../scripts/import_images_to_db.php
 */
chdir(__DIR__ . '/..'); // ensure relative paths work
require_once __DIR__ . '/../config/db.php';

$conn = get_db_connection();
if (!$conn) {
    echo "DB connection failed. Edit config/db.php with correct credentials and ensure MySQL is running.";
    exit;
}

// create table if not exists (safe) - also add missing columns if table exists
$create = "CREATE TABLE IF NOT EXISTS `products` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `price` DECIMAL(10,2) DEFAULT 0.00,
    `image` VARCHAR(255),
    `description` TEXT,
    `category` VARCHAR(100) DEFAULT '',
    `features` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
$conn->query($create);

// scan directory
$baseDir = 'assets/images/products';
if (!is_dir($baseDir)) {
    echo "Images directory not found: $baseDir";
    exit;
}

$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($baseDir));
$filesImported = 0;
$stmt = $conn->prepare('SELECT id FROM products WHERE image = ? LIMIT 1');
$ins = $conn->prepare('INSERT INTO products (name, image, price, description, category) VALUES (?, ?, ?, ?, ?)');

foreach ($rii as $file) {
    if ($file->isDir()) continue;
    $ext = strtolower(pathinfo($file->getFilename(), PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg','jpeg','png','gif','webp'])) continue;

    $relative = str_replace('\\', '/', substr($file->getPathname(), strlen($baseDir) + 1));
    // check exists
    $stmt->bind_param('s', $relative);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $res->fetch_assoc()) {
        continue; // already in DB
    }

    // generate a sensible name from filename
    $name = pathinfo($file->getFilename(), PATHINFO_FILENAME);
    $name = str_replace(['-','_'], ' ', $name);
    $name = preg_replace('/\s+/', ' ', $name);
    $name = ucwords($name);
    // derive category from first directory segment
    $partsForCat = explode('/', $relative);
    $rawCat = strtolower($partsForCat[0] ?? '');
    $cat = '';
    if (strpos($rawCat, 'coord') !== false || strpos($rawCat, 'co-ord') !== false || strpos($rawCat, 'co-ords') !== false) {
        $cat = 'co-ords';
    } elseif (strpos($rawCat, 'party') !== false) {
        $cat = 'party-wear';
    } elseif (strpos($rawCat, 'wedding') !== false) {
        $cat = 'wedding-wear';
    } else {
        // fallback keep raw directory name
        $cat = $rawCat ?: 'uncategorized';
    }

    // default price and description (can be updated later by backfill script)
    $price = '0.00';
    $desc = 'Imported product: ' . $name;

    $ins->bind_param('sssss', $name, $relative, $price, $desc, $cat);
    if ($ins->execute()) {
        $filesImported++;
    }
}

echo "Import complete. $filesImported new products added.";
