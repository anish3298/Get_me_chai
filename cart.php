<?php
$pageTitle = 'Cart';
include __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <h1>Your cart</h1>
        <p>Review items, update quantities and continue to secure checkout.</p>
    </div>
</section>

<section class="section">
    <div class="container cart-layout">
        <div class="panel">
            <h3>Selected items</h3>
            <div id="cartItems"></div>
        </div>

        <aside class="panel">
            <h3>Bill summary</h3>
            <div class="summary-row">
                <span>Subtotal</span>
                <strong class="summary-subtotal">₹0</strong>
            </div>
            <div class="summary-row">
                <span>Evening offer discount</span>
                <strong class="summary-discount">- ₹0</strong>
            </div>
            <div class="summary-row">
                <span>Delivery fee</span>
                <strong class="summary-delivery">₹0</strong>
            </div>
            <div class="summary-row total">
                <span>Total</span>
                <strong class="summary-total">₹0</strong>
            </div>

            <p class="muted">🎯 Save 10% automatically on orders above ₹199.</p>
            <a class="btn btn-primary" href="checkout.php">Proceed to checkout</a>
        </aside>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
