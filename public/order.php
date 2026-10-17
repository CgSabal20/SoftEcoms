<?php 
session_start();
$pageClass = "order-page";
include('./admin/includes/header.php');
include('./admin/includes/topbar.php');
include_once("../app/config/config.php");


$query = "SELECT id, productName, productDescription, price, img 
               FROM product_item LIMIT 20";

$result = mysqli_query($conn, $query);


?>

<div class="container-fluid px-5">
  <h2 class="text-center my-5">Our Pastries</h2>
  <div class="row gx-5 gy-5">

<?php while($row = mysqli_fetch_assoc($result)) { ?>

  <div class="col-lg-3 col-md-6 col-sm-12 text-center">
<a href="productpage.php?id=<?php echo $row['id']; ?>" 
   class="text-decoration-none d-block text-dark">
      
      <div class="card rounded-5 shadow">
        <img src="assets/product_img/<?php echo $row['img']; ?>"
             class="card-img-top rounded-top-5 hover-zoom">

        <div class="card-body">
          <h5 class="card-title"><?php echo $row['productName']; ?></h5>
          <p class="card-text"><?php echo $row['productDescription']; ?></p>
          <p class="card-text">$<?php echo $row['price']; ?></p>
        </div>
      </div>

    </a>
  </div>

<?php } ?>

  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>