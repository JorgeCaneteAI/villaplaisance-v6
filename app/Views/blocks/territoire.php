<?php
$lieux = Database::fetchAll("SELECT * FROM vp_proximites ORDER BY distance_km ASC");
$categories = [];
foreach ($lieux as $lieu) {
    $categories[$lieu['category']][] = $lieu;
}
?>
<?php if (!empty($lieux)): ?>
<section class="block-territoire container reveal">
    <h2 class="block-title">Triangle d'Or — Provence</h2>
    <div class="territoire-grid">
        <?php foreach ($categories as $cat => $items): ?>
        <div class="territoire-cat">
            <h3 class="territoire-cat-title"><?= htmlspecialchars($cat) ?></h3>
            <ul class="territoire-list">
                <?php foreach ($items as $lieu): ?>
                <li class="territoire-item">
                    <span class="territoire-name"><?= htmlspecialchars($lieu['name']) ?></span>
                    <span class="territoire-dist">
                        <?php if (!empty($lieu['distance_km'])): ?>
                        <?= htmlspecialchars($lieu['distance_km']) ?> km
                        <?php endif; ?>
                        <?php if (!empty($lieu['duration_min'])): ?>
                        · <?= htmlspecialchars($lieu['duration_min']) ?> min
                        <?php endif; ?>
                    </span>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>
