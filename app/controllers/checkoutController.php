<?php
session_start();

include_once("../config/config.php");


// =========================
// GENERATE UUID FUNCTION
// =========================
function generate_uuid() {

    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),

        mt_rand(0, 0xffff),

        mt_rand(0, 0x0fff) | 0x4000,

        mt_rand(0, 0x3fff) | 0x8000,

        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );
}





// =========================
// CHECKOUT
// =========================
if (isset($_POST['checkout'])) {

    // =========================
    // LOGIN CHECK
    // =========================
    if (!isset($_SESSION['user_id'])) {

        header("Location: /E-commerce/public/login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];

    $address = mysqli_real_escape_string(
        $conn,
        $_POST['address']
    );

    $phone = mysqli_real_escape_string(
        $conn,
        $_POST['phone']
    );

    $payment = mysqli_real_escape_string(
        $conn,
        $_POST['payment_method']
    );





    // =========================
    // GET CART ITEMS
    // =========================
    $cartQuery = "

        SELECT 
            c.*,
            p.price

        FROM cart c

        JOIN product_item p
            ON c.product_id = p.id

        WHERE c.user_id = '$user_id'

    ";

    $cartResult = mysqli_query($conn, $cartQuery);

    if(!$cartResult){

        die("Cart query failed: " . mysqli_error($conn));
    }

    $subtotal = 0;





    // =========================
    // COMPUTE SUBTOTAL
    // =========================
    while ($row = mysqli_fetch_assoc($cartResult)) {

        $price = (float)$row['price'];

        $quantity = (int)$row['quantity'];

        $subtotal += $price * $quantity;
    }





    // =========================
    // TAX CALCULATION
    // =========================
    $tax_rate = 0.12;

    $tax = $subtotal * $tax_rate;

    $total = $subtotal + $tax;





    // =========================
    // GENERATE ORDER UUID
    // =========================
    $order_uuid = generate_uuid();





    // =========================
    // INSERT ORDER
    // =========================
    $insertOrder = "

        INSERT INTO orders

        (
            uuid,
            user_id,
            subtotal,
            tax,
            totalPrice,
            address,
            contactNumber,
            paymentMethod,
            status,
            DateCreated
        )

        VALUES

        (
            '$order_uuid',
            '$user_id',
            '$subtotal',
            '$tax',
            '$total',
            '$address',
            '$phone',
            '$payment',
            'Pending',
            NOW()
        )

    ";

    $result = mysqli_query($conn, $insertOrder);

    if(!$result){

        die("Order insert failed: " . mysqli_error($conn));
    }





    // =========================
    // GET ORDER ID
    // =========================
    $order_id = mysqli_insert_id($conn);





    // =========================
    // GENERATE CO NUMBER
    // =========================
    $COnumber = "CO" . str_pad(
        $order_id,
        5,
        "0",
        STR_PAD_LEFT
    );

    mysqli_query(
        $conn,
        "UPDATE orders 
         SET COnumber='$COnumber' 
         WHERE id='$order_id'"
    );





    // =========================
    // INSERT ORDER ITEMS
    // =========================
    $cartResult = mysqli_query($conn, $cartQuery);

    while ($row = mysqli_fetch_assoc($cartResult)) {

        $product_id = $row['product_id'];

        $quantity = (int)$row['quantity'];

        $price = (float)$row['price'];





        $insertItem = "

            INSERT INTO orderitems

            (
                order_id,
                product_id,
                quantity,
                price
            )

            VALUES

            (
                '$order_id',
                '$product_id',
                '$quantity',
                '$price'
            )

        ";

        mysqli_query($conn, $insertItem);
    }





    // =========================
    // CLEAR CART
    // =========================
    mysqli_query(
        $conn,
        "DELETE FROM cart 
         WHERE user_id='$user_id'"
    );





    // =========================
    // REDIRECT TO RECEIPT
    // =========================
    header(
        "Location: /E-commerce/public/users/receipt.php?uuid=" . $order_uuid
    );

    exit();
}
?>