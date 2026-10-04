<!-- Slider with sales banners -->
<?php if ($banners_num > 0): ?>
<section class="wide" id="slider">
    <div class="slider">
        <div class="slider__body" id="slider_moving">
            <?php for ($i = 0; $i < $banners_num; $i++): ?>
            <img src="images/sales_banners/sale_<?= $i ?>.webp" alt="slider-image<?= $i ?>">
            <?php endfor; ?>
        </div>
        <div class="control">
            <?php for ($i = 0; $i < $banners_num; $i++): ?>
            <input type="radio" name="slider_control" value="<?= $i ?>" id="sc<?= $i ?>" <?= $i == 0 ? "checked" : '' ?>>
            <?php endfor; ?>
        </div>
    </div>
</section>
<script src="scripts/slider-control.js"></script>
<?php endif; ?>

<!-- List of company advantages -->
<section id="corp">
    <div class="corp__content default-container">
        <h2>Нас выбирают, потому что мы гарантируем...</h2>
        <div class="corp__enumeration list">
            <div class="corp__entry custom-li with-image">
                <img src="images/general/desc1_icon.svg" alt="desc_icon">
                <h3>Высокое<br>качество</h3>
            </div>
            <div class="corp__entry custom-li with-image">
                <img src="images/general/desc2_icon.svg" alt="desc_icon">
                <h3>Низкие<br>цены</h3>
            </div>
            <div class="corp__entry custom-li with-image">
                <img src="images/general/desc3_icon.svg" alt="desc_icon">
                <h3>Большой<br>ассортимент</h3>
            </div>
        </div>
    </div>
</section>

<!-- Сетка товаров -->

<section class="wide" id="categories_products">
    <div class="marketing_grid">

        <!-- Список категорий -->
        <div class="category_list default-container">
            <h2>Категории</h2>
            <?php foreach ($categories as [$id, $name]): ?>
            <a href="search.php?type=category&id=<?=clean($id)?>"><?=clean($name)?></a>
            <?php endforeach; ?>
        </div>
        <!-- Grid of product cards -->
        <?php
            include __DIR__."\\product_card.html.php";
            foreach ($goods as [$id, $name, $price, $is_in_basket, $is_in_favorite]) {
                create_card($id, $name, $price, $is_in_basket, $is_in_favorite);
            }
        ?>
        <!-- TOFIX
        Pre-last 5 - class "one-minus-hide"
        Last 5 - class "two-minus-hide";
        -->
        <!-- Script for actions with items -->
        <script src="scripts/basket_actions.js"></script>
        <!-- Blank card for space consistency -->
        <div class="see-more default-container">
            <img src="./images/general/cross_icon.svg" alt="Плюс">
            <a href="#">Больше товаров...</a>
        </div>
    </div>
</section>

<!-- Collaboration form -->
<?php if (isset($_SESSION['user_data']) and !$is_offer_send): ?>
<section id="collab_form">
    <form class="generic-form" method="post">
        <h2>Давайте наладим сотрудничество!</h2>
        <div class="fields-box">
            <div class="entry">
                <label for="i_name">Полное имя</label>
                <input type="text" name="full_name" id="i_name">
            </div>
            <div class="entry">
                <label for="i_corp">Наименование компании</label>
                <input type="text" name="corp_name" id="i_corp">
            </div>
            <div class="entry">
                <label for="i_phone">Конткатный телефон</label>
                <input type="tel" name="phone" id="i_phone">
            </div>
        </div>
        <div class="check-entry">
            <input type="checkbox" name="agreement" id="i_check">
            <label>Я согласен на <a class="blue-link" href="#">обработку персональных данных</a></label>
        </div>
        <button class="gold-box" type="submit" name="collab_offer_submit">Отправить</button>
    </form>
</section>
<?php endif ?>