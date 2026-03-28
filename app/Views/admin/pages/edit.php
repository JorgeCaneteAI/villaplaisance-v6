<?php $pageTitle = htmlspecialchars($page['title'] ?: $page['slug']); ?>

<style>
.section-row {
    background: #fff;
    border: 1px solid var(--c-border);
    border-radius: var(--radius);
    padding: 1rem 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: .5rem;
}
.section-row.inactive { opacity: .5; }
.section-type { font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: var(--c-muted); min-width: 120px; }
.section-actions { margin-left: auto; display: flex; gap: .4rem; align-items: center; }
.btn-icon { background: none; border: 1px solid var(--c-border); border-radius: 6px; padding: .3rem .5rem; cursor: pointer; color: var(--c-muted); font-size: .85rem; transition: all .15s; }
.btn-icon:hover { background: #f9fafb; color: var(--c-text); }
.drag-handle { color: #d1d5db; cursor: grab; font-size: 1rem; }
</style>

<div class="page-header">
    <div>
        <div style="font-size:.8rem;color:var(--c-muted);margin-bottom:.25rem;">
            <a href="/admin/pages" style="color:inherit;text-decoration:none;">Pages</a> /
            <?= htmlspecialchars($page['slug']) ?>
        </div>
        <h1><?= htmlspecialchars($page['title'] ?: $page['slug']) ?></h1>
    </div>
    <div style="display:flex;gap:.5rem;">
        <a href="/admin/pages/<?= htmlspecialchars($page['slug']) ?>/seo" class="btn btn-secondary">SEO</a>
        <a href="/admin/pages/<?= htmlspecialchars($page['slug']) ?>/sections/nouveau" class="btn btn-primary">+ Ajouter un bloc</a>
    </div>
</div>

<?php if (empty($sections)): ?>
    <div style="text-align:center;padding:3rem;color:var(--c-muted);">
        <p style="font-size:1.1rem;margin-bottom:.5rem;">Aucun bloc sur cette page.</p>
        <p style="font-size:.875rem;">Commencez par ajouter un bloc <strong>Hero</strong> pour le titre de la page.</p>
    </div>
<?php else: ?>
    <div class="section-title">Blocs (<?= count($sections) ?>)</div>

    <?php foreach ($sections as $section): ?>
        <div class="section-row <?= $section['active'] ? '' : 'inactive' ?>">
            <span class="drag-handle">⠿</span>

            <div>
                <div class="section-type"><?= htmlspecialchars($section['type']) ?></div>
                <div style="font-size:.85rem;color:var(--c-text);">
                    <?php
                    $d = is_array($section['data']) ? $section['data'] : [];
                    echo htmlspecialchars(
                        $d['title'] ?? $d['text'] ?? $d['offer'] ?? '—'
                    );
                    ?>
                </div>
            </div>

            <div class="section-actions">
                <!-- Monter -->
                <form method="POST" action="/admin/sections/<?= $section['id'] ?>/monter" style="display:inline">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                    <button type="submit" class="btn-icon" title="Monter">↑</button>
                </form>

                <!-- Descendre -->
                <form method="POST" action="/admin/sections/<?= $section['id'] ?>/descendre" style="display:inline">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                    <button type="submit" class="btn-icon" title="Descendre">↓</button>
                </form>

                <!-- Activer/Désactiver -->
                <form method="POST" action="/admin/sections/<?= $section['id'] ?>/activer" style="display:inline">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                    <button type="submit" class="btn-icon" title="<?= $section['active'] ? 'Désactiver' : 'Activer' ?>">
                        <?= $section['active'] ? '◉' : '○' ?>
                    </button>
                </form>

                <!-- Éditer -->
                <a href="/admin/sections/<?= $section['id'] ?>/modifier" class="btn btn-secondary btn-sm">Éditer</a>

                <!-- Supprimer -->
                <form method="POST" action="/admin/sections/<?= $section['id'] ?>/supprimer" style="display:inline"
                      onsubmit="return confirm('Supprimer ce bloc ?')">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                    <button type="submit" class="btn btn-danger btn-sm">✕</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
