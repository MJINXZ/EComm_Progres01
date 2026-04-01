<?php 
session_start();
$pageClass = "index-page";
include('../admin/includes/header.php');
include('../admin/includes/topbar.php');
include_once("../../app/config/config.php");


?>
 
 

<section class="intro">
    <div class="container py-3">
        <div class="row py-2">
            <div class="col-lg-7 pt-2 text-center">
              <h1 class="pt-2">Welcome to Eclair Shop!</h1>
              <button class="btn1">For More</button>
            </div>
        </div>
    </div>    
</section>  



 <section class="new">
      <div class="container py-5">
        <div class="row pt-5">
          <div class="col-lg-7 m-auto">
            <div class="row">
              <div class="col-lg-4 text-center">
                <img src="../assets/img/varieties.png" class="img-fluid mb-2" alt="" />
                <h6 class="vary_custom_sell">Varieties</h6>
              </div>

              <div class="col-lg-4 text-center">
                <img
                  src="../assets/img/custom_made.png"
                  class="img-fluid mb-2"
                  alt="">

                <h6 class="vary_custom_sell">Custom Made</h6>
              </div>
              <div class="col-lg-4 text-center">
                <img
                  src="../assets/img/Best_Seller.png"
                  class="img-fluid mb-2"
                  alt=""
                />
                <h6 class="vary_custom_sell">Best Sellers</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

<?php
    $query = "SELECT productName, productDescription, price, img 
               FROM product_item LIMIT 4";

$result = mysqli_query($conn, $query);


?>

    <section class="product">
      <div class="container py-5">
        <div class="row py-5">
          <div class="col-lg-5 m-auto text-center">
            <h1 class="our_products">Sweet Tooths</h1>
            <h6 style="color: red">Our Sweetest delivered at your Doorstep.</h6>
          </div>
        </div>


       <div class="row gx-5 gy-5">

<?php while($row = mysqli_fetch_assoc($result)) { ?>

  <div class="col-lg-3 col-md-6 col-sm-12 text-center">
    <a href="#" class="text-decoration-none d-block text-dark">
      
      <div class="card rounded-5 shadow">
        <img src="../assets/product_img/<?php echo $row['img']; ?>"
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
    </section>

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>



</body>