<?php 
    require_once __DIR__."\\..\\..\\..\\includes\\connect.php";
    // Unpacking values
    $status = $_GET['status'] ?? 'ordered';
    $date_from = $_GET['date_from'] ?? date("Y-m-d", getdate()[0] - 4*7*24*60*60);
    $date_to = $_GET['date_to'] ?? date("Y-m-d");
    // Paging
    $page_num = intval($_GET['page_number'] ?? '1') - 1;
    $offset = $page_num * 4;
    // Main querry
    $sql = <<<EOF
    SELECT SQL_CALC_FOUND_ROWS o.order_id, u.login AS `username`, o.status, o.date,
    SUM(oi.count * IF(oi.count < 15, g.price, g.wholesale_price)) as `total_price`
    FROM `orders` AS o
    INNER JOIN users AS u ON o.FK_user = u.user_id
    INNER JOIN order_items AS oi ON o.order_id = oi.FK_order
    INNER JOIN goods AS g ON oi.FK_good = g.good_id
    WHERE o.status = :status AND o.date >= :date_from AND o.date <= :date_to
    GROUP BY o.order_id
    ORDER BY o.date
    LIMIT $offset, 4
    EOF;
    $statement = $pdo->prepare($sql);
    $statement->bindValue(":status", $status);
    $statement->bindValue(":date_from", $date_from);
    $statement->bindValue(":date_to", $date_to);
    $statement->execute();
    $result = $statement->fetchAll();
    $pages_count = ceil($pdo->query("SELECT FOUND_ROWS( );")->fetch()[0] / 4);
    // Function to get order items
    function getOrderItems(PDO $pdo, string $order_id) {
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
        return $pdo->query($sql)->fetchAll();
    }
?>

<!-- List of filters -->
<form flex-display='centered-list' class="state-line default-container" method="get" action="">
    <input type="hidden" name="page" value="orders">
    <select name="status" id="i_category">
        <option value="ordered" <?= $status == 'ordered' ? 'selected' : '' ?>>Ожидающих</option>
        <option value="done" <?= $status == 'done' ? 'selected' : '' ?>>Выданных</option>
    </select>
    <label for="i_date_from">заказов от</label>
    <input type="date" name="date_from" id="i_date_from" value="<?= clean($date_from) ?>">
    <label for="i_date_to">до</label>
    <input type="date" name="date_to" id="i_date_to" value="<?= clean($date_to) ?>">
    <input type="submit" value="Найти">
    <a class="reset-button" href="?page=orders">Сбросить</a>
</form>

<!-- List of orders -->
<div flex-display="centered-column">
    <?php foreach ($result as $row) { ?>
    <div class="order-wiget default-container">
        <!-- Username and date -->
        <div class="order-wiget__main_info f-30">
            Заказ пользователя <u><?= clean($row['username']) ?></u> от <?= clean($row['date']) ?>
        </div>
        <!-- State -->
        <div class="order-wiget__state f-24">
            Статус:
            <?php if ($row['status'] == 'done') { ?>
            <span class="state-done">доставлено</span>
            <?php } else { ?>
            <span class="state-in-progress">в пути</span>
            <a class="check_button green-button f-20" href="actions/check_order.php?order_id=<?= $row['order_id'] ?>">
                Отметить как доставленный
            </a>
            <?php } ?>
        </div>
        <!-- Content of order -->
        <div class="order-wiget__content f-24">
            Состав:
            <?php foreach (getOrderItems($pdo, $row['order_id']) as $oi_row) { ?>
            <span class="content-entry">
                <a href="/item_page.php?id=<?= $oi_row['good_id'] ?>"><?= clean($oi_row['name']) ?></a> 
                (<?= clean($oi_row['price']) ?> ₽) x <?= clean($oi_row['count']) ?></span>
            <?php } ?>
        </div>
        <!-- Total price -->
        <div class="total f-30">Итого: <?= $row['total_price'] ?> ₽</div>
    </div>
    <?php } ?>
</div>

<!-- Pages control -->
<?php if ($pages_count > 1) { ?>
<div flex-display="centered-list" class="pages-control">
    <!-- Previous page -->
    <button type="button" class="pages-control__arrow clear-button"
    onclick="update_get_query('page_number', <?= max(1, $page_num) ?>)">
        <img src="../images/general/arrow_left.svg" alt="Назад">
    </button>
    <!-- List of pages -->
    <?php for ($i=1; $i < $pages_count + 1; $i++) { ?>
    <button type="button" class="pages-control__page clear-button"
    onclick="update_get_query('page_number', <?= $i ?>)">
        <?php echo $i == $page_num + 1 ? "<b>$i</b>" : $i ?>
    </button>
    <?php } ?>
    <!-- Next page -->
    <button type="button" class="pages-control__arrow clear-button"
    onclick="update_get_query('page_number', <?= min($pages_count, $page_num + 2) ?>)">
        <img src="../images/general/arrow_right.svg" alt="Назад">
    </button>
</div>
<?php } ?>

<!-- Script for update query function -->
<script src="functions.js"></script>