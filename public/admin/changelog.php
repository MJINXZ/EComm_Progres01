<?php
session_start();

$pageClass = "changelog-page";

include('../admin/includes/header.php');
include_once('../../app/config/config.php');


// ======================
// ADMIN CHECK
// ======================
if(!isset($_SESSION['authUser'])){

    header("Location: /E-commerce/public/login");
    exit();

}

if($_SESSION['userRole'] !== 'admin'){

    header("Location: /E-commerce/public/index");
    exit();

}


// ======================
// SEARCH
// ======================
$search = "";

if(isset($_GET['search'])){

    $search = mysqli_real_escape_string($conn, $_GET['search']);

}


// ======================
// FETCH LOGS
// ======================
$query = "

SELECT 

    admin_changelog.*,

    users.firstName,
    users.lastName

FROM admin_changelog

INNER JOIN users

ON admin_changelog.admin_id = users.id

WHERE

    users.firstName LIKE '%$search%'
    OR users.lastName LIKE '%$search%'
    OR admin_changelog.action_type LIKE '%$search%'
    OR admin_changelog.description LIKE '%$search%'

ORDER BY admin_changelog.created_at DESC

";

$result = mysqli_query($conn, $query);


// ======================
// TOTAL LOGS
// ======================
$total_logs_query = mysqli_query($conn, "

SELECT COUNT(*) as total

FROM admin_changelog

");

$total_logs = mysqli_fetch_assoc($total_logs_query)['total'];


// ======================
// ORDER LOGS
// ======================
$order_logs_query = mysqli_query($conn, "

SELECT COUNT(*) as total

FROM admin_changelog

WHERE action_type='ORDER_UPDATE'

");

$order_logs = mysqli_fetch_assoc($order_logs_query)['total'];


// ======================
// PRODUCT LOGS
// ======================
$product_logs_query = mysqli_query($conn, "

SELECT COUNT(*) as total

FROM admin_changelog

WHERE action_type='PRODUCT_UPDATE'

");

$product_logs = mysqli_fetch_assoc($product_logs_query)['total'];

?>

<link rel="stylesheet" href="/E-commerce/public/assets/css/changelog.css">


<div class="container-fluid py-4">

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

        <div>

            <h1 class="fw-bold mb-1">
                📜 Admin Changelog
            </h1>

            <p class="text-muted mb-0">
                Track all admin activities and actions
            </p>

        </div>

    </div>



    <!-- SUMMARY CARDS -->
    <div class="row g-4 mb-4">

        <!-- TOTAL LOGS -->
        <div class="col-lg-4 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 log-card">

                <div class="card-body">

                    <h2 class="fw-bold mb-2">
                        <?php echo $total_logs; ?>
                    </h2>

                    <p class="text-muted mb-0">
                        Total Logs
                    </p>

                </div>

            </div>

        </div>



        <!-- ORDER LOGS -->
        <div class="col-lg-4 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 log-card">

                <div class="card-body">

                    <h2 class="fw-bold text-primary mb-2">
                        <?php echo $order_logs; ?>
                    </h2>

                    <p class="text-muted mb-0">
                        Order Updates
                    </p>

                </div>

            </div>

        </div>



        <!-- PRODUCT LOGS -->
        <div class="col-lg-4 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 log-card">

                <div class="card-body">

                    <h2 class="fw-bold text-success mb-2">
                        <?php echo $product_logs; ?>
                    </h2>

                    <p class="text-muted mb-0">
                        Product Updates
                    </p>

                </div>

            </div>

        </div>

    </div>



    <!-- SEARCH -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row g-3">

                    <div class="col-md-10">

                        <input
                            type="text"
                            name="search"
                            class="form-control form-control-lg"
                            placeholder="Search logs..."
                            value="<?php echo $search; ?>"
                        >

                    </div>

                    <div class="col-md-2">

                        <button
                            type="submit"
                            class="btn btn-dark btn-lg w-100"
                        >
                            Search
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>



    <!-- CHANGELOG TABLE -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        <div class="card-header bg-dark text-white py-3">

            <h5 class="mb-0">
                Recent Activities
            </h5>

        </div>


        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th class="px-4 py-3">
                            Admin
                        </th>

                        <th class="px-4 py-3">
                            Action Type
                        </th>

                        <th class="px-4 py-3">
                            Description
                        </th>

                        <th class="px-4 py-3">
                            Date
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <?php if(mysqli_num_rows($result) > 0){ ?>

                        <?php while($log = mysqli_fetch_assoc($result)){ ?>

                            <tr>

                                <!-- ADMIN -->
                                <td class="px-4 py-3 fw-semibold">

                                    <?php 
                                    
                                    echo $log['firstName'] . ' ' . $log['lastName']; 
                                    
                                    ?>

                                </td>



                                <!-- ACTION TYPE -->
                                <td class="px-4 py-3">

                                    <?php

                                    $badge = "secondary";

                                    if($log['action_type'] == "ORDER_UPDATE"){
                                        $badge = "primary";
                                    }

                                    if($log['action_type'] == "PRODUCT_UPDATE"){
                                        $badge = "success";
                                    }

                                    if($log['action_type'] == "DELETE"){
                                        $badge = "danger";
                                    }

                                    if($log['action_type'] == "LOGIN"){
                                        $badge = "dark";
                                    }

                                    ?>

                                    <span class="badge bg-<?php echo $badge; ?> px-3 py-2">

                                        <?php echo $log['action_type']; ?>

                                    </span>

                                </td>



                                <!-- DESCRIPTION -->
                                <td class="px-4 py-3">

                                    <?php echo $log['description']; ?>

                                </td>



                                <!-- DATE -->
                                <td class="px-4 py-3 text-muted">

                                    <?php 
                                    
                                    echo date(
                                        'M d, Y h:i A',
                                        strtotime($log['created_at'])
                                    ); 
                                    
                                    ?>

                                </td>

                            </tr>

                        <?php } ?>

                    <?php } else { ?>

                        <tr>

                            <td colspan="4" class="text-center py-5 text-muted">

                                No changelog records found.

                            </td>

                        </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php include('../admin/includes/footer.php'); ?>