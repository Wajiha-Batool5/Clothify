<?php
/**
 * Direct price update for specific products by name matching
 */
chdir(__DIR__ . '/..');
require_once __DIR__ . '/../config/db.php';

$conn = get_db_connection();
if (!$conn) {
    echo "DB connection failed\n";
    exit(1);
}

// Map product names to prices (exact name matching)
$updates = [
    'The Emerald Bloom' => '240000.00',
    'Emerald Bloom' => '240000.00',
];

$updated = 0;
$stmt = $conn->prepare('UPDATE products SET price = ? WHERE name LIKE ?');

foreach ($updates as $namePattern => $price) {
    $like = '%' . $namePattern . '%';
    $stmt->bind_param('ss', $price, $like);
    if ($stmt->execute()) {
        $affected = $stmt->affected_rows;
        if ($affected > 0) {
            echo "Updated '$namePattern' — $affected rows set to Rs $price\n";
            $updated += $affected;
        }
    }
}

$stmt->close();
echo "Done. Total $updated rows updated.\n";

?>
