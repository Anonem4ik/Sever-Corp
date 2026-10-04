<?php function create_card($id, $prod_name, $price, $is_in_basket, $is_in_favorite = false) { ?>

<div class="product-card">
    <img src="images/items_images/<?= $id ?>_1.webp" alt="product_img">
    <h3 class="f-20"><a href="./item_page.php?id=<?= $id ?>"><?= clean($prod_name) ?></a></h3>
    <p class="cost f-16"><?= clean($price) ?> ₽</p>
    <div flex-display="centered-list" class="actions_row">
        <!-- To basket button -->
        <?php if (!isset($_SESSION['user_data'])) { // If user unregistered ?>
            <button class="to-cart f-16 purple-box" onclick="window.location = 'login.php'">
                В корзину
            </button>
        <?php } else if (!$is_in_basket) { // If this good not in user's basket?>
            <button class="to-cart f-16 purple-box" onclick="change_basket(event, 'add', <?= $id ?>)">
                В корзину
            </button>
        <?php } else { // Placeholder when good already in basket ?>
            <span class="in-basket f-16">В корзине</span>
        <?php } ?>
        <!-- Favorite button -->
        <?php if (!isset($_SESSION['user_data'])) { // If user unregistered ?>
            <button class="to-favorite clear-button" onclick="window.location = 'login.php'">
                <img src="/images/general/hollow_star.svg" alt="В избранное">
            </button>
        <?php } else if (!$is_in_favorite) { // Add to favorite button ?>
            <button class="to-favorite clear-button" onclick="change_favorite(event, 'add', <?= $id ?>)">
                <img src="/images/general/hollow_star.svg" alt="В избранное">
            </button>
        <?php } else { // Delete from favorite button ?>
            <button class="in-favorite clear-button" onclick="change_favorite(event, 'delete', <?= $id ?>)">
                <img src="/images/general/full_star.svg" alt="В избранное">
            </button>
        <?php } ?>
    </div>
</div>

<?php } ?>