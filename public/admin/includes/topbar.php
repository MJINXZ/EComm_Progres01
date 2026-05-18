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
          <a class="nav-link" href="/E-commerce/public/contactUs">Contact Us</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#">Best Seller</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="/E-commerce/public/order">Order</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="/E-commerce/public/about">About</a>
        </li>




  



      </ul>

       <div class="d-flex align-items-center gap-3">

  <!-- ORDER HISTORY / RECEIPT -->
  <a href="/E-commerce/public/users/orderHistory" 
     class="nav-icon">
     
   <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-receipt" viewBox="0 0 16 16">
  <path d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27m.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0z"/>
  <path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5"/>
</svg>

  </a>

  <!-- CART -->
  <a href="/E-commerce/public/cart" 
     class="nav-icon">

    <svg xmlns="http://www.w3.org/2000/svg" 
         width="22" 
         height="22" 
         fill="currentColor" 
         class="bi bi-cart" 
         viewBox="0 0 16 16">

      <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7z"/>
      
      <path d="M5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
    </svg>

  </a>

</div>




      <form method="POST" action="/E-commerce/app/controllers/userController.php" class="d-flex">

          <li class="nav-item">
      
           

      <?php if (isset($_SESSION['user_id'])) { ?>

        <div class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
            <?php echo $_SESSION['authUser']['username']; ?>
          </a>

          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/E-commerce/public/users/profilePage.php">Profile</a></li>
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


