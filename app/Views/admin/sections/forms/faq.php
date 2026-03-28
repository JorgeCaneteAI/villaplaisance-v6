<div class="form-group">
    <label class="form-label">Filtre page</label>
    <input type="text" name="page_filter" class="form-control"
           value="<?= htmlspecialchars($d['page_filter'] ?? '') ?>"
           placeholder="ex: accueil, chambres, villa…">
    <p class="form-hint">Affiche les FAQ dont le champ "page" correspond à cette valeur. Laissez vide pour tout afficher.</p>
</div>
