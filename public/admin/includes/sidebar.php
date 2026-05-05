<?php
$pageClass = "sidebar-page";
?>

<!-- ✅ ADD THIS WRAPPER -->
<div class="sidebar-page">

<div class="admin-sidebar d-flex flex-column flex-shrink-0 p-3 text-white bg-dark">

  <a href="#" class="d-flex align-items-center mb-3 text-white text-decoration-none">
    <span class="fs-4">Admin Panel</span>
  </a>

  <hr>

  <ul class="nav nav-pills flex-column mb-auto">
    <li class="nav-item">
      <a href="index.php" class="nav-link active text-white">Home</a>
    </li>

    <li>
      <a href="dashboard.php" class="nav-link text-white">Dashboard</a>
    </li>

    <li>
      <a href="orders.php" class="nav-link text-white">Orders</a>
    </li>

    <li>
      <a href="products.php" class="nav-link text-white">Products</a>
    </li>

    <li>
      <a href="customers.php" class="nav-link text-white">Customers</a>
    </li>
  </ul>

  <hr>

  <div class="mt-auto">
    <a href="../../logout.php" class="btn btn-danger w-100">Logout</a>
  </div>

</div>