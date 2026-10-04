<?php
    session_start();
    require_once __DIR__."\\..\\includes\\connect.php";
    require_once __DIR__."\\..\\includes\\dbQueries.php";
    require_once __DIR__."\\..\\includes\\htmlFunctions.php";
    // Check if user is registered
    if (!isset($_SESSION['user_data'])) {
        header("Location: login.php");
        exit;
    }
    $user_id = $_SESSION['user_data']['uid'];
    // Check if user tries to logout
    if (isset($_POST['logout_submit'])) {
        unset($_SESSION['user_data']);
        header("Location: /");
        exit;
    }
    // Getting user data
    $sql = <<<EOF
    SELECT u.login, COUNT(o.order_id) - 1 AS `orders_count`
    FROM users as u
    INNER JOIN orders AS o ON u.user_id = o.FK_user
    WHERE u.user_id = '$user_id'
    EOF;
    $user = $pdo->query($sql)->fetch();
    // Getting orders data
    $sql = <<<EOF
    SELECT `order_id`, `status`, `date`,
    SUM(oi.count * IF(oi.count < 15, g.price, g.wholesale_price)) as `total_price`
    FROM `orders` AS o
    INNER JOIN order_items AS oi ON o.order_id = oi.FK_order
    INNER JOIN goods AS g ON oi.FK_good = g.good_id
    WHERE `FK_user` = '$user_id' AND `status` <> 'basket'
    GROUP BY o.order_id
    EOF;
    $orders = $pdo->query($sql);
    // Function to get order items
    function getOrderItems($pdo, $order_id) {
        $sql = <<<EOF
        SELECT g.good_id, g.name, g.price, oi.count
        FROM order_items as oi
        INNER JOIN goods AS g ON oi.FK_good = g.good_id
        WHERE oi.FK_order = '$order_id' AND oi.count < 15
        UNION
        SELECT g.good_id, g.name, g.wholesale_price, oi.count
        FROM order_items as oi
        INNER JOIN goods AS g ON oi.FK_good = g.good_id
        WHERE oi.FK_order = '$order_id' AND oi.count >= 15
        EOF;
        return $pdo->query($sql);
    }
    // Preparing output data
    $page_title = 'Личный кабинет';
    $page_css_list = ['account'];
    ob_start();
    include __DIR__.'\\..\\templates\\account.html.php';
    $page_content = ob_get_clean();
    // Displaying page to user
    include __DIR__.'\\..\\templates\\layout.html.php';
?>