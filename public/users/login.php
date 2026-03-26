<?php
  /*  connector */

  include('../admin/includes/header.php');
  include('../admin/includes/topbar.php');
  session_start();

  
?>  




<!-- Login Section -->
<section class="login d-flex align-items-center" style="height: 90vh;">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 m-auto text-center">

        <h2 class="mb-4">Login</h2>

        <form method="POST" enctype="multipart/form-data" autocomplete="off" novalidate action="/E-commerce/app/controllers/loginController.php" >

          <input type="text" class="form-control mb-3" placeholder="Username"  name="username">
          <input type="password" class="form-control mb-3" placeholder="Password"  name="password">
          <button type ="submit" class="btn1 w-100 mb-3" name="login">Login</button>

          <p>Don't have an account? <a href="register.php">Register</a></p>

        </form>

      </div>
    </div>
  </div>
</section>

<!--- js? -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<?php 
if (isset($_SESSION['message']) && $_SESSION['code'] != ""){
?>
<script>
  const Toast = Swal.mixin({
    toast: true,
    position: "Top-end",
    showConfirmationButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.onmouseenter = Swal.stopTimer;
      toast.onmouseleave = Swal.resumeTimer;
    }

  });
   Toast.fire({
      icon: "<?php echo $_SESSION['code']; ?>",
      title: "<?php echo $_SESSION['message']; ?>"
    });
    </script>

<?php
  unset($_session['message']);
  unset($_session['code']);
}
?>

</body>
</html>