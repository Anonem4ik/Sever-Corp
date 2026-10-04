<section id="account_data">
    <div class="acc-data__container default-container">
        <div class="acc-data__wrapper with-image f-16">
            <img class="acc-data__avatar" src="images/users_avatars/default.png" alt="Аватар">
            <div class="acc-data__info">
                <div class="acc-data__nickname f-30"><?= clean($user['login']) ?></div>
                <form method="post">
                    <button class="acc-data__logout clear-button f-16" name="logout_submit">Выйти</button>
                </form>
                <div class="acc-data__orders-count">Заказов: <?= $user['orders_count'] ?></div>
            </div>
        </div>
    </div>
</section>

<section id="orders_list">
    <div flex-display="centered-column" class="orders__container">
        <?php foreach ($orders as [$order_id, $status, $date, $total_price]): ?>
        <div class="orders__entry default-container">
            <div class="date f-30">Заказ от <?= $date ?></div>
            <div class="state f-24">
                Статус:
                <?php if ($status == 'done'): ?>
                <span class="state-done">доставлено</span>
                <?php else: ?>
                <span class="state-in-progress">в пути</span>
                <?php endif; ?>
            </div>
            <div class="inside f-24">
                Состав:
                <?php foreach (getOrderItems($db, $order_id) as $row): ?>
                <span class="inside-entry">
                    <a href="item_page.php?id=<?= $row['good_id'] ?>"><?= clean($row['name']) ?></a>
                    (<?= clean($row['price']) ?> ₽) x <?= $row['count'] ?></span>
                <?php endforeach; ?>
            </div>
            <div class="total f-30">Итого: <?= $total_price ?> ₽</div>
        </div>
        <?php endforeach; ?>
    </div>
</section>