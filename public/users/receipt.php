<?php 
session_start();
$pageClass = "receipt-page";

include('../admin/includes/header.php');
include('../admin/includes/topbar.php');
include_once("../../app/config/config.php");

// LOGIN CHECK
if(!isset($_SESSION['user_id'])){
    header("Location: /E-commerce/public/login.php");
    exit();
}

// ORDER ID CHECK
if(!isset($_GET['id'])){
    echo "No order selected";
    exit();
}

$order_id = intval($_GET['id']);

// GET ORDER + USER NAME
$order_query = mysqli_query($conn, "
    SELECT o.*, u.username 
    FROM orders o
    JOIN users u ON o.user_id = u.id
    WHERE o.id='$order_id'
");

$order = mysqli_fetch_assoc($order_query);

if(!$order){
    echo "Order not found";
    exit();
}

// GET ORDER ITEMS + PRODUCT NAME
$items_query = mysqli_query($conn, "
    SELECT oi.*, p.productName 
    FROM orderitems oi
    JOIN product_item p ON oi.product_id = p.id
    WHERE oi.order_id='$order_id'
");

// TOTAL + TAX
$total = 0;
$tax_rate = 0.12; // 12% VAT
?>

<body class="<?php echo $pageClass; ?>">

<div class="receipt-wrapper">

  <div class="receipt">

    <!-- HEADER -->
    <div class="header">
      <h2>SweetShop</h2>
      <p>Official Receipt</p>
      <span class="badge"><?php echo $order['status']; ?></span>
    </div>

    <!-- INFO -->
    <div class="info">
      <p><strong>Order #:</strong> <?php echo $order['COnumber']; ?></p>
      <p><strong>Date:</strong> <?php echo $order['DateCreated']; ?></p>
      <p><strong>Customer:</strong> <?php echo $order['username']; ?></p>
    </div>

    <!-- ITEMS -->
    <table class="items">
      <tr>
        <th>Product</th>
        <th>Qty</th>
        <th>Subtotal</th>
      </tr>

      <?php while($item = mysqli_fetch_assoc($items_query)): 
          $subtotal = $item['price'] * $item['quantity'];
          $total += $subtotal;
      ?>
      <tr>
        <td><?php echo $item['productName']; ?></td>
        <td><?php echo $item['quantity']; ?></td>
        <td>₱<?php echo number_format($subtotal, 2); ?></td>
      </tr>
      <?php endwhile; ?>

    </table>

    <?php
    // CALCULATE TAX AFTER LOOP
    $tax = $total * $tax_rate;
    $grand_total = $total + $tax;
    ?>

    <!-- TOTAL -->
    <div class="total">

      <div style="width:100%;">
        
        <div style="display:flex; justify-content:space-between;">
          <span>Subtotal</span>
          <span>₱<?php echo number_format($total, 2); ?></span>
        </div>

        <div style="display:flex; justify-content:space-between;">
          <span>VAT (12%)</span>
          <span>₱<?php echo number_format($tax, 2); ?></span>
        </div>

        <div style="display:flex; justify-content:space-between; margin-top:8px; font-weight:bold;">
          <span>Total</span>
          <span>₱<?php echo number_format($grand_total, 2); ?></span>
        </div>

      </div>

    </div>

    <!-- FOOTER -->
    <div class="footer">
      Thank you for your purchase 💚
    </div>

  </div>

</div>

</body>
</html>