<?php
session_start();

require_once __DIR__ . "/../config/config.php";

// Return JSON response
function sendResponse($success, $message, $cartCount = 0, $status = 200) {
    http_response_code($status);
    header("Content-Type: application/json");

    echo json_encode([
        "success" => $success,
        "message" => $message,
        "cartCount" => $cartCount
    ]);

    exit();
}

// Check if Add to Cart button was clicked
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {

    // Get submitted product information
    $product_uuid = trim($_POST['product_uuid'] ?? '');
    $quantity = filter_var($_POST['quantity'] ?? 1, FILTER_VALIDATE_INT);

    // Validate input
    if (empty($product_uuid) || $quantity === false || $quantity < 1) {
        sendResponse(false, "Invalid product information.", 0, 400);
    }

    // Get product from database
    $stmt = mysqli_prepare(
        $conn,
        "SELECT id, uuid, productName, price, img
         FROM product_item
         WHERE uuid = ?
         LIMIT 1"
    );

    if (!$stmt) {
        sendResponse(false, "Database query failed.", 0, 500);
    }

    mysqli_stmt_bind_param($stmt, "s", $product_uuid);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $product = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    // Check if product exists
    if (!$product) {
        sendResponse(false, "Product not found.", 0, 404);
    }

    // Create cart session if it does not exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $product_id = $product['id'];

    // Check if product is already in cart
    if (isset($_SESSION['cart'][$product_id])) {

        // Add to existing quantity
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;

    } else {

        // Add new product to cart
        $_SESSION['cart'][$product_id] = [
            'id'       => $product['id'],
            'uuid'     => $product['uuid'],
            'name'     => $product['productName'],
            'price'    => $product['price'],
            'img'      => $product['img'],
            'quantity' => $quantity
        ];
    }

    // Calculate total quantity in cart
    $cartCount = 0;

    foreach ($_SESSION['cart'] as $item) {
        $cartCount += $item['quantity'];
    }

    // Send success response without redirecting
    sendResponse(true, "Product added to cart!", $cartCount);
}

// If accessed directly, return to order page
header("Location: ../../public/order.php");
exit();

?>