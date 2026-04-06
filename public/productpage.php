<?php 
session_start();
$pageClass = "index-page";
include('./admin/includes/header.php');
include('./admin/includes/topbar.php');
include_once("../app/config/config.php");

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT id, productName, productDescription, price, img FROM product_item WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result);
}
?>

<section class="banner">
<div class="container py-5">
<div class="container-fluid">
  <div class="row" style="min-height: 400px;">
   
    <div class="col-md-7">

      <img src="assets/product_img/<?php echo $product['img']; ?>" 
           id="Productimg" 
           class="product-img" 
           alt="Product Image">
    </div>

    <div class="col-md-5 d-flex flex-column align-items-start ps-5 pt-5">
      <h2 class="new"><?php echo $product['productName']; ?></h2>
      <br>
      <p><?php echo $product['productDescription']; ?></p>

  <div class="add-to-cart">
    <div class="quantity-container">   
      
        <form method="POST" class="d-flex align-items-center gap-2" action="/E-commerce/app/controllers/cartController.php">
    
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

        
            <button type="button" onclick="decrementQuantity()">-</button>

    
            <input type="number" name="quantity" id="quantity_input" value="1" min="1" style="width: 50px; text-align: center;">

   
            <button type="button" onclick="incrementQuantity()">+</button>


            <button type="submit" name="add_to_cart">Add to Cart</button>
        </form>
    </div>
</div>
                    </div>
    </div>

  </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    let quantity = 1; 

   function incrementQuantity() {
    let input = document.getElementById('quantity_input');
    input.value = parseInt(input.value) + 1;
}
function decrementQuantity() {
    let input = document.getElementById('quantity_input');
    if(parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

    </script>


<?php 
if (isset($_SESSION['message']) && $_SESSION['code'] != ""){
?>
<script>
  const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
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


</body>