<?php
    require_once __DIR__."\\..\\..\\..\\includes\\connect.php";
    // Getting table data
    $sql = <<<EOF
    SELECT s.shipper_id, s.name, s.site, COUNT(g.good_id) as `usage_count`
    FROM shippers as s
    LEFT JOIN goods as g ON g.FK_shipper = s.shipper_id
    GROUP BY s.shipper_id
    EOF;
    $result = $pdo->query($sql)->fetchAll();
?>

<!-- Sectons with total shippers count -->
<div class="state-line default-container f-20">
    Всего поставщиков: <?= count($result) ?>
</div>

<!-- Section with shippers -->
<div flex-display="centered-column">
    <!-- Shippers wigets -->
    <?php foreach ($result as $row) { ?>
    <form class="default-container wiget" id="wiget<?= $row['shipper_id'] ?>" method="post" action="actions/update_data.php">
        <span class="wiget__usage">(<?= $row['usage_count'] ?>)</span>    
        <span class="wiget__text">
            <?= clean($row['name']) ?>
            <?php if (!is_null($row['site'])) echo '(<a href='.clean($row['site']).'>'.clean($row['site']).'</a>)'; ?>
        </span>
        <!-- Update button -->
        <button type="button" class="clear-button" onclick="convert_to_form(<?= $row['shipper_id'] ?>)">
            <img class="wiget__icon" src="../../images/general/pencil_icon.svg" alt="Изменить">
        </button>
        <!-- Delete button -->
        <button type="button" class="clear-button" onclick="confirm_deletion(<?= $row['shipper_id'] ?>)">
            <img class="wiget__icon" src="../../images/general/trash_can_icon.svg" alt="Удалить">
        </button>
    </form>
    <?php } ?>
    <!-- Wiget for adding shippers -->
    <form class="default-container wiget add-wiget" id="wiget0" method="post" action="actions/add_data.php">
        <button type="button" class="clear-button" onclick="convert_to_form(0)">
            <img class="wiget__icon" src="../../images/general/cross_icon.svg" alt="Добавить">
        </button>
        <span class="wiget__text">Добавить</span>
    </form>
</div>

<script src="functions.js"></script>
<script>
    table_name = 'shippers';
    fields_data = [
        {name: 'name', type: 'text', required: true },
        {name: 'site', type: 'text', required: false }
    ];
</script>