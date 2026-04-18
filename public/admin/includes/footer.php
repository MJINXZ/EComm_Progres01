<section class="footer">
  <div class="container py-3">
    <!-- Footer Content -->
    <div class="row footer-content-wrapper">
      <div class="col-lg-4 footer-content">
        <h3>Contact Us</h3>
        <p>Email: EclairStop@gmail.com</p>
        <p>Phone: +961 123 456 789</p>
        <p>Address: 123 Main Street, Beirut, Lebanon</p>
      </div>
      <div class="col-lg-4 footer-content">
        <h3>Information</h3>
        <ul class="list">
          <li><a href="#">Home</a></li>
          <li><a href="#">About</a></li>
          <li><a href="#">Services</a></li>
          <li><a href="#">Products</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
      </div>
      <div class="col-lg-4 footer-content">
        <h3>Social Media</h3>
        <ul class="list">
          <li><a href="#">Instagram</a></li>
          <li><a href="#">Facebook</a></li>
          <li><a href="#">Twitter</a></li>
          <li><a href="#">Youtube</a></li>
          <li><a href="#">Tiktok</a></li>
        </ul>
      </div>
    </div>
  </div>


  <div class="bottom-bar text-center">
    <p>&copy; 2024 Eclair Shop. All rights reserved</p>
  </div>
</section>

</body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


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
  unset($_SESSION['message']);
  unset($_SESSION['code']);
}
?>
