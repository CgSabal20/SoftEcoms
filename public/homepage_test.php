<?php 
session_start();
$pageClass = "index-page";
include('admin/includes/header.php');
include('admin/includes/topbar.php');
include_once("../app/config/config.php");


// $sweetQuery = "SELECT id, productName, productDescription, price, img 
//                FROM product_item LIMIT 8";
// $sweetResult = mysqli_query($conn, $sweetQuery);
// if (!$sweetResult) {
//     error_log("Sweet Tooths query failed: " . mysqli_error($conn));
//     $sweetProducts = [];
// } else {
//     $sweetProducts = mysqli_fetch_all($sweetResult, MYSQLI_ASSOC);
//     mysqli_free_result($sweetResult);
// }


// $bestQuery = "SELECT id, productName, price, img 
//               FROM product_item LIMIT 4";
// $bestResult = mysqli_query($conn, $bestQuery);
// if (!$bestResult) {
//     error_log("Best Sellers query failed: " . mysqli_error($conn));
//     $bestProducts = [];
// } else {
//     $bestProducts = mysqli_fetch_all($bestResult, MYSQLI_ASSOC);
//     mysqli_free_result($bestResult);
// }
// ?>
 

<section class="intro">



   <!-- Naa diri ang Now Available and etcetera -carlo  -->
<div class="container py-5">
  <div class="row">

    <div class="col-10 col-sm-8 col-md-6 col-lg-5 mx-auto mx-lg-0 px-4 px-lg-5 hero-box text-center text-white"
         style="background-color: rgba(97, 27, 16, 0.6);
                backdrop-filter: blur(5px);
                border-radius: 0 60px 0 60px;">

      <h2 class="fs-2 fw-light mb-1"
          style="color:#CD9C9E; font-family: 'Gentium Book', serif;">
        Now Available:
      </h2>

      <h3 class="display-5 fw-bold mb-3"
          style="color:#CD9C9E; font-family: 'Gentium Book', serif;">
        Strawberry Theme
      </h3>

      <p class="small text-white-50 mb-4">
        Indulge in our delicious sweet treats. Try our freshly baked eclairs today!
      </p>

     <button class="btn btn-sm rounded-pill px-4" 
        style="background-color: #FFB9C8; color: #AB4848; font-weight: bold; border: none;">
    Go to Products
</button>


    </div>
  </div>
</div>



</section>  



<section class="new">
  <div class="container py-5">
    <div class="carousel">

      <div class="track">

        <div class="carousel-group">

          <div class="carousel-item-custom">
            <img src="assets/img/varieties.png" class="img-fluid mb-2" alt="Varieties">
            <h6 class="vary_custom_sell">Varieties</h6>
          </div>

          <div class="carousel-item-custom">
            <img src="assets/img/custom_made.png" class="img-fluid mb-2" alt="Custom Made">
            <h6 class="vary_custom_sell">Custom Made</h6>
          </div>

          <div class="carousel-item-custom">
            <img src="assets/img/Best_Seller.png" class="img-fluid mb-2" alt="Best Sellers">
            <h6 class="vary_custom_sell">Best Sellers</h6>
          </div>

        </div>

        <div class="carousel-group">

          <div class="carousel-item-custom">
            <img src="assets/img/varieties.png" class="img-fluid mb-2" alt="Varieties">
            <h6 class="vary_custom_sell">Varieties</h6>
          </div>

          <div class="carousel-item-custom">
            <img src="assets/img/custom_made.png" class="img-fluid mb-2" alt="Custom Made">
            <h6 class="vary_custom_sell">Custom Made</h6>
          </div>

          <div class="carousel-item-custom">
            <img src="assets/img/Best_Seller.png" class="img-fluid mb-2" alt="Best Sellers">
            <h6 class="vary_custom_sell">Best Sellers</h6>
          </div>

        </div>

      </div>

    </div>
  </div>
</section>


<section class="product">
  <div class="container py-5">
    <div class="row py-4">
      <div class="col-lg-5 m-auto text-center">
        <h1 class="our_products">Sweet Tooths</h1>
        <h6 class="section-subtitle">Our Sweetest delivered at your Doorstep.</h6>
      </div>
    </div>

    <?php if (!empty($sweetProducts)): ?>
    <div class="row g-4">
      <?php foreach ($sweetProducts as $row): 
          $imgPath = "assets/product_img/" . htmlspecialchars($row['img']);
          $fallback = "assets/product_img/placeholder.jpg";
          $displayImg = (!empty($row['img']) && file_exists($imgPath)) ? $imgPath : $fallback;
      ?>
      <div class="col-6 col-md-4 col-lg-3">
        <a href="/softEcoms/public/productpage.php?id=<?php echo (int)$row['id']; ?>" 
           class="text-decoration-none d-block h-100">
          <div class="card h-100 rounded-4 shadow-sm overflow-hidden border-0">
            <div class="card-img-wrapper">
              <img src="<?php echo $displayImg; ?>" 
                   class="card-img-top" 
                   alt="<?php echo htmlspecialchars($row['productName']); ?>"
                   loading="lazy">
            </div>
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?php echo htmlspecialchars($row['productName']); ?></h5>
              <p class="card-text flex-grow-1"><?php echo htmlspecialchars(substr($row['productDescription'], 0, 70)) . '...'; ?></p>
              <p class="card-price">$<?php echo number_format($row['price'], 2); ?></p>
            </div>
          </div>
        </a>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
      <p class="text-center text-muted py-4">No products available at the moment.</p>
    <?php endif; ?>

    <div class="row">
      <div class="col-lg-12 text-center mt-4">
        <button class="btn2">Click For More</button>
      </div>
    </div>
  </div>
</section>


<section class="new-section">
  <div class="container py-5">
    <div class="row py-4">
      <div class="col-lg-12 m-auto text-center">
        <h1 class="our_products">Communities</h1>
        <h6 class="section-subtitle">We Offer a Wide Range of Eclairs at your Comfort.</h6>
      </div>
    </div>
    <div class="row g-4">
      <div class="col-md-6 col-lg-4">
        <div class="community-card card border-0 h-100 text-center rounded-4 overflow-hidden shadow-sm">
          <div class="community-img-wrapper">
            <img src="assets/img/for_bd.jpg" class="community-img" alt="Join Our Community" loading="lazy">
          </div>
          <div class="card-body">
            <h5 class="card-title">Join Our Community</h5>
            <p class="card-text">Connect with fellow eclair enthusiasts, share your love for our delicious treats.</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="community-card card border-0 h-100 text-center rounded-4 overflow-hidden shadow-sm">
          <div class="community-img-wrapper">
            <img src="assets/img/for_peeps.jpg" class="community-img" alt="Exclusive Offers" loading="lazy">
          </div>
          <div class="card-body">
            <h5 class="card-title">Exclusive Offers</h5>
            <p class="card-text">Gain access to exclusive offers, discounts, and promotions on our delectable eclairs.</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="community-card card border-0 h-100 text-center rounded-4 overflow-hidden shadow-sm">
          <div class="community-img-wrapper">
            <img src="assets/img/section_show.jpg" class="community-img" alt="Stay Updated" loading="lazy">
          </div>
          <div class="card-body">
            <h5 class="card-title">Stay Updated</h5>
            <p class="card-text">Be the first to know about our latest eclair flavors, upcoming events, and exciting news.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12 text-center mt-4">
        <button class="btn2">See More</button>
      </div>
    </div>
  </div>
</section>


<section class="shop">
  <div class="container py-5">
    <div class="row py-4">
      <div class="col-lg-12 m-auto text-center">
        <h1 class="our_products">Sweetness Deserved</h1>
        <h6 class="section-subtitle">Experience the Sweetness with our Best Sellers at an Affordable Price!</h6>
      </div>
    </div>

    <?php if (!empty($bestProducts)): ?>
    <div class="row g-4 justify-content-center">
      <?php foreach ($bestProducts as $row): 
          $imgPath = "assets/product_img/" . htmlspecialchars($row['img']);
          $fallback = "assets/product_img/placeholder.jpg";
          $displayImg = (!empty($row['img']) && file_exists($imgPath)) ? $imgPath : $fallback;
      ?>
      <div class="col-6 col-md-4 col-lg-3">
        <a href="/softEcoms/public/productpage.php?id=<?php echo (int)$row['id']; ?>" 
           class="text-decoration-none d-block h-100">
          <div class="best-card card border-0 h-100 rounded-4 overflow-hidden shadow-sm">
            <div class="best-img-wrapper">
              <img src="<?php echo $displayImg; ?>" 
                   class="best-img" 
                   alt="<?php echo htmlspecialchars($row['productName']); ?>"
                   loading="lazy">
            </div>
            <div class="card-body text-center">
              <h6 class="best-title"><?php echo htmlspecialchars($row['productName']); ?></h6>
              <p class="best-price">$<?php echo number_format($row['price'], 2); ?></p>
            </div>
          </div>
        </a>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
      <p class="text-center text-muted py-4">No products available at the moment.</p>
    <?php endif; ?>
  </div>
</section>


<section class="e_clair py-5">
  <div class="container text-white py-5">
    <div class="row py-5">
      <div class="col-lg-12 m-auto text-center">
        <h1 class="font-wweight-bold py-3">Invite All!</h1>
        <h6 class="cta-subtitle">Enjoy the heartfelt moments with your Loved Ones at our Shop!</h6>
        <button class="btn2 mt-3">See More</button>
      </div>
    </div>
  </div>
</section>






<?php 
include('admin/includes/footer.php');
?>