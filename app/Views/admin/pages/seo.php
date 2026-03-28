<?php $pageTitle = 'SEO — ' . $page['slug']; ?>

<div class="page-header">
    <div>
        <div style="font-size:.8rem;color:var(--c-muted);margin-bottom:.25rem;">
            <a href="/admin/pages" style="color:inherit;text-decoration:none;">Pages</a> /
            <a href="/admin/pages/<?= htmlspecialchars($page['slug']) ?>" style="color:inherit;text-decoration:none;"><?= htmlspecialchars($page['slug']) ?></a> /
            SEO
        </div>
        <h1>SEO — <?= htmlspecialchars($page['slug']) ?></h1>
    </div>
    <a href="/admin/pages/<?= htmlspecialchars($page['slug']) ?>" class="btn btn-secondary">← Retour</a>
</div>

<div style="background:#fff;border:1px solid var(--c-border);border-radius:var(--radius);padding:2rem;max-width:780px;">
    <form method="POST" action="/admin/pages/<?= htmlspecialchars($page['slug']) ?>/seo">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

        <div class="form-group">
            <label class="form-label">Titre de la page <span style="color:var(--c-muted);font-weight:400;">(balise H1 visible)</span></label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($page['title'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label class="form-label">Meta title <span style="color:var(--c-muted);font-weight:400;">(onglet navigateur, résultats Google)</span></label>
            <input type="text" name="meta_title" class="form-control" value="<?= htmlspecialchars($page['meta_title'] ?? '') ?>">
            <p class="form-hint">50–60 caractères recommandés.</p>
        </div>

        <div class="form-group">
            <label class="form-label">Meta description</label>
            <textarea name="meta_desc" class="form-control" rows="3"><?= htmlspecialchars($page['meta_desc'] ?? '') ?></textarea>
            <p class="form-hint">140–160 caractères recommandés.</p>
        </div>

        <div class="form-group">
            <label class="form-label">Mots-clés</label>
            <input type="text" name="meta_keywords" class="form-control" value="<?= htmlspecialchars($page['meta_keywords'] ?? '') ?>">
            <p class="form-hint">Séparés par des virgules.</p>
        </div>

        <div class="form-group">
            <label class="form-label">Description GSO <span style="color:var(--c-muted);font-weight:400;">(Google Search Optimization — JSON-LD)</span></label>
            <textarea name="gso_desc" class="form-control" rows="5"><?= htmlspecialchars($page['gso_desc'] ?? '') ?></textarea>
            <p class="form-hint">Texte naturel décrivant la page pour les moteurs de recherche et l'IA. 2–3 phrases claires.</p>
        </div>

        <div style="display:flex;gap:.75rem;margin-top:2rem;padding-top:1.5rem;border-top:1px solid var(--c-border);">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="/admin/pages/<?= htmlspecialchars($page['slug']) ?>" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>
