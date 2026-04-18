<?php
session_start();
include_once("../config/config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!isset($_SESSION['user_id'])) {
        header("Location: /E-commerce/public/login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $payment = $_POST['payment_method'];
    $total = $_POST['total'];

    
 $insertOrder = "INSERT INTO orders (user_id, totalPrice, address, contactNumber, paymentMethod, status, DateCreated)
                VALUES ('$user_id', '$total', '$address', '$phone', '$payment', 'Pending', NOW())";

mysqli_query($conn, $insertOrder);

$order_id = mysqli_insert_id($conn);


$COnumber = "CO" . str_pad($order_id, 5, "0", STR_PAD_LEFT);

mysqli_query($conn, "UPDATE orders SET COnumber='$COnumber' WHERE id='$order_id'");

$cartQuery = "SELECT c.*, p.price 
              FROM cart c 
              JOIN product_item p ON c.product_id = p.id 
              WHERE c.user_id='$user_id'";

    $cartResult = mysqli_query($conn, $cartQuery);

    while ($row = mysqli_fetch_assoc($cartResult)) {

        $product_id = $row['product_id'];
        $quantity = $row['quantity'];
        $price = $row['price'];
        $subtotal = $price * $quantity;

      
 $insertItem = "INSERT INTO orderitems (order_id, product_id, quantity, price)
               VALUES ('$order_id', '$product_id', '$quantity', '$subtotal' )";
mysqli_query($conn, $insertItem);
    }


    mysqli_query($conn, "DELETE FROM cart WHERE user_id='$user_id'");


   header("Location: /E-commerce/public/index.php");
    exit();
}
?>