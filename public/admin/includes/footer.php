


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