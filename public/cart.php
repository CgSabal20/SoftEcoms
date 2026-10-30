<?php
session_start();

$pageClass = "cart-page";

// REMOVE ITEM FROM CART
if (isset($_GET['remove'])) {

    $product_id = intval($_GET['remove']);

    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }

    header("Location: cart.php");
    exit();
}

include('./admin/includes/header.php');
include('./admin/includes/topbar.php');

$cart = $_SESSION['cart'] ?? [];
?>

<div class="container my-5 px-4">

    <h2 class="text-center mb-5">My Shopping Cart</h2>

    <?php if (empty($cart)) { ?>

        <div class="text-center py-5">
            <h4>Your cart is empty!</h4>
            <p>Looks like you haven't added any pastries yet.</p>

            <a href="order.php" class="btn btn-dark mt-3">
                Continue Shopping
            </a>
        </div>

    <?php } else { ?>

        <div class="row">

            <div class="col-lg-8">

                <?php foreach ($cart as $id => $item) { ?>

                    <div class="card mb-4 shadow-sm rounded-4">

                        <div class="card-body">

                            <div class="row align-items-center">

                                <!-- PRODUCT IMAGE -->
                                <div class="col-md-3">

                                    <img
                                        src="assets/product_img/<?php echo htmlspecialchars($item['img']); ?>"
                                        class="img-fluid rounded-4"
                                        style="height:120px; width:100%; object-fit:cover;">

                                </div>

                                <!-- PRODUCT DETAILS -->
                                <div class="col-md-4">

                                    <h5>
                                        <?php echo htmlspecialchars($item['name']); ?>
                                    </h5>

                                    <p class="text-muted mb-0">
                                        ₱<?php echo number_format($item['price'], 2); ?>
                                    </p>

                                </div>

                                <!-- QUANTITY -->
                                <div class="col-md-3">

                                    <form action="update_cart.php" method="POST"
                                          class="d-flex align-items-center gap-2">

                                        <input type="hidden" name="product_id"
                                               value="<?php echo $id; ?>">

                                        <input type="number"
                                               name="quantity"
                                               value="<?php echo $item['quantity']; ?>"
                                               min="1"
                                               class="form-control"
                                               style="width:75px;">

                                        <button type="submit"
                                                name="update"
                                                class="btn btn-outline-dark btn-sm">
                                            Update
                                        </button>

                                    </form>

                                </div>

                                <!-- SUBTOTAL AND REMOVE -->
                                <div class="col-md-2 text-end">

                                    <p class="fw-bold">
                                        ₱<?php echo number_format(
                                            $item['price'] * $item['quantity'], 2
                                        ); ?>
                                    </p>

                                    <a href="#"
                                       class="text-danger text-decoration-none"
                                       data-bs-toggle="modal"
                                       data-bs-target="#removeModal<?php echo $id; ?>">
                                        Remove
                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- REMOVE CONFIRMATION MODAL -->
                    <div class="modal fade"
                         id="removeModal<?php echo $id; ?>"
                         tabindex="-1"
                         aria-hidden="true">

                        <div class="modal-dialog modal-dialog-centered">

                            <div class="modal-content rounded-4 border-0">

                                <div class="modal-body text-center p-4">

                                    <div class="mb-3">
                                        <i class="fas fa-trash-alt"
                                           style="font-size:40px; color:#B65D50;">
                                        </i>
                                    </div>

                                    <h4 class="fw-bold">
                                        Remove Item?
                                    </h4>

                                    <p class="text-muted">
                                        Are you sure you want to remove
                                        <strong>
                                            <?php echo htmlspecialchars($item['name']); ?>
                                        </strong>
                                        from your cart?
                                    </p>

                                    <div class="d-flex justify-content-center gap-2 mt-4">

                                        <button type="button"
                                                class="btn btn-outline-secondary rounded-pill px-4"
                                                data-bs-dismiss="modal">
                                            Cancel
                                        </button>

                                        <a href="cart.php?remove=<?php echo $id; ?>"
                                           class="btn rounded-pill px-4 text-white"
                                           style="background:#704638;">
                                            Yes, Remove
                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                <?php } ?>

            </div>


            <!-- ORDER SUMMARY -->
            <div class="col-lg-4">

                <div class="card shadow-sm rounded-4 p-4">

                    <h4 class="mb-4">Order Summary</h4>

                    <?php
                    $total = 0;

                    foreach ($cart as $item) {
                        $total += $item['price'] * $item['quantity'];
                    }
                    ?>

                    <div class="d-flex justify-content-between mb-3">

                        <span>Subtotal</span>

                        <span>
                            ₱<?php echo number_format($total, 2); ?>
                        </span>

                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-4">

                        <h5>Total</h5>

                        <h5>
                            ₱<?php echo number_format($total, 2); ?>
                        </h5>

                    </div>

                    <a href="checkout.php"
                       class="btn btn-dark w-100 rounded-pill">
                        Proceed to Checkout
                    </a>

                    <a href="order.php"
                       class="btn btn-outline-dark w-100 rounded-pill mt-3">
                        Continue Shopping
                    </a>

                </div>

            </div>

        </div>

    <?php } ?>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
