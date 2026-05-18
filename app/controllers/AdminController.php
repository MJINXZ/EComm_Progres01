<?php 

session_start();

include_once("../config/config.php");
include_once("changelogController.php");



// ======================
// LOGOUT
// ======================
if(isset($_POST['logout'])){

    // SAVE ADMIN ID BEFORE DESTROYING SESSION
    $admin_id = $_SESSION['user_id'];

    
    // ADD CHANGELOG FIRST
    addAdminLog(

        $admin_id,

        'LOGOUT',

        'Admin logged out of the system'

    );


    // DESTROY SESSION
    unset($_SESSION['authUser']);
    unset($_SESSION['user_id']);
    unset($_SESSION['userRole']);

    session_destroy();


    // REDIRECT
    header("Location: /E-commerce/public/index");
    exit(0);

}




// ======================
// UPDATE ORDER STATUS
// ======================
if(isset($_POST['updateOrderStatus'])){

    $order_id = $_POST['order_id'];

    $status = strtolower($_POST['status']);



    // ALLOWED ENUM VALUES
    $allowed = ['pending', 'completed', 'cancelled'];



    if(in_array($status, $allowed)){



        // ======================
        // UPDATE ORDER
        // ======================
        $stmt = $conn->prepare("

        UPDATE orders

        SET status = ?

        WHERE id = ?

        ");

        $stmt->bind_param("si", $status, $order_id);

        $stmt->execute();




        // ======================
        // GET ORDER NUMBER
        // ======================
        $orderQuery = mysqli_query($conn, "

        SELECT COnumber

        FROM orders

        WHERE id='$order_id'

        ");

        $orderData = mysqli_fetch_assoc($orderQuery);

        $COnumber = $orderData['COnumber'];




        // ======================
        // ADMIN ID
        // ======================
        $admin_id = $_SESSION['user_id'];




        // ======================
        // ADD CHANGELOG
        // ======================
        addAdminLog(

            $admin_id,

            'ORDER_UPDATE',

            "Changed order $COnumber status to $status"

        );

    }



    header("Location: ../../public/admin/orders.php");
    exit();

}

?>