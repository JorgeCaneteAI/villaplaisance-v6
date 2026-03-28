<div class="form-group">
    <label class="form-label">Titre</label>
    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($d['title'] ?? '') ?>">
</div>
<div class="form-group">
    <label class="form-label">Texte</label>
    <textarea name="text" class="form-control" rows="3"><?= htmlspecialchars($d['text'] ?? '') ?></textarea>
</div>
<div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
    <div class="form-group">
        <label class="form-label">Bouton 1 — libellé</label>
        <input type="text" name="btn1_label" class="form-control" value="<?= htmlspecialchars($d['btn1_label'] ?? '') ?>">
    </div>
    <div class="form-group">
        <label class="form-label">Bouton 1 — URL</label>
        <input type="text" name="btn1_url" class="form-control" value="<?= htmlspecialchars($d['btn1_url'] ?? '') ?>">
    </div>
    <div class="form-group">
        <label class="form-label">Bouton 2 — libellé (optionnel)</label>
        <input type="text" name="btn2_label" class="form-control" value="<?= htmlspecialchars($d['btn2_label'] ?? '') ?>">
    </div>
    <div class="form-group">
        <label class="form-label">Bouton 2 — URL</label>
        <input type="text" name="btn2_url" class="form-control" value="<?= htmlspecialchars($d['btn2_url'] ?? '') ?>">
    </div>
</div>
