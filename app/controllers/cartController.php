<?php
session_start();
include_once("../config/config.php");

if (isset($_POST['add_to_cart'])) {

    $productid = $_POST['product_id'];
    $quantity  = (int)$_POST['quantity'];

    if (isset($_SESSION['user_id'])) {

        $userid = $_SESSION['user_id'];

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
            mysqli_stmt_close($updateStmt);

        } else {
      
            $insertQuery = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
            $insertStmt = mysqli_prepare($conn, $insertQuery);
            mysqli_stmt_bind_param($insertStmt, "iii", $userid, $productid, $quantity);
            mysqli_stmt_execute($insertStmt);
            mysqli_stmt_close($insertStmt);
        }

       $_SESSION['message'] = "Product added to cart!";
        $_SESSION['code'] = "success";


    } else {

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$productid])) {
            $_SESSION['cart'][$productid] += $quantity;
        } else {
            $_SESSION['cart'][$productid] = $quantity;
        }

      $_SESSION['message'] = "Product added to cart!";
      $_SESSION['code'] = "success";
    }

    header("Location: /E-commerce/public/productpage.php?id=$productid");
exit;
}