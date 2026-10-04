<!-- Section with company metrics -->
<section id="main_points">
    <div class="points__container list">
        <?php foreach ($data['metrics'] as $metric): ?>
        <div class="point__box gold-box">
            <h3 class="value"><?= clean($metric['value']) ?></h3>
            <h3 class="metric"><?= clean($metric['name']) ?></h3>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- General company description -->
<section id="company_description">
    <pre class="description__container default-container"><?= clean($data['company_description']) ?></pre>
</section>

<!-- Snippets with company history -->
<section class="company_history">
    <div class="history__container">
        <?php foreach ($data['snippets'] as $i => $snippet_text): ?>
        <div class="history__snippet">
            <?php if ($i % 2 === 0): // Even numbered snippet - image first ?>
            <img src="images/history_images/snippet_image_<?= $i ?>.webp" alt="history image">
            <?php endif; ?>
            <p class="default-container">
                <?= clean($snippet_text) ?>
            </p>
            <?php if ($i % 2 === 1): // Odd numbered snippet - image last ?>
            <img src="images/history_images/snippet_image_<?= $i ?>.webp" alt="history image">
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
</section>