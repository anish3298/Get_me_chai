<?php
$pageTitle = 'Payment';
include __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <h1>Payment</h1>
        <p>Scan the QR, use the UPI ID or choose bank transfer to confirm your order.</p>
    </div>
</section>

<section class="section">
    <div class="container payment-layout">
        <div class="panel">
            <h3>Complete your payment</h3>
            <form id="paymentForm">
                <label class="payment-option">
                    <input type="radio" name="paymentMethod" value="UPI" checked>
                    <span>
                        <strong>UPI / QR</strong><br>
                        Pay instantly using any UPI app.
                    </span>
                </label>

                <label class="payment-option">
                    <input type="radio" name="paymentMethod" value="Bank Transfer">
                    <span>
                        <strong>Bank transfer</strong><br>
                        Use the account details shown on the right.
                    </span>
                </label>

                <label>
                    Payer name
                    <input id="payerName" type="text" placeholder="Your full name" required>
                </label>

                <label>
                    Transaction / UTR reference
                    <input id="transactionRef" type="text" placeholder="UPI123456789 / bank ref" required>
                </label>

                <button class="btn btn-primary" type="submit">Confirm payment</button>
            </form>
        </div>

        <aside class="panel">
            <div class="qr-box">
                <img src="assets/images/phonepe-qr.png" alt="PhonePe UPI QR Code">
                <div>
                    <p><strong>PhonePe UPI ID:</strong> 9588103298-2@ybl</p>
                    <p><strong>Scan & pay using PhonePe</strong></p>
                    <p><strong>Or use any UPI app with the above ID.</strong></p>
                </div>
            </div>

            <div class="panel" style="margin-top: 1rem;">
                <h4>Payment tips</h4>
                <ul>
                    <li>Enter the correct UTR/transaction reference.</li>
                    <li>After confirmation, you’ll be redirected to order tracking.</li>
                    <li>For demo use, any reference value will work.</li>
                </ul>
            </div>
        </aside>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
