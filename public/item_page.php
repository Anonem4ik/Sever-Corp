<?php
    session_start();
    require_once __DIR__."\\..\\includes\\connect.php";
    require_once __DIR__."\\..\\includes\\dbQueries.php";
    require_once __DIR__."\\..\\includes\\htmlFunctions.php";
    // Checking if "id" is present
    if (!isset($_GET['id']) or $_GET['id'] == '') {
        header('Location: /');
        exit;
    }
    $good_id = $_GET['id'];
    // Getting general information
    $sql = <<<EOF
    SELECT g.article_num, g.name, g.price, g.wholesale_price, g.images_count,
    g.description, c.category_id, c.name as `category_name`, AVG(r.rating) as rating,
    COUNT(r.rating) as rewiews_num, s.name as `shipper_name`, g.country, soff.partner,
    soff.offer_value, g.supply_left
    FROM goods as g
    LEFT JOIN categories as c ON g.FK_category = c.category_id
    LEFT JOIN shippers as s ON g.FK_shipper = s.shipper_id
    LEFT JOIN special_offers as soff ON g.FK_special_offer = soff.offer_id
    LEFT JOIN reviews as r ON r.FK_good = g.good_id
    WHERE `good_id` = :good_id
    EOF;
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':good_id', $good_id);
    $statement->execute();
    $good = $statement->fetch();
    // Check if good with this id exists
    if (!$good or is_null($good['name'])) {
        header('Location: /');
        exit;
    }
    // Getting additional info
    $add_info_list = getBy($pdo, 'additional_info', ['FK_good' => $good_id], true);
    $add_info_len = count($add_info_list);
    // User-related info
    if (isset($_SESSION['user_data'])) {
        // Basket information
        $user_id = $_SESSION['user_data']['uid'];
        $basket_id = getBy($pdo, 'orders', ['FK_user' => $user_id, 'status' => 'basket'])['order_id'];
        // Getting data about basket and favorite
        $sql = <<<EOF
        SELECT (oi.entry_id IS NOT NULL) as `is_in_basket`, (f.FK_user IS NOT NULL) as `is_in_favorite`
        FROM goods as g
        LEFT JOIN order_items AS oi ON g.good_id = oi.FK_good AND oi.FK_order = '$basket_id'
        LEFT JOIN favorite_lists AS f ON g.good_id = f.FK_good AND f.FK_user = '$user_id'
        WHERE `good_id` = :good_id
        EOF;
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':good_id', $good_id);
        $statement->execute();
        $user_info = $statement->fetch();
        // Proceed user written rewiew
        if (isset($_POST['submit_review'])) {
            // Unpack fields
            $rating = $_POST['rating'] ?? '5';
            $text = $_POST['review_text'] ?? "";
            // Check if review already left
            var_dump(getBy($pdo, 'reviews', ['FK_user' => $user_id, 'FK_good' => $good_id]));
            if (!getBy($pdo, 'reviews', ['FK_user' => $user_id, 'FK_good' => $good_id])){
                // Write review to database
                insert_data($pdo, 'reviews', [
                    'FK_good' => $good_id, 'FK_user' => $user_id,
                    'rating' => $rating, 'review_text' => $text, 'review_date' => date("Y-m-d")
                ]);
            }
        }
        // More items
        $sql = <<<EOF
        SELECT g.good_id, g.name, g.price,
        (oi.entry_id IS NOT NULL) as `is_in_basket`,
        (f.FK_user IS NOT NULL) as `is_in_favorite`
        FROM goods as g
        LEFT JOIN order_items AS oi ON g.good_id = oi.FK_good AND oi.FK_order = $basket_id
        LEFT JOIN favorite_lists AS f ON g.good_id = f.FK_good AND f.FK_user = '$user_id'
        WHERE `supply_left` > 0 AND `good_id` != $good_id
        LIMIT 5
        EOF;
        $more_goods = $pdo->query($sql)->fetchAll();
    }
    // Rewiews
    $sql = <<<EOF
    SELECT u.login, r.rating, r.review_text, r.review_date, u.user_id
    FROM reviews as r
    INNER JOIN users as u ON r.FK_user = u.user_id
    WHERE r.FK_good = $good_id
    EOF;
    $reviews_list = $pdo->query($sql)->fetchAll();
    // Flag if user already wrote rewiew
    if (count($reviews_list) <= 0) $is_present = false;
    else {
        $uids = array_map(null, ...$reviews_list)[4];
        if (gettype($uids) == 'string') $uids = array($uids);
        $is_present = in_array($_SESSION['user_data']['uid'] ?? null, $uids);
    }
    // Preparing output data
    $page_title = clean($good['name']);
    $page_css_list = ['item_page', 'product_card'];
    ob_start();
    include __DIR__.'\\..\\templates\\item_page.html.php';
    $page_content = ob_get_clean();
    // Displaying page to user
    include __DIR__.'\\..\\templates\\layout.html.php';
?>