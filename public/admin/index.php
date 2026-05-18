<?php 
session_start();

$pageClass = "dashboard-page";

include('../admin/includes/header.php');
include_once("../../app/config/config.php");


// =====================
// DAILY SALES
// =====================
$daily_query = "
SELECT 
    DATE_FORMAT(DateCreated, '%b %d %h:%i %p') as time_label,
    SUM(totalPrice) as total

FROM orders

WHERE DateCreated >= DATE_SUB(NOW(), INTERVAL 24 HOUR)
AND status IN ('pending', 'completed')

GROUP BY HOUR(DateCreated), DATE(DateCreated)

ORDER BY DateCreated ASC
";

$daily_result = mysqli_query($conn, $daily_query);

$daily_labels = [];
$daily_data = [];

while($row = mysqli_fetch_assoc($daily_result)){

    $daily_labels[] = $row['time_label'];

    $daily_data[] = (float)$row['total'];

}


// =====================
// WEEKLY SALES
// =====================
$weekly_query = "
SELECT 
    DATE_FORMAT(DateCreated, '%W (%b %d)') as date_label,
    SUM(totalPrice) as total

FROM orders

WHERE DateCreated >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
AND status IN ('pending', 'completed')

GROUP BY DATE(DateCreated)

ORDER BY DATE(DateCreated) ASC
";

$weekly_result = mysqli_query($conn, $weekly_query);

$week_labels = [];
$week_data = [];

while($row = mysqli_fetch_assoc($weekly_result)){

    $week_labels[] = $row['date_label'];

    $week_data[] = (float)$row['total'];

}


// =====================
// MONTHLY SALES
// =====================
$monthly_query = "
SELECT 
    DATE_FORMAT(DateCreated, '%M %Y') as month,
    SUM(totalPrice) as total

FROM orders

WHERE DateCreated >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
AND status IN ('pending', 'completed')

GROUP BY month

ORDER BY MIN(DateCreated) ASC
";

$monthly_result = mysqli_query($conn, $monthly_query);

$month_labels = [];
$month_data = [];

while($row = mysqli_fetch_assoc($monthly_result)){

    $month_labels[] = $row['month'];

    $month_data[] = (float)$row['total'];

}


// =====================
// RECENT COMPLETED ORDERS
// =====================
$recent_query = "
SELECT 
    orders.id,
    orders.totalPrice,
    orders.DateCreated,

    users.firstName,
    users.lastName,
    users.street,
    users.barangay,
    users.city

FROM orders

JOIN users 
ON users.id = orders.user_id

WHERE orders.status = 'completed'

ORDER BY orders.DateCreated DESC

LIMIT 5
";

$recent_result = mysqli_query($conn, $recent_query);

?>

<body class="dashboard-page">

<div class="dashboard-layout">

    <!-- SIDEBAR -->
    <?php include('../admin/includes/sidebar.php'); ?>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- CHARTS -->
        <div class="charts-grid">

            <!-- DAILY -->
            <div class="chart-col">

                <div class="dashboard-card">

                    <div class="card-header">
                        📅 Daily Sales
                    </div>

                    <canvas id="dailyChart"></canvas>

                </div>

            </div>

            <!-- WEEKLY -->
            <div class="chart-col">

                <div class="dashboard-card">

                    <div class="card-header">
                        📈 Weekly Sales
                    </div>

                    <canvas id="weeklyChart"></canvas>

                </div>

            </div>

            <!-- MONTHLY -->
            <div class="chart-col">

                <div class="dashboard-card">

                    <div class="card-header">
                        📊 Monthly Sales
                    </div>

                    <canvas id="monthlyChart"></canvas>

                </div>

            </div>

        </div>


        <!-- RECENT COMPLETED ORDERS -->
        <div class="dashboard-card">

            <div class="card-header">
                ✅ Recent Completed Orders
            </div>

            <table class="recent-orders-table">

                <thead>

                    <tr>
                        <th>Customer</th>
                        <th>Address</th>
                        <th>Location</th>
                        <th>Total</th>
                        <th>Date & Time</th>
                    </tr>

                </thead>

                <tbody>

                <?php if(mysqli_num_rows($recent_result) > 0): ?>

                    <?php while($row = mysqli_fetch_assoc($recent_result)): ?>

                        <tr>

                            <!-- CUSTOMER -->
                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $row['firstName'].' '.$row['lastName']
                                );
                                ?>
                            </td>

                            <!-- ADDRESS -->
                            <td>
                                <?php
                                echo htmlspecialchars($row['street']);
                                ?>
                            </td>

                            <!-- LOCATION -->
                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $row['barangay'].', '.$row['city']
                                );
                                ?>
                            </td>

                            <!-- TOTAL -->
                            <td>

                                ₱<?php
                                echo number_format($row['totalPrice'], 2);
                                ?>

                            </td>

                            <!-- DATE -->
                            <td>

                                <?php
                                echo date(
                                    "F d, Y - h:i A",
                                    strtotime($row['DateCreated'])
                                );
                                ?>

                            </td>

                        </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>

                        <td colspan="5" style="text-align:center;">
                            No completed orders found
                        </td>

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

// =====================
// DAILY CHART
// =====================
new Chart(document.getElementById('dailyChart'), {

    type: 'line',

    data: {

        labels: <?php echo json_encode($daily_labels); ?>,

        datasets: [{

            label: 'Daily Sales',

            data: <?php echo json_encode($daily_data); ?>,

            borderColor: '#f59e0b',

            backgroundColor: 'rgba(245,158,11,0.2)',

            fill: true,

            tension: 0.4

        }]

    }

});


// =====================
// WEEKLY CHART
// =====================
new Chart(document.getElementById('weeklyChart'), {

    type: 'line',

    data: {

        labels: <?php echo json_encode($week_labels); ?>,

        datasets: [{

            label: 'Weekly Sales',

            data: <?php echo json_encode($week_data); ?>,

            borderColor: '#3b82f6',

            backgroundColor: 'rgba(59,130,246,0.2)',

            fill: true,

            tension: 0.4

        }]

    }

});


// =====================
// MONTHLY CHART
// =====================
new Chart(document.getElementById('monthlyChart'), {

    type: 'bar',

    data: {

        labels: <?php echo json_encode($month_labels); ?>,

        datasets: [{

            label: 'Monthly Sales',

            data: <?php echo json_encode($month_data); ?>,

            backgroundColor: '#10b981'

        }]

    }

});

</script>

</body>
</html>