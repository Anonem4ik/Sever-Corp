<?php
    require_once __DIR__."\\..\\..\\..\\includes\\connect.php";
    // Unpacking values
    $category = $_GET['category'] ?? null;
    $prompt = $_GET['prompt'] ?? "";
    $price_from = $_GET['price_from'] ?? null;
    $price_to = $_GET['price_to'] ?? null;
    $page_num = intval($_GET['page_number'] ?? '1') - 1;
    // Forming querry
    $sql = <<<EOF
    SELECT SQL_CALC_FOUND_ROWS g.good_id, g.article_num, g.name, c.name as `category`,
    g.price, g.wholesale_price, g.country, s.name as `shipper`,
    so.partner, so.offer_value, g.supply_left
    FROM goods as g
    LEFT JOIN categories as c ON g.FK_category = c.category_id
    LEFT JOIN shippers as s ON g.FK_shipper = s.shipper_id
    LEFT JOIN special_offers as so ON g.FK_special_offer = so.offer_id
    WHERE LOCATE(LOWER(:prompt), LOWER(g.name)) != 0
    EOF;
    // Appending search options
    if (!is_null($category) && $category != '') $sql .= " AND g.FK_category = :category";
    if (!is_null($price_from) && $price_from != '') $sql .= " AND g.price >= :price_from";
    if (!is_null($price_to) && $price_to != '') $sql .= " AND g.price <= :price_to";
    // Setting limit and finding result rows
    $offset = $page_num * 4;
    $sql .= " LIMIT $offset, 4;";
    // Getting goods data and resulted row
    $statement = $pdo->prepare($sql);
    $statement->bindValue(":prompt", $prompt);
    if (!is_null($category) && $category != '') $statement->bindValue(":category", $category);
    if (!is_null($price_from) && $price_from != '') $statement->bindValue(":price_from", $price_from);
    if (!is_null($price_to) && $price_to != '') $statement->bindValue(":price_to", $price_to);
    $statement->execute();
    $result = $statement->fetchAll();
    $pages_count = ceil($pdo->query("SELECT FOUND_ROWS( );")->fetch()[0] / 4);
    // Categories
    $sql = "SELECT * FROM categories";
    $categories = $pdo->query($sql);
?>

<!-- Line with search options -->
<form flex-display='centered-list' class="state-line default-container" method="get">
    <input type="hidden" name="page" value="goods">
    <label for="i_category">Категория:</label>
    <select name="category" id="i_category">
        <option value="">Любая</option>
        <?php foreach ($categories as $c_data) { ?>
        <option value="<?= $c_data['category_id'] ?>"
        <?= $c_data['category_id'] == $category ? 'selected="selected"' : '' ?>>
            <?= clean($c_data['name']) ?>
        </option>
        <?php } ?>
    </select>
    <label for="i_prompt">Название:</label>
    <input type="text" name="prompt" id="i_prompt" value="<?= clean($prompt) ?>" placeholder="Фрагмент названия...">
    <label for="i_price_from">Цена от</label>
    <input type="number" name="price_from" id="i_price_from"
    value="<?= !is_null($price_from) ? clean($price_from) : '0' ?>">
    <label for="i_price_to">до</label>
    <input type="number" name="price_to" id="i_price_to"
    value="<?= !is_null($price_to) ? clean($price_to) : '10000' ?>">
    <input type="submit" value="Найти">
    <a class="reset-button" href="?page=goods">Сбросить</a>
</form>

<!-- Button to add goods -->
<div class="wrapper">
    <a class="add-good-button green-button with-image" href="?page=good_info&action=add">
        <img src="../images/general/cross_icon.svg" alt="+">
        Добавить товар
    </a>
</div>

<!-- List of goods -->
<div flex-display="centered-column">
    <?php foreach ($result as $row) { ?>
    <div class="good-wiget default-container with-image">
        <img src="../images/items_images/<?= $row['good_id'] ?>_1.webp" alt="<?= clean($row['name']) ?>">
        <div flex-display="centered-column">
            <!-- Name and special offer -->
            <div flex-display="centered-list" class="good-wiget__name-container">
                <div class="f-24"><?= clean($row['name']) ?></div>
                <?php if (!is_null($row['partner'])) { ?>
                <div class="good-wiget__sp-offer gold-box">
                    <?= clean($row['partner']) ?> - <?= clean($row['offer_value']) ?>%
                </div>
                <?php } ?>
            </div>
            <!-- Main info -->
            <div flex-display="centered-list" class="good-wiget__data-set">
                <div class="entry">
                    <div class="name">Категория:</div>
                    <div class="value"><?= clean($row['category']) ?></div>
                </div>
                <div class="entry">
                    <div class="name">Поставщик:</div>
                    <div class="value"><?= clean($row['shipper']) ?></div>
                </div>
                <div class="entry">
                    <div class="name">Страна:</div>
                    <div class="value"><?= clean($row['country']) ?></div>
                </div>
                <div class="entry">
                    <div class="name">Артикул:</div>
                    <div class="value"><?= clean($row['article_num']) ?></div>
                </div>
                <div class="entry">
                    <div class="name">Цена:</div>
                    <div class="value"><b><?= clean($row['price']) ?> ₽</b> (<?= clean($row['wholesale_price']) ?> ₽)</div>
                </div>
                <div class="entry">
                    <div class="name">Остаток на складе:</div>
                    <div class="value"><b><?= clean($row['supply_left']) ?></b> шт.</div>
                </div>
            </div>
            <!-- Interaction buttons -->
            <div flex-display="centered-list" class="good-wiget__actions">
                <a class="blue-button" href="?page=good_info&action=update&id=<?= $row['good_id'] ?>">Изменить</a>
                <a class="red-button" onclick="confirm_deletion(<?= $row['good_id'] ?>)">Удалить</a>
            </div>
        </div>
    </div>
    <?php } ?>
</div>

<!-- Pages control -->
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

<!-- Script for update$sql function -->
<script src="functions.js"></script>
<script>
    table_name = 'goods'
</script>