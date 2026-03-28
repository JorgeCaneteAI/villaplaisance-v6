<section class="block-hero">
    <div class="hero-inner container">
        <?php if (!empty($data['title'])): ?>
        <h1 class="hero-title reveal"><?= htmlspecialchars($data['title']) ?></h1>
        <?php endif; ?>
        <?php if (!empty($data['subtitle'])): ?>
        <p class="hero-subtitle reveal"><?= htmlspecialchars($data['subtitle']) ?></p>
        <?php endif; ?>
        <?php if (!empty($data['intro'])): ?>
        <p class="hero-intro reveal speakable"><?= nl2br(htmlspecialchars($data['intro'])) ?></p>
        <?php endif; ?>
        <?php if (!empty($data['cta_label']) && !empty($data['cta_url'])): ?>
        <a href="<?= htmlspecialchars($data['cta_url']) ?>" class="btn btn-primary reveal">
            <?= htmlspecialchars($data['cta_label']) ?>
        </a>
        <?php endif; ?>
    </div>
</section>
