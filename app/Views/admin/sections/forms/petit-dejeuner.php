<div class="form-group">
    <label class="form-label">Titre</label>
    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($d['title'] ?? '') ?>">
</div>
<div class="form-group">
    <label class="form-label">Description</label>
    <textarea name="text" class="form-control" rows="5"><?= htmlspecialchars($d['text'] ?? '') ?></textarea>
</div>
