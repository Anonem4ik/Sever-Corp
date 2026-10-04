<?php
    require_once __DIR__."\\..\\..\\..\\includes\\connect.php";
    // Getting table data
    $sql = "SELECT * FROM special_offers";
    $result = $pdo->query($sql)->fetchAll();
?>

<!-- Section with metadata -->
<div flex-display="centered-list" class="metadata-list">
    <div class="entry default-container">
        <div class="entry__header">Всего предложений</div>
        <div class="entry__value"><?= count($result) ?></div>
    </div>
    <div class="entry default-container">
        <div class="entry__header">Максимальный кешбек</div>
        <div class="entry__value"><?= max(...array_map(null, ...$result)[4]) ?>%</div>
    </div>
</div>

<!-- Section with special offers -->
<div grid-display="3col-widget-grid">
    <!-- Special offers wigets -->
    <?php foreach ($result as $row) { ?>
    <form class="default-container wiget gold-wiget" id="wiget<?= $row['offer_id'] ?>" method="post" action="actions/update_data.php">
        <span class="wiget__text"><?= $row['partner'] ?> - <?= $row['offer_value'] ?>%</span>
        <!-- Update button -->
        <button type="button" class="clear-button" onclick="convert_to_form(<?= $row['offer_id'] ?>)">
            <img class="wiget__icon" src="../../images/general/pencil_icon.svg" alt="Изменить">
        </button>
        <!-- Delete button -->
        <button type="button" class="clear-button" onclick="confirm_deletion(<?= $row['offer_id'] ?>)">
            <img class="wiget__icon" src="../../images/general/trash_can_icon.svg" alt="Удалить">
        </button>
    </form>
    <?php } ?>
    <!-- Wiget for adding special offers -->
    <form class="default-container wiget add-wiget" id="wiget0" method="post" action="actions/add_data.php">
        <button type="button" class="clear-button" onclick="convert_to_form(0)">
            <img class="wiget__icon" src="../../images/general/cross_icon.svg" alt="Добавить">
        </button>
        <span class="wiget__text">Добавить</span>
    </form>
</div>

<script src="functions.js"></script>
<script>
    table_name = 'special_offers';
    fields_data = [
        {name: 'partner', type: 'text', required: true },
        {name: 'offer_value', type: 'number', required: true }
    ];
</script>
