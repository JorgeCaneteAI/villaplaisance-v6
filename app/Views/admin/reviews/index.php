<?php
$csrf = $_SESSION['csrf_token'] ?? '';
$counts = ['total' => count($reviews), 'bb' => 0, 'villa' => 0, 'featured' => 0, 'airbnb' => 0, 'booking' => 0];
foreach ($reviews as $r) {
    if ($r['offer'] === 'bb')    $counts['bb']++;
    if ($r['offer'] === 'villa') $counts['villa']++;
    if ($r['featured'])          $counts['featured']++;
    if ($r['platform'] === 'airbnb')  $counts['airbnb']++;
    if ($r['platform'] === 'booking') $counts['booking']++;
}
?>
<style>
.reviews-filters { display:flex; gap:.75rem; margin-bottom:1.5rem; flex-wrap:wrap; align-items:center; }
.filter-btn { padding:.35rem .8rem; border-radius:20px; font-size:.78rem; font-weight:600; cursor:pointer;
              border:1.5px solid var(--c-border); background:var(--c-white); color:var(--c-muted);
              transition:all .15s; text-decoration:none; }
.filter-btn.active, .filter-btn:hover { border-color:var(--c-sidebar); color:var(--c-sidebar); background:#f0f4f8; }
.review-text { max-width:420px; overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; }
.platform-badge { display:inline-block; padding:.15rem .45rem; border-radius:4px; font-size:.7rem; font-weight:700; }
.platform-airbnb  { background:#fff0f0; color:#c0392b; }
.platform-booking { background:#e8f0fb; color:#003580; }
.offer-badge { display:inline-block; padding:.15rem .45rem; border-radius:4px; font-size:.7rem; font-weight:700; }
.offer-bb    { background:#f0fdf4; color:#065f46; }
.offer-villa { background:#fff7ed; color:#9a3412; }
.star { color:#f59e0b; }
.toggle-btn { background:none; border:1.5px solid var(--c-border); border-radius:6px; padding:.25rem .5rem;
              cursor:pointer; font-size:.8rem; transition:all .15s; }
.toggle-btn:hover { border-color:var(--c-accent); }
.toggle-on  { border-color:#86efac!important; background:#f0fdf4; color:#065f46; }
.toggle-off { border-color:var(--c-border); color:var(--c-muted); }
</style>

<div class="page-header">
    <h1>Avis clients</h1>
</div>

<div class="stat-grid" style="grid-template-columns:repeat(5,1fr);margin-bottom:1.5rem;">
    <div class="stat-card"><div class="stat-value"><?= $counts['total'] ?></div><div class="stat-label">Total</div></div>
    <div class="stat-card"><div class="stat-value"><?= $counts['airbnb'] ?></div><div class="stat-label">Airbnb</div></div>
    <div class="stat-card"><div class="stat-value"><?= $counts['booking'] ?></div><div class="stat-label">Booking</div></div>
    <div class="stat-card"><div class="stat-value"><?= $counts['bb'] ?></div><div class="stat-label">Chambres</div></div>
    <div class="stat-card"><div class="stat-value"><?= $counts['featured'] ?></div><div class="stat-label">En vedette</div></div>
</div>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>Auteur</th>
                <th>Plateforme</th>
                <th>Offre</th>
                <th>Note</th>
                <th>Date</th>
                <th>Commentaire</th>
                <th>Vedette</th>
                <th>Carousel</th>
                <th>Statut</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($reviews as $r): ?>
        <tr>
            <td>
                <strong><?= htmlspecialchars($r['author']) ?></strong>
                <?php if (!empty($r['origin'])): ?>
                <div style="font-size:.75rem;color:var(--c-muted);"><?= htmlspecialchars($r['origin']) ?></div>
                <?php endif; ?>
            </td>
            <td>
                <span class="platform-badge platform-<?= htmlspecialchars($r['platform']) ?>">
                    <?= strtoupper(htmlspecialchars($r['platform'])) ?>
                </span>
            </td>
            <td>
                <span class="offer-badge offer-<?= htmlspecialchars($r['offer']) ?>">
                    <?= $r['offer'] === 'bb' ? 'Chambres' : ($r['offer'] === 'villa' ? 'Villa' : 'Les deux') ?>
                </span>
            </td>
            <td>
                <span class="star"><?= str_repeat('★', min(5, (int)$r['rating'])) ?></span>
                <span style="font-size:.75rem;color:var(--c-muted);"><?= $r['rating'] ?></span>
            </td>
            <td style="white-space:nowrap;font-size:.8rem;"><?= htmlspecialchars($r['review_date'] ?? '') ?></td>
            <td><div class="review-text"><?= htmlspecialchars($r['content'] ?? '') ?></div></td>
            <td>
                <form method="POST" action="/admin/avis/<?= $r['id'] ?>/featured">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                    <button type="submit" class="toggle-btn <?= $r['featured'] ? 'toggle-on' : 'toggle-off' ?>">
                        <?= $r['featured'] ? '★ Oui' : '☆ Non' ?>
                    </button>
                </form>
            </td>
            <td>
                <form method="POST" action="/admin/avis/<?= $r['id'] ?>/carousel">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                    <button type="submit" class="toggle-btn <?= $r['home_carousel'] ? 'toggle-on' : 'toggle-off' ?>">
                        <?= $r['home_carousel'] ? '▶ Oui' : '○ Non' ?>
                    </button>
                </form>
            </td>
            <td>
                <form method="POST" action="/admin/avis/<?= $r['id'] ?>/statut">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                    <button type="submit" class="toggle-btn <?= $r['status'] === 'published' ? 'toggle-on' : 'toggle-off' ?>">
                        <?= $r['status'] === 'published' ? 'Publié' : 'Masqué' ?>
                    </button>
                </form>
            </td>
            <td>
                <form method="POST" action="/admin/avis/<?= $r['id'] ?>/supprimer"
                      onsubmit="return confirm('Supprimer cet avis ?')">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                    <button type="submit" class="btn btn-danger btn-sm">Suppr.</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
