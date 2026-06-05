<?php
$pageTitle = 'Product Details';
include __DIR__ . '/includes/header.php';

$productId = isset($_GET['id']) ? (int) $_GET['id'] : 1;
$product = getProductById($conn, $productId);
?>

<section class="page-hero">
    <div class="container">
        <h1>Product details</h1>
        <p>View flavour notes, ratings and add your preferred quantity.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (!$product): ?>
            <div class="panel">
                <h3>Product not found</h3>
                <a class="btn btn-primary" href="menu.php">Back to menu</a>
            </div>
        <?php else: ?>
            <div class="product-layout">
                <div class="panel">
                    <img class="product-hero-img" src="<?= esc($product['image']) ?>" alt="<?= esc($product['name']) ?>">
                </div>

                <div class="panel">
                    <span class="badge"><?= ucfirst(esc($product['category'])) ?></span>
                    <h2><?= esc($product['name']) ?></h2>
                    <p class="rating">⭐ <?= esc((string) $product['rating']) ?> rating</p>
                    <p><?= esc($product['description']) ?></p>
                    <h3 class="price"><?= formatPrice((float) $product['price']) ?></h3>

                    <div class="qty-wrap">
                        <span>Quantity:</span>
                        <div class="qty-box">
                            <button id="productQtyMinus" class="qty-btn" type="button">-</button>
                            <span id="productQtyValue">1</span>
                            <button id="productQtyPlus" class="qty-btn" type="button">+</button>
                        </div>
                    </div>

                    <div class="card-actions">
                        <button
                            id="productAddBtn"
                            class="btn btn-primary add-to-cart"
                            type="button"
                            data-id="<?= (int) $product['id'] ?>"
                            data-name="<?= esc($product['name']) ?>"
                            data-price="<?= (float) $product['price'] ?>"
                            data-image="<?= esc($product['image']) ?>"
                            data-qty="1"
                        >Add to cart</button>
                        <a class="btn btn-outline" href="cart.php">Go to cart</a>
                    </div>

                    <div class="panel" style="margin-top: 1rem;">
                        <h4>Perfect with</h4>
                        <p class="muted">Pairs well with samosa, pakora or a butter biscuit for an evening chai break.</p>
                    </div>
                </div>
            </div>

            <div class="panel" style="margin-top: 1.25rem;">
                <h3>⭐ Customer reviews</h3>
                <div id="reviewList" class="review-list">
                    <div class="review-item">
                        <strong>Riya</strong>
                        <div class="rating">⭐⭐⭐⭐⭐</div>
                        <p>Perfectly balanced and super comforting.</p>
                    </div>
                    <div class="review-item">
                        <strong>Aman</strong>
                        <div class="rating">⭐⭐⭐⭐</div>
                        <p>Very fresh and delivered hot. Great evening pick.</p>
                    </div>
                    <div id="dynamicReviews"></div>
                </div>

                <form id="reviewForm" data-product-id="<?= (int) $product['id'] ?>">
                    <div class="form-grid">
                        <label>
                            Your name
                            <input type="text" name="name" placeholder="Enter your name">
                        </label>
                        <label>
                            Rating
                            <select name="rating">
                                <option value="5">5 Stars</option>
                                <option value="4">4 Stars</option>
                                <option value="3">3 Stars</option>
                            </select>
                        </label>
                    </div>
                    <label>
                        Review
                        <textarea name="comment" placeholder="Tell others what you loved about it..."></textarea>
                    </label>
                    <button class="btn btn-primary" type="submit">Submit review</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php if ($product): ?>
<script>
    (function () {
        let qty = 1;
        const value = document.getElementById('productQtyValue');
        const addBtn = document.getElementById('productAddBtn');
        document.getElementById('productQtyPlus')?.addEventListener('click', function () {
            qty += 1;
            value.textContent = qty;
            addBtn.dataset.qty = String(qty);
        });
        document.getElementById('productQtyMinus')?.addEventListener('click', function () {
            qty = Math.max(1, qty - 1);
            value.textContent = qty;
            addBtn.dataset.qty = String(qty);
        });
    })();
</script>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
