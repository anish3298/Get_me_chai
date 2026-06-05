<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/functions.php';

$pageTitle = $pageTitle ?? 'ChaiAdda';
$currentPage = basename($_SERVER['PHP_SELF']);
$user = currentUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($pageTitle) ?> | ChaiAdda</title>
    <meta name="description" content="Order chai and snacks online with a warm Indian tea house vibe.">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="site-header">
    <nav class="navbar container">
        <a class="brand" href="index.php">
            <span class="brand-logo">☕</span>
            <div>
                <strong>ChaiAdda</strong>
                <small>Sip. Snack. Smile.</small>
            </div>
        </a>

        <form class="nav-search" action="menu.php" method="get">
            <input type="text" name="search" placeholder="Search chai, snacks..." value="<?= esc($_GET['search'] ?? '') ?>">
            <button type="submit">🔎</button>
        </form>

        <div class="nav-links">
            <a class="<?= $currentPage === 'index.php' ? 'active' : '' ?>" href="index.php">Home</a>
            <a class="<?= $currentPage === 'menu.php' ? 'active' : '' ?>" href="menu.php">Menu</a>
            <a class="<?= $currentPage === 'tracking.php' ? 'active' : '' ?>" href="tracking.php">Track</a>
            <a class="<?= $currentPage === 'history.php' ? 'active' : '' ?>" href="history.php">Orders</a>
            <?php if ($user): ?>
                <span class="welcome-chip">Hi, <?= esc($user['name']) ?></span>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a class="<?= $currentPage === 'login.php' ? 'active' : '' ?>" href="login.php">Login</a>
            <?php endif; ?>
            <a class="cart-link <?= $currentPage === 'cart.php' ? 'active' : '' ?>" href="cart.php" aria-label="Cart">
                🛒
                <span class="cart-badge" data-cart-count>0</span>
            </a>
        </div>
    </nav>
</header>
<main>
