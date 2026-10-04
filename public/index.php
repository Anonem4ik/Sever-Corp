<?php
    session_start();
    require_once __DIR__."\\..\\includes\\connect.php";
    require_once __DIR__."\\..\\includes\\dbQueries.php";
    require_once __DIR__."\\..\\includes\\htmlFunctions.php";
    // Proceed collab offer
    if (isset($_POST['collab_offer_submit'])) {
        // Check for agreement
        if (!isset($_POST['agreement'])) {
            $_SESSION['error_message'] = "Вы обязаны дать согласие на обработку персональных данных!";
        } else {
            // Unpack fiels
            $uid = $_SESSION['user_data']['uid'];
            $full_name = $_POST['full_name'];
            $corp_name = $_POST['corp_name'];
            $phone = $_POST['phone'];
            // Send data
            insert_data($pdo, 'collab_offers', [
                'FK_user' => $uid, 'full_name' => $full_name,
                'company_name' => $corp_name, 'phone_number' => $phone
            ]);
            // Refreshing page
            header("Refresh: 0");
            exit;
        }
    }
    // Sales banners count
    const BANNERS_PATH = "images\\sales_banners\\";
    $banners_num = count(glob(BANNERS_PATH . "*.webp"));
    // Categories list
    $categories = getAllOrdered($pdo, 'name');
    // Information about registered user
    $user_id = '';
    $basket_id = '';
    if (isset($_SESSION['user_data'])) {
        $user_id = $_SESSION['user_data']['uid'];
        $basket_id = getBy($pdo, 'orders', ['FK_user' => $user_id, 'status' => 'basket'])['order_id'];
        // Check if collab form was already send
        $is_offer_send = getBy($pdo, 'collab_offers', ['FK_user' => $user_id]);
    }
    // List of general information of first 15 goods
    $sql = <<<EOF
    SELECT g.good_id, g.name, g.price,
    (oi.entry_id IS NOT NULL) as `is_in_basket`,
    (f.FK_user IS NOT NULL) as `is_in_favorite`
    FROM goods as g
    LEFT JOIN reviews AS r ON g.good_id = r.FK_good
    LEFT JOIN order_items AS oi ON g.good_id = oi.FK_good AND oi.FK_order = '$basket_id'
    LEFT JOIN favorite_lists AS f ON g.good_id = f.FK_good AND f.FK_user = '$user_id'
    WHERE `supply_left` > 0
    GROUP BY g.good_id, oi.entry_id
    ORDER BY AVG(`rating`) DESC
    LIMIT 15
    EOF;
    $goods = $pdo->query($sql);
    // Preparing output data
    $page_title = 'Главная';
    $page_css_list = ['index_s', 'generic_form', 'product_card'];
    ob_start();
    include __DIR__.'\\..\\templates\\index.html.php';
    $page_content = ob_get_clean();
    // Displaying page to user
    include __DIR__.'\\..\\templates\\layout.html.php';
?>