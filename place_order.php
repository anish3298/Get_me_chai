<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

$payload = json_decode(file_get_contents('php://input'), true);
$cart = $payload['cart'] ?? [];
$checkout = $payload['checkout'] ?? [];
$paymentMethod = trim($payload['paymentMethod'] ?? 'UPI');
$transactionRef = trim($payload['transactionRef'] ?? '');
$payerName = trim($payload['payerName'] ?? ($checkout['name'] ?? 'Guest User'));

if (empty($cart)) {
    echo json_encode(['success' => false, 'message' => 'Cart is empty.']);
    exit;
}

$productMap = [];
foreach (getProducts($conn) as $product) {
    $productMap[(string) $product['id']] = $product;
}

$validatedItems = [];
$subtotal = 0;

foreach ($cart as $item) {
    $productId = (string) ($item['id'] ?? '');
    $qty = max(1, (int) ($item['qty'] ?? 1));

    if (!isset($productMap[$productId])) {
        continue;
    }

    $product = $productMap[$productId];
    $unitPrice = (float) $product['price'];
    $validatedItems[] = [
        'product_id' => (int) $product['id'],
        'quantity' => $qty,
        'unit_price' => $unitPrice,
    ];
    $subtotal += $unitPrice * $qty;
}

if (empty($validatedItems)) {
    echo json_encode(['success' => false, 'message' => 'No valid items found in cart.']);
    exit;
}

$discount = $subtotal >= 199 ? round($subtotal * 0.10, 2) : 0;
$deliveryFee = 25;
$grandTotal = $subtotal - $discount + $deliveryFee;

if (!($conn instanceof mysqli)) {
    $demoId = 'DEMO-' . time();
    $_SESSION['last_order_id'] = $demoId;
    echo json_encode([
        'success' => true,
        'order_id' => $demoId,
        'total' => $grandTotal,
        'demo' => true,
        'message' => 'Order placed in demo mode.',
    ]);
    exit;
}

try {
    $conn->begin_transaction();

    $status = 'Preparing';
    $userId = $_SESSION['user']['id'] ?? null;

    if ($userId) {
        $orderStmt = $conn->prepare('INSERT INTO orders (user_id, total_price, status) VALUES (?, ?, ?)');
        if (!$orderStmt) {
            throw new Exception('Failed to prepare order insert.');
        }
        $orderStmt->bind_param('ids', $userId, $grandTotal, $status);
    } else {
        $orderStmt = $conn->prepare('INSERT INTO orders (user_id, total_price, status) VALUES (NULL, ?, ?)');
        if (!$orderStmt) {
            throw new Exception('Failed to prepare guest order insert.');
        }
        $orderStmt->bind_param('ds', $grandTotal, $status);
    }

    if (!$orderStmt->execute()) {
        throw new Exception('Unable to save order.');
    }
    $orderId = $conn->insert_id;
    $orderStmt->close();

    $itemStmt = $conn->prepare('INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)');
    if (!$itemStmt) {
        throw new Exception('Failed to prepare order items insert.');
    }

    foreach ($validatedItems as $item) {
        $itemStmt->bind_param('iiid', $orderId, $item['product_id'], $item['quantity'], $item['unit_price']);
        if (!$itemStmt->execute()) {
            throw new Exception('Unable to save order item.');
        }
    }
    $itemStmt->close();

    $upiId = '9588103298-2@ybl';
    $paymentStmt = $conn->prepare('INSERT INTO payments (order_id, user_name, price, upi_id, transaction_method, transaction_ref) VALUES (?, ?, ?, ?, ?, ?)');
    if (!$paymentStmt) {
        throw new Exception('Failed to prepare payment insert.');
    }
    $paymentStmt->bind_param('isdsss', $orderId, $payerName, $grandTotal, $upiId, $paymentMethod, $transactionRef);
    if (!$paymentStmt->execute()) {
        throw new Exception('Unable to save payment details.');
    }
    $paymentStmt->close();

    $conn->commit();
    $_SESSION['last_order_id'] = $orderId;

    echo json_encode([
        'success' => true,
        'order_id' => $orderId,
        'total' => $grandTotal,
        'message' => 'Order placed successfully.',
    ]);
} catch (Throwable $exception) {
    $conn->rollback();
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Order placement failed: ' . $exception->getMessage(),
    ]);
}
