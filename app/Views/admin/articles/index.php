<?php
$csrf = $_SESSION['csrf_token'] ?? '';
$counts = ['total' => count($articles), 'journal' => 0, 'sur-place' => 0, 'published' => 0, 'draft' => 0];
foreach ($articles as $a) {
    $counts[$a['type']]++;
    $counts[$a['status']]++;
}
?>
<style>
.type-badge   { display:inline-block; padding:.15rem .45rem; border-radius:4px; font-size:.7rem; font-weight:700; }
.type-journal { background:#fef3c7; color:#92400e; }
.type-sur-place { background:#e0f2fe; color:#075985; }
.status-badge { display:inline-block; padding:.15rem .45rem; border-radius:4px; font-size:.7rem; font-weight:700; }
.status-published { background:#f0fdf4; color:#065f46; }
.status-draft     { background:#f1f5f9; color:#64748b; }
.article-excerpt  { max-width:320px; overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical;
                    font-size:.8rem; color:var(--c-muted); }
.filter-tabs { display:flex; gap:.5rem; margin-bottom:1.5rem; }
.filter-tab  { padding:.35rem .9rem; border-radius:20px; font-size:.78rem; font-weight:600; text-decoration:none;
               border:1.5px solid var(--c-border); color:var(--c-muted); transition:all .15s; }
.filter-tab.active, .filter-tab:hover { border-color:var(--c-sidebar); color:var(--c-sidebar); background:#f0f4f8; }
</style>

<div class="page-header">
    <h1>Articles</h1>
    <a href="/admin/articles/nouveau" class="btn btn-primary">+ Nouvel article</a>
</div>

<?php if ($flash): ?>
<div class="flash flash-<?= $flash['type'] ?>"><?= htmlspecialchars($flash['message']) ?></div>
<?php endif; ?>

<div class="stat-grid" style="grid-template-columns:repeat(5,1fr);margin-bottom:1.5rem;">
    <div class="stat-card"><div class="stat-value"><?= $counts['total'] ?></div><div class="stat-label">Total</div></div>
    <div class="stat-card"><div class="stat-value"><?= $counts['journal'] ?></div><div class="stat-label">Journal</div></div>
    <div class="stat-card"><div class="stat-value"><?= $counts['sur-place'] ?></div><div class="stat-label">Sur place</div></div>
    <div class="stat-card"><div class="stat-value"><?= $counts['published'] ?></div><div class="stat-label">Publiés</div></div>
    <div class="stat-card"><div class="stat-value"><?= $counts['draft'] ?></div><div class="stat-label">Brouillons</div></div>
</div>

<div class="filter-tabs">
    <a href="/admin/articles" class="filter-tab <?= $filter === '' ? 'active' : '' ?>">Tous</a>
    <a href="/admin/articles?type=journal" class="filter-tab <?= $filter === 'journal' ? 'active' : '' ?>">Journal</a>
    <a href="/admin/articles?type=sur-place" class="filter-tab <?= $filter === 'sur-place' ? 'active' : '' ?>">Sur place</a>
</div>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Type</th>
                <th>Catégorie</th>
                <th>Statut</th>
                <th>Publication</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($articles as $a): ?>
        <tr>
            <td>
                <strong><?= htmlspecialchars($a['title']) ?></strong>
                <div class="article-excerpt"><?= htmlspecialchars($a['excerpt']) ?></div>
                <div style="font-size:.7rem;color:var(--c-muted);margin-top:.2rem;"><?= htmlspecialchars($a['slug']) ?></div>
            </td>
            <td>
                <span class="type-badge type-<?= htmlspecialchars($a['type']) ?>">
                    <?= $a['type'] === 'journal' ? 'Journal' : 'Sur place' ?>
                </span>
            </td>
            <td style="font-size:.82rem;"><?= htmlspecialchars($a['category'] ?? '') ?></td>
            <td>
                <span class="status-badge status-<?= htmlspecialchars($a['status']) ?>">
                    <?= $a['status'] === 'published' ? 'Publié' : 'Brouillon' ?>
                </span>
            </td>
            <td style="font-size:.8rem;white-space:nowrap;">
                <?= !empty($a['published_at']) ? date('d/m/Y', strtotime($a['published_at'])) : '—' ?>
            </td>
            <td style="white-space:nowrap;">
                <a href="/admin/articles/<?= $a['id'] ?>/modifier" class="btn btn-sm" style="margin-right:.25rem;">Modifier</a>
                <a href="/<?= htmlspecialchars($a['type']) ?>/<?= htmlspecialchars($a['slug']) ?>"
                   target="_blank" class="btn btn-sm" style="margin-right:.25rem;" title="Voir en ligne">↗</a>
                <form method="POST" action="/admin/articles/<?= $a['id'] ?>/supprimer" style="display:inline"
                      onsubmit="return confirm('Supprimer « <?= htmlspecialchars(addslashes($a['title'])) ?> » ?')">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                    <button type="submit" class="btn btn-danger btn-sm">Suppr.</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($articles)): ?>
        <tr><td colspan="6" style="text-align:center;color:var(--c-muted);padding:2rem;">Aucun article.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
