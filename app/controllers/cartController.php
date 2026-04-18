<?php
session_start();
include_once("../config/config.php");

if (isset($_POST['add_to_cart'])) {

    $productid = $_POST['product_id'];
    $quantity  = (int)$_POST['quantity'];

    if (isset($_SESSION['user_id'])) {

        $userid = $_SESSION['user_id'];

     
        if (isset($_SESSION['cart'])) {

            foreach ($_SESSION['cart'] as $g_productid => $g_quantity) {

                $query = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "ii", $userid, $g_productid);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) > 0) {

                    $row = mysqli_fetch_assoc($result);
                    $newQuantity = $row['quantity'] + $g_quantity;

                    $updateQuery = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
                    $updateStmt = mysqli_prepare($conn, $updateQuery);
                    mysqli_stmt_bind_param($updateStmt, "iii", $newQuantity, $userid, $g_productid);
                    mysqli_stmt_execute($updateStmt);

                } else {

                    $insertQuery = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
                    $insertStmt = mysqli_prepare($conn, $insertQuery);
                    mysqli_stmt_bind_param($insertStmt, "iii", $userid, $g_productid, $g_quantity);
                    mysqli_stmt_execute($insertStmt);
                }
            }

            unset($_SESSION['cart']); 
        }

   
        $query = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ii", $userid, $productid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
    
            $row = mysqli_fetch_assoc($result);
            $newQuantity = $row['quantity'] + $quantity;

            $updateQuery = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
            $updateStmt = mysqli_prepare($conn, $updateQuery);
            mysqli_stmt_bind_param($updateStmt, "iii", $newQuantity, $userid, $productid);
            mysqli_stmt_execute($updateStmt);

        } else {
      
            $insertQuery = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
            $insertStmt = mysqli_prepare($conn, $insertQuery);
            mysqli_stmt_bind_param($insertStmt, "iii", $userid, $productid, $quantity);
            mysqli_stmt_execute($insertStmt);
        }

    } else {

    
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$productid])) {
            $_SESSION['cart'][$productid] += $quantity;
        } else {
            $_SESSION['cart'][$productid] = $quantity;
        }
    }

    $_SESSION['message'] = "Product added to cart!";
    $_SESSION['code'] = "success";

    header("Location: /E-commerce/public/productpage.php?id=$productid");
    exit;
}


if (isset($_GET['remove_session'])) {
    $productid = $_GET['remove_session'];

    if (isset($_SESSION['cart'][$productid])) {
        unset($_SESSION['cart'][$productid]);
    }

    header("Location: /E-commerce/public/cart.php");
    exit;
}


if (isset($_GET['remove'])) {
    $id = $_GET['remove'];

    $deleteQuery = "DELETE FROM cart WHERE id = $id";
    mysqli_query($conn, $deleteQuery);


header("Location: /E-commerce/public/cart.php");
    exit();
}

/*

if ($_POST['action'] == 'saveTempCheckout') {

    $_SESSION['temp_address'] = $_POST['address'];
    $_SESSION['temp_phone'] = $_POST['phone'];
    $_SESSION['temp_payment'] = $_POST['payment_method'];
    $_SESSION['temp_packaging'] = $_POST['packaging'];

    header("Location: /E-commerce/public/cart.php");
    exit;
}

*/
