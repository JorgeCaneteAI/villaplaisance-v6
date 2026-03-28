<?php
$statsRows = Database::fetchAll("SELECT * FROM vp_stats ORDER BY position ASC");
?>
<?php if (!empty($statsRows)): ?>
<section class="block-stats container reveal">
    <div class="stats-grid">
        <?php foreach ($statsRows as $stat): ?>
        <div class="stat-item">
            <?php if (!empty($stat['icon'])): ?>
            <span class="stat-icon"><?= htmlspecialchars($stat['icon']) ?></span>
            <?php endif; ?>
            <strong class="stat-value counter" data-target="<?= htmlspecialchars($stat['value'] ?? '') ?>">
                <?= htmlspecialchars($stat['value'] ?? '') ?>
            </strong>
            <span class="stat-label"><?= htmlspecialchars($stat['label'] ?? '') ?></span>
            <?php if (!empty($stat['sublabel'])): ?>
            <span class="stat-sublabel"><?= htmlspecialchars($stat['sublabel']) ?></span>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>
