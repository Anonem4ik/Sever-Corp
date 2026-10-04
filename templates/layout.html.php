<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <meta name="description" content="Магазин канцтоваров предлагает широкий ассортимент продукции для учебы, офиса и творчества, включая письменные принадлежности, бумажную продукцию, папки, органайзеры и товары для рисования. В каталоге представлены качественные товары от проверенных производителей по доступным ценам. Удобная система заказа и быстрая доставка позволяют клиентам оперативно приобретать необходимые товары для повседневных задач.">
    <link rel="shortcut icon" href="images/general/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <?php foreach ($page_css_list as $file_name): ?>
    <link rel="stylesheet" href="./css/<?= $file_name ?>.css">
    <?php endforeach; ?>
</head>
<body>
    <?php include __DIR__."\\error_modal.html.php"; ?>

    <!-- Header of the page -->
    <header>
        <!-- Upper side of header -->
        <div class="upper__container f-16">
            <nav flex-display="sided">
                <!-- Left side -->
                <div flex-display="centered-list" class="upper__side">
                    <div class="with-image">
                        <img src="images/general/location_icon.png" alt="Местоположение">
                        <a href="#">Орёл</a>
                    </div>
                    <div class="screen__only-wide"><a href="about.php">О компании</a></div>
                    <div class="screen__only-wide"><a href="#">Возврат</a></div>
                    <div class="screen__only-wide"><a href="#">Юридическим лицам</a></div>
                </div>
                <!-- Right side -->
                <div flex-display="centered-list" class="upper__side">
                    <?php if (($_SESSION['user_data']['uid'] ?? null) == 6) { ?>
                    <div class="screen__only-wide"><a href="admin/admin_panel.php">Админ-панель</a></div>
                    <?php } ?>
                    <div class="screen__only-wide"><a href="#">Магазины</a></div>
                    <div class="screen__only-wide"><a href="#">Доставка</a></div>
                    <div class="screen__only-wide"><a href="#">Вакансии</a></div>
                    <div class="screen__only-slim">
                        <button class="upper__menu-open" id="show_menu_btn">
                            <img src="./images/general/menue_icon.svg" alt="Открыть меню">
                        </button>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Hidden side menu (awalible only on slim screens) -->
        <div id="side_menu" style="display: none;">
            <div class="menu__overshadow" id="close_menu_btn"></div>
            <div class="menu__container f-24 default-container">
                <?php if (($_SESSION['user_data']['uid'] ?? null) == 6) { ?>
                <a href="admin/admin_panel.php">Админ-панель</a>
                <?php } ?>
                <a href="#">О компании</a>
                <a href="#">Возврат</a>
                <a href="#">Юридическим лицам</a>
                <a href="#">Магазины</a>
                <a href="#">Доставка</a>
                <a href="#">Вакансии</a>
            </div>
        </div>
        <script src="./scripts/togle-menu.js"></script>

        <!-- Lower side of header -->
        <div class="lower__container">
            <div class="lower__top-row">
                <!-- Company logo -->
                <a href="/"><img class="lower__logo" src="images/general/logo.svg" alt="ООО ПКП 'Север'"></a>
                <!-- Items search -->
                <div flex-display="sided" class="search__container">
                    <form class="search__form" action="search.php" method="get">
                        <input class="default-container" type="text" name="prompt" placeholder="Поиск...">
                        <button class="default-container" type="submit">
                            <img src="images/general/search_icon.png" alt="Найти">
                        </button>
                    </form>
                    <a class="search__catalog f-16 default-container with-image" href="search.php">
                        <img src="images/general/catalog_icon.svg" alt="Каталог">
                        <span class="catalog-text">Каталог товаров</span>
                    </a>
                </div>
                <!-- User control buttons -->
                <div flex-display="centered-list" class="user-control__container">
                    <a href="basket.php" class="user-control__btn with-image">
                        <img src="images/general/basket_icon.png" alt="Корзина">
                        <span>Корзина</span>
                    </a>
                    <a href="favorite.php" class="user-control__btn with-image">
                        <img src="images/general/favorite_icon.png" alt="Избранное">
                        <span>Избранное</span>
                    </a>
                    <?php if (isset($_SESSION['user_data'])) { ?>
                    <a href="account.php" class="user-control__btn with-image">
                        <img src="images/users_avatars/default.png" alt="Личный каьинет">
                        <span>Аккаунт</span>
                    </a>
                    <?php } else { ?>
                    <a href="login.php" class="user-control__btn with-image">
                        <img src="images/general/user_icon.png" alt="Войти">
                        <span>Войти</span>
                    </a>
                    <?php } ?>
                </div>
            </div>
            <!-- Additional categories -->
            <div flex-display="centered-list" class="bottom-row__container f-24">
                <a href="#">Акция</a>
                <a href="#">Для дома</a>
                <a href="#">Для офиса</a>
                <a href="#">Для печати</a>
                <a href="#">Для детей</a>
                <a href="#">Готовимся к школе</a>
            </div>
        </div>
    </header>

    <!-- Content of the page -->
    <main class="page-wrapper">
        <?= $page_content ?>
    </main>

    <!-- Footer of the page -->
    <footer>
    <div flex-display="centered-list" class="links__container f-18">
        <div flex-display="centered-list" class="links__section">
            <h2 class="f-30">ООО ПКП "Север"</h2>
            <hr>
            <a href="#">О компании</a>
            <a href="#">Наши вакансии</a>
            <a href="#">Реклама на сайте</a>
            <a href="#">Партнрам</a>
        </div>
        <div flex-display="centered-list" class="links__section">
            <h2 class="f-30">Контактные данные</h2>
            <hr>
            <a href="mailto:orelsevercorp@mail.ru">orelsevercorp@mail.ru</a>
            <a href="tel:+76038908999">+7 (603) 890 89-99</a>
        </div>
        <div flex-display="centered-list" class="links__section">
            <h2 class="f-30">Информация</h2>
            <hr>
            <a href="#">Пользовательское соглашение</a>
            <a href="#">Политика конфиденциальности</a>
            <a href="#">Правила оплаты и политика безопасности</a>
            <a href="#">Политика использования cookie</a>
            <a href="#">Правообладателям</a>
            <a href="#">Правила платформы</a>
        </div>
    </div>
    <div class="trademark">
        © ООО ПКП “Север” - все права защищены
    </div>
</footer>
</body>
</html>