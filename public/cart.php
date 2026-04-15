<?php 
session_start();
$pageClass = "index-page";
include('./admin/includes/header.php');
include('./admin/includes/topbar.php');
include_once("../app/config/config.php");


if (isset($_SESSION['user_id'])) {

    $user_id = $_SESSION['user_id'];

    $query = "SELECT street, barangay, city, contactNumber 
              FROM users 
              WHERE id = $user_id";

    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $db_address = $row['street'] . ", " . $row['barangay'] . ", " . $row['city'];
        $db_phone = $row['contactNumber'];

        $address = isset($_SESSION['temp_address']) ? $_SESSION['temp_address'] : $db_address;
        $phone = isset($_SESSION['temp_phone']) ? $_SESSION['temp_phone'] : $db_phone;
    }


} else {

  
    $address = "";
    $phone = "";
}

?>

<div class="container cart-layout">

<div class="cart-left">
<div class="small container cart-page"> 

<table>
<tr>
    <th>Product Name</th>
    <th>Quantity</th>
    <th>Subtotal</th>
</tr>

<?php
$totalPrice = 0;

if (isset($_SESSION['user_id'])) {

    $user_id = $_SESSION['user_id'];

    $query = "SELECT p.productname, p.price, c.quantity, p.img, c.id
              FROM cart c
              INNER JOIN product_item p ON c.product_id = p.id
              WHERE c.user_id = $user_id";

    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {

            $subtotal = $row["price"] * $row["quantity"];
            $totalPrice += $subtotal;
?>

<tr>    
<td>
    <div class="cart-info">
        <img src="assets/product_img/<?php echo $row['img']; ?>">

        <div>
            <p><?php echo $row["productname"]; ?></p>
            <small>Price: ₱<?php echo $row["price"]; ?></small><br><br>

            <button type="button"
                    class="remove-btn"
                    data-id="<?php echo $row['id']; ?>">
               Cancel
            </button>
        </div>
    </div>
</td>

<td>
    <input type="number" value="<?php echo $row["quantity"]; ?>">
</td>

<td>₱<?php echo $subtotal; ?></td>
</tr>

<?php
        }

    } else {
        echo '<tr><td colspan="3">Your cart is empty.</td></tr>';
    }

} else {

    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {

        foreach ($_SESSION['cart'] as $productid => $quantity) {

            $query = "SELECT * FROM product_item WHERE id = $productid";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {

                $row = mysqli_fetch_assoc($result);

                $subtotal = $row["price"] * $quantity;
                $totalPrice += $subtotal;
?>

<tr>    
<td>
    <div class="cart-info">
        <img src="assets/product_img/<?php echo $row['img']; ?>">

        <div>
            <p><?php echo $row["productName"]; ?></p>
            <small>Price: ₱<?php echo $row["price"]; ?></small><br><br>

            <button type="button"
                    class="remove-btn"
                    data-id="<?php echo $row['id']; ?>">
                Cancel
            </button>
        </div>
    </div>
</td>

<td>
    <input type="number" value="<?php echo $quantity; ?>">
</td>

<td>₱<?php echo $subtotal; ?></td>
</tr>

<?php
            }
        }

    } else {
        echo '<tr><td colspan="3">Your cart is empty.</td></tr>';
    }
}
?>

<?php
$tax = $totalPrice * 0.10;
$grandTotal = $totalPrice + $tax;
?>
<tr>
    <td colspan="3">
        <div class="cart-totals">
            <table>
           <tr>
    <td>Subtotal</td>
    <td>₱<?php echo $totalPrice; ?></td>
</tr>

<tr>
    <td>Tax (10%)</td>
    <td>₱<?php echo $tax; ?></td>
</tr>

<tr>
    <td><strong>Total</strong></td>
    <td><strong>₱<?php echo $grandTotal; ?></strong></td>
</tr>
            </table>
        </div>
    </td>
</tr>
</table>
</div>
</div>


<div class="cart-right">
<div class="checkout-box">

<form method="POST" action="/E-commerce/app/controllers/checkoutController.php">

<input type="hidden" name="action" value="saveTempCheckout">

<h4>Address:</h4>
<input type="text" name="address" class="form-control mb-3"
       value="<?php echo $address; ?>">

<h4>Phone Number:</h4>
<input type="text" name="phone" class="form-control mb-3"
       value="<?php echo $phone; ?>">

<h4>Form of Payment:</h4>
<input type="text" name="payment_method" class="form-control mb-4">

<h4>Total Price:</h4>
<input type="text" name="total" class="form-control mb-4"
       value="<?php echo $grandTotal; ?>" readonly>

<div style="display:flex; gap:10px;">

    <button type="submit" class="btn btn-success">
        Checkout
    </button>

<?php if (!isset($_SESSION['user_id'])) { ?>
    <button type="button" class="btn btn-secondary" disabled>
        Login Required
    </button>
<?php } ?>

</div>

</form>

</div>
</div>

</div>


</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('click', function(e) {

    const btn = e.target.closest('.remove-btn');
    if (!btn) return;

    const id = btn.dataset.id;

    if (confirm('Remove this item?')) {
        window.location.href = "/E-commerce/app/controllers/cartController.php?remove=" + id;
    }
});
</script>

</body>