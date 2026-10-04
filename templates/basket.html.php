<section id="basket">
    <h1 class="page-header">Корзина</h1>
    <form class="form__basket" method="post">
        <?php 
            foreach ($basket_goods as $i => [$id, $name, $price, $wholesale]):
        ?>
        <div class="entry__basket default-container">
            <img src="images/items_images/<?= $id ?>_1.webp" alt="<?= clean($name) ?>" class="item__img">
            <h3 class="item__name"><a href="item_page.php?id=<?= $id ?>"><?= clean($name) ?></a></h3>
            <span class="item__price"><?= clean($price) ?> ₽</span>
            <span class="item__wolesale f-20">(<?= clean($wholesale) ?> ₽)</span>
            <input type="hidden" name="items[<?= $i ?>][]" value="<?= $id ?>">
            <input class="item__count" type="number" name="items[<?= $i ?>][]"
            value="1" price="<?= clean($price) ?>" wholesale=<?= clean($wholesale) ?> min="1">
            <button type="button" class="clear-button delete-button" onclick="change_basket(event, 'delete', <?= $id ?>)">
                <img src="images/general/red_cross_icon.svg" alt="Удалить">
            </button>
        </div>
        <?php endforeach; ?>

        <?php if (count($basket_goods) > 0) { ?>
        <div class="total-price default-container">
            Итоговая цена: <span id="total_price"></span> ₽
        </div>
        <input class="by_button purple-box" type="submit" name="by_all_basket_submit" value="Купить">
        <?php } else if (isset($successful_purchase)) { ?>
        <div class="total-price default-container">
            Товыра успешно куплены! Уведомление о поступлении вашего заказа
            будет отправлено на вашу электронную почту.
        </div>
        <?php } else { ?>
        <div class="total-price default-container">Здесь пока ничего нет...</div>
        <?php } ?>
    </form>
</section>

<script src="scripts/total_changing.js"></script>
<script src="scripts/basket_actions.js"></script>