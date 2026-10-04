<?php
    session_start();
    require_once __DIR__."\\actions\\admin_check.php";
    require_once __DIR__."\\..\\..\\includes\\connect.php";
    require_once __DIR__."\\..\\..\\includes\\htmlFunctions.php";
    // Check if location is exists
    $page = $_GET['page'] ?? 'default';
    if (!file_exists("pages/".$page.".php")) {
        header("Location: admin_panel.php");
        exit;
    };
    // Russian pages names, displayed on upper line
    const PAGE_NAMES = [
        'goods' => 'Товары',
        'good_info' => 'Информация о товаре',
        'categories' => 'Категории',
        'shippers' => 'Поставщики',
        'special_offers' => 'Специальные предложения',
        'orders' => 'Заказы',
        'collab_offers' => 'Предложения сотрудничества',
        'sale_banners' => 'Баннеры с акциями',
        'about' => 'Страница "О компании"'
    ];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель</title>
    <link rel="shortcut icon" href="../images/general/admin_favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin_panel.css">
</head>
<body>
    <!-- Side menue with links -->
    <aside class="side-menu default-container">
        <div class="side-menu__pages-group">
            <div class="side-menu__group-header">
                <h3>Основная информация</h3>
                <hr>
            </div>
            <a class="side-menu__link with-image f-20" href="?page=sale_banners">
                <img src="../images/general/admin_icon_sale_banners.svg" alt="icon">
                Слайдер акций
            </a>
            <a class="side-menu__link with-image f-20" href="?page=about">
                <img src="../images/general/admin_icon_about_page.svg" alt="icon">
                О компании
            </a>
        </div>
        <div class="side-menu__pages-group">
            <div class="side-menu__group-header">
                <h3>Маркетинг</h3>
                <hr>
            </div>
            <a class="side-menu__link with-image f-20" href="?page=goods">
                <img src="../images/general/admin_icon_goods.svg" alt="icon">
                Товары
            </a>
            <a class="side-menu__link with-image f-20" href="?page=categories">
                <img src="../images/general/admin_icon_categories.svg" alt="icon">
                Категории
            </a>
            <a class="side-menu__link with-image f-20" href="?page=shippers">
                <img src="../images/general/admin_icon_shippers.svg" alt="icon">
                Поставщики
            </a>
            <a class="side-menu__link with-image f-20" href="?page=special_offers">
                <img src="../images/general/admin_icon_special_offers.svg" alt="icon">
                Специальные предложения
            </a>
        </div>
        <div class="side-menu__pages-group">
            <div class="side-menu__group-header">
                <h3>Работа с клиентами</h3>
                <hr>
            </div>
            <a class="side-menu__link with-image f-20" href="?page=collab_offers">
                <img src="../images/general/admin_icon_collab_offers.svg" alt="icon">
                Заявки на сотрудничество
            </a>
            <a class="side-menu__link with-image f-20" href="?page=orders">
                <img src="../images/general/admin_icon_orders.svg" alt="icon">
                Заказы
            </a>
        </div>
    </aside>

    <!-- Upper line -->
    <div class="upper-line" flex-display="sided">
        <span><?= PAGE_NAMES[$page] ?? 'Админ-панель' ?></span>
        <a href="/">На главную</a>
    </div>

    <main>

        <?php include __DIR__."\\..\\..\\templates\\error_modal.html.php"; // Error modal ?>

        <?php include __DIR__."\\pages\\".$page.".php"; // Content of the page ?>

    </main>
</body>
</html>