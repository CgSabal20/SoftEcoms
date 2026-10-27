<?php 
session_start();

$pageClass = "home-page";

include('./admin/includes/header.php');
include('./admin/includes/topbar.php');
include_once("../app/config/config.php");


if(isset($_GET['uuid'])) {

    $uuid = mysqli_real_escape_string($conn, $_GET['uuid']);


    $query = "SELECT 
                    id,
                    uuid,
                    productName,
                    productDescription,
                    price,
                    img
              FROM product_item 
              WHERE uuid = '$uuid'
              LIMIT 1";

    $result = mysqli_query($conn, $query);

    if(!$result) {

        echo "Database error: " . mysqli_error($conn);
        exit();
    }

    $product = mysqli_fetch_assoc($result);

    // PRODUCT NOT FOUND
    if(!$product){

        echo "Product not found";
        exit();
    }

} 


elseif(isset($_GET['id'])) {

    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $query = "SELECT 
                    id,
                    uuid,
                    productName,
                    productDescription,
                    price,
                    img
              FROM product_item 
              WHERE id = '$id'
              LIMIT 1";

    $result = mysqli_query($conn, $query);

    if(!$result) {

        echo "Database error: " . mysqli_error($conn);
        exit();
    }

    $product = mysqli_fetch_assoc($result);

    if(!$product){

        echo "Product not found";
        exit();
    }

} 

else {

    echo "No Product Selected";
    exit();
}
?>

<div class="product-container">


    <div class="left">

        <div class="image-wrapper">

            <img src="assets/product_img/<?php echo htmlspecialchars($product['img']); ?>"
                 alt="<?php echo htmlspecialchars($product['productName']); ?>">

        </div>

    </div>





    
    <div class="right">

        <div class="brand">

            Premium Collection

        </div>





        <div class="title">

            <?php echo htmlspecialchars($product['productName']); ?>

        </div>




        <div class="price-section">

            <span class="price">

                ₱<?php echo number_format($product['price'], 2); ?>

            </span>

        </div>





        <div class="desc">

            <?php echo nl2br(htmlspecialchars($product['productDescription'])); ?>

        </div>





        
        <div class="label">

            Quantity:

        </div>





       
        <form method="POST"
              action="/E-commerce/app/controllers/cartController.php"
              id="cartForm">

      
            <input type="hidden"
                   name="product_uuid"
                   value="<?php echo htmlspecialchars($product['uuid']); ?>">


            <input type="hidden"
                   name="selected_size"
                   id="selected_size"
                   value="L">


            <input type="hidden"
                   name="selected_color"
                   id="selected_color"
                   value="Orange">




            <div class="quantity-box">

                <button type="button"
                        onclick="decrementQuantity()">

                    -

                </button>

                <input type="number"
                       name="quantity"
                       id="quantity_input"
                       value="1"
                       min="1">

                <button type="button"
                        onclick="incrementQuantity()">

                    +

                </button>

            </div>





   
            <button type="submit"
                    name="add_to_cart"
                    class="buy-btn">

                <i class="fas fa-shopping-cart"></i>

                Add to Cart

            </button>

        </form>

    </div>

</div>

<?php
include('./admin/includes/footer.php');
?>

<script>


function incrementQuantity() {

    let input = document.getElementById("quantity_input");

    let newVal = parseInt(input.value) + 1;

    input.value = newVal;
}






function decrementQuantity() {

    let input = document.getElementById("quantity_input");

    if(parseInt(input.value) > 1){

        input.value = parseInt(input.value) - 1;
    }
}






const sizeBtns = document.querySelectorAll('.size-btn');

const selectedSizeInput = document.getElementById('selected_size');

sizeBtns.forEach(btn => {

    btn.addEventListener('click', function() {

        sizeBtns.forEach(b => b.classList.remove('active'));

        this.classList.add('active');

        selectedSizeInput.value = this.getAttribute('data-size');

    });

});





const colorCircles = document.querySelectorAll('.color-circle');

const selectedColorInput = document.getElementById('selected_color');

colorCircles.forEach(circle => {

    circle.addEventListener('click', function() {

        colorCircles.forEach(c => c.classList.remove('selected'));

        this.classList.add('selected');

        selectedColorInput.value = this.getAttribute('data-color');

    });

});

</script>