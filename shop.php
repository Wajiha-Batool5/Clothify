<?php include "views/include/header.php"; ?>

<?php
// Get selected category from URL query
$selectedCategory = isset($_GET['category']) ? trim($_GET['category']) : '';

// Attempt to load products from DB. If DB is available and has rows, we'll use those.
$dbProducts = null;
if (file_exists(__DIR__ . '/config/db.php') && file_exists(__DIR__ . '/models/Product.php')) {
    require_once __DIR__ . '/config/db.php';
    require_once __DIR__ . '/models/Product.php';
    
    if ($selectedCategory) {
        // Load products for selected category only
        $dbProducts = Product::byCategory($selectedCategory);
    } else {
        // Load all products
        $dbProducts = Product::all();
    }
}
?>

<div class="shop-page">
    <h2>Clothify's Products</h2>

    <!-- Category Filter Links -->
    <div class="category-filter" style="margin: 20px 0; text-align: center;">
        <a href="shop.php" style="margin: 0 15px; padding: 8px 16px; text-decoration: none; color: #333; border: 2px solid #ddd; border-radius: 4px; <?php echo !$selectedCategory ? 'background: #ff69b4; color: white; border-color: #ff69b4;' : ''; ?>">All Products</a>
        <a href="shop.php?category=co-ords" style="margin: 0 15px; padding: 8px 16px; text-decoration: none; color: #333; border: 2px solid #ddd; border-radius: 4px; <?php echo $selectedCategory === 'co-ords' ? 'background: #ff69b4; color: white; border-color: #ff69b4;' : ''; ?>">Co-Ords</a>
        <a href="shop.php?category=party-wear" style="margin: 0 15px; padding: 8px 16px; text-decoration: none; color: #333; border: 2px solid #ddd; border-radius: 4px; <?php echo $selectedCategory === 'party-wear' ? 'background: #ff69b4; color: white; border-color: #ff69b4;' : ''; ?>">Party Wear</a>
        <a href="shop.php?category=wedding-wear" style="margin: 0 15px; padding: 8px 16px; text-decoration: none; color: #333; border: 2px solid #ddd; border-radius: 4px; <?php echo $selectedCategory === 'wedding-wear' ? 'background: #ff69b4; color: white; border-color: #ff69b4;' : ''; ?>">Wedding Wear</a>
    </div>

    <div class="product-grid">

        <?php if (!empty($dbProducts) && is_array($dbProducts)): ?>
            <?php foreach ($dbProducts as $p):
                // build url-encoded image path
                $raw = isset($p['image']) ? str_replace('\\','/',$p['image']) : '';
                $imgSrc = '';
                if ($raw !== '') {
                    $parts = explode('/', $raw);
                    $filename = array_pop($parts);
                    $dir = implode('/', $parts);
                    $imgSrc = ($dir ? 'assets/images/products/' . $dir . '/' : 'assets/images/products/') . rawurlencode($filename);
                }
            ?>
                <div class="product-card">
                    <img src="<?= $imgSrc ?: 'assets/images/products/placeholder.jpg' ?>" alt="<?= htmlspecialchars($p['name']) ?>">
                    <p class="name"><?= htmlspecialchars($p['name']) ?></p>
                    <p class="price"><?= htmlspecialchars($p['price']) ?></p>
                    <a href="views/products/product_detail.php?id=<?= (int)$p['id'] ?>" class="btn-sm">View</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>

        <div class="product-card">
            <?php
            $raw = 'assets/images/products/co-ords/Black Scalloped Embroidered Co-Ord Set (2-Piece).jpg';
            $raw = str_replace('\\', '/', $raw);
            $parts = explode('/', $raw);
            $filename = array_pop($parts);
            $dir = implode('/', $parts);
            $imgSrc = ($dir ? $dir . '/' : '') . rawurlencode($filename);
            ?>
            <img src="<?= $imgSrc ?>" alt="Black Scalloped Co-Ord">
            <p class="name">Black Scalloped Embroidered Co-Ord Set (2-Piece)</p>
            <p class="price">Rs 5000</p>
            <a href="views/products/product_detail.php?id=1" class="btn-sm">View</a>
        </div>

        <div class="product-card">
            <?php
            $raw = 'assets/images/products/party wear/Celeste Ethereal Powder Blue Embroidered Suit.jpg';
            $raw = str_replace('\\', '/', $raw);
            $parts = explode('/', $raw);
            $filename = array_pop($parts);
            $dir = implode('/', $parts);
            $imgSrc = ($dir ? $dir . '/' : '') . rawurlencode($filename);
            ?>
            <img src="<?= $imgSrc ?>" alt="Celeste Ethereal Suit">
            <p class="name">Celeste Ethereal Powder Blue Embroidered Suit</p>
            <p class="price">Rs 42,000</p>
            <a href="views/products/product_detail.php?id=2" class="btn-sm">View</a>
        </div>

        <div class="product-card">
            <?php
            $raw = 'assets/images/products/wedding/Ethereal Ivory & Gold Bridal Pishwas Lehenga.jpg';
            $raw = str_replace('\\', '/', $raw);
            $parts = explode('/', $raw);
            $filename = array_pop($parts);
            $dir = implode('/', $parts);
            $imgSrc = ($dir ? $dir . '/' : '') . rawurlencode($filename);
            ?>
            <img src="<?= $imgSrc ?>" alt="Ethereal Ivory Lehenga">
            <p class="name">Ethereal Ivory & Gold Bridal Pishwas Lehenga</p>
            <p class="price">Rs 670,000</p>
            <a href="views/products/product_detail.php?id=3" class="btn-sm">View</a>
        </div>

        <div class="product-card">
            <?php
            $raw = 'assets/images/products/co-ords/Red & White Botanical Printed Co-Ord Set (2-Piece).jpg';
            $raw = str_replace('\\', '/', $raw);
            $parts = explode('/', $raw);
            $filename = array_pop($parts);
            $dir = implode('/', $parts);
            $imgSrc = ($dir ? $dir . '/' : '') . rawurlencode($filename);
            ?>
            <img src="<?= $imgSrc ?>" alt="Red & White Botanical Co-Ord">
            <p class="name">Red & White Botanical Printed Co-Ord Set (2-Piece)</p>
            <p class="price">Rs 4000</p>
            <a href="views/products/product_detail.php?id=4" class="btn-sm">View</a>
        </div>

        <div class="product-card">
            <?php
            $raw = 'assets/images/products/party wear/Ivory White Tonal Embroidered Suit (New Outfit).jpg';
            $raw = str_replace('\\', '/', $raw);
            $parts = explode('/', $raw);
            $filename = array_pop($parts);
            $dir = implode('/', $parts);
            $imgSrc = ($dir ? $dir . '/' : '') . rawurlencode($filename);
            ?>
            <img src="<?= $imgSrc ?>" alt="Ivory White Tonal Suit">
            <p class="name">Ivory White Tonal Embroidered Suit (New Outfit)</p>
            <p class="price">Rs 19,000</p>
            <a href="views/products/product_detail.php?id=5" class="btn-sm">View</a>
        </div>

        <div class="product-card">
            <?php
            $raw = 'assets/images/products/wedding/Luxurious Dark TealGreen Velvet Jacket & Sharara Ensemble.jpg';
            $raw = str_replace('\\', '/', $raw);
            $parts = explode('/', $raw);
            $filename = array_pop($parts);
            $dir = implode('/', $parts);
            $imgSrc = ($dir ? $dir . '/' : '') . rawurlencode($filename);
            ?>
            <img src="<?= $imgSrc ?>" alt="Dark TealGreen Velvet Ensemble">
            <p class="name">Luxurious Dark TealGreen Velvet Jacket & Sharara Ensemble</p>
            <p class="price">Rs 150,000</p>
            <a href="views/products/product_detail.php?id=6" class="btn-sm">View</a>
        </div>

        <div class="product-card">
            <?php
            $raw = 'assets/images/products/co-ords/Emerald Breeze Printed Co-Ord Set.jpg';
            $raw = str_replace('\\', '/', $raw);
            $parts = explode('/', $raw);
            $filename = array_pop($parts);
            $dir = implode('/', $parts);
            $imgSrc = ($dir ? $dir . '/' : '') . rawurlencode($filename);
            ?>
            <img src="<?= $imgSrc ?>" alt="Emerald Breeze Co-Ord">
            <p class="name">Emerald Breeze Printed Co-Ord Set</p>
            <p class="price">Rs 8000</p>
            <a href="views/products/product_detail.php?id=7" class="btn-sm">View</a>
        </div>

        <div class="product-card">
            <?php
            $raw = 'assets/images/products/party wear/Desert Rose - Camel Embroidered Suit with Deep Plum Dupatta.jpg';
            $raw = str_replace('\\', '/', $raw);
            $parts = explode('/', $raw);
            $filename = array_pop($parts);
            $dir = implode('/', $parts);
            $imgSrc = ($dir ? $dir . '/' : '') . rawurlencode($filename);
            ?>
            <img src="<?= $imgSrc ?>" alt="Desert Rose Suit">
            <p class="name">Desert Rose - Camel Embroidered Suit with Deep Plum Dupatta</p>
            <p class="price">Rs 70,000</p>
            <a href="views/products/product_detail.php?id=8" class="btn-sm">View</a>
        </div>

        <div class="product-card">
            <?php
            $raw = 'assets/images/products/wedding/Pastel Grey Organza Kameez with Dusty Pink Gharara.jpg';
            $raw = str_replace('\\', '/', $raw);
            $parts = explode('/', $raw);
            $filename = array_pop($parts);
            $dir = implode('/', $parts);
            $imgSrc = ($dir ? $dir . '/' : '') . rawurlencode($filename);
            ?>
            <img src="<?= $imgSrc ?>" alt="Pastel Grey Organza Kameez">
            <p class="name">Pastel Grey Organza Kameez with Dusty Pink Gharara</p>
            <p class="price">Rs 190,000</p>
            <a href="views/products/product_detail.php?id=9" class="btn-sm">View</a>
        </div>

        <div class="product-card">
            <?php
            $raw = 'assets/images/products/wedding/Regal Rani Pink & Gold Layered Bridal Pishwas.jpg';
            $raw = str_replace('\\', '/', $raw);
            $parts = explode('/', $raw);
            $filename = array_pop($parts);
            $dir = implode('/', $parts);
            $imgSrc = ($dir ? $dir . '/' : '') . rawurlencode($filename);
            ?>
            <img src="<?= $imgSrc ?>" alt="Regal Rani Bridal Pishwas">
            <p class="name">Regal Rani Pink & Gold Layered Bridal Pishwas</p>
            <p class="price">Rs 550,000</p>
            <a href="views/products/product_detail.php?id=10" class="btn-sm">View</a>
        </div>

        <?php endif; ?>

    </div>
</div>

<?php include "views/include/footer.php"; ?>
