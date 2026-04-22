<?php
// Receipt Page
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Receipt</title>
  <link rel="stylesheet" href="receipt.css">
</head>
<body>

<div class="receipt">

  <!-- HEADER -->
  <div class="header">
    <h2>SweetShop</h2>
    <p>Official Receipt</p>
    <span class="badge">Paid</span>
  </div>

  <!-- INFO -->
  <div class="info">
    <p><strong>Order ID:</strong> #EC20260422</p>
    <p><strong>Date:</strong> April 22, 2026</p>
    <p><strong>Customer:</strong> John Doe</p>
  </div>

  <!-- ITEMS -->
  <table class="items">
    <tr>
      <th>Item</th>
      <th>Qty</th>
      <th>Price</th>
    </tr>

    <tr>
      <td>Chocolate Cake</td>
      <td>1</td>
      <td>$12.00</td>
    </tr>

    <tr>
      <td>Strawberry Eclair</td>
      <td>2</td>
      <td>$6.00</td>
    </tr>
  </table>

  <!-- TOTAL -->
  <div class="total">
    <span>Total</span>
    <span>$18.00</span>
  </div>

  <!-- FOOTER -->
  <div class="footer">
    Thank you for your purchase 💚<br>
    www.sweetshop.com
  </div>

</div>

</body>
</html>
