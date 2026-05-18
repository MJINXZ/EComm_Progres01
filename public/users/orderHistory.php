<?php
session_start();

$pageClass = "cus-order-page";

if(!isset($_SESSION['user_id'])){
    header("Location: /E-commerce/public/index");
    exit();
}

include('../admin/includes/header.php');
include('../admin/includes/topbar.php');
include_once("../../app/config/config.php");

$user_id = $_SESSION['user_id'];

$order_query = "
SELECT *
FROM orders
WHERE user_id = '$user_id'
ORDER BY DateCreated DESC
";

$order_result = mysqli_query($conn, $order_query);

?>

<div class="orders-page-container">

    <div class="main-content">

        <!-- HEADER -->
        <div class="cus-order-header">

            <div>
                <h2>📦 My Orders</h2>
                <p>View all your recent orders</p>
            </div>

            <input type="text"
                   id="searchInput"
                   placeholder="Search order number...">

        </div>

        <!-- ORDER CARD -->
        <div class="cus-order-card">

            <div class="table-responsive">

                <table class="cus-order-table">

                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Total</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody id="ordersTable">

                    <?php if(mysqli_num_rows($order_result) > 0): ?>

                        <?php while($row = mysqli_fetch_assoc($order_result)): ?>

                            <?php

                            $status = strtolower($row['status']);

                            if($status == "completed"){

                                $badge = "completed";

                            }
                            elseif($status == "cancelled"){

                                $badge = "cancelled";

                            }
                            else{

                                $badge = "pending";

                            }

                            ?>

                            <tr>

                                <!-- ORDER NUMBER -->
                                <td>
                                    <?php echo htmlspecialchars($row['COnumber']); ?>
                                </td>

                                <!-- TOTAL -->
                                <td>
                                    ₱<?php echo number_format((float)$row['totalPrice'], 2); ?>
                                </td>

                                <!-- PAYMENT -->
                                <td>
                                    <?php echo htmlspecialchars($row['paymentMethod']); ?>
                                </td>

                                <!-- STATUS -->
                                <td>

                                    <span class="cus-order-status <?php echo $badge; ?>">

                                        <?php echo htmlspecialchars($row['status']); ?>

                                    </span>

                                </td>

                                <!-- DATE -->
                                <td>

                                    <?php
                                    echo date(
                                        'M d, Y',
                                        strtotime($row['DateCreated'])
                                    );
                                    ?>

                                </td>

                                <!-- ACTION -->
                                <td>

                                    <a href="receipt.php?co=<?php echo urlencode($row['COnumber']); ?>"
                                       class="cus-order-view-btn">

                                        View

                                    </a>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="6" class="empty-row">
                                No Orders Found
                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<?php include('../admin/includes/footer.php'); ?>

<script>

const searchInput = document.getElementById("searchInput");

searchInput.addEventListener("keyup", function(){

    let value = this.value.toLowerCase();

    let rows = document.querySelectorAll("#ordersTable tr");

    rows.forEach(row => {

        if(row.innerText.toLowerCase().includes(value)){

            row.style.display = "";

        }
        else{

            row.style.display = "none";

        }

    });

});

</script>