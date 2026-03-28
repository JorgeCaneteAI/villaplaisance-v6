<section class="block-cta reveal">
    <div class="cta-inner container">
        <?php if (!empty($data['title'])): ?>
        <h2 class="cta-title"><?= htmlspecialchars($data['title']) ?></h2>
        <?php endif; ?>
        <?php if (!empty($data['text'])): ?>
        <p class="cta-text"><?= nl2br(htmlspecialchars($data['text'])) ?></p>
        <?php endif; ?>
        <div class="cta-btns">
            <?php if (!empty($data['btn1_label']) && !empty($data['btn1_url'])): ?>
            <a href="<?= htmlspecialchars($data['btn1_url']) ?>" class="btn btn-primary">
                <?= htmlspecialchars($data['btn1_label']) ?>
            </a>
            <?php endif; ?>
            <?php if (!empty($data['btn2_label']) && !empty($data['btn2_url'])): ?>
            <a href="<?= htmlspecialchars($data['btn2_url']) ?>" class="btn btn-outline">
                <?= htmlspecialchars($data['btn2_label']) ?>
            </a>
            <?php endif; ?>
        </div>
    </div>
</section>
