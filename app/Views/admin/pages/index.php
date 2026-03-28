<?php $pageTitle = 'Pages & blocs'; ?>

<div class="page-header">
    <h1>Pages & blocs</h1>
</div>

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
        <?php foreach ($pages as $page): ?>
            <tr>
                <td><code style="font-size:.8rem;"><?= htmlspecialchars($page['slug']) ?></code></td>
                <td><?= htmlspecialchars($page['title'] ?: '—') ?></td>
                <td><span class="badge badge-gray"><?= htmlspecialchars($page['lang']) ?></span></td>
                <td style="color:#9ca3af;font-size:.8rem;">
                    <?= $page['updated_at'] ? date('d/m/Y', strtotime($page['updated_at'])) : '—' ?>
                </td>
                <td style="display:flex;gap:.5rem;">
                    <a href="/admin/pages/<?= htmlspecialchars($page['slug']) ?>" class="btn btn-primary btn-sm">Blocs</a>
                    <a href="/admin/pages/<?= htmlspecialchars($page['slug']) ?>/seo" class="btn btn-secondary btn-sm">SEO</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
