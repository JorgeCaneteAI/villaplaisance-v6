<?php
$offer  = $data['offer'] ?? 'both';
$max    = (int)($data['max'] ?? 6);
$where  = $offer === 'both' ? '' : "AND offer = '{$offer}'";
$avis   = Database::fetchAll(
    "SELECT * FROM vp_reviews WHERE status = 'published' AND featured = 1 {$where} ORDER BY RAND() LIMIT {$max}"
);
?>
<?php if (!empty($avis)): ?>
<section class="block-avis container reveal">
    <h2 class="block-title sr-only">Avis clients</h2>
    <div class="avis-grid">
        <?php foreach ($avis as $av): ?>
        <blockquote class="avis-card">
            <p class="avis-text"><?= nl2br(htmlspecialchars($av['comment'] ?? '')) ?></p>
            <footer class="avis-footer">
                <cite class="avis-author"><?= htmlspecialchars($av['author'] ?? '') ?></cite>
                <?php if (!empty($av['rating'])): ?>
                <span class="avis-stars" aria-label="<?= (int)$av['rating'] ?> étoiles sur 5">
                    <?= str_repeat('★', min(5, (int)$av['rating'])) ?>
                </span>
                <?php endif; ?>
                <?php if (!empty($av['platform'])): ?>
                <span class="avis-platform"><?= htmlspecialchars($av['platform']) ?></span>
                <?php endif; ?>
            </footer>
        </blockquote>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>
