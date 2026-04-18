<?php
  /*  connector */
session_start();
$pageClass ="register-page";
include('admin/includes/header.php');
include('admin/includes/topbar.php');
include_once("../app/config/config.php");


  
?>  




<!-- Register Section -->
<section class="login py-5">
  <div class="container">
    <div class="row justify-content-center">
      
      <div class="col-12 col-md-8 col-lg-6">
        
        <div class="p-4">
          
          <h2 class="mb-4 text-center">Create Account</h2>

          <form method="POST" enctype="multipart/form-data" autocomplete="off" action="/E-commerce/app/controllers/loginController.php">

            <label>First Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control mb-3" name="firstName" value="<?php echo isset($_SESSION['old_firstName']) ? $_SESSION['old_firstName'] : ''; ?>" required autocomplete="off" >

            <label>Last Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control mb-3" name="lastName" value="<?php echo isset($_SESSION['old_lastName']) ? $_SESSION['old_lastName'] : ''; ?>" required autocomplete="off">

            <label>Middle Name </label>
            <input type="text" class="form-control mb-3" name="middleName" value="<?php echo isset($_SESSION['old_middleName']) ? $_SESSION['old_middleName'] : ''; ?>" autocomplete="off">

            <label>Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control mb-3" name="email" value="<?php echo isset($_SESSION['old_email']) ? $_SESSION['old_email'] : ''; ?>" required autocomplete="off">

            <label>Contact Number <span class="text-danger">*</span></label>
            <input type="text" class="form-control mb-3" name="contact" value="<?php echo isset($_SESSION['old_contact']) ? $_SESSION['old_contact'] : ''; ?>"  required autocomplete="off">

            <label>Username <span class="text-danger">*</span></label>
            <input type="text" class="form-control mb-3" name="username" value="<?php echo isset($_SESSION['old_username']) ? $_SESSION['old_username'] : ''; ?>" required autocomplete="off">

            <label>Password <span class="text-danger">*</span></label>
            <input type="password" class="form-control mb-3" name="password" required autocomplete="new-password">

            <label>Confirm Password <span class="text-danger">*</span></label>
            <input type="password" class="form-control mb-3" name="confirmPassword" required autocomplete="new-password">

            <label>Street <span class="text-danger">*</span></label>
            <input type="text" class="form-control mb-3" name="street"  value="<?php echo isset($_SESSION['old_street']) ? $_SESSION['old_street'] : ''; ?>" required autocomplete="off">

            <label>Barangay <span class="text-danger">*</span></label>
            <input type="text" class="form-control mb-3" name="barangay" value="<?php echo isset($_SESSION['old_barangay']) ? $_SESSION['old_barangay'] : ''; ?>"  required autocomplete="off">

            <label>City <span class="text-danger">*</span></label>
            <input type="text" class="form-control mb-3" name="city"value="<?php echo isset($_SESSION['old_city']) ? $_SESSION['old_city'] : ''; ?>"  required autocomplete="off">

            <button type="submit" name="register" class="btn btn-success w-100 mt-2">
              Register
            </button>

            <p class="text-center mt-3">
              Already have an account? <a href="login.php">Login</a>
            </p>

          </form>

        </div>

      </div>

    </div>
  </div>
</section>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php 
if (isset($_SESSION['message']) && isset($_SESSION['code'])) {
?>
<script>
  const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
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
  unset($_SESSION['message']);
  unset($_SESSION['code']);
}
?>




</body>
</html>