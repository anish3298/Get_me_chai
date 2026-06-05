<?php
$pageTitle = 'Menu';
include __DIR__ . '/includes/header.php';

$category = $_GET['category'] ?? 'all';
$search = trim($_GET['search'] ?? '');
$products = getProducts($conn, $category, $search);
?>

<section class="page-hero">
    <div class="container">
        <span class="tag">☕ Brewed fresh every time</span>
        <h1>Chai & snacks menu</h1>
        <p>Search, filter and add your favourites to the cart instantly.</p>

        <div class="filter-row">
            <button class="filter-btn <?= $category === 'all' ? 'active' : '' ?>" data-filter="all" type="button">All</button>
            <button class="filter-btn <?= $category === 'chai' ? 'active' : '' ?>" data-filter="chai" type="button">Chai</button>
            <button class="filter-btn <?= $category === 'snacks' ? 'active' : '' ?>" data-filter="snacks" type="button">Snacks</button>
            <input id="menuSearch" type="text" placeholder="Quick filter on this page..." value="<?= esc($search) ?>">
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="grid cards-3">
            <?php foreach ($products as $item): ?>
                <article class="card menu-card" data-category="<?= esc($item['category']) ?>">
                    <img class="card-image" src="<?= esc($item['image']) ?>" alt="<?= esc($item['name']) ?>">
                    <div class="card-body">
                        <div class="card-title-row">
                            <h3><?= esc($item['name']) ?></h3>
                            <span class="price"><?= formatPrice((float) $item['price']) ?></span>
                        </div>
                        <p class="muted"><?= esc($item['description']) ?></p>
                        <div class="inline-actions">
                            <span class="badge"><?= ucfirst(esc($item['category'])) ?></span>
                            <span class="rating">⭐ <?= esc((string) $item['rating']) ?></span>
                        </div>
                        <div class="card-actions">
                            <a class="btn btn-outline" href="product.php?id=<?= (int) $item['id'] ?>">View details</a>
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

        <?php if (empty($products)): ?>
            <div class="panel">
                <h3>No items found</h3>
                <p class="muted">Try another search term or switch the category filter.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
