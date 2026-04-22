<?php
// User Profile Page
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dessert Shop - Profile</title>
  <link rel="stylesheet" href="user_profile.css">
</head>
<body>

<header class="navbar">
  <h2 style="color: black;">Sweet!</h2>
  <div class="nav-links">
    <a href="#" style="color: black;">Shop</a>
    <a href="#" style="color: black;">Orders</a>
    <a href="#" style="color: black;">Logout</a>
  </div>
</header>

<div class="container">

  <!-- LEFT PROFILE CARD -->
  <div class="profile-card">
    <img src="https://via.placeholder.com/120" alt="Profile">
    <h3>User1111</h3>
    <p>user@gmail.com</p>
    <button class="btn" style="color: black;">Change Photo</button>
  </div>

  <!-- RIGHT FORM -->
  <div class="profile-form">
    <h2>Profile Settings</h2>

    <div class="form-grid">
      <div>
        <label>First Name</label>
        <input type="text" value="User1111">
      </div>

      <div>
        <label>Last Name</label>
        <input type="text" value="User1111">
      </div>

      <div>
        <label>Mobile</label>
        <input type="text" value="1234567890">
      </div>

      <div>
        <label>Email</label>
        <input type="email" value="user@email.com">
      </div>

      <div class="full">
        <label>Address</label>
        <input type="text" value="Magsaysay France">
      </div>

      <div>
        <label>Province</label>
        <select>
          <option>Western</option>
        </select>
      </div>

      <div>
        <label>District</label>
        <select>
          <option>Colombo</option>
        </select>
      </div>

    </div>

    <button class="save-btn" style="color: black;">Save Changes</button>
  </div>

</div>

<!-- ORDER HISTORY -->
<div class="order-history">

  <h2>Order History</h2>

  <table>
    <thead>
      <tr>
        <th>Order ID</th>
        <th>Date</th>
        <th>Total</th>
        <th>Status</th>
        <th>Details</th>
      </tr>
    </thead>

    <tbody>
      <tr>
        <td>#1001</td>
        <td>April 10, 2026</td>
        <td>$25.00</td>
        <td class="status delivered">Delivered</td>
        <td><button class="details-btn">View</button></td>
      </tr>

      <tr>
        <td>#1002</td>
        <td>April 15, 2026</td>
        <td>$12.00</td>
        <td class="status pending">Pending</td>
        <td><button class="details-btn">View</button></td>
      </tr>

      <tr>
        <td>#1003</td>
        <td>April 18, 2026</td>
        <td>$18.00</td>
        <td class="status cancelled">Cancelled</td>
        <td><button class="details-btn">View</button></td>
      </tr>
    </tbody>
  </table>

</div>

</body>
</html>
