<?php
include_once '../config/db.php';
include_once '../class/User.php';

$database = new Database();
$user = new User();

$stmt = $user->readAllUsersWithWardrobe();
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'header.php';
?>

<section class="client-list">
    <h2>Client Wardrobe Overview</h2>

    <table class="styled-table">
        <thead>
            <tr>
                <th>Client Name</th>
                <th>Clothes</th>
                <th>Bottoms</th>
                <th>Shoes</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clients as $client): ?>
                <tr>
                    <td><?= htmlspecialchars($client['username']); ?></td>
                    <td><?= htmlspecialchars($client['clothes_name'] ?? '—'); ?></td>
                    <td><?= htmlspecialchars($client['bottoms_name'] ?? '—'); ?></td>
                    <td><?= htmlspecialchars($client['shoes_name'] ?? '—'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<?php include 'footer.php'; ?>
