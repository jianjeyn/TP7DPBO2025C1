<?php
// Include database and object files
include_once 'config/db.php';
include_once 'class/User.php';
include_once 'class/Clothes.php';
include_once 'class/Bottoms.php';
include_once 'class/Shoes.php';

// Initialize Database connection (PDO)
$database = new Database();
$pdo = $database->conn;  // This should initialize the $pdo object for the database connection

// Initialize the models with the $pdo object
$user = new User();
$clothesItem = new Clothes($pdo);
$bottomsItem = new Bottoms($pdo);
$shoesItem = new Shoes($pdo);

// Assume we are retrieving items for a specific user (e.g., user_id = 1)
$user_id = 1; // Replace with dynamic user ID if needed

// Get all wardrobe items for the user
$clothes_stmt = $clothesItem->readByUser($user_id);
$bottoms_stmt = $bottomsItem->readByUser($user_id);
$shoes_stmt = $shoesItem->readByUser($user_id);

// Fetch items from each category
$clothes_items = $clothes_stmt->fetchAll(PDO::FETCH_ASSOC);
$bottoms_items = $bottoms_stmt->fetchAll(PDO::FETCH_ASSOC);
$shoes_items = $shoes_stmt->fetchAll(PDO::FETCH_ASSOC);

// Page includes
include 'view/header.php';
?>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h1>Welcome to Your Fashion Planner</h1>
        <p>Create outfits, track your wardrobe items, and always be stylish!</p>
        <a href="view/outfit_form.php" class="btn btn-primary">Create Your Outfit</a>
    </div>
</section>

<!-- Wardrobe Section -->
<section class="wardrobe">
    <h2>Your Wardrobe</h2>

    <!-- Wardrobe category buttons -->
    <div class="wardrobe-categories">
        <a href="view/client_list.php" class="btn btn-category">Client</a>
        <a href="view/clothes.php" class="btn btn-category">Clothes</a>
        <a href="view/bottoms.php" class="btn btn-category">Bottoms</a>
        <a href="view/shoes.php" class="btn btn-category">Shoes</a>
    </div>

    <div class="wardrobe-items">
        <!-- Display clothes items -->
        <?php foreach ($clothes_items as $item): ?>
            <div class="wardrobe-item">
                <img src="assets/images/<?= $item['image_url']; ?>" alt="<?= $item['item_name']; ?>">
                <h3><?= $item['item_name']; ?></h3>
                <p>Category: Clothes</p>
                <p>Color: <?= $item['color']; ?></p>
            </div>
        <?php endforeach; ?>

        <!-- Display bottoms items -->
        <?php foreach ($bottoms_items as $item): ?>
            <div class="wardrobe-item">
                <img src="assets/images/<?= $item['image_url']; ?>" alt="<?= $item['item_name']; ?>">
                <h3><?= $item['item_name']; ?></h3>
                <p>Category: Bottoms</p>
                <p>Color: <?= $item['color']; ?></p>
            </div>
        <?php endforeach; ?>

        <!-- Display shoes items -->
        <?php foreach ($shoes_items as $item): ?>
            <div class="wardrobe-item">
                <img src="assets/images/<?= $item['image_url']; ?>" alt="<?= $item['item_name']; ?>">
                <h3><?= $item['item_name']; ?></h3>
                <p>Category: Shoes</p>
                <p>Color: <?= $item['color']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Quick Access Section -->
<section class="quick-access">
    <h2>Quick Access</h2>
    <div class="quick-access-grid">
        <div class="quick-access-card">
            <h3>Add New Item</h3>
            <p>Log a new wardrobe item.</p>
            <a href="view/wardrobe_form.php" class="btn btn-secondary">Add Item</a>
        </div>
        <div class="quick-access-card">
            <h3>Create Outfit</h3>
            <p>Mix and match your items to create outfits.</p>
            <a href="view/outfit_form.php" class="btn btn-secondary">Create Outfit</a>
        </div>
    </div>
</section>

<!-- Outfit Predictions Section -->
<?php if (count($clothes_items) > 0 || count($bottoms_items) > 0 || count($shoes_items) > 0): ?>
<section class="outfit-prediction">
    <h2>Your Outfit Ideas</h2>
    <div class="outfit-cards">
        <!-- Display outfit prediction cards for clothes -->
        <?php foreach ($clothes_items as $item): ?>
            <div class="outfit-card">
                <h3>Outfit for Today</h3>
                <p>Combine your wardrobe items for a new look!</p>
                <div class="outfit-info">
                    <p><strong>Item:</strong> <?= $item['item_name']; ?></p>
                    <a href="view/outfit_details.php?item_id=<?= $item['id']; ?>" class="btn btn-text">View Details</a>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Display outfit prediction cards for bottoms -->
        <?php foreach ($bottoms_items as $item): ?>
            <div class="outfit-card">
                <h3>Outfit for Today</h3>
                <p>Combine your wardrobe items for a new look!</p>
                <div class="outfit-info">
                    <p><strong>Item:</strong> <?= $item['item_name']; ?></p>
                    <a href="view/outfit_details.php?item_id=<?= $item['id']; ?>" class="btn btn-text">View Details</a>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Display outfit prediction cards for shoes -->
        <?php foreach ($shoes_items as $item): ?>
            <div class="outfit-card">
                <h3>Outfit for Today</h3>
                <p>Combine your wardrobe items for a new look!</p>
                <div class="outfit-info">
                    <p><strong>Item:</strong> <?= $item['item_name']; ?></p>
                    <a href="view/outfit_details.php?item_id=<?= $item['id']; ?>" class="btn btn-text">View Details</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<?php include 'view/footer.php'; ?>
