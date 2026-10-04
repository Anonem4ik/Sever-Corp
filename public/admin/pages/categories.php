<?php
    require_once __DIR__."\\..\\..\\..\\includes\\connect.php";
    // Getting table data
    $sql = <<<EOF
    SELECT c.category_id, c.name, COUNT(g.good_id) as `usage_count`
    FROM categories as c
    LEFT JOIN goods as g ON g.FK_category = c.category_id
    GROUP BY c.category_id
    EOF;
    $result = $pdo->query($sql);
?>

<!-- Section with main categories -->
<h2 class="page-header">Основные категории</h2>
<div grid-display="3col-widget-grid">
    <!-- Categories wigets -->
    <?php foreach ($result as $row) { ?>
    <form class="default-container wiget" id="wiget<?= $row['category_id'] ?>" method="post" action="actions/update_data.php">
        <span class="wiget__usage">(<?= $row['usage_count'] ?>)</span>
        <span class="wiget__text"><?= clean($row['name']) ?></span>
        <!-- Update button -->
        <button type="button" class="clear-button" onclick="convert_to_form(<?= $row['category_id'] ?>)">
            <img class="wiget__icon" src="../../images/general/pencil_icon.svg" alt="Изменить">
        </button>
        <!-- Delete button -->
        <button type="button" class="clear-button" onclick="confirm_deletion(<?= $row['category_id'] ?>)">
            <img class="wiget__icon" src="../../images/general/trash_can_icon.svg" alt="Удалить">
        </button>
    </form>
    <?php } ?>
    <!-- Wiget for adding categories -->
    <form class="default-container wiget add-wiget" id="wiget0" method="post" action="actions/add_data.php">
        <button type="button" class="clear-button" onclick="convert_to_form(0)">
            <img class="wiget__icon" src="../../images/general/cross_icon.svg" alt="Добавить">
        </button>
        <span class="wiget__text">Добавить</span>
    </form>
</div>

<script src="functions.js"></script>
<script>
    table_name = 'categories';
    fields_data = [
        {name: 'name', type: 'text', required: true }
    ];
</script>
