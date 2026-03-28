<div class="form-group">
    <label class="form-label">Titre</label>
    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($d['title'] ?? '') ?>">
</div>

<div class="form-group">
    <label class="form-label">Lignes</label>
    <div id="tableau-rows">
        <?php foreach (($d['rows'] ?? []) as $row): ?>
        <div class="tableau-row" style="display:flex;gap:.5rem;margin-bottom:.5rem;">
            <input type="text" name="rows[label][]" class="form-control" value="<?= htmlspecialchars($row['label'] ?? '') ?>" placeholder="Libellé">
            <input type="text" name="rows[value][]" class="form-control" value="<?= htmlspecialchars($row['value'] ?? '') ?>" placeholder="Valeur">
            <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger btn-sm">✕</button>
        </div>
        <?php endforeach; ?>
    </div>
    <button type="button" onclick="addRow()" class="btn btn-secondary btn-sm" style="margin-top:.5rem;">+ Ajouter une ligne</button>
</div>

<script>
function addRow() {
    const wrap = document.getElementById('tableau-rows');
    const div  = document.createElement('div');
    div.className = 'tableau-row';
    div.style.cssText = 'display:flex;gap:.5rem;margin-bottom:.5rem;';
    div.innerHTML = `
        <input type="text" name="rows[label][]" class="form-control" placeholder="Libellé">
        <input type="text" name="rows[value][]" class="form-control" placeholder="Valeur">
        <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger btn-sm">✕</button>`;
    wrap.appendChild(div);
}
</script>
