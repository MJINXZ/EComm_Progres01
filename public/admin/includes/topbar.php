<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>


<nav class="navbar navbar-expand-lg">
  <div class="container">

    <!-- Always show logo -->
    <a class="navbar-brand" href="/E-commerce/public/users/index">Sweet!</a>

<?php if ($current_page != 'login.php' && $current_page != 'register.php') { ?>

  

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav m-auto my-2 my-lg-0">

        <li class="nav-item">
          <a class="nav-link active" href="/E-commerce/public/users/index">Home</a>
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

      <form method="POST" action="/E-commerce/app/controllers/userController.php" class="d-flex">

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

        <a class="nav-link" href="/E-commerce/public/login.php">Sign In</a>

      <?php } ?>

      </form>
    </div>

    <?php } ?>

  </div>
</nav>


