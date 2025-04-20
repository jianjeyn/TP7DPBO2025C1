<?php
// Include database and object files
include_once '../config/db.php';
include_once '../class/Bottoms.php';

// Initialize Database connection (PDO)
$database = new Database();
$pdo = $database->conn;  // This should initialize the $pdo object for the database connection

// Initialize the model with the $pdo object
$bottomsItem = new Bottoms($pdo);

// Handling form submissions for add, update, delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add a new item
    if (isset($_POST['add_item'])) {
        $bottomsItem->user_id = 1; // Set user_id as needed
        $bottomsItem->item_name = $_POST['item_name'];
        $bottomsItem->color = $_POST['color'];
        $bottomsItem->image_url = $_POST['image_url'];
        $bottomsItem->create();
    }
    // Update an existing item
    elseif (isset($_POST['update_item'])) {
        $bottomsItem->id = $_POST['id'];
        $bottomsItem->item_name = $_POST['item_name'];
        $bottomsItem->color = $_POST['color'];
        $bottomsItem->image_url = $_POST['image_url'];
        $bottomsItem->update();
    }
    // Delete an item
    elseif (isset($_POST['delete_item'])) {
        $bottomsItem->id = $_POST['id'];
        $bottomsItem->delete();
    }
}

// Fetch all bottoms items for the user
$user_id = 1; // Example user_id, replace with dynamic user ID if needed
$bottoms_stmt = $bottomsItem->readByUser($user_id);
$bottoms_items = $bottoms_stmt->fetchAll(PDO::FETCH_ASSOC);

include 'header.php';
?>

<section class="wardrobe">
    <h2>Your Wardrobe - Bottoms</h2>

    <!-- Add New Item Form -->
    <h3>Add New Item</h3>
    <form method="POST">
        <input type="text" name="item_name" placeholder="Item Name" required>
        <input type="text" name="color" placeholder="Color" required>
        <input type="text" name="image_url" placeholder="Image URL" required>
        <button type="submit" name="add_item" class="btn">Add Item</button>
    </form>

    <!-- Bottoms Items Table -->
    <h3>Manage Your Bottoms</h3>
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
            <?php foreach ($bottoms_items as $item): ?>
                <tr>
                    <td><?= $item['item_name']; ?></td>
                    <td><?= $item['color']; ?></td>
                    <td><img src="../assets/images/<?= $item['image_url']; ?>" alt="<?= $item['item_name']; ?>" width="100"></td>
                    <td>
                        <!-- Edit Form -->
                        <form action="bottoms.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $item['id']; ?>">
                            <input type="text" name="item_name" value="<?= $item['item_name']; ?>" required>
                            <input type="text" name="color" value="<?= $item['color']; ?>" required>
                            <input type="text" name="image_url" value="<?= $item['image_url']; ?>" required>
                            <button type="submit" name="update_item" class="btn btn-update">Update</button>
                        </form>

                        <!-- Delete Form -->
                        <form action="bottoms.php" method="POST" style="display:inline;">
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
