<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Admin') ?> — Villa Plaisance</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --sidebar-w: 220px;
            --topbar-h: 56px;
            --c-bg:      #f1f0ed;
            --c-sidebar: #1a2332;
            --c-accent:  #8a9ab0;
            --c-text:    #1a2332;
            --c-muted:   #6b7280;
            --c-border:  #e5e7eb;
            --c-white:   #ffffff;
            --radius:    8px;
        }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            font-size: .9rem;
            background: var(--c-bg);
            color: var(--c-text);
            display: flex;
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: var(--c-sidebar);
            display: flex;
            flex-direction: column;
            z-index: 100;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 1.5rem 1.25rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }

        .sidebar-brand h2 {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 1.2rem;
            font-weight: 600;
            color: #fff;
            letter-spacing: .02em;
        }

        .sidebar-brand span {
            font-size: .7rem;
            color: var(--c-accent);
            text-transform: uppercase;
            letter-spacing: .1em;
        }

        .nav-section {
            padding: .75rem 0;
            border-bottom: 1px solid rgba(255,255,255,.06);
        }

        .nav-section-label {
            padding: .4rem 1.25rem;
            font-size: .65rem;
            font-weight: 700;
            color: rgba(255,255,255,.3);
            text-transform: uppercase;
            letter-spacing: .12em;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .55rem 1.25rem;
            color: rgba(255,255,255,.65);
            text-decoration: none;
            font-size: .85rem;
            transition: all .15s;
            border-left: 3px solid transparent;
        }

        .nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,.06);
        }

        .nav-link.active {
            color: #fff;
            border-left-color: var(--c-accent);
            background: rgba(255,255,255,.08);
        }

        .nav-link .icon { font-size: 1rem; width: 1.2rem; text-align: center; }

        .sidebar-footer {
            margin-top: auto;
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,.08);
        }

        .sidebar-footer form button {
            background: none;
            border: 1px solid rgba(255,255,255,.2);
            color: rgba(255,255,255,.5);
            padding: .45rem .9rem;
            border-radius: var(--radius);
            font-size: .8rem;
            cursor: pointer;
            width: 100%;
            transition: all .15s;
        }

        .sidebar-footer form button:hover {
            border-color: rgba(255,255,255,.4);
            color: rgba(255,255,255,.8);
        }

        /* ── Main ── */
        .main-wrap {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .topbar {
            height: var(--topbar-h);
            background: var(--c-white);
            border-bottom: 1px solid var(--c-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.75rem;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--c-text);
        }

        .topbar-user {
            font-size: .8rem;
            color: var(--c-muted);
        }

        .main-content {
            flex: 1;
            padding: 2rem 1.75rem;
            max-width: 1200px;
        }

        /* ── Flash ── */
        .flash {
            padding: .75rem 1rem;
            border-radius: var(--radius);
            margin-bottom: 1.5rem;
            font-size: .875rem;
            font-weight: 500;
        }

        .flash-success { background: #f0fdf4; border: 1px solid #86efac; color: #166534; }
        .flash-error   { background: #fef2f2; border: 1px solid #fca5a5; color: #b91c1c; }
        .flash-info    { background: #eff6ff; border: 1px solid #93c5fd; color: #1d4ed8; }

        /* ── Cards / Stats ── */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--c-white);
            border-radius: var(--radius);
            padding: 1.25rem 1rem;
            border: 1px solid var(--c-border);
        }

        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--c-text);
            line-height: 1;
        }

        .stat-card .stat-label {
            font-size: .75rem;
            color: var(--c-muted);
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-top: .4rem;
        }

        /* ── Tables ── */
        .table-wrap {
            background: var(--c-white);
            border-radius: var(--radius);
            border: 1px solid var(--c-border);
            overflow: hidden;
        }

        .table-wrap table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-wrap th {
            background: #f9fafb;
            padding: .6rem 1rem;
            text-align: left;
            font-size: .75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--c-muted);
            border-bottom: 1px solid var(--c-border);
        }

        .table-wrap td {
            padding: .7rem 1rem;
            border-bottom: 1px solid var(--c-border);
            font-size: .875rem;
            vertical-align: middle;
        }

        .table-wrap tr:last-child td { border-bottom: none; }
        .table-wrap tr:hover td { background: #fafaf9; }

        /* ── Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .5rem 1rem;
            border-radius: var(--radius);
            font-size: .85rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            border: none;
            transition: all .15s;
        }

        .btn-primary   { background: var(--c-sidebar); color: #fff; }
        .btn-primary:hover { background: #2d3f55; }
        .btn-secondary { background: var(--c-white); color: var(--c-text); border: 1px solid var(--c-border); }
        .btn-secondary:hover { background: #f9fafb; }
        .btn-danger    { background: #fef2f2; color: #b91c1c; border: 1px solid #fca5a5; }
        .btn-danger:hover { background: #fee2e2; }
        .btn-sm { padding: .35rem .75rem; font-size: .8rem; }

        /* ── Form elements ── */
        .form-group { margin-bottom: 1.25rem; }
        .form-label {
            display: block;
            font-size: .8rem;
            font-weight: 600;
            color: #4a5568;
            margin-bottom: .4rem;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .form-control {
            width: 100%;
            padding: .65rem .9rem;
            border: 1.5px solid var(--c-border);
            border-radius: var(--radius);
            font-size: .9rem;
            color: var(--c-text);
            background: #fafafa;
            transition: border-color .2s;
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--c-accent);
            background: var(--c-white);
        }

        textarea.form-control { resize: vertical; min-height: 100px; }

        select.form-control { cursor: pointer; }

        .form-hint {
            font-size: .75rem;
            color: var(--c-muted);
            margin-top: .3rem;
        }

        /* ── Badges ── */
        .badge {
            display: inline-block;
            padding: .2rem .5rem;
            border-radius: 4px;
            font-size: .7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .badge-green  { background: #d1fae5; color: #065f46; }
        .badge-red    { background: #fee2e2; color: #991b1b; }
        .badge-yellow { background: #fef3c7; color: #92400e; }
        .badge-blue   { background: #dbeafe; color: #1e40af; }
        .badge-gray   { background: #f3f4f6; color: #374151; }

        /* ── Page header ── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.75rem;
        }

        .page-header h1 {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 1.6rem;
            font-weight: 600;
            color: var(--c-text);
        }

        .section-title {
            font-size: .8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--c-muted);
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <h2>Villa Plaisance</h2>
        <span>Administration</span>
    </div>

    <nav>
        <?php
        $currentPath = trim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
        function navActive(string $path, string $current): string {
            return str_starts_with($current, $path) ? ' active' : '';
        }
        ?>

        <div class="nav-section">
            <div class="nav-section-label">Principal</div>
            <a href="/admin" class="nav-link<?= navActive('admin', $currentPath) === ' active' && $currentPath === 'admin' ? ' active' : '' ?>">
                <span class="icon">⊞</span> Dashboard
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-label">Pages</div>
            <?php
            $navPages = \Database::fetchAll(
                "SELECT slug, title FROM vp_pages WHERE lang = 'fr'
                 AND slug NOT IN ('mentions-legales','politique-confidentialite')
                 ORDER BY FIELD(slug,'accueil','chambres-d-hotes','location-villa-provence','journal','sur-place','contact')"
            );
            foreach ($navPages as $np):
                $label = $np['title'] ?: $np['slug'];
                // Raccourcis d'affichage
                $label = match($np['slug']) {
                    'accueil'                   => 'Accueil',
                    'chambres-d-hotes'          => 'Chambres d\'hôtes',
                    'location-villa-provence'   => 'Villa',
                    'journal'                   => 'Journal',
                    'sur-place'                 => 'Sur Place',
                    'contact'                   => 'Contact',
                    default                     => $np['title'] ?: $np['slug'],
                };
            ?>
            <a href="/admin/pages/<?= htmlspecialchars($np['slug']) ?>"
               class="nav-link<?= navActive('admin/pages/' . $np['slug'], $currentPath) ?>">
                <span class="icon">◻</span> <?= htmlspecialchars($label) ?>
            </a>
            <?php endforeach; ?>
        </div>

        <div class="nav-section">
            <div class="nav-section-label">Contenus</div>
            <a href="/admin/pieces" class="nav-link<?= navActive('admin/pieces', $currentPath) ?>">
                <span class="icon">⬡</span> Pièces
            </a>
            <a href="/admin/avis" class="nav-link<?= navActive('admin/avis', $currentPath) ?>">
                <span class="icon">★</span> Avis clients
            </a>
            <a href="/admin/articles" class="nav-link<?= navActive('admin/articles', $currentPath) ?>">
                <span class="icon">✎</span> Articles
            </a>
            <a href="/admin/faq" class="nav-link<?= navActive('admin/faq', $currentPath) ?>">
                <span class="icon">?</span> FAQ
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-label">Médias</div>
            <a href="/admin/media" class="nav-link<?= navActive('admin/media', $currentPath) ?>">
                <span class="icon">▦</span> Médiathèque
            </a>
        </div>
    </nav>

    <div class="sidebar-footer">
        <div style="font-size:.75rem;color:rgba(255,255,255,.4);margin-bottom:.5rem;">
            <?= htmlspecialchars($_SESSION['admin_user_name'] ?? '') ?>
        </div>
        <form method="POST" action="/admin/deconnexion">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
            <button type="submit">Déconnexion</button>
        </form>
    </div>
</aside>

<!-- Main -->
<div class="main-wrap">
    <header class="topbar">
        <span class="topbar-title"><?= htmlspecialchars($pageTitle ?? '') ?></span>
        <span class="topbar-user">vp.villaplaisance.fr</span>
    </header>

    <main class="main-content">
        <?php if (!empty($flash)): ?>
            <div class="flash flash-<?= htmlspecialchars($flash['type']) ?>">
                <?= htmlspecialchars($flash['message']) ?>
            </div>
        <?php endif; ?>

        <?= $pageContent ?>
    </main>
</div>

</body>
</html>
