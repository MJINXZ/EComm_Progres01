<?php 
session_start();
$pageClass = "dashboard-page";

include_once("../../app/config/config.php");
include('../admin/includes/header.php');
include('../admin/includes/topbar.php');



// =====================
// WEEKLY SALES (7 DAYS)
// =====================
$weekly_query = "
SELECT DATE(DateCreated) as date, SUM(totalPrice) as total
FROM orders
WHERE DateCreated >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
GROUP BY DATE(DateCreated)
ORDER BY date ASC
";

$weekly_result = mysqli_query($conn, $weekly_query);

$week_labels = [];
$week_data = [];

while($row = mysqli_fetch_assoc($weekly_result)){
    $week_labels[] = $row['date'];
    $week_data[] = $row['total'];
}


// =====================
// MONTHLY SALES (6 MONTHS)
// =====================
$monthly_query = "
SELECT DATE_FORMAT(DateCreated, '%Y-%m') as month, SUM(totalPrice) as total
FROM orders
WHERE DateCreated >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
GROUP BY month
ORDER BY month ASC
";

$monthly_result = mysqli_query($conn, $monthly_query);

$month_labels = [];
$month_data = [];

while($row = mysqli_fetch_assoc($monthly_result)){
    $month_labels[] = $row['month'];
    $month_data[] = $row['total'];
}


// =====================
// TOTAL STATS (OPTIONAL)
// =====================
$total_sales_query = "SELECT SUM(totalPrice) as total FROM orders";
$total_orders_query = "SELECT COUNT(*) as count FROM orders";

$total_sales = mysqli_fetch_assoc(mysqli_query($conn, $total_sales_query))['total'] ?? 0;
$total_orders = mysqli_fetch_assoc(mysqli_query($conn, $total_orders_query))['count'] ?? 0;
?>



<!-- DASHBOARD CONTENT -->
<div class="dashboard-container">

    <h2 class="mb-4">Sales Dashboard</h2>

    <!-- STATS CARDS -->
    <div class="row mb-4">

        <div class="col-md-6">
            <div class="stat-card stat-sales">
                <h5>Total Sales</h5>
                <h3>₱<?php echo number_format($total_sales, 2); ?></h3>
            </div>
        </div>

        <div class="col-md-6">
            <div class="stat-card stat-orders">
                <h5>Total Orders</h5>
                <h3><?php echo $total_orders; ?></h3>
            </div>
        </div>

    </div>


    <!-- CHARTS -->
    <div class="row">

        <!-- WEEKLY -->
        <div class="col-md-6">
            <div class="card dashboard-card p-3">
                <h5>Weekly Sales</h5>
                <canvas id="weeklyChart"></canvas>
            </div>
        </div>

        <!-- MONTHLY -->
        <div class="col-md-6">
            <div class="card dashboard-card p-3">
                <h5>Monthly Sales</h5>
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>

    </div>

</div>

<?php 
$recent_query = "
SELECT 
    orders.id,
    orders.totalPrice,
    orders.address,
    orders.DateCreated,
    users.firstName,
    users.lastName,
    users.street,
    users.barangay,
    users.city
FROM orders
JOIN users ON users.id = orders.user_id
ORDER BY orders.DateCreated DESC
LIMIT 5
";

$recent_result = mysqli_query($conn, $recent_query);

?>

<!-- RECENT ORDERS -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card dashboard-card p-3">
            
            <h5>Recent Orders</h5>

            <table class="table table-bordered table-hover mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>Customer Name</th>
                        <th>Address</th>
                        <th>Location</th>
                        <th>Total Price</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>

                <?php if(mysqli_num_rows($recent_result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($recent_result)): ?>
                        <tr>
                            <!-- CUSTOMER NAME -->
                            <td>
                                <?php echo $row['firstName'] . ' ' . $row['lastName']; ?>
                            </td>

                            <!-- ADDRESS -->
                            <td>
                                <?php echo $row['street']; ?>
                            </td>

                            <!-- LOCATION -->
                            <td>
                                <?php echo $row['barangay'] . ', ' . $row['city']; ?>
                            </td>

                            <!-- TOTAL -->
                            <td>
                                ₱<?php echo number_format($row['totalPrice'], 2); ?>
                            </td>

                            <!-- DATE -->
                            <td>
                                <?php echo date("M d, Y - h:i A", strtotime($row['DateCreated'])); ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No recent orders found</td>
                    </tr>
                <?php endif; ?>

                </tbody>
            </table>

        </div>
    </div>
</div>


<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// DATA FROM PHP
const weekLabels = <?php echo json_encode($week_labels); ?>;
const weekData = <?php echo json_encode($week_data); ?>;

const monthLabels = <?php echo json_encode($month_labels); ?>;
const monthData = <?php echo json_encode($month_data); ?>;


// WEEKLY CHART
new Chart(document.getElementById('weeklyChart'), {
    type: 'line',
    data: {
        labels: weekLabels,
        datasets: [{
            label: 'Weekly Sales',
            data: weekData,
            borderWidth: 2,
            tension: 0.3
        }]
    }
});


// MONTHLY CHART
new Chart(document.getElementById('monthlyChart'), {
    type: 'bar',
    data: {
        labels: monthLabels,
        datasets: [{
            label: 'Monthly Sales',
            data: monthData,
            borderWidth: 1
        }]
    }
});
</script>

</body>
</html>