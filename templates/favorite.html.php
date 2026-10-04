<section id="basket">
    <h1 class="page-header">Избранное</h1>
    <?php if (count($favorite_goods) > 0): ?>
    <div class="marketing_grid">
        <?php
            include __DIR__."\\product_card.html.php";
            foreach ($favorite_goods as [$id, $name, $price, $is_in_basket]) {
                create_card($id, $name, $price, $is_in_basket, true);
            }
        ?>
    </div>
    <?php else: ?>
    <div class="nothing total-price default-container">Здесь пока ничего нет!</div>
    <?php endif; ?>
</section>

<script src="scripts/basket_actions.js"></script>