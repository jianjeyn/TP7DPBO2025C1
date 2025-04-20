<?php
// Include database and object files
include_once '../config/db.php';
include_once '../class/Shoes.php';

// Initialize Database connection (PDO)
$database = new Database();
$pdo = $database->conn;  // This should initialize the $pdo object for the database connection

// Initialize the model with the $pdo object
$shoesItem = new Shoes($pdo);

// Handling form submissions for add, update, delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add a new item
    if (isset($_POST['add_item'])) {
        $shoesItem->user_id = 1; // Set user_id as needed
        $shoesItem->item_name = $_POST['item_name'];
        $shoesItem->color = $_POST['color'];
        $shoesItem->image_url = $_POST['image_url'];
        $shoesItem->create();
    }
    // Update an existing item
    elseif (isset($_POST['update_item'])) {
        $shoesItem->id = $_POST['id'];
        $shoesItem->item_name = $_POST['item_name'];
        $shoesItem->color = $_POST['color'];
        $shoesItem->image_url = $_POST['image_url'];
        $shoesItem->update();
    }
    // Delete an item
    elseif (isset($_POST['delete_item'])) {
        $shoesItem->id = $_POST['id'];
        $shoesItem->delete();
    }
}

// Fetch all shoes items for the user
$user_id = 1; // Example user_id, replace with dynamic user ID if needed
$shoes_stmt = $shoesItem->readByUser($user_id);
$shoes_items = $shoes_stmt->fetchAll(PDO::FETCH_ASSOC);

include 'header.php';
?>

<section class="wardrobe">
    <h2>Your Wardrobe - Shoes</h2>

    <!-- Add New Item Form -->
    <h3>Add New Item</h3>
    <form method="POST">
        <input type="text" name="item_name" placeholder="Item Name" required>
        <input type="text" name="color" placeholder="Color" required>
        <input type="text" name="image_url" placeholder="Image URL" required>
        <button type="submit" name="add_item" class="btn">Add Item</button>
    </form>

    <!-- Shoes Items Table -->
    <h3>Manage Your Shoes</h3>
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
            <?php foreach ($shoes_items as $item): ?>
                <tr>
                    <td><?= $item['item_name']; ?></td>
                    <td><?= $item['color']; ?></td>
                    <td><img src="../assets/images/<?= $item['image_url']; ?>" alt="<?= $item['item_name']; ?>" width="100"></td>
                    <td>
                        <!-- Edit Form -->
                        <form action="shoes.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $item['id']; ?>">
                            <input type="text" name="item_name" value="<?= $item['item_name']; ?>" required>
                            <input type="text" name="color" value="<?= $item['color']; ?>" required>
                            <input type="text" name="image_url" value="<?= $item['image_url']; ?>" required>
                            <button type="submit" name="update_item" class="btn btn-update">Update</button>
                        </form>

                        <!-- Delete Form -->
                        <form action="shoes.php" method="POST" style="display:inline;">
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
