<div class="form-group">
    <label class="form-label">Titre (H2)</label>
    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($d['title'] ?? '') ?>">
</div>
<div class="form-group">
    <label class="form-label">Texte principal</label>
    <textarea name="text" class="form-control" rows="6"><?= htmlspecialchars($d['text'] ?? '') ?></textarea>
    <p class="form-hint">Saut de ligne = nouveau paragraphe.</p>
</div>
<div class="form-group">
    <label class="form-label">Encadré (optionnel)</label>
    <textarea name="encadre" class="form-control" rows="3"><?= htmlspecialchars($d['encadre'] ?? '') ?></textarea>
</div>
