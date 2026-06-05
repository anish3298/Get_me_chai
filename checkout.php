<?php
$pageTitle = 'Checkout';
include __DIR__ . '/includes/header.php';
$user = currentUser();
?>

<section class="page-hero">
    <div class="container">
        <h1>Checkout</h1>
        <p>Fill your address and contact details for smooth delivery.</p>
    </div>
</section>

<section class="section">
    <div class="container checkout-layout">
        <div class="panel">
            <h3>Delivery details</h3>
            <form id="checkoutForm">
                <div class="form-grid">
                    <label>
                        Full name
                        <input type="text" name="name" value="<?= esc($user['name'] ?? '') ?>" required>
                    </label>
                    <label>
                        Phone number
                        <input type="tel" name="phone" placeholder="9876543210" required>
                    </label>
                </div>

                <div class="form-grid">
                    <label>
                        Email
                        <input type="email" name="email" value="<?= esc($user['email'] ?? '') ?>">
                    </label>
                    <label>
                        City
                        <input type="text" name="city" placeholder="New Delhi" required>
                    </label>
                </div>

                <label>
                    Address
                    <textarea name="address" placeholder="House no, street, landmark" required></textarea>
                </label>

                <div class="form-grid">
                    <label>
                        Pincode
                        <input type="text" name="pincode" placeholder="110001" required>
                    </label>
                    <label>
                        Delivery note
                        <input type="text" name="note" placeholder="Call on arrival / leave at gate">
                    </label>
                </div>

                <button class="btn btn-primary" type="submit">Continue to payment</button>
            </form>
        </div>

        <aside class="panel">
            <h3>Why checkout with ChaiAdda?</h3>
            <ul>
                <li>Fresh preparation after your order</li>
                <li>Secure UPI and bank transfer support</li>
                <li>Delivery tracking after payment</li>
                <li>Perfect evening chai combo discounts</li>
            </ul>
        </aside>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
