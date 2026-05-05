<?php 
session_start();
$pageClass = "about-page";
include('admin/includes/header.php');
include('admin/includes/topbar.php');
include_once("../app/config/config.php");
?>

<link rel="stylesheet" href="assets/css/about.css">

<!-- ========== ABOUT US ========== -->
<section class="about-section">
  
    <h1 class="heading"><span>About</span> Us</h1>

    <div class="row">

        <div class="showcase">
            <img src="assets/img/section_show.jpg" alt="About Us Image">
        </div>

        <div class="content">
            <h3>Our Story</h3>
            <p>
                Founded in 2020, Sweet! started as a small bakery with a passion for creating delicious pastries. 
                Our mission is to bring joy to our customers through our delectable treats made from the finest ingredients.
            </p>
            <p>
                From classic croissants to innovative desserts, we strive to offer a wide variety of options that cater to every taste. 
                Our team of skilled bakers and pastry chefs are dedicated to crafting each item with care and creativity.
            </p>
            <p>
                At Sweet!, we believe that every bite should be an experience. We are committed to providing exceptional quality and service.
            </p>

            <a href="contact.php" class="btn">Contact Us</a>
        </div>

    </div>
</section>

<!-- ========== MISSION ========== -->
<section class="about-section">
    
    <h1 class="heading"><span>Our</span> Mission</h1>

    <div class="row">

        <div class="content">
            <h3>The Mission</h3>
            <p>
                At Sweet!, our mission is to deliver high-quality, freshly crafted pastries and desserts through a seamless e-commerce experience,
                bringing joy and satisfaction to every customer while using only the finest ingredients and creative techniques, 
                and providing reliable service from order to delivery.
            </p>
        </div>

        <div class="showcase">
            <img src="assets/product_img/yinyang.jpg" alt="Mission Image">
        </div>

    </div>
</section>

<!-- ========== VISION ========== -->
<section class="about-section">
  
    <h1 class="heading"><span>Our</span> Vision</h1>

    <div class="row">

        <div class="showcase">
            <img src="assets/product_img/for_bd.jpg" alt="Vision Image">
        </div>

        <div class="content">
            <h3>The Vision</h3>
            <p>
                Our vision is to become a leading online pastry destination known for innovation, exceptional quality,
                and customer delight, where every treat creates a memorable experience and every customer feels valued 
                and inspired to keep coming back.
            </p>
        </div>

    </div>

</section>

<?php include('admin/includes/footer.php'); ?>