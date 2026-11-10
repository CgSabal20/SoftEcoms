
<?php
session_start();

$pageClass = "checkout-page";

// Clear selected cart IDs after successful checkout.
if (isset($_GET['clear_selection']) && $_GET['clear_selection'] === '1') {
    unset($_SESSION['checkout_selected_cart_ids']);

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['success' => true]);
    exit;
}

// Receive selected cart IDs from cart.php.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $submitted = $_POST['selected_cart_ids'] ?? [];

    if (!is_array($submitted)) {
        $submitted = [];
    }

    $selectedIDs = [];

    foreach ($submitted as $id) {
        $validated = filter_var($id, FILTER_VALIDATE_INT);

        if ($validated !== false && $validated > 0) {
            $selectedIDs[] = $validated;
        }
    }

    $selectedIDs = array_values(array_unique($selectedIDs));

    if (empty($selectedIDs)) {
        unset($_SESSION['checkout_selected_cart_ids']);
        header('Location: cart.php');
        exit;
    }

    $_SESSION['checkout_selected_cart_ids'] = $selectedIDs;
}

$selectedIDs = $_SESSION['checkout_selected_cart_ids'] ?? [];

if (empty($selectedIDs) || !is_array($selectedIDs)) {
    header('Location: cart.php');
    exit;
}

include('./admin/includes/header.php');
include('./admin/includes/topbar.php');
?>

<link rel="stylesheet" href="assets/css/checkout.css">

<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
>

<style>
#deliveryMap {
    width: 100%;
    height: 380px;
    border-radius: 14px;
    margin-top: 12px;
    border: 1px solid #ddd;
    z-index: 1;
}

.map-description {
    font-size: 14px;
    color: #777;
    margin-top: 5px;
}

.map-location-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 12px;
}

.map-location-actions button {
    padding: 10px 16px;
    border: 1px solid #222;
    border-radius: 8px;
    background: white;
    cursor: pointer;
    font-size: 13px;
    font-weight: 600;
    transition: 0.2s;
}

.map-location-actions button:hover {
    background: #222;
    color: white;
}

#selectedCoordinates {
    display: block;
    margin-top: 12px;
    font-size: 13px;
    color: #666;
}

#checkoutForm[hidden],
#checkoutLoading[hidden],
#checkoutError[hidden],
#checkoutEmpty[hidden] {
    display: none !important;
}

@media (max-width: 600px) {
    #deliveryMap {
        height: 300px;
    }

    .map-location-actions button {
        flex: 1;
    }
}
</style>

<main class="checkout-page">

    <div class="checkout-container">

        <header class="checkout-heading">

            <span class="checkout-eyebrow">
                SWEET! • ALMOST THERE
            </span>

            <h1>Complete Your Order</h1>

            <p>
                Review your selected pastries and provide your delivery details.
            </p>

            <div class="checkout-progress" aria-label="Checkout progress">

                <div class="progress-step completed">
                    <span>✓</span>
                    <small>Cart</small>
                </div>

                <div class="progress-line active"></div>

                <div class="progress-step current">
                    <span>2</span>
                    <small>Checkout</small>
                </div>

                <div class="progress-line"></div>

                <div class="progress-step">
                    <span>3</span>
                    <small>Confirmation</small>
                </div>

            </div>

        </header>

        <div id="checkoutLoading" class="checkout-message">
            Loading your selected products...
        </div>

        <div
            id="checkoutError"
            class="checkout-message checkout-error"
            hidden
        ></div>

        <section id="checkoutEmpty" class="checkout-empty" hidden>

            <div class="empty-icon">♡</div>

            <h3>No selected products found</h3>

            <p>
                Your selected cart items may have been removed.
                Return to your cart and select products again.
            </p>

            <a href="cart.php" class="checkout-main-btn">
                Return to Cart
            </a>

        </section>

        <form id="checkoutForm" hidden>

            <div class="checkout-layout">

                <!-- LEFT SIDE -->

                <div class="checkout-main">

                    <!-- DELIVERY INFORMATION -->

                    <section class="checkout-card">

                        <div class="section-heading">

                            <div class="section-icon">01</div>

                            <div>
                                <h3>Delivery Information</h3>
                                <p>Where should we deliver your order?</p>
                            </div>

                        </div>

                        <div class="form-grid">

                            <div class="form-group full-width">

                                <label for="checkoutAddress">
                                    Complete Delivery Address
                                </label>

                                <textarea
                                    id="checkoutAddress"
                                    name="address"
                                    rows="4"
                                    placeholder="House number, street, barangay, city / municipality"
                                    required
                                    maxlength="1000"
                                ></textarea>

                            </div>

                            <div class="form-group full-width">

                                <label for="checkoutPhone">
                                    Contact Number
                                </label>

                                <input
                                    type="tel"
                                    id="checkoutPhone"
                                    name="phone"
                                    placeholder="09XX XXX XXXX"
                                    maxlength="20"
                                    required
                                >

                            </div>

                            <!-- MAP LOCATION -->

                            <div class="form-group full-width">

                                <label>
                                    Pin Your Delivery Location
                                </label>

                                <p class="map-description">
                                    Select your exact delivery location.
                                    Click anywhere on the map or drag the pin.
                                </p>

                                <div id="deliveryMap"></div>

                                <div class="map-location-actions">

                                    <button
                                        type="button"
                                        id="useCurrentLocation"
                                    >
                                        📍 Use My Current Location
                                    </button>

                                    <button
                                        type="button"
                                        id="resetMapLocation"
                                    >
                                        Reset Map
                                    </button>

                                </div>

                                <small id="selectedCoordinates">
                                    No delivery location selected yet.
                                </small>

                                <input type="hidden" id="deliveryLatitude">
                                <input type="hidden" id="deliveryLongitude">

                            </div>

                        </div>

                    </section>

                    <!-- PAYMENT METHOD -->

                    <section class="checkout-card">

                        <div class="section-heading">

                            <div class="section-icon">02</div>

                            <div>
                                <h3>Payment Method</h3>
                                <p>Choose how you want to pay for your order.</p>
                            </div>

                        </div>

                        <div class="payment-options">

                            <label class="payment-option selected">

                                <input
                                    type="radio"
                                    name="payment_method"
                                    value="Cash"
                                    checked
                                >

                                <span class="payment-symbol">₱</span>

                                <span class="payment-details">
                                    <strong>Cash on Delivery</strong>
                                    <small>Pay when your order arrives.</small>
                                </span>

                                <span class="choice-check">✓</span>

                            </label>

                            <label class="payment-option">

                                <input
                                    type="radio"
                                    name="payment_method"
                                    value="GCash"
                                >

                                <span class="gcash-symbol">G</span>

                                <span class="payment-details">
                                    <strong>GCash</strong>
                                    <small>Choose GCash as your payment method.</small>
                                </span>

                                <span class="choice-check">✓</span>

                            </label>

                        </div>

                        <div class="gcash-note" id="gcashNote" hidden>
                            GCash is recorded as your selected payment method.
                            Payment processing or QR-code verification is not
                            integrated yet.
                        </div>

                    </section>

                </div>

                <!-- RIGHT SIDE: ORDER SUMMARY -->

                <aside class="checkout-sidebar">

                    <div class="summary-card">

                        <div class="summary-heading">

                            <div>
                                <span class="checkout-eyebrow">
                                    YOUR SELECTED ITEMS
                                </span>

                                <h3>Order Summary</h3>
                            </div>

                            <a href="cart.php">Edit Cart</a>

                        </div>

                        <div
                            id="summaryProducts"
                            class="summary-products"
                        ></div>

                        <div class="summary-divider"></div>

                        <div class="summary-row">
                            <span>Selected Items</span>
                            <strong id="summaryCount">0</strong>
                        </div>

                        <div class="summary-row">
                            <span>Subtotal</span>
                            <strong id="summarySubtotal">₱0.00</strong>
                        </div>

                        <div class="summary-row">
                            <span>VAT (12%)</span>
                            <strong id="summaryTax">₱0.00</strong>
                        </div>

                        <div class="summary-divider"></div>

                        <div class="summary-total">
                            <span>Total</span>
                            <strong id="summaryTotal">₱0.00</strong>
                        </div>

                        <button
                            type="submit"
                            id="placeOrderButton"
                            class="place-order-btn"
                        >
                            Place Order <span>→</span>
                        </button>

                        <p class="summary-note">
                            Your final order total is verified by the server.
                        </p>

                    </div>

                </aside>

            </div>

        </form>

    </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>

document.addEventListener("DOMContentLoaded", function () {

    // ==========================================
    // CONFIGURATION
    // ==========================================

    const API_URL = "http://localhost:3000";

    const selectedCartIDs = <?php
        echo json_encode(
            array_values($selectedIDs),
            JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP
        );
    ?>;

    // Initial map location: Bislig area.
    // Change this to your actual shop's service area.
    const defaultLocation = [8.8794, 125.0726];

    // ==========================================
    // HTML ELEMENTS
    // ==========================================

    const loading = document.getElementById("checkoutLoading");
    const errorBox = document.getElementById("checkoutError");
    const emptyBox = document.getElementById("checkoutEmpty");

    const form = document.getElementById("checkoutForm");

    const placeOrderButton =
        document.getElementById("placeOrderButton");

    const summaryProducts =
        document.getElementById("summaryProducts");

    const addressInput =
        document.getElementById("checkoutAddress");

    const phoneInput =
        document.getElementById("checkoutPhone");

    const latitudeInput =
        document.getElementById("deliveryLatitude");

    const longitudeInput =
        document.getElementById("deliveryLongitude");

    const coordinatesLabel =
        document.getElementById("selectedCoordinates");

    const useCurrentLocationButton =
        document.getElementById("useCurrentLocation");

    const resetMapButton =
        document.getElementById("resetMapLocation");

    // ==========================================
    // VARIABLES
    // ==========================================

    let selectedCartItems = [];
    let deliveryMap = null;
    let deliveryMarker = null;

    // ==========================================
    // PRICE FORMATTER
    // ==========================================

    function formatPrice(value) {

        return Number(value).toLocaleString("en-PH", {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

    }

    // ==========================================
    // API REQUEST
    // ==========================================

    async function apiRequest(endpoint, options = {}) {

        const response = await fetch(API_URL + endpoint, {

            ...options,

            credentials: "include",

            headers: {
                "Accept": "application/json",
                ...(options.headers || {})
            }

        });

        const responseText = await response.text();

        let data;

        try {
            data = JSON.parse(responseText);
        } catch (error) {

            console.error("Server response:", responseText);

            throw new Error(
                "The server returned an invalid response. Check your Node.js server."
            );

        }

        if (response.status === 401) {

            window.location.href = "/SoftEcoms/public/login.php";

            throw new Error("Please log in first.");

        }

        if (!response.ok || data.success === false) {

            throw new Error(
                data.message || "Something went wrong."
            );

        }

        return data;

    }

    // ==========================================
    // DELIVERY MAP
    // ==========================================

    function initializeDeliveryMap() {

        if (deliveryMap) return;

        deliveryMap = L.map("deliveryMap").setView(
            defaultLocation,
            14
        );

        L.tileLayer(
            "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
            {
                maxZoom: 19,
                attribution:
                    '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }
        ).addTo(deliveryMap);

        deliveryMap.on("click", function (event) {

            setDeliveryLocation(
                event.latlng.lat,
                event.latlng.lng
            );

        });

        setTimeout(function () {
            deliveryMap.invalidateSize();
        }, 200);

    }

    // ==========================================
    // SET DELIVERY LOCATION
    // ==========================================

    function setDeliveryLocation(lat, lng) {

        latitudeInput.value = Number(lat).toFixed(8);
        longitudeInput.value = Number(lng).toFixed(8);

        coordinatesLabel.textContent =
            "Selected location: " +
            Number(lat).toFixed(6) +
            ", " +
            Number(lng).toFixed(6);

        coordinatesLabel.style.color = "#198754";

        if (!deliveryMarker) {

            deliveryMarker = L.marker(
                [lat, lng],
                { draggable: true }
            ).addTo(deliveryMap);

            deliveryMarker.bindPopup("Your delivery location");

            deliveryMarker.on("dragend", function () {

                const position = deliveryMarker.getLatLng();

                setDeliveryLocation(
                    position.lat,
                    position.lng
                );

            });

        } else {

            deliveryMarker.setLatLng([lat, lng]);

        }

        deliveryMap.setView([lat, lng], 17);

    }

    // ==========================================
    // CURRENT LOCATION
    // ==========================================

    useCurrentLocationButton.addEventListener("click", function () {

        if (!navigator.geolocation) {

            Swal.fire(
                "Unavailable",
                "Your browser does not support location services.",
                "warning"
            );

            return;

        }

        useCurrentLocationButton.disabled = true;
        useCurrentLocationButton.textContent = "Getting Location...";

        navigator.geolocation.getCurrentPosition(

            function (position) {

                setDeliveryLocation(
                    position.coords.latitude,
                    position.coords.longitude
                );

                useCurrentLocationButton.disabled = false;
                useCurrentLocationButton.textContent =
                    "📍 Use My Current Location";

            },

            function (error) {

                console.error("Geolocation error:", error);

                Swal.fire(
                    "Location Unavailable",
                    "Please allow location access in your browser or select your location manually on the map.",
                    "warning"
                );

                useCurrentLocationButton.disabled = false;
                useCurrentLocationButton.textContent =
                    "📍 Use My Current Location";

            },

            {
                enableHighAccuracy: true,
                timeout: 15000,
                maximumAge: 0
            }

        );

    });

    // ==========================================
    // RESET MAP
    // ==========================================

    resetMapButton.addEventListener("click", function () {

        latitudeInput.value = "";
        longitudeInput.value = "";

        coordinatesLabel.textContent =
            "No delivery location selected yet.";

        coordinatesLabel.style.color = "#666";

        if (deliveryMarker) {

            deliveryMap.removeLayer(deliveryMarker);
            deliveryMarker = null;

        }

        deliveryMap.setView(defaultLocation, 14);

    });

    // ==========================================
    // PAYMENT METHOD
    // ==========================================

    function updatePaymentSelection() {

        document.querySelectorAll(".payment-option").forEach(option => {

            const radio = option.querySelector(
                'input[type="radio"]'
            );

            option.classList.toggle(
                "selected",
                radio.checked
            );

        });

        const payment = document.querySelector(
            'input[name="payment_method"]:checked'
        )?.value;

        document.getElementById("gcashNote").hidden =
            payment !== "GCash";

    }

    document.querySelectorAll(
        'input[name="payment_method"]'
    ).forEach(radio => {

        radio.addEventListener("change", updatePaymentSelection);

    });

    // ==========================================
    // RENDER ORDER SUMMARY
    // ==========================================

    function renderSummary() {

        summaryProducts.innerHTML = "";

        let subtotalCents = 0;
        let totalQuantity = 0;

        selectedCartItems.forEach(item => {

            const priceCents =
                Math.round(Number(item.price) * 100);

            const quantity = Number(item.quantity);

            subtotalCents += priceCents * quantity;
            totalQuantity += quantity;

            const product = document.createElement("div");
            product.className = "summary-product";

            const imageWrap = document.createElement("div");
            imageWrap.className = "summary-image";

            const image = document.createElement("img");

            image.src =
                "assets/product_img/" +
                encodeURIComponent(item.img || "");

            image.alt = item.productName || "Product";

            image.onerror = function () {
                this.style.visibility = "hidden";
            };

            const quantityBadge = document.createElement("span");
            quantityBadge.textContent = quantity;

            imageWrap.append(image, quantityBadge);

            const info = document.createElement("div");
            info.className = "summary-product-info";

            const name = document.createElement("strong");
            name.textContent = item.productName || "Product";

            const each = document.createElement("small");
            each.textContent =
                "₱" + formatPrice(item.price) + " each";

            info.append(name, each);

            const lineTotal = document.createElement("strong");
            lineTotal.className = "summary-price";

            lineTotal.textContent =
                "₱" + formatPrice(
                    priceCents * quantity / 100
                );

            product.append(imageWrap, info, lineTotal);

            summaryProducts.appendChild(product);

        });

        const taxCents = Math.round(subtotalCents * 0.12);
        const totalCents = subtotalCents + taxCents;

        document.getElementById("summaryCount").textContent =
            totalQuantity;

        document.getElementById("summarySubtotal").textContent =
            "₱" + formatPrice(subtotalCents / 100);

        document.getElementById("summaryTax").textContent =
            "₱" + formatPrice(taxCents / 100);

        document.getElementById("summaryTotal").textContent =
            "₱" + formatPrice(totalCents / 100);

    }

    // ==========================================
    // LOAD SELECTED PRODUCTS
    // ==========================================

    async function loadSelectedItems() {

        try {

            if (
                !Array.isArray(selectedCartIDs) ||
                selectedCartIDs.length === 0
            ) {

                loading.hidden = true;
                emptyBox.hidden = false;

                return;

            }

            const data = await apiRequest("/cart");

            const allItems = Array.isArray(data.cart)
                ? data.cart
                : [];

            const selectedSet = new Set(
                selectedCartIDs.map(Number)
            );

            selectedCartItems = allItems.filter(item =>
                selectedSet.has(Number(item.cartID))
            );

            loading.hidden = true;

            if (
                selectedCartItems.length === 0 ||
                selectedCartItems.length !== selectedSet.size
            ) {

                emptyBox.hidden = false;
                return;

            }

            renderSummary();

            form.hidden = false;

            initializeDeliveryMap();

            updatePaymentSelection();

        } catch (error) {

            console.error("Checkout loading error:", error);

            loading.hidden = true;
            errorBox.textContent = error.message;
            errorBox.hidden = false;

        }

    }

    // ==========================================
    // PLACE ORDER
    // ==========================================

    form.addEventListener("submit", async function (event) {

        event.preventDefault();

        if (selectedCartItems.length === 0) {

            Swal.fire(
                "No selected products",
                "Return to your cart and select products first.",
                "warning"
            );

            return;

        }

        const address = addressInput.value.trim();
        const phone = phoneInput.value.trim();

        const paymentMethod = document.querySelector(
            'input[name="payment_method"]:checked'
        )?.value;

        const latitude = latitudeInput.value;
        const longitude = longitudeInput.value;

        // VALIDATE ADDRESS

        if (!address) {

            Swal.fire(
                "Address Required",
                "Please enter your complete delivery address.",
                "warning"
            );

            return;

        }

        // VALIDATE PHONE

        if (!phone) {

            Swal.fire(
                "Contact Number Required",
                "Please enter your contact number.",
                "warning"
            );

            return;

        }

        // VALIDATE PAYMENT

        if (!paymentMethod) {

            Swal.fire(
                "Payment Required",
                "Please select a payment method.",
                "warning"
            );

            return;

        }

        // VALIDATE MAP

        if (!latitude || !longitude) {

            Swal.fire(
                "Location Required",
                "Please select your delivery location on the map.",
                "warning"
            );

            return;

        }

        const confirmation = await Swal.fire({

            title: "Place your order?",

            text:
                "Please confirm that your selected products and delivery details are correct.",

            icon: "question",

            showCancelButton: true,

            confirmButtonText: "Place Order",

            cancelButtonText: "Review Order"

        });

        if (!confirmation.isConfirmed) return;

        placeOrderButton.disabled = true;
        placeOrderButton.textContent = "Processing Order...";

        try {

            // SEND ORDER TO NODE.JS

            const result = await apiRequest("/checkout", {

                method: "POST",

                headers: {
                    "Content-Type": "application/json"
                },

                body: JSON.stringify({

                    address: address,

                    phone: phone,

                    latitude: Number(latitude),

                    longitude: Number(longitude),

                    payment_method: paymentMethod,

                    selected_cart_ids: selectedCartItems.map(
                        item => Number(item.cartID)
                    )

                })

            });

            // VALIDATE NODE RESPONSE

            if (!result.order || !result.order.orderNumber) {

                throw new Error(
                    "The order was processed, but the server returned incomplete receipt information. Contact the store before attempting another checkout."
                );

            }

            // SAVE RECEIPT IN PHP SESSION

            const confirmationResponse = await fetch(
                "confirmation.php",
                {

                    method: "POST",

                    credentials: "same-origin",

                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },

                    body: JSON.stringify({
                        order: result.order
                    })

                }
            );

            const confirmationData =
                await confirmationResponse.json();

            if (
                !confirmationResponse.ok ||
                !confirmationData.success
            ) {

                throw new Error(
                    "Your order was placed, but the receipt could not be prepared. Order number: " +
                    result.order.orderNumber
                );

            }

            // CLEAR PHP CHECKOUT SELECTION

            try {

                await fetch(
                    "checkout.php?clear_selection=1",
                    {
                        credentials: "same-origin"
                    }
                );

            } catch (error) {

                console.error(
                    "Unable to clear PHP checkout selection:",
                    error
                );

            }

            // SUCCESS

            await Swal.fire({

                icon: "success",

                title: "Order Placed!",

                text: "Your order has been successfully placed.",

                confirmButtonText: "View Confirmation",

                allowOutsideClick: false

            });

            // REDIRECT TO RECEIPT

            window.location.href = "confirmation.php";

        } catch (error) {

            console.error("Checkout error:", error);

            Swal.fire(
                "Checkout Notice",
                error.message,
                "error"
            );

            placeOrderButton.disabled = false;

            placeOrderButton.innerHTML =
                'Place Order <span>→</span>';

        }

    });

    // ==========================================
    // INITIALIZE
    // ==========================================

    updatePaymentSelection();

    loadSelectedItems();

});

</script>

</body>
</html>