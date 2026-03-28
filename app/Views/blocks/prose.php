<section class="block-prose container reveal">
    <?php if (!empty($data['title'])): ?>
    <h2 class="block-title"><?= htmlspecialchars($data['title']) ?></h2>
    <?php endif; ?>
    <?php if (!empty($data['text'])): ?>
    <div class="prose-content speakable">
        <?= nl2br(htmlspecialchars($data['text'])) ?>
    </div>
    <?php endif; ?>
    <?php if (!empty($data['encadre'])): ?>
    <aside class="prose-encadre">
        <?= nl2br(htmlspecialchars($data['encadre'])) ?>
    </aside>
    <?php endif; ?>
</section>
