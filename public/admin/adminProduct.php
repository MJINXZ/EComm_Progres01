<?php
session_start();

$pageClass = "products-page";

include('../admin/includes/header.php');
include_once("../../app/config/config.php");

// ======================
// PAGINATION
// ======================
$limit = 10;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if($page < 1){
    $page = 1;
}

$start = ($page - 1) * $limit;

// ======================
// TOTAL PRODUCTS
// ======================
$total_query = "SELECT COUNT(*) as total FROM product_item";

$total_result = mysqli_query($conn, $total_query);

$total_row = mysqli_fetch_assoc($total_result);

$total_products = $total_row['total'];

$total_pages = ceil($total_products / $limit);

// ======================
// GET PRODUCTS
// ======================
$product_query = "
SELECT *
FROM product_item
ORDER BY id DESC
LIMIT $start, $limit
";

$product_result = mysqli_query($conn, $product_query);

?>

<body class="products-page">

<div class="dashboard-layout">

    <?php include('../admin/includes/sidebar.php'); ?>

    <div class="main-content">

        <!-- HEADER -->
        <div class="products-header">

            <div>

                <h2>🛍️ Products Management</h2>

                <p>
                    Manage your pastry products
                </p>

            </div>

            <div class="header-actions">

                <input 
                    type="text"
                    id="searchInput"
                    placeholder="Search product..."
                >

                <a href="add_product.php" class="add-btn">
                    + Add Product
                </a>

            </div>

        </div>

        <!-- PRODUCT CARD -->
        <div class="products-card">

            <div class="table-responsive">

                <table class="products-table">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>

                    </thead>

                    <tbody id="productsTable">

                        <?php if(mysqli_num_rows($product_result) > 0): ?>

                            <?php while($row = mysqli_fetch_assoc($product_result)): ?>

                                <tr>

                                    <!-- ID -->
                                    <td>
                                        <?php echo $row['id']; ?>
                                    </td>

                                    <!-- IMAGE -->
                                    <td>

                                        <img 
                                            src="../assets/product_img/<?php echo $row['img']; ?>"
                                            class="product-image"
                                        >

                                    </td>

                                    <!-- PRODUCT NAME -->
                                    <td>

                                        <?php
                                        echo htmlspecialchars($row['productName']);
                                        ?>

                                    </td>

                                    <!-- DESCRIPTION -->
                                    <td class="description-cell">

                                        <?php
                                        echo htmlspecialchars($row['productDescription']);
                                        ?>

                                    </td>

                                    <!-- PRICE -->
                                    <td>

                                        ₱<?php
                                        echo htmlspecialchars($row['price']);
                                        ?>

                                    </td>

                                    <!-- ACTIONS -->
                                    <td>

                                        <div class="action-buttons">

                                            <a 
                                                href="edit_product.php?id=<?php echo $row['id']; ?>"
                                                class="edit-btn"
                                            >
                                                Edit
                                            </a>

                                            <a 
                                                href="../../app/controllers/delete_product.php?id=<?php echo $row['id']; ?>"
                                                class="delete-btn"
                                                onclick="return confirm('Delete this product?')"
                                            >
                                                Delete
                                            </a>

                                        </div>

                                    </td>

                                </tr>

                            <?php endwhile; ?>

                        <?php else: ?>

                            <tr>

                                <td colspan="6" class="empty-row">
                                    No Products Found
                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

            <!-- PAGINATION -->
            <div class="pagination-container">

                <?php if($page > 1): ?>

                    <a 
                        href="?page=<?php echo $page - 1; ?>"
                        class="page-btn"
                    >
                        Previous
                    </a>

                <?php endif; ?>

                <?php for($i = 1; $i <= $total_pages; $i++): ?>

                    <a 
                        href="?page=<?php echo $i; ?>"
                        class="page-btn <?php echo ($page == $i) ? 'active-page' : ''; ?>"
                    >
                        <?php echo $i; ?>
                    </a>

                <?php endfor; ?>

                <?php if($page < $total_pages): ?>

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

searchInput.addEventListener("keyup", function(){

    let value = this.value.toLowerCase();

    let rows = document.querySelectorAll("#productsTable tr");

    rows.forEach(row => {

        row.style.display = row.innerText.toLowerCase().includes(value)
            ? ""
            : "none";

    });

});

</script>

</body>
</html>