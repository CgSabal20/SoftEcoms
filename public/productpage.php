
<?php
session_start();

$pageClass = "product-page";

require_once __DIR__ . "/../app/config/config.php";

$product = null;

/* ==========================================
   FIND PRODUCT USING UUID OR ID
========================================== */

if (isset($_GET['uuid']) && trim($_GET['uuid']) !== '') {

    $uuid = trim($_GET['uuid']);

    $stmt = mysqli_prepare(
        $conn,
        "SELECT id, uuid, productName, productDescription, price, img, stock
         FROM product_item
         WHERE uuid = ?
         LIMIT 1"
    );

    if (!$stmt) {
        http_response_code(500);
        exit("Unable to prepare the product query.");
    }

    mysqli_stmt_bind_param($stmt, "s", $uuid);

} elseif (
    isset($_GET['id']) &&
    filter_var($_GET['id'], FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1]
    ])
) {

    $id = (int) $_GET['id'];

    $stmt = mysqli_prepare(
        $conn,
        "SELECT id, uuid, productName, productDescription, price, img, stock
         FROM product_item
         WHERE id = ?
         LIMIT 1"
    );

    if (!$stmt) {
        http_response_code(500);
        exit("Unable to prepare the product query.");
    }

    mysqli_stmt_bind_param($stmt, "i", $id);

} else {

    http_response_code(400);
    exit("Invalid product selection.");

}

if (!mysqli_stmt_execute($stmt)) {
    http_response_code(500);
    exit("Unable to load this product.");
}

$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$product) {
    http_response_code(404);
    exit("Product not found.");
}

// Normalize stock to an integer.
$productStock = max(0, (int)($product['stock'] ?? 0));
$isOutOfStock = $productStock <= 0;

include('includes/header.php');
include('includes/topbar.php');
?>

<main class="product-page">

    <div class="product-container" style="margin-top: 60px;">

        <!-- ==========================================
             PRODUCT IMAGE
        ========================================== -->

        <section class="product-image-panel">

            <div class="image-wrapper">

                <img
                    src="assets/product_img/<?php echo rawurlencode(basename($product['img'] ?? '')); ?>"
                    alt="<?php echo htmlspecialchars($product['productName'], ENT_QUOTES, 'UTF-8'); ?>"
                >

            </div>

        </section>

        <!-- ==========================================
             PRODUCT DETAILS
        ========================================== -->

        <section class="product-details">

            <div class="brand">Premium Collection</div>

            <h1 class="product-title">
                <?php echo htmlspecialchars($product['productName'], ENT_QUOTES, 'UTF-8'); ?>
            </h1>

            <div class="price-section">

                <span class="price">
                    ₱<?php echo number_format((float)$product['price'], 2); ?>
                </span>

            </div>

            <!-- STOCK INFORMATION -->

            <div class="stock-information mt-2 mb-3">

                <?php if ($isOutOfStock): ?>

                    <span class="text-danger fw-bold">
                        <i class="fas fa-times-circle"></i>
                        Out of Stock
                    </span>

                <?php else: ?>

                    <span class="text-success fw-bold">
                        <i class="fas fa-check-circle"></i>
                        <?php echo $productStock; ?> available in stock
                    </span>

                <?php endif; ?>

            </div>

            <p class="product-description">
                <?php
                echo nl2br(htmlspecialchars(
                    $product['productDescription'] ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                ));
                ?>
            </p>

            <!-- ==========================================
                 ADD TO CART FORM
            ========================================== -->

            <form
                method="POST"
                action="http://localhost:3000/cart/add"
                id="cartForm"
            >

                <input
                    type="hidden"
                    name="product_uuid"
                    value="<?php echo htmlspecialchars($product['uuid'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                >

                <input type="hidden" name="selected_size" value="L">
                <input type="hidden" name="selected_color" value="Orange">

                <label class="label" for="quantity_input">
                    Quantity
                </label>

                <div class="quantity-box">

                    <button
                        type="button"
                        id="decreaseQuantity"
                        aria-label="Decrease quantity"
                        <?php echo $isOutOfStock ? 'disabled' : ''; ?>
                    >
                        −
                    </button>

                    <input
                        type="number"
                        name="quantity"
                        id="quantity_input"
                        value="1"
                        min="1"
                        max="<?php echo $productStock; ?>"
                        step="1"
                        required
                        <?php echo $isOutOfStock ? 'disabled' : ''; ?>
                    >

                    <button
                        type="button"
                        id="increaseQuantity"
                        aria-label="Increase quantity"
                        <?php echo $isOutOfStock ? 'disabled' : ''; ?>
                    >
                        +
                    </button>

                </div>

                <button
                    type="submit"
                    name="add_to_cart"
                    class="buy-btn"
                    <?php echo $isOutOfStock ? 'disabled' : ''; ?>
                >

                    <i class="fas fa-shopping-cart" aria-hidden="true"></i>

                    <?php echo $isOutOfStock
                        ? 'Out of Stock'
                        : 'Add to Cart'; ?>

                </button>

            </form>

        </section>

    </div>

</main>

<style>

/* ==========================================
   STOCK INFORMATION
========================================== */

.stock-information {
    font-size: 14px;
}

.stock-information .text-danger {
    color: #dc3545 !important;
}

.stock-information .text-success {
    color: #198754 !important;
}

/* ==========================================
   DISABLED BUTTONS
========================================== */

.buy-btn:disabled,
.quantity-box button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* ==========================================
   FLYING PRODUCT
========================================== */

.flying-product {
    position: fixed !important;
    z-index: 999999 !important;
    object-fit: cover;
    pointer-events: none;
    border-radius: 15px;
    will-change: transform, opacity, border-radius;

    transition:
        transform 0.8s cubic-bezier(0.22, 1, 0.36, 1),
        opacity 0.8s ease,
        border-radius 0.8s ease;
}

/* ==========================================
   CART BOUNCE
========================================== */

#cartIcon.cart-bounce {
    animation: cartBounce 0.6s ease;
}

@keyframes cartBounce {

    0%, 100% {
        transform: scale(1);
    }

    30% {
        transform: scale(1.35) rotate(-12deg);
    }

    60% {
        transform: scale(0.9) rotate(8deg);
    }

}

/* ==========================================
   SUCCESS NOTIFICATION
========================================== */

.cart-toast {
    position: fixed;
    z-index: 1000000;
    top: 160px;
    left: 50%;
    bottom: auto;

    transform: translate(-50%, -20px);
    opacity: 0;

    padding: 14px 25px;
    border-radius: 30px;

    color: white;

    background: linear-gradient(
        to right,
        #F56C6C,
        #FF9B4F,
        #FFA1A1
    );

    box-shadow: 0 5px 15px rgba(245, 108, 108, .3);

    font-weight: 600;

    transition: all .3s ease;

    pointer-events: none;
}

.cart-toast.show {
    opacity: 1;
    transform: translate(-50%, 0);
}

.cart-toast.error {
    background: #B94040;
}

</style>

<script>

document.addEventListener("DOMContentLoaded", function () {

    const API_URL = "http://localhost:3000";

    const form = document.getElementById("cartForm");
    const quantityInput = document.getElementById("quantity_input");

    const decreaseButton = document.getElementById("decreaseQuantity");
    const increaseButton = document.getElementById("increaseQuantity");

    const addButton = form.querySelector(".buy-btn");

    const cartIcon =
        document.getElementById("cartIcon") ||
        document.querySelector('a.nav-icon[href*="cart.php"]');

    const availableStock = Number(quantityInput.max) || 0;

    // ==========================================
    // QUANTITY CONTROLS
    // ==========================================

    decreaseButton.addEventListener("click", function () {

        if (availableStock <= 0) return;

        quantityInput.value = Math.max(
            1,
            (parseInt(quantityInput.value, 10) || 1) - 1
        );

    });

    increaseButton.addEventListener("click", function () {

        if (availableStock <= 0) return;

        const currentQuantity =
            parseInt(quantityInput.value, 10) || 1;

        if (currentQuantity < availableStock) {

            quantityInput.value = currentQuantity + 1;

        } else {

            showMessage(
                `Only ${availableStock} item(s) available.`,
                true
            );

        }

    });

    quantityInput.addEventListener("change", function () {

        if (availableStock <= 0) {
            quantityInput.value = 0;
            return;
        }

        let quantity = Number(quantityInput.value);

        if (!Number.isSafeInteger(quantity) || quantity < 1) {
            quantity = 1;
        }

        if (quantity > availableStock) {

            quantity = availableStock;

            showMessage(
                `Only ${availableStock} item(s) available.`,
                true
            );

        }

        quantityInput.value = quantity;

    });

    // ==========================================
    // UPDATE CART BADGE
    // Always get the latest count from the API.
    // ==========================================

    async function updateCartBadge() {

        const badge = document.getElementById("cartCount");

        if (!badge) {
            return;
        }

        try {

            const response = await fetch(
                API_URL + "/cart/count",
                {
                    method: "GET",
                    credentials: "include",
                    headers: {
                        "Accept": "application/json"
                    }
                }
            );

            const data = await response.json();

            if (!response.ok || data.success === false) {
                throw new Error(
                    data.message || "Unable to get cart count."
                );
            }

            const count = Math.max(
                0,
                Number(data.cartCount) || 0
            );

            badge.textContent = count;
            badge.style.display = count > 0 ? "flex" : "none";

        } catch (error) {

            console.error("Cart badge error:", error);

        }

    }

    // ==========================================
    // ADD PRODUCT TO CART
    // ==========================================

    form.addEventListener("submit", async function (event) {

        event.preventDefault();

        const quantity = Number(quantityInput.value);

        const productUUID = form.querySelector(
            'input[name="product_uuid"]'
        ).value;

        // CHECK STOCK

        if (availableStock <= 0) {

            showMessage("This product is currently out of stock.", true);

            return;

        }

        // VALIDATE QUANTITY

        if (!Number.isSafeInteger(quantity) || quantity < 1) {

            quantityInput.value = 1;
            quantityInput.focus();

            showMessage("Please enter a valid quantity.", true);

            return;

        }

        if (quantity > availableStock) {

            showMessage(
                `Only ${availableStock} item(s) available.`,
                true
            );

            quantityInput.value = availableStock;

            return;

        }

        if (!productUUID) {

            showMessage("Product UUID is missing.", true);

            return;

        }

        if (addButton.disabled) {
            return;
        }

        addButton.disabled = true;

        const originalText = addButton.innerHTML;

        addButton.innerHTML = "Adding...";

        try {

            const response = await fetch(
                API_URL + "/cart/add",
                {
                    method: "POST",
                    credentials: "include",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({
                        product_uuid: productUUID,
                        quantity: quantity
                    })
                }
            );

            const responseText = await response.text();

            console.log("Cart API Status:", response.status);
            console.log("Cart API Response:", responseText);

            let data;

            try {

                data = JSON.parse(responseText);

            } catch (error) {

                throw new Error(
                    "The Node.js server returned an invalid response."
                );

            }

            // LOGIN CHECK

            if (response.status === 401) {

                window.location.href =
                    data.redirect || "/SoftEcoms/public/login.php";

                return;

            }

            // STOCK OR OTHER API ERROR

            if (!response.ok || !data.success) {

                throw new Error(
                    data.message || "Unable to add product to cart."
                );

            }

            // ANIMATE PRODUCT

            await animateProductToCart();

            // GET THE LATEST DATABASE COUNT

            await updateCartBadge();

            // SUCCESS MESSAGE

            showMessage("✓ Added to your cart!");

            // Customer stays on the product page.

        } catch (error) {

            console.error("Add to cart error:", error);

            showMessage("✕ " + error.message, true);

        } finally {

            // Keep button disabled if the product is out of stock.
            if (availableStock > 0) {
                addButton.disabled = false;
                addButton.innerHTML = originalText;
            }

        }

    });

    // ==========================================
    // FLYING IMAGE ANIMATION
    // ==========================================

    function animateProductToCart() {

        return new Promise(function (resolve) {

            const productImage =
                document.querySelector(".image-wrapper img");

            if (!productImage || !cartIcon) {

                console.error(
                    "Product image or cart icon was not found."
                );

                resolve();

                return;

            }

            const start = productImage.getBoundingClientRect();
            const end = cartIcon.getBoundingClientRect();

            const flyingImage = productImage.cloneNode(true);

            flyingImage.classList.add("flying-product");

            Object.assign(flyingImage.style, {
                left: start.left + "px",
                top: start.top + "px",
                width: start.width + "px",
                height: start.height + "px"
            });

            document.body.appendChild(flyingImage);

            flyingImage.getBoundingClientRect();

            requestAnimationFrame(function () {

                const moveX =
                    (end.left + end.width / 2) -
                    (start.left + start.width / 2);

                const moveY =
                    (end.top + end.height / 2) -
                    (start.top + start.height / 2);

                flyingImage.style.transform =
                    `translate(${moveX}px, ${moveY}px) scale(0.12)`;

                flyingImage.style.opacity = "0.3";
                flyingImage.style.borderRadius = "50%";

            });

            setTimeout(function () {

                flyingImage.remove();

                cartIcon.classList.remove("cart-bounce");

                void cartIcon.offsetWidth;

                cartIcon.classList.add("cart-bounce");

                resolve();

            }, 800);

        });

    }

    // ==========================================
    // NOTIFICATION
    // ==========================================

    function showMessage(message, isError = false) {

        const toast = document.createElement("div");

        toast.className = "cart-toast";

        if (isError) {
            toast.classList.add("error");
        }

        toast.textContent = message;

        document.body.appendChild(toast);

        requestAnimationFrame(function () {
            toast.classList.add("show");
        });

        setTimeout(function () {

            toast.classList.remove("show");

            setTimeout(function () {
                toast.remove();
            }, 300);

        }, 2200);

    }

    // ==========================================
    // INITIALIZATION
    // ==========================================

    // Refresh badge when product page opens.
    updateCartBadge();

});

</script>
