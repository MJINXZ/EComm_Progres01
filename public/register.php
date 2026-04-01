<?php
  /*  connector */
session_start();
$pageClass ="register-page";
  include('./admin/includes/header.php');
  include('./admin/includes/topbar.php');


  
?>  




<!-- Register Section -->
<section class="login d-flex align-items-center" style="height: 100vh;">
  <div class="container">
    <div class="row">
      <div class="col-lg-5 m-auto ">

        <h2 class="mb-4">Create Account</h2>


        <form method="POST" enctype="multipart/form-data" autocomplete="off"  action="/E-commerce/app/controllers/loginController.php">

          <label>First Name <span style="color: red;">*</span></label>        
          <input type="text" class="form-control mb-3" placeholder="John"  name="firstName" required>
          

           <label>last Name <span style="color: red;">*</span></label>       
          <input type="text" class="form-control mb-3" placeholder="STockston" name="lastName" required>

            <label>Middle Name <span style="color: red;"></span></label>       
          <input type="text" class="form-control mb-3" placeholder="Gomez" name="middleName" >

           <label>Email address <span style="color: red;">*</span></label>       
          <input type="email" class="form-control mb-3" placeholder="Email"  name = "email" required>

           <label>Contact Number<span style="color: red;">*</span></label>       
           <input type="text" class="form-control mb-3" placeholder="Contact Number"  name = "contact" required>

            <label>username <span style="color: red;">*</span></label>       
          <input type="text" class="form-control mb-3" placeholder="Username" name = "username" required>

           <label>Password <span style="color: red;">*</span></label>       
          <input type="password" class="form-control mb-3" placeholder="********"  name="password" required>


          <label>Confirm Password <span style="color: red;">*</span></label>       
          <input type="password" class="form-control mb-3" placeholder="********" name ="confirmPassword" required>

                    <label>Street<span style="color: red;">*</span></label>       
          <input type="text" class="form-control mb-3" placeholder="Pabayo hayes" name ="street" required>

         <label>Barangay<span style="color: red;">*</span></label>       
         <input type="text" class="form-control mb-3" placeholder="Nazareth" name ="barangay" required>

          <label>City<span style="color: red;">*</span></label>       
          <input type="text" class="form-control mb-3" placeholder="Cagayan de oro city" name ="city" required>

      
          <button type="submit" name="register" class="btn1 w-100 mb-3">Register</button>

          <p class= "text-center">Already have an account? <a href="Login.php">Login</a></p>  


        </form>

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