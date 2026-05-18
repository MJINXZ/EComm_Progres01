<?php 
session_start();
$pageClass = "cart-page";

include('admin/includes/header.php');
include('admin/includes/topbar.php');
include_once("../app/config/config.php");

// ================= USER INFO =================
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
$cartHasItems = false;

if (isset($_SESSION['user_id'])) {

    $user_id = $_SESSION['user_id'];

    $query = "SELECT p.productname, p.price, c.quantity, p.img, c.id
              FROM cart c
              INNER JOIN product_item p ON c.product_id = p.id
              WHERE c.user_id = $user_id";

    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {

        $cartHasItems = true;

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
            <small>Price: ₱<?php echo number_format($row["price"], 2); ?></small><br><br>

            <button type="button"
                    class="remove-btn"
                    data-id="<?php echo $row['id']; ?>">
               Remove
            </button>
        </div>
    </div>
</td>

<td>
    <input type="number" value="<?php echo $row["quantity"]; ?>" readonly>
</td>

<td>₱<?php echo number_format($subtotal, 2); ?></td>
</tr>

<?php
        }

    } else {
        echo '<tr><td colspan="3">Your cart is empty.</td></tr>';
    }

} else {

    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {

        $cartHasItems = true;

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
            <small>Price: ₱<?php echo number_format($row["price"], 2); ?></small><br><br>

            <button type="button"
                    class="remove-btn"
                    data-id="<?php echo $row['id']; ?>">
                Remove
            </button>
        </div>
    </div>
</td>

<td>
    <input type="number" value="<?php echo $quantity; ?>" readonly>
</td>

<td>₱<?php echo number_format($subtotal, 2); ?></td>
</tr>

<?php
            }
        }

    } else {
        echo '<tr><td colspan="3">Your cart is empty.</td></tr>';
    }
}

// ✅ TAX COMPUTATION
$tax = $totalPrice * 0.12;
$grandTotal = $totalPrice + $tax;
?>

<!-- TOTALS -->
<tr>
    <td colspan="2"></td>
    <td>Subtotal: ₱<?php echo number_format($totalPrice, 2); ?></td>
</tr>

<tr>
    <td colspan="2"></td>
    <td>VAT (12%): ₱<?php echo number_format($tax, 2); ?></td>
</tr>

<tr>
    <td colspan="2"></td>
    <td><strong>Total: ₱<?php echo number_format($grandTotal, 2); ?></strong></td>
</tr>

</table>
</div>
</div>

<div class="cart-right">
<div class="checkout-box">

<form method="POST" action="/E-commerce/app/controllers/checkoutController.php">

<h4>Address:</h4>
<input type="text" 
       name="address" 
       class="form-control mb-3"
       value="<?php echo $address; ?>"
       <?php echo !$cartHasItems ? 'disabled' : ''; ?>>

<h4>Phone Number:</h4>
<input type="text" 
       name="phone" 
       class="form-control mb-3"
       value="<?php echo $phone; ?>"
       <?php echo !$cartHasItems ? 'disabled' : ''; ?>>

<h4>Form of Payment:</h4>

<div class="form-check mb-2">
    <input class="form-check-input"
           type="radio"
           name="payment_method"
           id="cash"
           value="Cash"
           required
           <?php echo !$cartHasItems ? 'disabled' : ''; ?>>

    <label class="form-check-label" for="cash">
        Cash
    </label>
</div>

<div class="form-check mb-4">
    <input class="form-check-input"
           type="radio"
           name="payment_method"
           id="gcash"
           value="GCash"
           <?php echo !$cartHasItems ? 'disabled' : ''; ?>>

    <label class="form-check-label" for="gcash">
        GCash
    </label>
</div>

<h4>Total Price:</h4>
<input name="total" 
       type="text" 
       class="form-control mb-4"
       value="₱<?php echo number_format($grandTotal, 2); ?>" 
       readonly>

<button type="submit" 
        name="checkout" 
        class="checkout-btn"
        <?php echo !$cartHasItems ? 'disabled' : ''; ?>>
    CHECK OUT
</button>

<?php if (!$cartHasItems): ?>
    <p class="text-danger mt-3">
        Cannot checkout because your cart is empty.
    </p>
<?php endif; ?>

</form>

</div>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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