<div class="form-group">
    <label class="form-label">Titre (optionnel)</label>
    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($d['title'] ?? '') ?>">
</div>
<div class="form-group">
    <label class="form-label">Noms de fichiers (un par ligne)</label>
    <textarea name="images" class="form-control" rows="8" placeholder="photo-jardin.webp&#10;piscine-ete.webp&#10;chambre-verte.webp"><?= htmlspecialchars(implode("\n", $d['images'] ?? [])) ?></textarea>
    <p class="form-hint">Fichiers uploadés dans la Médiathèque. Un nom de fichier par ligne.</p>
</div>
