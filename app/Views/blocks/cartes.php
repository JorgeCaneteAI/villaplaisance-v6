<?php
$offer  = $data['offer'] ?? 'both';
$where  = $offer === 'both' ? '' : "AND offer = '{$offer}'";
$pieces = Database::fetchAll(
    "SELECT * FROM vp_pieces WHERE lang = ? AND active = 1 {$where} ORDER BY position ASC",
    [$lang ?? 'fr']
);
?>
<?php if (!empty($pieces)): ?>
<section class="block-cartes container reveal">
    <div class="cartes-grid">
        <?php foreach ($pieces as $piece): ?>
        <article class="carte">
            <?php if (!empty($piece['image'])): ?>
            <figure class="carte-image">
                <img src="/assets/img/<?= htmlspecialchars($piece['image']) ?>"
                     alt="<?= htmlspecialchars($piece['name'] ?? '') ?>" loading="lazy">
            </figure>
            <?php endif; ?>
            <div class="carte-body">
                <?php if (!empty($piece['name'])): ?>
                <h3 class="carte-title"><?= htmlspecialchars($piece['name']) ?></h3>
                <?php endif; ?>
                <?php if (!empty($piece['description'])): ?>
                <p class="carte-desc"><?= nl2br(htmlspecialchars($piece['description'])) ?></p>
                <?php endif; ?>
                <?php
                $features = json_decode($piece['features'] ?? '[]', true);
                if (!empty($features)):
                ?>
                <ul class="carte-features">
                    <?php foreach ($features as $feat): ?>
                    <li><?= htmlspecialchars($feat) ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>
