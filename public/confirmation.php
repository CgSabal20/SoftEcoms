
<?php
session_start();

/*
|--------------------------------------------------------------------------
| RECEIVE ORDER CONFIRMATION
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    header('Content-Type: application/json; charset=utf-8');

    $rawInput = file_get_contents('php://input');
    $data = json_decode($rawInput, true);

    if (!is_array($data) || !isset($data['order'])) {
        http_response_code(400);

        echo json_encode([
            'success' => false,
            'message' => 'Invalid order confirmation data.'
        ]);

        exit;
    }

    $order = $data['order'];

    $orderNumber = trim((string)($order['orderNumber'] ?? ''));
    $totalPrice = $order['totalPrice'] ?? null;
    $subtotal = $order['subtotal'] ?? null;
    $tax = $order['tax'] ?? null;
    $paymentMethod = trim((string)($order['paymentMethod'] ?? ''));
    $status = trim((string)($order['status'] ?? ''));

    if (
        $orderNumber === '' ||
        !is_numeric($totalPrice) ||
        !is_numeric($subtotal) ||
        !is_numeric($tax) ||
        !in_array($paymentMethod, ['Cash', 'GCash'], true)
    ) {
        http_response_code(400);

        echo json_encode([
            'success' => false,
            'message' => 'Incomplete order confirmation details.'
        ]);

        exit;
    }

    $_SESSION['last_order_confirmation'] = [
        'orderNumber' => $orderNumber,
        'subtotal' => (float)$subtotal,
        'tax' => (float)$tax,
        'totalPrice' => (float)$totalPrice,
        'paymentMethod' => $paymentMethod,
        'status' => $status ?: 'pending',
        'createdAt' => date('F d, Y h:i A')
    ];

    echo json_encode([
        'success' => true,
        'message' => 'Order confirmation saved.'
    ]);

    exit;
}

/*
|--------------------------------------------------------------------------
| DISPLAY RECEIPT
|--------------------------------------------------------------------------
*/

$receipt = $_SESSION['last_order_confirmation'] ?? null;

if (!$receipt) {
    header('Location: order.php');
    exit;
}

$pageClass = "confirmation-page";

include('./admin/includes/header.php');
include('./admin/includes/topbar.php');

function formatPeso($amount) {
    return '₱' . number_format((float)$amount, 2);
}
?>

<link rel="stylesheet" href="assets/css/confirmation.css">

<main class="confirmation-page">

    <div class="confirmation-container">

        <div class="confirmation-card">

            <!-- SUCCESS MESSAGE -->

            <div class="confirmation-success">

                <div class="success-icon">✓</div>

                <h1>Order Placed Successfully!</h1>

                <p>
                    Thank you for ordering from Sweet!
                    Your order has been received.
                </p>

            </div>

            <!-- ORDER NUMBER -->

            <div class="order-number-box">

                <small>Your Order Number</small>

                <strong>
                    <?= htmlspecialchars($receipt['orderNumber']) ?>
                </strong>

            </div>

            <!-- ORDER DETAILS -->

            <h3 class="receipt-heading">
                Order Details
            </h3>

            <div class="receipt-row">
                <span>Order Number</span>

                <strong>
                    <?= htmlspecialchars($receipt['orderNumber']) ?>
                </strong>
            </div>

            <div class="receipt-row">
                <span>Order Date</span>

                <strong>
                    <?= htmlspecialchars($receipt['createdAt']) ?>
                </strong>
            </div>

            <div class="receipt-row">
                <span>Payment Method</span>

                <strong>
                    <?= htmlspecialchars($receipt['paymentMethod']) ?>
                </strong>
            </div>

            <div class="receipt-row">
                <span>Order Status</span>

                <strong>
                    <span class="order-status">
                        <?= htmlspecialchars($receipt['status']) ?>
                    </span>
                </strong>
            </div>

            <div class="receipt-divider"></div>

            <!-- PAYMENT SUMMARY -->

            <h3 class="receipt-heading">
                Payment Summary
            </h3>

            <div class="receipt-row">
                <span>Subtotal</span>

                <strong>
                    <?= formatPeso($receipt['subtotal']) ?>
                </strong>
            </div>

            <div class="receipt-row">
                <span>VAT (12%)</span>

                <strong>
                    <?= formatPeso($receipt['tax']) ?>
                </strong>
            </div>

            <div class="receipt-divider"></div>

            <div class="receipt-total">

                <span>Total Amount</span>

                <strong>
                    <?= formatPeso($receipt['totalPrice']) ?>
                </strong>

            </div>

            <!-- INFORMATION -->

            <div class="confirmation-note">

                <strong>What's next?</strong>

                <p>
                    Your order is currently pending.
                    Please wait for the store to review and process
                    your order. Thank you for choosing Sweet!
                </p>

            </div>

            <!-- ACTION BUTTONS -->

            <div class="confirmation-actions">

                <a href="order.php" class="continue-shopping">
                    Continue Shopping
                </a>

                <a href="index.php" class="back-home">
                    Back to Home
                </a>

            </div>

        </div>

    </div>

</main>

</body>
</html>
