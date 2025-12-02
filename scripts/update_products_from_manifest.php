<?php
/**
 * Update products table using a small manifest of richer metadata.
 * Run from project root:
 * php .\scripts\update_products_from_manifest.php
 */
chdir(__DIR__ . '/..');
require_once __DIR__ . '/../config/db.php';

$conn = get_db_connection();
if (!$conn) {
    echo "DB connection failed. Check config/db.php\n";
    exit(1);
}

// Manifest: map image (relative path or filename) => metadata
$manifest = [
    'co-ords/Black Scalloped Embroidered Co-Ord Set (2-Piece).jpg' => [
        'price' => '5000.00',
        'description' => 'A versatile two-piece co-ord set in classic black with scalloped embroidery. Relaxed kurta and matching trousers — great for casual or semi-formal wear.',
        'category' => 'co-ords'
    ],
    'Celeste Ethereal Powder Blue Embroidered Suit.jpg' => [
        'price' => '42000.00',
        'description' => 'Hand-embroidered powder-blue suit with tonal threadwork. Straight kameez and soft dupatta, suitable for daytime parties and formal gatherings.',
        'category' => 'party-wear'
    ],
    'Ethereal Ivory & Gold Bridal Pishwas Lehenga.jpg' => [
        'price' => '670000.00',
        'description' => 'Ivory bridal pishwas lehenga with gold zari and sequin embroidery — voluminous skirt and layered bodice for weddings and special ceremonies.',
        'category' => 'wedding-wear'
    ],
    'Red & White Botanical Printed Co-Ord Set (2-Piece).jpg' => [
        'price' => '4000.00',
        'description' => 'Fresh botanical print co-ord in red and white. Lightweight and breathable for warm-weather outings.',
        'category' => 'co-ords'
    ],
    'Ivory White Tonal Embroidered Suit (New Outfit).jpg' => [
        'price' => '19000.00',
        'description' => 'Tonal ivory suit with delicate embroidery and fine finishing. Versatile for day-to-evening events.',
        'category' => 'party-wear'
    ],
    'Luxurious Dark TealGreen Velvet Jacket & Sharara Ensemble.jpg' => [
        'price' => '150000.00',
        'description' => 'Opulent velvet jacket with coordinated sharara in deep teal-green; rich texture and embroidered accents for festive evenings.',
        'category' => 'wedding-wear'
    ],
    'Emerald Breeze Printed Co-Ord Set.jpg' => [
        'price' => '8000.00',
        'description' => 'Vibrant emerald-printed co-ord with breezy top and tapered trousers; lightweight and playful for relaxed looks.',
        'category' => 'co-ords'
    ],
    'Desert Rose - Camel Embroidered Suit with Deep Plum Dupatta.jpg' => [
        'price' => '70000.00',
        'description' => 'Camel-hued suit with intricate embroidery and contrasting deep-plum dupatta — tailored silhouette for festive occasions.',
        'category' => 'party-wear'
    ],
    'Pastel Grey Organza Kameez with Dusty Pink Gharara.jpg' => [
        'price' => '190000.00',
        'description' => 'Delicate organza kameez paired with a dusty-pink gharara; light, airy layers with subtle embellishment for wedding guests.',
        'category' => 'wedding-wear'
    ],
    'Regal Rani Pink & Gold Layered Bridal Pishwas.jpg' => [
        'price' => '550000.00',
        'description' => 'Regal rani-pink layered bridal pishwas with gold embroidery and rich embellishments — statement-ready for bridal ceremonies.',
        'category' => 'wedding-wear'
    ],
    'Majestic Steel Grey & Gold Open Style Bridal Maxi.jpg' => [
        'price' => '150000.00',
        'description' => 'Elegant steel grey bridal maxi with gold embroidery and open-style detailing. Modern yet traditional, perfect for formal wedding celebrations.',
        'category' => 'wedding-wear'
    ],
    'Mauve Mystique Embroidered Chiffon 3 Piece Suit.jpg' => [
        'price' => '160000.00',
        'description' => 'Beautiful mauve embroidered chiffon suit with intricate thread work. Three-piece ensemble with graceful layers for special occasions.',
        'category' => 'wedding-wear'
    ],
    'The Emerald Bloom Heavy Gold & Thread Embroidered Bridal Ensemble.jpg' => [
        'price' => '240000.00',
        'description' => 'Luxurious emerald-toned bridal ensemble with heavy gold and thread embroidery. Rich detailing for grand wedding ceremonies.',
        'category' => 'wedding-wear'
    ],
    'Royal Ivory & Gold Heavy Bridal Lehenga Frock.jpg' => [
        'price' => '280000.00',
        'description' => 'Royal ivory lehenga frock with heavy gold embroidery and stone work. Majestic silhouette for bridal perfection.',
        'category' => 'wedding-wear'
    ],
    'Regal Maroon Red Pakistani Bridal Lehenga Kameez.jpg' => [
        'price' => '450000.00',
        'description' => 'Deep maroon red Pakistani bridal lehenga with intricate gold work. Classic elegance and regal charm for brides.',
        'category' => 'wedding-wear'
    ],
];

$updated = 0;
$notFound = [];

$stmt = $conn->prepare('UPDATE products SET price = ?, description = ?, category = ? WHERE image LIKE ? OR name = ?');
if (!$stmt) {
    echo "Prepare failed: " . $conn->error . "\n";
    exit(1);
}

foreach ($manifest as $imgKey => $meta) {
    $filename = basename($imgKey);
    $like = '%' . $filename; // match by filename anywhere in image path

    $price = $meta['price'];
    $desc = $meta['description'];
    $cat = $meta['category'];

    $stmt->bind_param('sssss', $price, $desc, $cat, $like, $filename);
    if ($stmt->execute()) {
        $affected = $stmt->affected_rows;
        if ($affected > 0) {
            $updated += $affected;
        } else {
            $notFound[] = $imgKey;
        }
    } else {
        echo "Failed to update for $imgKey: " . $stmt->error . "\n";
    }
}

$stmt->close();

echo "Manifest update finished. $updated rows updated.\n";
if (!empty($notFound)) {
    echo "Products not found for these manifest keys (matched by filename):\n";
    foreach ($notFound as $k) echo " - $k\n";
}

echo "Done. You can verify in phpMyAdmin or run: SELECT id,name,price,category FROM products LIMIT 20;\n";

?>
