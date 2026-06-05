<?php
session_start();
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Register';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$name || !$email || strlen($password) < 6) {
        $error = 'Enter a valid name, email and password (min 6 chars).';
    } elseif (!($conn instanceof mysqli)) {
        $error = 'Database is not connected yet. Import the SQL file in XAMPP first.';
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');

        if ($stmt) {
            $stmt->bind_param('sss', $name, $email, $hashedPassword);
            if ($stmt->execute()) {
                $success = 'Registration successful. You can now log in.';
            } else {
                $error = 'Email already exists or registration failed.';
            }
            $stmt->close();
        } else {
            $error = 'Unable to create account right now.';
        }
    }
}

include __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <h1>Create account</h1>
        <p>Register to save your orders and unlock quicker re-ordering.</p>
    </div>
</section>

<section class="section">
    <div class="container auth-layout">
        <div class="panel">
            <h3>Join ChaiAdda</h3>
            <?php if ($error): ?>
                <p class="badge" style="background:#fee2e2;color:#991b1b;"><?= esc($error) ?></p>
            <?php endif; ?>
            <?php if ($success): ?>
                <p class="badge" style="background:#dcfce7;color:#166534;"><?= esc($success) ?></p>
            <?php endif; ?>
            <form method="post">
                <label>
                    Full name
                    <input type="text" name="name" placeholder="Your name" required>
                </label>
                <label>
                    Email
                    <input type="email" name="email" placeholder="you@example.com" required>
                </label>
                <label>
                    Password
                    <input type="password" name="password" placeholder="Minimum 6 characters" required>
                </label>
                <button class="btn btn-primary" type="submit">Register</button>
            </form>
        </div>

        <aside class="panel">
            <h3>Member perks</h3>
            <ul>
                <li>Access order history</li>
                <li>Use saved address details</li>
                <li>Get evening chai combo alerts</li>
            </ul>
        </aside>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
