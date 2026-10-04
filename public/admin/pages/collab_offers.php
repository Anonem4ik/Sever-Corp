<?php
    require_once __DIR__."\\..\\..\\..\\includes\\connect.php";
    // Getting table data
    $sql = "SELECT collab_offer_id, full_name, company_name, phone_number FROM collab_offers";
    $result = $pdo->query($sql);
?>

<div grid-display="3col-widget-grid" class="collabs__container">
    <?php foreach ($result as $row) { ?>
    <div class="default-container wiget vertical">
        <div class="collabs__name f-20"><?= $row['full_name'] ?></div>
        <div class="collabs__company f-24"><?= $row['company_name'] ?></div>
        <div class="collabs__phone f-16"><?= $row['phone_number'] ?></div>
    </div>
    <?php } ?>
</div>