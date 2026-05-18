<?php
session_start();
include_once("../config/config.php");

if (isset($_POST['add_to_cart'])) {

    // =========================
    // GET PRODUCT UUID
    // =========================
    $product_uuid = $_POST['product_uuid'];

    $quantity = (int)$_POST['quantity'];

    // =========================
    // CONVERT UUID TO REAL ID
    // =========================
    $productQuery = "SELECT id FROM product_item WHERE uuid = ? LIMIT 1";

    $productStmt = mysqli_prepare($conn, $productQuery);

    mysqli_stmt_bind_param($productStmt, "s", $product_uuid);

    mysqli_stmt_execute($productStmt);

    $productResult = mysqli_stmt_get_result($productStmt);

    // PRODUCT NOT FOUND
    if(mysqli_num_rows($productResult) == 0){

        $_SESSION['message'] = "Product not found";
        $_SESSION['code'] = "error";

        header("Location: /E-commerce/public/shop.php");
        exit();
    }

    $productData = mysqli_fetch_assoc($productResult);

    // REAL INTERNAL PRODUCT ID
    $productid = $productData['id'];





    // =========================
    // USER LOGGED IN
    // =========================
    if (isset($_SESSION['user_id'])) {

        $userid = $_SESSION['user_id'];

        // MOVE SESSION CART TO DATABASE
        if (isset($_SESSION['cart'])) {

            foreach ($_SESSION['cart'] as $g_productid => $g_quantity) {

                $query = "SELECT * FROM cart
                          WHERE user_id = ?
                          AND product_id = ?";

                $stmt = mysqli_prepare($conn, $query);

                mysqli_stmt_bind_param(
                    $stmt,
                    "ii",
                    $userid,
                    $g_productid
                );

                mysqli_stmt_execute($stmt);

                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) > 0) {

                    $row = mysqli_fetch_assoc($result);

                    $newQuantity = $row['quantity'] + $g_quantity;

                    $updateQuery = "UPDATE cart
                                    SET quantity = ?
                                    WHERE user_id = ?
                                    AND product_id = ?";

                    $updateStmt = mysqli_prepare($conn, $updateQuery);

                    mysqli_stmt_bind_param(
                        $updateStmt,
                        "iii",
                        $newQuantity,
                        $userid,
                        $g_productid
                    );

                    mysqli_stmt_execute($updateStmt);

                } else {

                    $insertQuery = "INSERT INTO cart
                                    (user_id, product_id, quantity)
                                    VALUES (?, ?, ?)";

                    $insertStmt = mysqli_prepare($conn, $insertQuery);

                    mysqli_stmt_bind_param(
                        $insertStmt,
                        "iii",
                        $userid,
                        $g_productid,
                        $g_quantity
                    );

                    mysqli_stmt_execute($insertStmt);
                }
            }

            unset($_SESSION['cart']);
        }





        // =========================
        // CHECK IF PRODUCT EXISTS
        // =========================
        $query = "SELECT * FROM cart
                  WHERE user_id = ?
                  AND product_id = ?";

        $stmt = mysqli_prepare($conn, $query);

        mysqli_stmt_bind_param(
            $stmt,
            "ii",
            $userid,
            $productid
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {

            // UPDATE QUANTITY
            $row = mysqli_fetch_assoc($result);

            $newQuantity = $row['quantity'] + $quantity;

            $updateQuery = "UPDATE cart
                            SET quantity = ?
                            WHERE user_id = ?
                            AND product_id = ?";

            $updateStmt = mysqli_prepare($conn, $updateQuery);

            mysqli_stmt_bind_param(
                $updateStmt,
                "iii",
                $newQuantity,
                $userid,
                $productid
            );

            mysqli_stmt_execute($updateStmt);

        } else {

            // INSERT NEW CART ITEM
            $insertQuery = "INSERT INTO cart
                            (user_id, product_id, quantity)
                            VALUES (?, ?, ?)";

            $insertStmt = mysqli_prepare($conn, $insertQuery);

            mysqli_stmt_bind_param(
                $insertStmt,
                "iii",
                $userid,
                $productid,
                $quantity
            );

            mysqli_stmt_execute($insertStmt);
        }

    } else {

        // =========================
        // GUEST SESSION CART
        // =========================
        if (!isset($_SESSION['cart'])) {

            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$productid])) {

            $_SESSION['cart'][$productid] += $quantity;

        } else {

            $_SESSION['cart'][$productid] = $quantity;
        }
    }






    // =========================
    // SUCCESS MESSAGE
    // =========================
    $_SESSION['message'] = "Product added to cart!";
    $_SESSION['code'] = "success";

    // REDIRECT USING UUID
    header("Location: /E-commerce/public/productpage.php?uuid=$product_uuid");

    exit;
}






// =========================
// REMOVE SESSION CART
// =========================
if (isset($_GET['remove_session'])) {

    $productid = $_GET['remove_session'];

    if (isset($_SESSION['cart'][$productid])) {

        unset($_SESSION['cart'][$productid]);
    }

    header("Location: /E-commerce/public/cart.php");

    exit;
}






// =========================
// REMOVE DATABASE CART
// =========================
if (isset($_GET['remove'])) {

    $id = $_GET['remove'];

    $deleteQuery = "DELETE FROM cart WHERE id = ?";

    $stmt = mysqli_prepare($conn, $deleteQuery);

    mysqli_stmt_bind_param($stmt, "i", $id);

    mysqli_stmt_execute($stmt);

    header("Location: /E-commerce/public/cart.php");

    exit();
}
?>