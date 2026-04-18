<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>


<nav class="navbar navbar-expand-lg ">
  <div class="container">

    <!-- Always show logo -->
    <?php if (isset($_SESSION['userRole']) && $_SESSION['userRole'] === 'admin') { ?>
      <a class="navbar-brand" href="/E-commerce/public/admin/index">Sweet!</a>
    <?php } else { ?>
      <a class="navbar-brand" href="/E-commerce/public/index">Sweet!</a>
    <?php } ?>

<?php if ($current_page != 'login.php' && $current_page != 'register.php') { ?>


    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav m-auto my-2 my-lg-0">

        <li class="nav-item">
         <?php if (isset($_SESSION['userRole']) && $_SESSION['userRole'] === 'admin') { ?>
          <a class="nav-link active" href="/E-commerce/public/admin/index">Home</a>
        <?php } else { ?>
          <a class="nav-link active" href="/E-commerce/public/index">Home</a>
        <?php } ?>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#">Contact Us</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#">Best Seller</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="/E-commerce/public/order">Order</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>




  



      </ul>
      


         <a href="/E-commerce/public/cart" style="text-decoration:none; color:black;">
   <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
  <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
</svg>
</a>




      <form method="POST" action="/E-commerce/app/controllers/userController.php" class="d-flex">

          <li class="nav-item">
      
           

      <?php if (isset($_SESSION['user_id'])) { ?>

        <div class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
            <?php echo $_SESSION['authUser']['username']; ?>
          </a>

          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="Profile.php">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <button type="submit" name="logout" class="dropdown-item">Sign out</button>
            </li>
          </ul>
        </div>

      <?php } else { ?>

        <a class="nav-link" href="/E-commerce/public/login">Sign In</a>

      <?php } ?>

      </form>
    </div>

    <?php } ?>

  </div>
</nav>


