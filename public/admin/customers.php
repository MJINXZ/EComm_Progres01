<?php
session_start();
$pageClass = "customers-page";

include('../admin/includes/header.php');
include_once("../../app/config/config.php");

// ======================
// PAGINATION
// ======================
$limit = 20;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$start = ($page - 1) * $limit;

// ======================
// TOTAL CUSTOMERS
// ======================
$total_query = "
SELECT COUNT(*) as total
FROM users
WHERE role != 'admin'
";

$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);

$total_customers = $total_row['total'];
$total_pages = ceil($total_customers / $limit);

// ======================
// GET CUSTOMERS
// ======================
$customer_query = "
SELECT 
    id,
    uuid,
    firstName,
    lastName,
    middleName,
    emailAddress,
    contactNumber,
    username,
    street,
    barangay,
    city,
    profile,
    role,
    dateCreated
FROM users
WHERE role != 'admin'
ORDER BY id DESC
LIMIT $start, $limit
";

$customer_result = mysqli_query($conn, $customer_query);
?>

<body class="customers-page">

<div class="dashboard-layout">

    <?php include('../admin/includes/sidebar.php'); ?>

    <div class="main-content">

        <!-- HEADER -->
        <div class="orders-header">
            <div>
                <h2>👥 Customers Management</h2>
                <p>Manage customer accounts</p>
            </div>

            <input 
                type="text"
                id="searchInput"
                placeholder="Search customer..."
            >
        </div>

        <!-- CARD -->
        <div class="orders-card">

            <div class="table-responsive">

                <table class="orders-table">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th>Role</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody id="customersTable">

                        <?php if (mysqli_num_rows($customer_result) > 0): ?>

                            <?php while ($row = mysqli_fetch_assoc($customer_result)): ?>

                                <tr>

                                    <!-- ID -->
                                    <td>
                                        <?php echo $row['id']; ?>
                                    </td>

                                    <!-- CUSTOMER -->
                                    <td>
                                        <?php
                                        echo htmlspecialchars(
                                            $row['firstName'] . ' ' .
                                            $row['lastName']
                                        );
                                        ?>
                                    </td>

                                    <!-- EMAIL -->
                                    <td>
                                        <?php echo htmlspecialchars($row['emailAddress']); ?>
                                    </td>

                                    <!-- USERNAME -->
                                    <td>
                                        <?php echo htmlspecialchars($row['username']); ?>
                                    </td>

                                    <!-- CONTACT -->
                                    <td>
                                        <?php echo htmlspecialchars($row['contactNumber']); ?>
                                    </td>

                                    <!-- ADDRESS -->
                                    <td>
                                        <?php
                                        echo htmlspecialchars(
                                            $row['street'] . ', ' .
                                            $row['barangay'] . ', ' .
                                            $row['city']
                                        );
                                        ?>
                                    </td>

                                    <!-- ROLE -->
                                    <td>
                                        <span class="status-badge pending">
                                            <?php echo ucfirst($row['role']); ?>
                                        </span>
                                    </td>

                                    <!-- DATE -->
                                    <td>
                                        <?php echo date("M d, Y", strtotime($row['dateCreated'])); ?>
                                    </td>

                                    <!-- ACTION -->
                                    <td>
                                        <div class="action-buttons">
                                            <a
                                                href="/E-commerce/public/admin/userProfile.php?id=<?php echo $row['id']; ?>"
                                                class="view-btn"
                                            >
                                                View
                                            </a>
                                        </div>
                                    </td>

                                </tr>

                            <?php endwhile; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="9" class="empty-row">
                                    No Customers Found
                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

            <!-- PAGINATION -->
            <div class="pagination-container">

                <?php if ($page > 1): ?>
                    <a
                        href="?page=<?php echo $page - 1; ?>"
                        class="page-btn"
                    >
                        Previous
                    </a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a
                        href="?page=<?php echo $i; ?>"
                        class="page-btn <?php echo ($page == $i) ? 'active-page' : ''; ?>"
                    >
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <a
                        href="?page=<?php echo $page + 1; ?>"
                        class="page-btn"
                    >
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

searchInput.addEventListener("keyup", function () {

    let value = this.value.toLowerCase();

    let rows = document.querySelectorAll("#customersTable tr");

    rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value)
            ? ""
            : "none";
    });

});

</script>

</body>
</html>