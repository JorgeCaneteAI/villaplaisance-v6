<section class="block-petit-dejeuner container reveal">
    <div class="pdj-inner">
        <div class="pdj-text">
            <?php if (!empty($data['title'])): ?>
            <h2 class="block-title"><?= htmlspecialchars($data['title']) ?></h2>
            <?php endif; ?>
            <?php if (!empty($data['text'])): ?>
            <div class="prose-content">
                <?= nl2br(htmlspecialchars($data['text'])) ?>
            </div>
            <?php endif; ?>
        </div>
        <div class="pdj-visual" aria-hidden="true">
            <span class="pdj-icon">☕</span>
        </div>
    </div>
</section>
