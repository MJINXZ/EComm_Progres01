<?php 
session_start();
$pageClass = "cart-page";
include('admin/includes/header.php');
include('admin/includes/topbar.php');
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

        $address = $_SESSION['temp_address'] ?? $db_address;
        $phone = $_SESSION['temp_phone'] ?? $db_phone;
    }

} else {
    $address = "";
    $phone = "";
}
?>

<!-- CSS -->
<link rel="stylesheet" href="assets/css/cart_page.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container cart-layout">

<!-- ================= LEFT SIDE ================= -->
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
               Remove
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

/* =========================
   GUEST CART
========================= */
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
                Remove
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


$tax = $totalPrice * 0.10;
$grandTotal = $totalPrice + $tax;
?>

<!-- MATCHED WITH FRONTEND DESIGN -->
<tr class="subtotal-row">
    <td colspan="2"></td>
    <td>Subtotal: ₱<?php echo $totalPrice; ?></td>
</tr>

<tr class="tax-row">
    <td colspan="2"></td>
    <td>Tax (10%): ₱<?php echo $tax; ?></td>
</tr>

<tr class="total-row total-final">
    <td colspan="2"></td>
    <td>Total: ₱<?php echo $grandTotal; ?></td>
</tr>

</table>
</div>
</div>

<!-- ================= RIGHT SIDE ================= -->
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

<h4>Add Extra Safety Packaging:</h4>
<select name="packaging" class="form-control mb-4">
    <option value="0">No</option>
    <option value="20">Yes (+₱20)</option>
</select>

<h4>Total Price:</h4>
<input name ="total" type="text" class="form-control mb-4"
       value="₱<?php echo $grandTotal; ?>" readonly>

<button class="checkout-btn">CHECK OUT</button>

</form>

</div>
</div>

</div>


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