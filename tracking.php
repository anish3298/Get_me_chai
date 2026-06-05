<?php
$pageTitle = 'Order Tracking';
include __DIR__ . '/includes/header.php';

$orderId = $_GET['order_id'] ?? ($_SESSION['last_order_id'] ?? 'DEMO-' . date('His'));
$status = 'Preparing';
$totalPrice = null;

if ($conn instanceof mysqli && !empty($_GET['order_id']) && is_numeric($_GET['order_id'])) {
    $stmt = $conn->prepare('SELECT total_price, status FROM orders WHERE id = ? LIMIT 1');
    if ($stmt) {
        $numericOrderId = (int) $_GET['order_id'];
        $stmt->bind_param('i', $numericOrderId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($result) {
            $status = $result['status'] ?: 'Preparing';
            $totalPrice = $result['total_price'];
        }
    }
}
?>

<section class="page-hero">
    <div class="container">
        <span class="tag">🚚 Live order tracking UI</span>
        <h1>Track your order</h1>
        <p>Order ID: <strong><?= esc((string) $orderId) ?></strong></p>
    </div>
</section>

<section class="section">
    <div class="container tracking-layout">
        <div class="panel">
            <h3>Delivery progress</h3>
            <p id="etaText" class="muted">Fresh chai is being prepared for you.</p>

            <div id="trackingSteps" class="steps">
                <div class="step active">
                    <div class="step-bullet">1</div>
                    <div>
                        <strong>Order placed</strong>
                        <p class="muted">Your payment was received successfully.</p>
                    </div>
                </div>
                <div class="step <?= $status === 'Preparing' ? 'active' : '' ?>">
                    <div class="step-bullet">2</div>
                    <div>
                        <strong>Preparing</strong>
                        <p class="muted">Tea is brewing and snacks are being packed.</p>
                    </div>
                </div>
                <div class="step <?= $status === 'Out for delivery' ? 'active' : '' ?>">
                    <div class="step-bullet">3</div>
                    <div>
                        <strong>Out for delivery</strong>
                        <p class="muted">Your rider is heading toward your address.</p>
                    </div>
                </div>
                <div class="step <?= $status === 'Delivered' ? 'done' : '' ?>">
                    <div class="step-bullet">4</div>
                    <div>
                        <strong>Delivered</strong>
                        <p class="muted">Enjoy your hot chai and evening snacks.</p>
                    </div>
                </div>
            </div>
        </div>

        <aside class="panel">
            <h3>Order snapshot</h3>
            <p><strong>Current status:</strong> <?= esc($status) ?></p>
            <?php if ($totalPrice !== null): ?>
                <p><strong>Total:</strong> <?= formatPrice((float) $totalPrice) ?></p>
            <?php endif; ?>
            <p><strong>Estimated arrival:</strong> 15-20 mins</p>
            <p><strong>Pickup point:</strong> CP Tea Corner</p>
            <div class="panel" style="margin-top: 1rem;">
                <h4>📍 Nearby chai point</h4>
                <p class="muted">Your order is being dispatched from our nearest tea kitchen in Connaught Place.</p>
            </div>
        </aside>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
