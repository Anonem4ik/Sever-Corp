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
    $basket_id = getBy($pdo, 'orders', ['FK_user' => $user_id, 'status' => 'basket'])['order_id'];
    // Getting favorite item
    $query = <<<EOF
    SELECT g.good_id, g.name, g.price, (oi.entry_id IS NOT NULL) as `is_in_basket`
    FROM favorite_lists as f
    LEFT JOIN goods as g ON g.good_id = f.FK_good
    LEFT JOIN order_items AS oi ON g.good_id = oi.FK_good AND oi.FK_order = $basket_id
    WHERE f.FK_user = $user_id
    EOF;
    $favorite_goods = mysqli_fetch_all(mysqli_query($db, $query));
    // Preparing output data
    $page_title = 'Избранное';
    $page_css_list = ['product_card', 'basket', 'favorite'];
    ob_start();
    include __DIR__.'\\..\\templates\\favorite.html.php';
    $page_content = ob_get_clean();
    // Displaying page to user
    include __DIR__.'\\..\\templates\\layout.html.php';