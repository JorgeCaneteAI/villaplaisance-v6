<?php
$lieux = Database::fetchAll("SELECT * FROM vp_proximites WHERE active = 1 ORDER BY position ASC");
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
                        <?php if (!empty($lieu['distance'])): ?>
                        <?= htmlspecialchars($lieu['distance']) ?>
                        <?php endif; ?>
                        <?php if (!empty($lieu['duration'])): ?>
                        · <?= htmlspecialchars($lieu['duration']) ?>
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
