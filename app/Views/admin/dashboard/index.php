<?php $pageTitle = 'Dashboard'; ?>

<div class="page-header">
    <h1>Bonjour, <?= htmlspecialchars($userName) ?></h1>
    <a href="https://vp.villaplaisance.fr" target="_blank" class="btn btn-secondary btn-sm">
        Voir le site &rarr;
    </a>
</div>

<!-- Stats -->
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-value"><?= $stats['pages'] ?></div>
        <div class="stat-label">Pages</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= $stats['sections'] ?></div>
        <div class="stat-label">Blocs CMS</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= $stats['pieces'] ?></div>
        <div class="stat-label">Pièces</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= $stats['avis'] ?></div>
        <div class="stat-label">Avis clients</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= $stats['articles'] ?></div>
        <div class="stat-label">Articles</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= $stats['medias'] ?></div>
        <div class="stat-label">Médias</div>
    </div>
</div>

<!-- Pages -->
<div class="section-title">Pages du site</div>
<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>Slug</th>
                <th>Titre</th>
                <th>Langue</th>
                <th>Modifiée</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($pages)): ?>
            <tr><td colspan="5" style="color:#9ca3af;font-style:italic;text-align:center;padding:2rem;">
                Aucune page — lancez le seed <code>003_seed_pages.php</code>
            </td></tr>
        <?php else: ?>
            <?php foreach ($pages as $page): ?>
            <tr>
                <td><code style="font-size:.8rem;"><?= htmlspecialchars($page['slug']) ?></code></td>
                <td><?= htmlspecialchars($page['title'] ?: '—') ?></td>
                <td><span class="badge badge-gray"><?= htmlspecialchars($page['lang']) ?></span></td>
                <td style="color:#9ca3af;font-size:.8rem;">
                    <?= $page['updated_at'] ? date('d/m/Y', strtotime($page['updated_at'])) : '—' ?>
                </td>
                <td>
                    <a href="/admin/pages/<?= htmlspecialchars($page['slug']) ?>" class="btn btn-secondary btn-sm">
                        Éditer
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
