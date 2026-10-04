<?php
    session_start();
    require_once __DIR__."\\..\\includes\\connect.php";
    require_once __DIR__."\\..\\includes\\dbQueries.php";
    require_once __DIR__."\\..\\includes\\htmlFunctions.php";
    // Category list
    $categories = getAllOrdered($pdo, 'name');
    // Unpacking values
    $prompt = $_GET['prompt'] ?? null;
    $category_id = $_GET['category_id'] ?? null;
    $price_from = $_GET['price_from'] ?? 0;
    $price_to = $_GET['price_to'] ?? 10000;
    // Information about registered user
    $user_id = '';
    $basket_id = '';
    if (isset($_SESSION['user_data'])) {
        $user_id = $_SESSION['user_data']['uid'];
        $basket_id = getBy($pdo, 'orders', ['FK_user' => $user_id, 'status' => 'basket'])['order_id'];
        // Check if collab form was already send
        $is_offer_send = getBy($pdo, 'collab_offers', ['FK_user' => $user_id]);
    }
    // Main prompt
    $sql = <<<EOF
    SELECT g.good_id, g.name, g.price,
    (oi.entry_id IS NOT NULL) as `is_in_basket`,
    (f.FK_user IS NOT NULL) as `is_in_favorite`
    FROM goods as g
    LEFT JOIN order_items AS oi ON g.good_id = oi.FK_good AND oi.FK_order = '$basket_id'
    LEFT JOIN favorite_lists AS f ON g.good_id = f.FK_good AND f.FK_user = '$user_id'
    WHERE `price` <= ? AND `price` >= ?
    AND `supply_left` > 0
    EOF;
    // Additional conditions
    $params = [$price_to, $price_from];
    if (!is_null($category_id)) {
        $sql .= " AND `FK_category` = ?";
        $params[] = $category_id;
    }
    if (!is_null($prompt)) {
        $sql .= " AND LOCATE(LOWER(?), LOWER(`name`)) != 0";
        $params[] = $prompt;
    }
    // Getting good
    $statement = $pdo->prepare($sql);
    $statement->execute($params);
    $goods = $statement->fetchAll();
    // Preparing output data
    $page_title = 'Каталог';
    $page_css_list = ['index_s', 'catalog', 'product_card'];
    ob_start();
    include __DIR__.'\\..\\templates\\search.html.php';
    $page_content = ob_get_clean();
    // Displaying page to user
    include __DIR__.'\\..\\templates\\layout.html.php';
?>