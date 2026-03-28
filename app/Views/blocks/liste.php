<section class="block-liste container reveal">
    <?php if (!empty($data['title'])): ?>
    <h2 class="block-title"><?= htmlspecialchars($data['title']) ?></h2>
    <?php endif; ?>
    <?php if (!empty($data['items'])): ?>
    <ul class="liste-items">
        <?php foreach ($data['items'] as $item): ?>
        <?php if (empty($item['label'])) continue; ?>
        <li class="liste-item liste-item--<?= $item['type'] === 'exclu' ? 'exclu' : 'inclus' ?>">
            <span class="liste-icon"><?= $item['type'] === 'exclu' ? '✗' : '✓' ?></span>
            <?= htmlspecialchars($item['label']) ?>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
</section>
