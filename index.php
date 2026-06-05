<?php
$pageTitle = 'Home';
include __DIR__ . '/includes/header.php';

$featuredProducts = array_slice(getProducts($conn), 0, 6);
$offers = getOffers();
$shops = getNearbyShops();
?>

<section class="hero">
    <div class="container hero-grid">
        <div class="hero-card hero-copy">
            <span class="tag">🔥 Freshly brewed, delivered fast</span>
            <h1>Order hot chai & crispy snacks like your favourite food app.</h1>
            <p>From kadak masala chai to kulhad specials, ChaiAdda brings your evening comfort straight to your doorstep.</p>

            <div class="hero-actions">
                <a class="btn btn-primary" href="menu.php">Explore Menu</a>
                <a class="btn btn-soft" href="tracking.php">Track Delivery</a>
            </div>

            <div class="hero-stats">
                <div class="stat-box">
                    <strong>20 mins</strong>
                    <span>Avg delivery</span>
                </div>
                <div class="stat-box">
                    <strong>4.8/5</strong>
                    <span>Customer rating</span>
                </div>
                <div class="stat-box">
                    <strong>30+</strong>
                    <span>Tea combos</span>
                </div>
            </div>
        </div>

        <div class="hero-visual hero-card">
            <div class="floating-card">
                <strong>Today’s Pick</strong>
                <p>Masala Chai + Samosa combo</p>
                <span class="badge">Save 15% this evening</span>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <div>
                <h2>Popular items</h2>
                <p>Customer favourites for every chai break.</p>
            </div>
            <a class="btn btn-outline" href="menu.php">View full menu</a>
        </div>

        <div class="grid cards-3">
            <?php foreach ($featuredProducts as $item): ?>
                <article class="card">
                    <img class="card-image" src="<?= esc($item['image']) ?>" alt="<?= esc($item['name']) ?>">
                    <div class="card-body">
                        <span class="badge"><?= ucfirst(esc($item['category'])) ?></span>
                        <div class="card-title-row">
                            <h3><?= esc($item['name']) ?></h3>
                            <span class="price"><?= formatPrice((float) $item['price']) ?></span>
                        </div>
                        <p class="muted"><?= esc($item['description']) ?></p>
                        <p class="rating">⭐ <?= esc((string) $item['rating']) ?></p>
                        <div class="card-actions">
                            <a class="btn btn-outline" href="product.php?id=<?= (int) $item['id'] ?>">Details</a>
                            <button
                                class="btn btn-primary add-to-cart"
                                type="button"
                                data-id="<?= (int) $item['id'] ?>"
                                data-name="<?= esc($item['name']) ?>"
                                data-price="<?= (float) $item['price'] ?>"
                                data-image="<?= esc($item['image']) ?>"
                            >Add to cart</button>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container grid cards-3">
        <?php foreach ($offers as $offer): ?>
            <div class="offer-banner">
                <h3><?= esc($offer['title']) ?></h3>
                <p><?= esc($offer['text']) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <div>
                <h2>📍 Nearby chai shops</h2>
                <p>Inspired by your neighbourhood tea points.</p>
            </div>
        </div>

        <div class="grid cards-3">
            <div class="panel">
                <h3>Fast delivery around you</h3>
                <?php foreach ($shops as $shop): ?>
                    <div class="shop-chip">
                        <div>
                            <strong><?= esc($shop['name']) ?></strong>
                            <p class="muted"><?= esc($shop['distance']) ?> away</p>
                        </div>
                        <span class="badge"><?= esc($shop['time']) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="panel">
                <h3>Why chai lovers choose us</h3>
                <ul>
                    <li>Freshly brewed every order</li>
                    <li>Warm Indian tea house theme</li>
                    <li>Easy UPI and bank payment options</li>
                    <li>Live delivery tracking interface</li>
                </ul>
            </div>
            <div class="panel">
                <h3>⭐ Ratings & reviews</h3>
                <p><strong>4.8 overall rating</strong> from tea lovers who enjoy quick deliveries and authentic taste.</p>
                <p class="muted">“The kulhad chai tastes exactly like a roadside favourite.”</p>
                <p class="muted">“Perfect evening combo deals with samosa and chai.”</p>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
