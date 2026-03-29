<?php
$csrf    = $_SESSION['csrf_token'] ?? '';
$isEdit  = !empty($article['id']);
$action  = $isEdit ? "/admin/articles/{$article['id']}/modifier" : '/admin/articles/nouveau';
$a       = $article ?? [];
function aval(array $a, string $key, string $default = ''): string {
    return htmlspecialchars($a[$key] ?? $default);
}
?>
<style>
.form-article { max-width:900px; }
.form-cols    { display:grid; grid-template-columns:1fr 1fr; gap:1.25rem; }
.form-col3    { display:grid; grid-template-columns:1fr 1fr 1fr; gap:1.25rem; }
.form-full    { grid-column:1/-1; }
textarea      { font-family:monospace; font-size:.82rem; }
.char-count   { font-size:.72rem; color:var(--c-muted); text-align:right; margin-top:.2rem; }
.section-sep  { border:none; border-top:1.5px solid var(--c-border); margin:1.75rem 0 1.25rem; }
.section-label{ font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em;
                color:var(--c-muted); margin-bottom:1rem; }
</style>

<div class="page-header">
    <h1><?= $pageTitle ?></h1>
    <a href="/admin/articles" class="btn">← Retour</a>
</div>

<?php if (!empty($errors)): ?>
<div class="flash flash-error">
    <?php foreach ($errors as $e): ?><div><?= htmlspecialchars($e) ?></div><?php endforeach; ?>
</div>
<?php endif; ?>

<form method="POST" action="<?= $action ?>" class="form-article">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

    <!-- Infos principales -->
    <div class="form-cols">
        <div class="form-group form-full">
            <label>Titre *</label>
            <input type="text" name="title" value="<?= aval($a, 'title') ?>" required
                   oninput="autoSlug(this.value)" placeholder="Titre de l'article">
        </div>

        <div class="form-group">
            <label>Type *</label>
            <select name="type" onchange="updateCategories(this.value)">
                <option value="journal"   <?= ($a['type'] ?? '') === 'journal'    ? 'selected' : '' ?>>Journal</option>
                <option value="sur-place" <?= ($a['type'] ?? '') === 'sur-place'  ? 'selected' : '' ?>>Sur place</option>
            </select>
        </div>

        <div class="form-group">
            <label>Catégorie</label>
            <input type="text" name="category" id="category-input" value="<?= aval($a, 'category') ?>"
                   list="categories-list" placeholder="Ex: Tourisme, Commerces…">
            <datalist id="categories-list"></datalist>
        </div>

        <div class="form-group">
            <label>Slug</label>
            <input type="text" name="slug" id="slug-input" value="<?= aval($a, 'slug') ?>"
                   placeholder="génèré automatiquement">
        </div>

        <div class="form-group">
            <label>Statut</label>
            <select name="status">
                <option value="draft"     <?= ($a['status'] ?? 'draft') === 'draft'     ? 'selected' : '' ?>>Brouillon</option>
                <option value="published" <?= ($a['status'] ?? '') === 'published' ? 'selected' : '' ?>>Publié</option>
            </select>
        </div>

        <div class="form-group">
            <label>Date de publication</label>
            <input type="datetime-local" name="published_at"
                   value="<?= !empty($a['published_at']) ? date('Y-m-d\TH:i', strtotime($a['published_at'])) : date('Y-m-d\TH:i') ?>">
        </div>

        <div class="form-group form-full">
            <label>Extrait * <span style="font-weight:400;color:var(--c-muted);">(affiché dans les listes — 1-2 phrases)</span></label>
            <textarea name="excerpt" rows="2" required
                      oninput="countChars(this,'count-excerpt')"><?= aval($a, 'excerpt') ?></textarea>
            <div class="char-count"><span id="count-excerpt"><?= strlen($a['excerpt'] ?? '') ?></span> caractères</div>
        </div>
    </div>

    <!-- Corps -->
    <hr class="section-sep">
    <div class="section-label">Contenu</div>
    <div class="form-group">
        <label>Corps de l'article <span style="font-weight:400;color:var(--c-muted);">(HTML accepté)</span></label>
        <textarea name="body" rows="20"
                  oninput="countChars(this,'count-body')"><?= htmlspecialchars($a['body'] ?? '') ?></textarea>
        <div class="char-count"><span id="count-body"><?= strlen($a['body'] ?? '') ?></span> caractères</div>
    </div>

    <!-- SEO -->
    <hr class="section-sep">
    <div class="section-label">SEO & GSO</div>
    <div class="form-cols">
        <div class="form-group form-full">
            <label>Meta title <span style="font-weight:400;color:var(--c-muted);">(50-60 car. idéal)</span></label>
            <input type="text" name="meta_title" value="<?= aval($a, 'meta_title') ?>"
                   oninput="countChars(this,'count-mt')" placeholder="Titre SEO de la page">
            <div class="char-count"><span id="count-mt"><?= strlen($a['meta_title'] ?? '') ?></span> / 60</div>
        </div>

        <div class="form-group form-full">
            <label>Meta description <span style="font-weight:400;color:var(--c-muted);">(150-160 car. idéal)</span></label>
            <textarea name="meta_desc" rows="2"
                      oninput="countChars(this,'count-md')"><?= aval($a, 'meta_desc') ?></textarea>
            <div class="char-count"><span id="count-md"><?= strlen($a['meta_desc'] ?? '') ?></span> / 160</div>
        </div>

        <div class="form-group form-full">
            <label>Mots-clés</label>
            <input type="text" name="meta_keywords" value="<?= aval($a, 'meta_keywords') ?>"
                   placeholder="provence, tourisme, bédarrides, …">
        </div>

        <div class="form-group form-full">
            <label>Description GSO <span style="font-weight:400;color:var(--c-muted);">(résumé factuel pour IA — Perplexity, Google AI Overview)</span></label>
            <textarea name="gso_desc" rows="3"
                      oninput="countChars(this,'count-gso')"><?= aval($a, 'gso_desc') ?></textarea>
            <div class="char-count"><span id="count-gso"><?= strlen($a['gso_desc'] ?? '') ?></span> caractères</div>
        </div>
    </div>

    <!-- Images -->
    <hr class="section-sep">
    <div class="section-label">Images</div>
    <div class="form-cols">
        <div class="form-group">
            <label>Image de couverture <span style="font-weight:400;color:var(--c-muted);">(nom fichier WebP)</span></label>
            <input type="text" name="cover_image" value="<?= aval($a, 'cover_image') ?>"
                   placeholder="ex: journal-slow-tourisme.webp">
        </div>
        <div class="form-group">
            <label>Image OG (réseaux sociaux)</label>
            <input type="text" name="og_image" value="<?= aval($a, 'og_image') ?>"
                   placeholder="ex: og-journal-slow-tourisme.webp">
        </div>
    </div>

    <div style="display:flex;gap:.75rem;margin-top:2rem;">
        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Enregistrer' : 'Créer l\'article' ?></button>
        <a href="/admin/articles" class="btn">Annuler</a>
        <?php if ($isEdit): ?>
        <a href="/<?= htmlspecialchars($a['type']) ?>/<?= htmlspecialchars($a['slug']) ?>"
           target="_blank" class="btn" style="margin-left:auto;">Voir en ligne ↗</a>
        <?php endif; ?>
    </div>
</form>

<script>
const journalCats  = ['Tourisme','Destination','Art de vivre','Gastronomie','Environnement'];
const surPlaceCats = ['Commerces','Sites','Enfants','Restaurants','Hors normes'];

function updateCategories(type) {
    const list = document.getElementById('categories-list');
    const cats = type === 'journal' ? journalCats : surPlaceCats;
    list.innerHTML = cats.map(c => `<option value="${c}">`).join('');
}
updateCategories(document.querySelector('select[name=type]').value);

function autoSlug(title) {
    if (document.getElementById('slug-input').dataset.manual) return;
    const slug = title.toLowerCase()
        .normalize('NFD').replace(/[\u0300-\u036f]/g,'')
        .replace(/[^a-z0-9]+/g,'-').replace(/^-|-$/g,'');
    document.getElementById('slug-input').value = slug;
}
document.getElementById('slug-input').addEventListener('input', function() {
    this.dataset.manual = '1';
});

function countChars(el, targetId) {
    document.getElementById(targetId).textContent = el.value.length;
}
</script>
