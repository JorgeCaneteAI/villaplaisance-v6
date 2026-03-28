<?php $pageTitle = 'Ajouter un bloc'; ?>

<style>
.type-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: .75rem; margin-top: 1.5rem; }
.type-card { border: 2px solid var(--c-border); border-radius: var(--radius); padding: 1rem; cursor: pointer; transition: all .15s; background: #fff; }
.type-card:hover { border-color: var(--c-accent); background: #f8f9fa; }
.type-card input[type="radio"] { display: none; }
.type-card.selected { border-color: var(--c-sidebar); background: #f0f4f8; }
.type-name { font-weight: 700; font-size: .9rem; color: var(--c-text); }
.type-desc { font-size: .75rem; color: var(--c-muted); margin-top: .25rem; }
</style>

<div class="page-header">
    <div>
        <div style="font-size:.8rem;color:var(--c-muted);margin-bottom:.25rem;">
            <a href="/admin/pages" style="color:inherit;text-decoration:none;">Pages</a> /
            <a href="/admin/pages/<?= htmlspecialchars($page['slug']) ?>" style="color:inherit;text-decoration:none;"><?= htmlspecialchars($page['slug']) ?></a> /
            Nouveau bloc
        </div>
        <h1>Choisir un type de bloc</h1>
    </div>
    <a href="/admin/pages/<?= htmlspecialchars($page['slug']) ?>" class="btn btn-secondary">Annuler</a>
</div>

<form method="POST" action="/admin/pages/<?= htmlspecialchars($page['slug']) ?>/sections/nouveau" id="create-form">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
    <input type="hidden" name="type" id="selected-type" value="">

    <div class="type-grid">
        <?php foreach ($types as $key => $label): ?>
            <div class="type-card" onclick="selectType('<?= $key ?>', this)">
                <input type="radio" name="type_radio" value="<?= $key ?>">
                <div class="type-name"><?= htmlspecialchars($label) ?></div>
            </div>
        <?php endforeach; ?>
    </div>

    <div style="margin-top:2rem;">
        <button type="submit" class="btn btn-primary" id="submit-btn" disabled>Ajouter ce bloc →</button>
    </div>
</form>

<script>
function selectType(key, el) {
    document.querySelectorAll('.type-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('selected-type').value = key;
    document.getElementById('submit-btn').disabled = false;
}
</script>
