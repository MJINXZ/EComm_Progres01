<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap + Fonts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">

  <title>Register - Sweet!</title>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="index.html">Sweet!</a>
  </div>
</nav>

<!-- Register Section -->
<section class="login d-flex align-items-center" style="height: 100vh;">
  <div class="container">
    <div class="row">
      <div class="col-lg-5 m-auto text-center">

        <h2 class="mb-4">Create Account</h2>


        <form method="POST" action="validation.php">

                 <?php if(isset($_GET['error'])) { ?>
                    <p class="error"><?php echo $_GET['error']; ?></p>
                <?php } ?>
          <input type="text" class="form-control mb-3" placeholder="First Name"  name="First">
          <input type="text" class="form-control mb-3" placeholder="Last Name" name="Last">
          <input type="email" class="form-control mb-3" placeholder="Email"  name = "Email">
           <input type="text" class="form-control mb-3" placeholder="Contact Number"  name = "Contact">
          <input type="text" class="form-control mb-3" placeholder="Username" name = "userName">
          <input type="password" class="form-control mb-3" placeholder="Password"  name="Password">
          <input type="password" class="form-control mb-3" placeholder="Confirm Password" name ="CPassword">

          <button type="submit" name="register" class="btn1 w-100 mb-3">Register</button>

          <p>Already have an account? <a href="Login.php">Login</a></p>  <!-- login Link Connection-->

<!-- VALIDATION CHECKER  -->

  

        </form>

      </div>
    </div>
  </div>
</section>

</body>
</html>