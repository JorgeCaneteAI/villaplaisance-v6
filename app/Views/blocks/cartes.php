<?php
$offer  = $data['offer'] ?? 'both';
$where  = $offer === 'both' ? '' : "AND offer = '{$offer}'";
$pieces = Database::fetchAll(
    "SELECT * FROM vp_pieces WHERE lang = ? {$where} ORDER BY position ASC",
    [$lang ?? 'fr']
);
?>
<?php if (!empty($pieces)): ?>
<section class="block-cartes container reveal">
    <div class="cartes-grid">
        <?php foreach ($pieces as $piece): ?>
        <article class="carte">
            <div class="carte-body">
                <?php if (!empty($piece['name'])): ?>
                <h3 class="carte-title"><?= htmlspecialchars($piece['name']) ?></h3>
                <?php endif; ?>
                <?php if (!empty($piece['sous_titre'])): ?>
                <p class="carte-subtitle"><?= htmlspecialchars($piece['sous_titre']) ?></p>
                <?php endif; ?>
                <?php if (!empty($piece['description'])): ?>
                <p class="carte-desc"><?= nl2br(htmlspecialchars($piece['description'])) ?></p>
                <?php endif; ?>
                <?php if (!empty($piece['equip'])): ?>
                <ul class="carte-features">
                    <?php foreach (array_filter(array_map('trim', explode(',', $piece['equip']))) as $equip): ?>
                    <li><?= htmlspecialchars($equip) ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
                <?php if (!empty($piece['note'])): ?>
                <p class="carte-note"><?= htmlspecialchars($piece['note']) ?></p>
                <?php endif; ?>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>
