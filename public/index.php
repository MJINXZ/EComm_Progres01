<?php 
session_start();
$pageClass = "index-page";
include('admin/includes/header.php');
include('admin/includes/topbar.php');
include_once("../app/config/config.php");


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
    <div class="carousel">

      <div class="track">

        <!-- ORIGINAL -->
        <div class="row flex-nowrap text-center">
          <div class="col-lg-4">
            <img src="assets/img/varieties.png" class="img-fluid mb-2">
            <h6 class="vary_custom_sell">Varieties</h6>
          </div>

          <div class="col-lg-4">
            <img src="assets/img/custom_made.png" class="img-fluid mb-2">
            <h6 class="vary_custom_sell">Custom Made</h6>
          </div>

          <div class="col-lg-4">
            <img src="assets/img/Best_Seller.png" class="img-fluid mb-2">
            <h6 class="vary_custom_sell">Best Sellers</h6>
          </div>
        </div>

        <!-- DUPLICATE (IMPORTANT for smooth loop) -->
        <div class="row flex-nowrap text-center">
          <div class="col-lg-4">
            <img src="assets/img/varieties.png" class="img-fluid mb-2">
            <h6 class="vary_custom_sell">Varieties</h6>
          </div>

          <div class="col-lg-4">
            <img src="assets/img/custom_made.png" class="img-fluid mb-2">
            <h6 class="vary_custom_sell">Custom Made</h6>
          </div>

          <div class="col-lg-4">
            <img src="assets/img/Best_Seller.png" class="img-fluid mb-2">
            <h6 class="vary_custom_sell">Best Sellers</h6>
          </div>
        </div>

      </div>

    </div>
  </div>
</section>

<?php
    $query = "SELECT productName, productDescription, price, img, id
               FROM product_item LIMIT 8";

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

      <a href="/E-commerce/public/productpage.php?id=<?php echo $row['id']; ?>" class="text-decoration-none d-block text-dark" >
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
  <div class="row">
  <div class="col-lg-12 text-center mt-5">

    <button class="btn2">Click For More</button></p>

  </div>
      </div>
    </section>






  <!-- New Section for Product Ad -->
<section class="new-section">
    <div class="container py-5">
        <div class="row py-5">
            <div class="col-lg-12 m-auto text-center">
                <h1 class="our_products">Communities</h1>
                <h6 style="margin-bottom: 20px; color: red">We Offer a Wide Range of Eclairs at your Comfort.</h6>
            </div>
           <div class="row">
    <div class="col-lg-4 mb-4">
        <div class="product-card card border-0 bg-light h-100 text-center">
            <img src="assets/img/for_bd.jpg" 
                 class="product-img container" 
                 alt=""
                 style="height: 250px; object-fit: cover;">
            <div class="card-body">
                <h5 class="card-title">Join Our Community</h5>
                <p class="card-text">Connect with fellow eclair enthusiasts, share your love for our delicious treats,</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="product-card card border-0 bg-light h-100 text-center">
            <img src="assets/img/for_peeps.jpg" 
                 class="product-img container"  
                 alt=""
                 style="height: 250px; object-fit: cover;">
            <div class="card-body">
                <h5 class="card-title">Exclusive Offers</h5>
                <p class="card-text">As a member of our community, you'll gain access to exclusive offers, discounts, and promotions on our delectable eclairs. Don't miss out on the chance to indulge in your favorite treats at a special price!</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="product-card card border-0 bg-light h-100 text-center">
            <img src="assets/img/section_show.jpg" 
                 class="product-img container" 
                 alt=""
                 style="height: 250px; object-fit: cover;">
            <div class="card-body">
                <h5 class="card-title">Stay Updated</h5> 
                <p class="card-text">Be the first to know about our latest eclair flavors, upcoming events, and exciting news. Join our community to stay in the loop and never miss out on the deliciousness!</p>
            </div>
        </div>
    </div>
</div>
            </div>
            <div class="row">
  <div class="col-lg-12 text-center">
    <button class="btn2">See More</button></p>
  </div>            
        </div>
    </div>
</section>


<section class="shop">
  <div class="container">
    <div class="row py-5">
      <div class="col-lg-12 m-auto text-center">
        <h1 class="our_products">Sweetness Deserved</h1>
        <h6 style="color: red">Experience the Sweetness with our Best Sellers at an Affordale Price!</h6>
      </div>
     </div>
     
    <!-- FOR OUR BEST SELLERS NI(ga error ang looping)-->

    <?php
    $query = "SELECT productName, productDescription, price, img 
               FROM product_item LIMIT 4";

$result = mysqli_query($conn, $query);


?>

       <div class="row">

       <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <div class="col-lg-3 col-md-6 col-sm-12 text-center mb-4">
        <div class="product-card card border-0 bg-light">
            <div class="product-img-container">
                <img src="assets/product_img/<?php echo $row['img']; ?>" class="product-img" alt="">
            </div>
            <h6 class="product-title"><?php echo $row['productName']; ?></h6>
            <p class="product-price"><?php echo $row['price']; ?></p>
        </div>
    </div>

    <?php
       }
?>
</div> 
</section>

<section class="e_clair py-5">
  <div class="container text-white py-5">
    <div class="row py-5">
      <div class="col-lg-12 m-auto text-center">
        <h1 class="font-wweight-bold py-3">Invite All!</h1>
        <h6 style="color: red;">Enjoy the heartfelt moments with your Loved Ones at our Shop !</h6>
        <button class="btn2 mt-3">See More</button>
      </div>
     </div>


</section>

<?php
include('admin/includes/footer.php');

?>



