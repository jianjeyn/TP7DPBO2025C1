<?php
// Include database and object files
include_once '../config/db.php';
include_once '../class/Clothes.php';

// Initialize Database connection (PDO)
$database = new Database();
$pdo = $database->conn;

// Initialize the model with the $pdo object
$clothesItem = new Clothes($pdo);

// Handling form submissions for add, update, delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_item'])) {
        $clothesItem->user_id = 1;
        $clothesItem->item_name = $_POST['item_name'];
        $clothesItem->color = $_POST['color'];
        $clothesItem->image_url = $_POST['image_url'];
        $clothesItem->create();
    } elseif (isset($_POST['update_item'])) {
        $clothesItem->id = $_POST['id'];
        $clothesItem->item_name = $_POST['item_name'];
        $clothesItem->color = $_POST['color'];
        $clothesItem->image_url = $_POST['image_url'];
        $clothesItem->update();
    } elseif (isset($_POST['delete_item'])) {
        $clothesItem->id = $_POST['id'];
        $clothesItem->delete();
    }
}

$user_id = 1;
$searchKeyword = isset($_GET['search']) ? $_GET['search'] : null;
$clothes_stmt = $clothesItem->readByUser($user_id, $searchKeyword);
$clothes_items = $clothes_stmt->fetchAll(PDO::FETCH_ASSOC);

include 'header.php';
?>

<section class="wardrobe">
    <h2>Your Wardrobe - Clothes</h2>

    <!-- Add New Item Form -->
    <h3>Add New Item</h3>
    <form method="POST">
        <input type="text" name="item_name" placeholder="Item Name" required>
        <input type="text" name="color" placeholder="Color" required>
        <input type="text" name="image_url" placeholder="Image URL" required>
        <button type="submit" name="add_item" class="btn">Add Item</button>
    </form>


    <!-- Clothes Items Table -->
    <h3>Manage Your Clothes</h3>
        <!-- Search Form -->
        <form method="GET">
        <input type="text" name="search" placeholder="Search by Item Name" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
        <button type="submit" class="btn">Search</button>
    </form>
    <table class="styled-table">
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Color</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clothes_items as $item): ?>
                <tr>
                    <td><?= $item['item_name']; ?></td>
                    <td><?= $item['color']; ?></td>
                    <td><img src="../assets/images/<?= $item['image_url']; ?>" alt="<?= $item['item_name']; ?>" width="100"></td>
                    <td>
                        <!-- Edit Form -->
                        <form action="clothes.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $item['id']; ?>">
                            <input type="text" name="item_name" value="<?= $item['item_name']; ?>" required>
                            <input type="text" name="color" value="<?= $item['color']; ?>" required>
                            <input type="text" name="image_url" value="<?= $item['image_url']; ?>" required>
                            <button type="submit" name="update_item" class="btn btn-update">Update</button>
                        </form>

                        <!-- Delete Form -->
                        <form action="clothes.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $item['id']; ?>">
                            <button type="submit" name="delete_item" class="btn btn-delete">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<?php include 'footer.php'; ?>
