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
    // Fetching basket id
    $basket_id = getBy($pdo, 'orders', ['FK_user' => $user_id, 'status' => 'basket'])['order_id'];
    // Processing basket bying
    if (isset($_POST['by_all_basket_submit'])) {
        // Unpack fields
        $items = $_POST['items'];
        // Checking if order is possible
        $is_possible = true;
        foreach ($items as [$good_id, $good_count]) {
            $good_info = getBy($pdo, 'goods', ['good_id' => $good_id]);
            if ($good_info['supply_left'] < $good_count) {
                $msg = 'К сожалению, товара "'.$good_info['name'].'" недостаточно на складе. Остаток: '.$good_info['supply_left'];
                $_SESSION['error_message'] = $msg;
                $is_possible = false;
                break;
            }
        }
        // Items manipulation
        if ($is_possible) {
            foreach ($items as [$good_id, $good_count]) {
                // Changing items count
                $sql = <<<EOF
                UPDATE order_items SET `count` = $good_count
                WHERE `FK_order` = :basket_id AND `FK_good` = :good_id
                EOF;
                $statement = $pdo->prepare($sql);
                $statement->execute([':basket_id' => $basket_id, ':good_id' => $good_id]);
                // Reducing supply
                $sql = <<<EOF
                UPDATE goods SET `supply_left` = `supply_left` - :good_count
                WHERE `good_id` = :good_id
                EOF;
                $statement = $pdo->prepare($sql);
                $statement->execute([':good_count' => $good_count, ':good_id' => $good_id]);
            }
            // Changing order status
            $sql = "UPDATE orders SET `status` = 'ordered', `date` = NOW() WHERE `order_id` = :basket_id";
            $statement = $pdo->prepare($sql);
            $statement->execute([':basket_id' => $basket_id]);
            // Creating new basket and updating basket id
            insert_data($pdo, 'orders', ['FK_user' => $user_id]);
        }
        // Refreshing page
        header("Refresh: 0");
        exit;
    }
    // Getting basket items
    $sql = <<<EOF
    SELECT g.good_id, g.name, g.price, g.wholesale_price
    FROM order_items as oi
    LEFT JOIN goods as g ON g.good_id = oi.FK_good
    WHERE oi.FK_order = :basket_id
    EOF;
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':basket_id', $basket_id);
    $statement->execute();
    $basket_goods = $statement->fetchAll();
    // Preparing output data
    $page_title = 'Корзина';
    $page_css_list = ['basket'];
    ob_start();
    include __DIR__.'\\..\\templates\\basket.html.php';
    $page_content = ob_get_clean();
    // Displaying page to user
    include __DIR__.'\\..\\templates\\layout.html.php';