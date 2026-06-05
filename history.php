<?php
$pageTitle = 'Order History';
include __DIR__ . '/includes/header.php';

$orders = [];

if (isLoggedIn() && $conn instanceof mysqli) {
    $stmt = $conn->prepare(
        'SELECT o.id, o.total_price, o.status, o.created_at,
         GROUP_CONCAT(CONCAT(p.name, " x", oi.quantity) SEPARATOR ", ") AS items
         FROM orders o
         LEFT JOIN order_items oi ON oi.order_id = o.id
         LEFT JOIN products p ON p.id = oi.product_id
         WHERE o.user_id = ?
         GROUP BY o.id, o.total_price, o.status, o.created_at
         ORDER BY o.id DESC'
    );

    if ($stmt) {
        $userId = (int) currentUser()['id'];
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        $stmt->close();
    }
}
?>

<section class="page-hero">
    <div class="container">
        <h1>Order history</h1>
        <p>View your previous chai orders and their current status.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (!isLoggedIn()): ?>
            <div class="panel">
                <h3>Please log in</h3>
                <p class="muted">Login to see your saved orders and reorder quickly.</p>
                <a class="btn btn-primary" href="login.php">Go to login</a>
            </div>
        <?php elseif (empty($orders)): ?>
            <div class="panel">
                <h3>No orders yet</h3>
                <p class="muted">Place your first chai order to see history here.</p>
                <a class="btn btn-primary" href="menu.php">Order now</a>
            </div>
        <?php else: ?>
            <div class="grid cards-3">
                <?php foreach ($orders as $order): ?>
                    <article class="panel">
                        <span class="badge">Order #<?= (int) $order['id'] ?></span>
                        <h3><?= formatPrice((float) $order['total_price']) ?></h3>
                        <p><strong>Status:</strong> <?= esc($order['status']) ?></p>
                        <p><strong>Date:</strong> <?= esc($order['created_at']) ?></p>
                        <p class="muted"><?= esc($order['items'] ?: 'Items unavailable') ?></p>
                        <a class="btn btn-outline" href="tracking.php?order_id=<?= (int) $order['id'] ?>">Track again</a>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
