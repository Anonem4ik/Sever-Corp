<!-- Bread crumbs -->
<section id="bread_crumbs" class="less-interval">
    <div class="bread-crumbs__container default-container list">
        <a href="/">Главная</a>
        <a href="search.php?category_id=<?= $good['category_id'] ?>">
            <?= clean($good['category_name']) ?>
        </a>
        <span><?= clean($good['name']) ?></span>
    </div>
</section>

<section id="main_info">
    <div class="main__container">
        <!-- Side with images -->
        <div class="images__container">
            <!-- Image scroll -->
            <div class="scroll__container" id="scroll_container">
                <div class="scroll__area" id="scroll_area">
                    <?php for ($i=1; $i <= $good['images_count']; $i++) { ?>
                    <img class="side-images"
                    src="./images/items_images/<?= $good_id ?>_<?= $i ?>.webp"
                    alt="item_image">
                    <?php } ?>
                </div>
                <?php if ($good['images_count'] > 2) {?>
                <button class="scroll__btn up" id="scroll_up">
                    <img src="images/general/scroll_up_icon.svg" alt="up">
                </button>
                <button class="scroll__btn down" id="scroll_down">
                    <img src="images/general/scroll_down_icon.svg" alt="down">
                </button>
                <?php } ?>
            </div>
            <!-- Main image -->
            <img src="./images/items_images/<?= $good_id ?>_1.webp" alt="item_image" id="selected_img">
            <!-- Special offer (if present) -->
            <?php if (!is_null($good['offer_value'])) { ?>
            <div class="images__sale-banner gold-box">
                Кэшбэк <?= clean($good['offer_value']) ?>% от <?= clean($good['partner']) ?>
            </div>
            <?php } ?>
        </div>
        <!-- Right side with main information and descriptions -->
        <div class="desc__container default-container">
            <h1 class="desc__product-name"><?= clean($good['name']) ?></h1>
            <!-- Rating -->
            <div class="desc__rating">
                <?php
                    for ($i=0; $i < 5; $i++) {
                        $type = 'full';
                        $margin = $good['rating'] - $i;
                        if ($margin <= 0) $type = 'hollow';
                        elseif (0.5 <= $margin and $margin < 1) $type = 'half';
                ?>
                <img src="./images/general/<?= $type ?>_star.svg" alt="rating_star">
                <?php } ?>
                <span class="desc__rewiews-count"><?= $good['rewiews_num'] ?> отзывов</span>
            </div>
            <!-- Price -->
            <div class="desc__price">
                <?= clean($good['price']) ?> ₽ | 
                <span class="desc__wholesale-price"><?= clean($good['wholesale_price']) ?> ₽ оптом</span>
            </div>
            <!-- Description -->
            <div class="desc__text-description"><?= clean($good['description']) ?></div>
            <!-- Shipper, country and article -->
            <div class="main-stats__container">
                <div class="entry">
                    <span class="record-name">Производитель</span>
                    <hr>
                    <h3><?= clean($good['shipper_name']) ?></h3>
                </div>
                <div class="entry">
                    <span class="record-name">Страна</span>
                    <hr>
                    <h3><?= clean($good['country']) ?></h3>
                </div>
                <div class="entry">
                    <span class="record-name">Артикул</span>
                    <hr>
                    <h3><?= clean($good['article_num']) ?></h3>
                </div>
            </div>
            <!-- Buttons (or out of stock) -->
            <?php if (!isset($user_info)) {?>
            <div flex-display="centered-list" class="buttons__container">
                <div class="default-box">Зарегестрируйтесь, чтобы купить!</div>
            </div>
            <?php } else if ($good['supply_left'] > 0) {?>
            <div flex-display="centered-list" class="buttons__container">
                <!-- Basket adding button -->
                <?php if (!$user_info['is_in_basket']): ?>
                <a class="buttons__btn purple-box" onclick="change_basket(event, 'add', <?= $good_id ?>)">
                    В корзину
                </a>
                <?php else: ?>
                <span class="in-basket f-16">В корзине</span>
                <?php endif; ?>
                <!-- To favorite button -->
                <?php if (!$user_info['is_in_favorite']): ?>
                <a class="buttons__btn gold-box" onclick="change_favorite(event, 'add', <?= $good_id ?>, true)">
                    В избранное
                </a>
                <?php else: ?>
                <span class="in-basket f-16">В избранном</span>
                <?php endif; ?>
            </div>
            <?php } else { ?>
                <p class="desc__out-of-stock">Нет в наличии</p>
            <?php } ?>
        </div>
    </div>
</section>

<!-- Section with additional info of good -->
<?php if ($add_info_len > 0) { ?>
<section id="additional_info">
    <div flex-display="sided" class="add-info__container default-container">
        <div class="add-info__side">
            <?php for ($i=0; $i < ceil($add_info_len / 2); $i++) { ?>
            <p class="add-info">
                <span class="info-name"><?= clean($add_info_list[$i]['name']) ?>:</span>
                <?= clean($add_info_list[$i]['value']) ?>
            </p>
            <?php } ?>
        </div>
        <hr>
        <div class="add-info__side">
            <?php for ($i=ceil($add_info_len / 2); $i < $add_info_len; $i++) { ?>
            <p class="add-info">
                <span class="info-name"><?= clean($add_info_list[$i]['name']) ?>:</span>
                <?= clean($add_info_list[$i]['value']) ?>
            </p>
            <?php } ?>
        </div>
    </div>
</section>
<?php } ?>

<!-- Section with review -->
<section id="reviews">
    <div flex-display="centered-column" class="rewiews__container">
        <!-- review form (only for registered users and users, who did't wrote it before) -->
        <?php if (isset($_SESSION['user_data']) && !$is_present) { ?>
        <form class="review-form__container" method="post">
            <h3 class="review-form__header">Понравился ли вам этот товар? Оставьте отзыв!</h3>
            <input type="hidden" name="good_id" value="<?= $good_id ?>">
            <input type="hidden" name="rating" value="5" id="i_rating">
            <div class="review-form__rating">
                <img id="r1" class="rating-star" src="./images/general/full_star.svg" alt="rating_star">
                <img id="r2" class="rating-star" src="./images/general/full_star.svg" alt="rating_star">
                <img id="r3" class="rating-star" src="./images/general/full_star.svg" alt="rating_star">
                <img id="r4" class="rating-star" src="./images/general/full_star.svg" alt="rating_star">
                <img id="r5" class="rating-star" src="./images/general/full_star.svg" alt="rating_star">
            </div>
            <textarea class="review-form__text" name="review_text" id="review_text"></textarea><br>
            <button class="review-form__submit purple-box" type="submit" name="submit_review">
                Отправить
            </button>
        </form>
        <?php } ?>
        <!-- Rewiews of other users -->
        <?php 
            foreach ($reviews_list as [$user_name, $rating, $text, $date]) {
            if ($text === '') continue;
        ?>
        <div class="review__background">
            <div class="rewiew__container">
                <!-- Information about user -->
                <div flex-display="sided" class="rewiew__info-row">
                    <div class="user__container with-image">
                        <img src="images/users_avatars/default.png" alt="user avatar">
                        <div class="user-info__container">
                            <div class="username"><?= clean($user_name) ?></div>
                            <div class="u_rewiew-rating">
                                <?php for ($i=0; $i < 5; $i++) { ?>
                                <img 
                                src="./images/general/<?= $i < $rating ? 'full' : 'hollow'?>_star.svg"
                                alt="rating_star">
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="rewiew__date"><?= dateToRussianStr($date) ?></div>
                </div>
                <!-- Rewiew text -->
                <div class="rewiew__text f-18"><?= clean($text) ?></div>
            </div>
        </div>
        <?php } ?>
    </div>
</section>

<!-- Section with other products -->
<?php if (isset($user_info)): ?>
<section id="similar_products">
    <div class="sp__container">
        <h3>Похожие товары</h3>
        <div class="sp__content">
            <?php
                include __DIR__."\\product_card.html.php";
                foreach ($more_goods as [$id, $name, $price, $is_in_basket, $is_in_favorite]) {
                    create_card($id, $name, $price, $is_in_basket, $is_in_favorite);
                }
            ?>
        </div>
    </div>
</section>
<?php endif; ?>

<script src="scripts/items_actions.js"></script>
<script src="scripts/basket_actions.js"></script>