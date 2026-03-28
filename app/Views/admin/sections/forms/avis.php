<div class="form-group">
    <label class="form-label">Offre filtrée</label>
    <select name="offer" class="form-control">
        <option value="bb"   <?= ($d['offer'] ?? '') === 'bb'    ? 'selected' : '' ?>>Chambres d'hôtes</option>
        <option value="villa"<?= ($d['offer'] ?? '') === 'villa'  ? 'selected' : '' ?>>Villa</option>
        <option value="both" <?= ($d['offer'] ?? 'both') === 'both' ? 'selected' : '' ?>>Tous</option>
    </select>
</div>
<div class="form-group">
    <label class="form-label">Nombre d'avis à afficher</label>
    <input type="number" name="max" class="form-control" value="<?= (int)($d['max'] ?? 6) ?>" min="1" max="20" style="width:100px;">
</div>
<p class="form-hint">Les avis affichés sont ceux marqués "featured" dans la gestion des avis.</p>
