<div class="form-group">
    <label class="form-label">Type d'articles</label>
    <select name="article_type" class="form-control">
        <option value="journal"   <?= ($d['type'] ?? '') === 'journal'   ? 'selected' : '' ?>>Journal</option>
        <option value="sur-place" <?= ($d['type'] ?? '') === 'sur-place' ? 'selected' : '' ?>>Sur Place</option>
    </select>
</div>
<div class="form-group">
    <label class="form-label">Nombre d'articles à afficher</label>
    <input type="number" name="max" class="form-control" value="<?= (int)($d['max'] ?? 3) ?>" min="1" max="12" style="width:100px;">
</div>
