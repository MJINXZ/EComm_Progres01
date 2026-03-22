<?php
  /*  connector */
  include("connect.php");
  
?>  

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap + Fonts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">

  <title>Login - Sweet!</title>
</head>
<body>

<!-- Navbar (same as your main page) -->
<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="index.php">Sweet!</a>  <!-- Connection to the Index page -->
  </div>
</nav>

<!-- Login Section -->
<section class="login d-flex align-items-center" style="height: 90vh;">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 m-auto text-center">

        <h2 class="mb-4">Login</h2>

        <form method= "POST" action ="validation.php">

            <!--- error handling for php -->
            <?php if(isset($_GET['error'])) { ?>
                    <p class="error"><?php echo $_GET['error']; ?></p>
                <?php } ?>
       
          <input type="text" class="form-control mb-3" placeholder="Username"  name="email">
          <input type="password" class="form-control mb-3" placeholder="Password"  name="password">
          <button type ="submit" class="btn1 w-100 mb-3" name="login">Login</button>

          <p>Don't have an account? <a href="register.php">Register</a></p>

        </form>

      </div>
    </div>
  </div>
</section>

</body>
</html>