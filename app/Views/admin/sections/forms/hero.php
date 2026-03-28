<div class="form-group">
    <label class="form-label">Titre (H1)</label>
    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($d['title'] ?? '') ?>">
</div>
<div class="form-group">
    <label class="form-label">Sous-titre</label>
    <input type="text" name="subtitle" class="form-control" value="<?= htmlspecialchars($d['subtitle'] ?? '') ?>">
</div>
<div class="form-group">
    <label class="form-label">Introduction</label>
    <textarea name="intro" class="form-control" rows="4"><?= htmlspecialchars($d['intro'] ?? '') ?></textarea>
</div>
<div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
    <div class="form-group">
        <label class="form-label">Bouton — libellé</label>
        <input type="text" name="cta_label" class="form-control" value="<?= htmlspecialchars($d['cta_label'] ?? '') ?>">
    </div>
    <div class="form-group">
        <label class="form-label">Bouton — URL</label>
        <input type="text" name="cta_url" class="form-control" value="<?= htmlspecialchars($d['cta_url'] ?? '') ?>">
    </div>
</div>
