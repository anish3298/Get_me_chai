<?php
session_start();
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Login';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
        $error = 'Please enter email and password.';
    } elseif (!($conn instanceof mysqli)) {
        $error = 'Database is not connected yet. Import the SQL file in XAMPP first.';
    } else {
        $stmt = $conn->prepare('SELECT id, name, email, password FROM users WHERE email = ? LIMIT 1');
        if ($stmt) {
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $userData = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            if ($userData && password_verify($password, $userData['password'])) {
                $_SESSION['user'] = [
                    'id' => $userData['id'],
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                ];
                header('Location: index.php');
                exit;
            }
        }

        $error = 'Invalid email or password.';
    }
}

include __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <h1>Login</h1>
        <p>Sign in to view your order history and faster checkouts.</p>
    </div>
</section>

<section class="section">
    <div class="container auth-layout">
        <div class="panel">
            <h3>Welcome back</h3>
            <?php if ($error): ?>
                <p class="badge" style="background:#fee2e2;color:#991b1b;"><?= esc($error) ?></p>
            <?php endif; ?>
            <form method="post">
                <label>
                    Email
                    <input type="email" name="email" placeholder="you@example.com" required>
                </label>
                <label>
                    Password
                    <input type="password" name="password" placeholder="Enter your password" required>
                </label>
                <button class="btn btn-primary" type="submit">Login</button>
            </form>
            <p class="muted">New here? <a href="register.php"><strong>Create an account</strong></a></p>
        </div>

        <aside class="panel">
            <h3>Login benefits</h3>
            <ul>
                <li>Track previous orders</li>
                <li>Save your delivery details</li>
                <li>Get notified about chai offers</li>
            </ul>
        </aside>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
