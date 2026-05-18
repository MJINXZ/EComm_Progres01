<?php

include_once(__DIR__ . '/../config/config.php');

function addAdminLog($admin_id, $action_type, $description){

    global $conn;

    $admin_id = mysqli_real_escape_string($conn, $admin_id);

    $action_type = mysqli_real_escape_string(
        $conn,
        $action_type
    );

    $description = mysqli_real_escape_string(
        $conn,
        $description
    );

    $query = "

    INSERT INTO admin_changelog (

        admin_id,
        action_type,
        description

    )

    VALUES (

        '$admin_id',
        '$action_type',
        '$description'

    )

    ";

    mysqli_query($conn, $query);

}
?>