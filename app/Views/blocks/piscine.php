<section class="block-piscine container reveal">
    <div class="piscine-inner">
        <div class="piscine-text">
            <?php if (!empty($data['title'])): ?>
            <h2 class="block-title"><?= htmlspecialchars($data['title']) ?></h2>
            <?php endif; ?>
            <?php if (!empty($data['text'])): ?>
            <div class="prose-content">
                <?= nl2br(htmlspecialchars($data['text'])) ?>
            </div>
            <?php endif; ?>
        </div>
        <div class="piscine-visual" aria-hidden="true">
            <span class="piscine-icon">🏊</span>
        </div>
    </div>
</section>
