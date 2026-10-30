```php
<?php
session_start();

require_once __DIR__ . "/../config/config.php";

// Check if Add to Cart button was clicked
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {

    // Get submitted product information
    $product_uuid = trim($_POST['product_uuid'] ?? '');
    $quantity = filter_var($_POST['quantity'] ?? 1, FILTER_VALIDATE_INT);

    // Validate input
    if (empty($product_uuid) || $quantity === false || $quantity < 1) {
        header("Location: ../../public/order.php");
        exit();
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
        exit("Database query failed.");
    }

    mysqli_stmt_bind_param($stmt, "s", $product_uuid);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $product = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    // Check if product exists
    if (!$product) {
        exit("Product not found.");
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

    // Redirect to cart page
    header("Location: ../../public/cart.php");
    exit();

}

// If accessed directly, return to order page
header("Location: ../../public/order.php");
exit();

?>
```