<?php
$pageTitle = 'Éditer — ' . ($types[$section['type']] ?? $section['type']);
$d = $section['data'];
?>

<div class="page-header">
    <div>
        <div style="font-size:.8rem;color:var(--c-muted);margin-bottom:.25rem;">
            <a href="/admin/pages" style="color:inherit;text-decoration:none;">Pages</a> /
            <a href="/admin/pages/<?= htmlspecialchars($page['slug']) ?>" style="color:inherit;text-decoration:none;"><?= htmlspecialchars($page['slug']) ?></a> /
            <span class="badge badge-blue"><?= htmlspecialchars($section['type']) ?></span>
        </div>
        <h1><?= htmlspecialchars($types[$section['type']] ?? $section['type']) ?></h1>
    </div>
    <a href="/admin/pages/<?= htmlspecialchars($page['slug']) ?>" class="btn btn-secondary">← Retour</a>
</div>

<div style="background:#fff;border:1px solid var(--c-border);border-radius:var(--radius);padding:2rem;max-width:780px;">
    <form method="POST" action="/admin/sections/<?= $section['id'] ?>/modifier">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

        <?php
        $formFile = ROOT . '/app/Views/admin/sections/forms/' . $section['type'] . '.php';
        if (file_exists($formFile)) {
            require $formFile;
        } else {
            echo '<p style="color:var(--c-muted);">Formulaire non disponible pour ce type de bloc.</p>';
        }
        ?>

        <div style="display:flex;gap:.75rem;margin-top:2rem;padding-top:1.5rem;border-top:1px solid var(--c-border);">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="/admin/pages/<?= htmlspecialchars($page['slug']) ?>" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>
