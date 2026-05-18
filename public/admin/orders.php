<?php
session_start();
$pageClass = "orders-page";

include('../admin/includes/header.php');
include_once("../../app/config/config.php");


// ======================
// PAGINATION
// ======================
$limit = 20;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if($page < 1){
    $page = 1;
}

$start = ($page - 1) * $limit;


// ======================
// TOTAL ORDERS
// ======================
$total_query = "SELECT COUNT(*) as total FROM orders";

$total_result = mysqli_query($conn, $total_query);

$total_row = mysqli_fetch_assoc($total_result);

$total_orders = $total_row['total'];

$total_pages = ceil($total_orders / $limit);


// ======================
// GET ORDERS
// ======================
$order_query = "
SELECT 
    orders.id,
    orders.COnumber,
    orders.totalPrice,
    orders.paymentMethod,
    orders.status,
    orders.DateCreated,

    users.firstName,
    users.lastName,
    users.street,
    users.barangay,
    users.city

FROM orders

JOIN users 
ON users.id = orders.user_id

ORDER BY orders.DateCreated DESC

LIMIT $start, $limit
";

$order_result = mysqli_query($conn, $order_query);

?>

<body class="orders-page">

<div class="dashboard-layout">

    <?php include('../admin/includes/sidebar.php'); ?>

    <div class="main-content">

        <!-- HEADER -->
        <div class="orders-header">

            <div>
                <h2>📦 Orders Management</h2>
                <p>Manage customer orders</p>
            </div>

            <input type="text" id="searchInput" placeholder="Search order...">

        </div>

        <!-- CARD -->
        <div class="orders-card">

            <div class="table-responsive">

                <table class="orders-table">

                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Address</th>
                            <th>Payment</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody id="ordersTable">

                    <?php if(mysqli_num_rows($order_result) > 0): ?>

                        <?php while($row = mysqli_fetch_assoc($order_result)): ?>

                            <?php
                            $status = strtolower($row['status']);

                            if($status == 'completed'){
                                $badge = "completed";
                            }
                            elseif($status == 'cancelled'){
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

                                <!-- CUSTOMER -->
                                <td>
                                    <?php echo htmlspecialchars(
                                        $row['firstName'].' '.$row['lastName']
                                    ); ?>
                                </td>

                                <!-- ADDRESS -->
                                <td>
                                    <?php
                                    echo htmlspecialchars(
                                        $row['street'].', '.
                                        $row['barangay'].', '.
                                        $row['city']
                                    );
                                    ?>
                                </td>

                                <!-- PAYMENT -->
                                <td>
                                    <?php echo htmlspecialchars($row['paymentMethod']); ?>
                                </td>

                                <!-- TOTAL -->
                                <td>
                                   <?php echo htmlspecialchars($row['totalPrice']); ?>
                                </td>

                                <!-- STATUS -->
                                <td>

                                    <form method="POST"
                                          action="/E-commerce/app/controllers/adminController.php">

                                        <input type="hidden"
                                               name="updateOrderStatus"
                                               value="1">

                                        <input type="hidden"
                                               name="order_id"
                                               value="<?php echo $row['id']; ?>">

                                        <select name="status"
                                                class="status-select <?php echo $badge; ?>"
                                                onchange="this.form.submit()">

                                            <option value="pending"
                                                <?php if($status == 'pending') echo 'selected'; ?>>
                                                Pending
                                            </option>

                                            <option value="completed"
                                                <?php if($status == 'completed') echo 'selected'; ?>>
                                                Completed
                                            </option>

                                            <option value="cancelled"
                                                <?php if($status == 'cancelled') echo 'selected'; ?>>
                                                Cancelled
                                            </option>

                                        </select>

                                    </form>

                                </td>

                                <!-- DATE -->
                                <td>
                                    <?php echo date(
                                        "M d, Y",
                                        strtotime($row['DateCreated'])
                                    ); ?>
                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="7" class="empty-row">
                                No Orders Found
                            </td>
                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

            <!-- PAGINATION -->
            <div class="pagination-container">

                <?php if($page > 1): ?>

                    <a href="?page=<?php echo $page - 1; ?>"
                       class="page-btn">
                        Previous
                    </a>

                <?php endif; ?>

                <?php for($i = 1; $i <= $total_pages; $i++): ?>

                    <a href="?page=<?php echo $i; ?>"
                       class="page-btn <?php echo ($page == $i) ? 'active-page' : ''; ?>">

                        <?php echo $i; ?>

                    </a>

                <?php endfor; ?>

                <?php if($page < $total_pages): ?>

                    <a href="?page=<?php echo $page + 1; ?>"
                       class="page-btn">
                        Next
                    </a>

                <?php endif; ?>

            </div>

        </div>

    </div>

</div>

<script>

// SEARCH
const searchInput = document.getElementById("searchInput");

searchInput.addEventListener("keyup", function(){

    let value = this.value.toLowerCase();

    let rows = document.querySelectorAll("#ordersTable tr");

    rows.forEach(row => {

        row.style.display = row.innerText.toLowerCase().includes(value)
            ? ""
            : "none";

    });

});

</script>

</body>
</html>