<section id="basket">
    <h1 class="page-header">Поиск</h1>
    <div class="marketing_grid">
        <!-- Filters select -->
        <form class="category_list default-container">
            <div class="params_set">
                <h2>Название:</h2>
                <input class="main-prompt" type="text" name="prompt" value="<?= $prompt ?>">
            </div>
            <div class="params_set">
                <h2>Ценовой диапазон</h2>
                <div class="search__entry">
                    <span class="boundary-side">От</span>
                    <input type="number" name="price_from" value="<?= $price_from ?>">
                </div>
                <div class="search__entry">
                    <span class="boundary-side">До</span>
                    <input type="number" name="price_to" value="<?= $price_to ?>">
                </div>
                <div class="search__entry">
                    <input type="checkbox" name="find_by_wholesale">
                    <span class="include-wholesale">Включая оптовую цену</span>
                </div>
            </div>
            <div class="params_set">
                <h2>Категория</h2>
                <?php foreach ($categories as [$id, $name]) {?>
                <div class="search__entry">
                    <input type="radio" name="category_id" value="<?= $id ?>"
                    <?php if ($id == $category_id) echo "checked"; ?>>
                    <span class="categor-name"><?= $name ?></span>
                </div>
                <?php } ?>
            </div>
            <input class="form-button purple-box" type="submit" value="Подтвердить">
            <a class="reset form-button purple-box" href="search.php">Сбросить</a>
        </form>
        <!-- Found goods -->
        <?php if ($goods): ?>
            <?php
                include __DIR__."\\product_card.html.php";
                foreach ($goods as [$id, $name, $price, $is_in_basket, $is_in_favorite]) {
                    create_card($id, $name, $price, $is_in_basket, $is_in_favorite);
                }
            ?>
        <?php else: ?>
            <div class="nothing-found default-container f-20">
                Не нашлось товаров по заданым фильтрам.
            </div>
        <?php endif; ?>
    </div>
</section>

<script src="scripts/basket_actions.js"></script>