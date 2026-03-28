<div class="form-group">
    <label class="form-label">Offre affichée</label>
    <select name="offer" class="form-control">
        <option value="bb"   <?= ($d['offer'] ?? '') === 'bb'   ? 'selected' : '' ?>>Chambres d'hôtes uniquement</option>
        <option value="villa"<?= ($d['offer'] ?? '') === 'villa' ? 'selected' : '' ?>>Villa uniquement</option>
        <option value="both" <?= ($d['offer'] ?? 'both') === 'both' ? 'selected' : '' ?>>Les deux</option>
    </select>
    <p class="form-hint">Affiche les pièces correspondant à cette offre depuis la table Pièces.</p>
</div>
