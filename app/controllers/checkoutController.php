<?php
session_start();
include_once("../config/config.php");

if (isset($_POST['checkout'])) {

    // LOGIN CHECK
    if (!isset($_SESSION['user_id'])) {
        header("Location: /E-commerce/public/login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $payment = mysqli_real_escape_string($conn, $_POST['payment_method']);

    // 🔥 GET CART ITEMS
    $cartQuery = "SELECT c.*, p.price 
                  FROM cart c 
                  JOIN product_item p ON c.product_id = p.id 
                  WHERE c.user_id='$user_id'";

    $cartResult = mysqli_query($conn, $cartQuery);

    $subtotal = 0;

    // COMPUTE SUBTOTAL
    while ($row = mysqli_fetch_assoc($cartResult)) {
        $subtotal += $row['price'] * $row['quantity'];
    }

    // 🔥 TAX CALCULATION (12% VAT)
    $tax_rate = 0.12;
    $tax = $subtotal * $tax_rate;
    $total = $subtotal + $tax;

    // 🔥 INSERT ORDER (WITH TAX)
    $insertOrder = "INSERT INTO orders 
        (user_id, subtotal, tax, totalPrice, address, contactNumber, paymentMethod, status, DateCreated)
        VALUES 
        ('$user_id', '$subtotal', '$tax', '$total', '$address', '$phone', '$payment', 'Pending', NOW())";

    $result = mysqli_query($conn, $insertOrder);

    if (!$result) {
        die("Order insert failed: " . mysqli_error($conn));
    }

    $order_id = mysqli_insert_id($conn);

    // GENERATE CO NUMBER
    $COnumber = "CO" . str_pad($order_id, 5, "0", STR_PAD_LEFT);
    mysqli_query($conn, "UPDATE orders SET COnumber='$COnumber' WHERE id='$order_id'");

    // 🔥 INSERT ORDER ITEMS AGAIN (RE-RUN QUERY)
    $cartResult = mysqli_query($conn, $cartQuery);

    while ($row = mysqli_fetch_assoc($cartResult)) {

        $product_id = $row['product_id'];
        $quantity = $row['quantity'];
        $price = $row['price'];

        mysqli_query($conn, "INSERT INTO orderitems 
            (order_id, product_id, quantity, price)
            VALUES 
            ('$order_id', '$product_id', '$quantity', '$price')");
    }

    // CLEAR CART
    mysqli_query($conn, "DELETE FROM cart WHERE user_id='$user_id'");

    // REDIRECT
    header("Location: /E-commerce/public/users/receipt.php?id=".$order_id);
    exit();
}
?>