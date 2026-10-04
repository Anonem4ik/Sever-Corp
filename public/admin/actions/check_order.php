<?php
    session_start();
    require_once __DIR__."\\admin_check.php";
    require_once __DIR__."\\..\\..\\..\\includes\\connect.php";
    // Unpack fields
    $order_id = $_GET['order_id'];
    // Modifying status
    $sql = "UPDATE orders SET `status` = 'done' WHERE `order_id` = :order_id";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':order_id', $order_id);
    $statement->execute();
    // Returning user
    header("Location: ../admin_panel.php?page=orders");
?>