<div class="form-group">
    <label class="form-label">Titre</label>
    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($d['title'] ?? '') ?>">
</div>

<div class="form-group">
    <label class="form-label">Items</label>
    <div id="liste-items">
        <?php foreach (($d['items'] ?? []) as $item): ?>
        <div class="liste-row" style="display:flex;gap:.5rem;margin-bottom:.5rem;">
            <select name="items[type][]" class="form-control" style="width:120px;flex-shrink:0;">
                <option value="plus"  <?= ($item['type'] ?? '') === 'plus'  ? 'selected' : '' ?>>✓ Inclus</option>
                <option value="minus" <?= ($item['type'] ?? '') === 'minus' ? 'selected' : '' ?>>✗ Exclus</option>
            </select>
            <input type="text" name="items[label][]" class="form-control" value="<?= htmlspecialchars($item['label'] ?? '') ?>" placeholder="Libellé">
            <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger btn-sm">✕</button>
        </div>
        <?php endforeach; ?>
    </div>
    <button type="button" onclick="addListeRow()" class="btn btn-secondary btn-sm" style="margin-top:.5rem;">+ Ajouter un item</button>
</div>

<script>
function addListeRow() {
    const wrap = document.getElementById('liste-items');
    const div  = document.createElement('div');
    div.className = 'liste-row';
    div.style.cssText = 'display:flex;gap:.5rem;margin-bottom:.5rem;';
    div.innerHTML = `
        <select name="items[type][]" class="form-control" style="width:120px;flex-shrink:0;">
            <option value="plus">✓ Inclus</option>
            <option value="minus">✗ Exclus</option>
        </select>
        <input type="text" name="items[label][]" class="form-control" placeholder="Libellé">
        <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger btn-sm">✕</button>`;
    wrap.appendChild(div);
}
</script>
