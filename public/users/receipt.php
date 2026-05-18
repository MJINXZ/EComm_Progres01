<?php 
session_start();

$pageClass = "receipt-page";

include('../admin/includes/header.php');
include('../admin/includes/topbar.php');
include_once("../../app/config/config.php");

// =========================
// LOGIN CHECK
// =========================
if(!isset($_SESSION['user_id'])){

    header("Location: /E-commerce/public/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


// =========================
// CHECK ORDER UUID
// =========================
if(!isset($_GET['uuid'])){

    echo "No order selected";
    exit();
}

$order_uuid = mysqli_real_escape_string($conn, $_GET['uuid']);


// =========================
// GET ORDER + USER
// =========================
$order_query = mysqli_query($conn, "

    SELECT 
        o.*, 
        u.username 

    FROM orders o

    JOIN users u 
        ON o.user_id = u.id

    WHERE o.uuid = '$order_uuid'
      AND o.user_id = '$user_id'

    LIMIT 1

");

if(!$order_query){

    echo "Database error: " . mysqli_error($conn);
    exit();
}


// =========================
// CHECK ORDER EXISTS
// =========================
if(mysqli_num_rows($order_query) == 0){

    echo "Order not found";
    exit();
}

$order = mysqli_fetch_assoc($order_query);

$order_id = $order['id'];


// =========================
// GET ORDER ITEMS
// =========================
$items_query = mysqli_query($conn, "

    SELECT 
        oi.*, 
        p.productName

    FROM orderitems oi

    JOIN product_item p 
        ON oi.product_id = p.id

    WHERE oi.order_id = '$order_id'

");

if(!$items_query){

    echo "Database error: " . mysqli_error($conn);
    exit();
}


// =========================
// TOTAL + TAX
// =========================
$total = 0;
$tax_rate = 0.12;

?>

<div class="receipt-wrapper">

    <div class="receipt-box">

        <!-- HEADER -->
        <div class="receipt-header">

            <h2>SweetShop</h2>

            <p>Official Receipt</p>

            <span class="receipt-badge">
                <?php echo htmlspecialchars($order['status']); ?>
            </span>

        </div>

        <!-- ORDER INFO -->
        <div class="receipt-info">

            <p>
                <strong>Order #:</strong>
                <?php echo htmlspecialchars($order['COnumber']); ?>
            </p>

            <p>
                <strong>Date:</strong>
                <?php echo date('M d, Y h:i A', strtotime($order['DateCreated'])); ?>
            </p>

            <p>
                <strong>Customer:</strong>
                <?php echo htmlspecialchars($order['username']); ?>
            </p>

            <p>
                <strong>Payment:</strong>
                <?php echo htmlspecialchars($order['paymentMethod']); ?>
            </p>

        </div>

        <!-- ORDER ITEMS -->
        <table class="receipt-items">

            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>

            <tbody>

            <?php while($item = mysqli_fetch_assoc($items_query)): ?>

                <?php
                    $price = (float)$item['price'];
                    $subtotal = $price * $item['quantity'];
                    $total += $subtotal;
                ?>

                <tr>

                    <td>
                        <?php echo htmlspecialchars($item['productName']); ?>
                    </td>

                    <td>
                        <?php echo $item['quantity']; ?>
                    </td>

                    <td>
                        ₱<?php echo number_format($price, 2); ?>
                    </td>

                    <td>
                        ₱<?php echo number_format($subtotal, 2); ?>
                    </td>

                </tr>

            <?php endwhile; ?>

            </tbody>

        </table>

        <?php 
            $tax = $total * $tax_rate;
            $grand_total = $total + $tax;
        ?>

        <!-- TOTALS -->
        <div class="receipt-total">

            <div class="receipt-total-row">
                <span>Subtotal</span>
                <span>₱<?php echo number_format($total, 2); ?></span>
            </div>

            <div class="receipt-total-row">
                <span>VAT (12%)</span>
                <span>₱<?php echo number_format($tax, 2); ?></span>
            </div>

            <div class="receipt-total-row grand-total">
                <span>Total</span>
                <span>₱<?php echo number_format($grand_total, 2); ?></span>
            </div>

        </div>

        <!-- FOOTER -->
        <div class="receipt-footer">

            <p>Thank you for your purchase 💚</p>

            <a href="orderHistory.php"
               class="receipt-back-btn">

                Back To Orders

            </a>

        </div>

    </div>

</div>

<?php include('../admin/includes/footer.php'); ?>