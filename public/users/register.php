<<?php
  /*  connector */

  include('../admin/includes/header.php');
  include('../admin/includes/topbar.php');
  session_start();

  
?>  




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


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>





</body>
</html>