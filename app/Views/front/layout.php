<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang ?? 'fr') ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= isset($seo) ? $seo->renderHead() : '' ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>

<header class="site-header" id="site-header">
    <div class="header-inner">
        <a href="<?= navUrl('accueil', $lang ?? 'fr') ?>" class="logo" aria-label="Villa Plaisance — Accueil">
            Villa Plaisance<span>Bédarrides · Vaucluse</span>
        </a>

        <button class="nav-toggle" id="nav-toggle" aria-label="Menu" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>

        <nav class="main-nav" id="main-nav" role="navigation" aria-label="Navigation principale">
            <ul class="nav-links">
                <li><a href="<?= navUrl('accueil', $lang ?? 'fr') ?>"><?= t('nav.accueil') ?></a></li>
                <li><a href="<?= navUrl('chambres', $lang ?? 'fr') ?>"><?= t('nav.chambres') ?></a></li>
                <li><a href="<?= navUrl('villa', $lang ?? 'fr') ?>"><?= t('nav.villa') ?></a></li>
                <li><a href="<?= navUrl('journal', $lang ?? 'fr') ?>"><?= t('nav.journal') ?></a></li>
                <li><a href="<?= navUrl('sur-place', $lang ?? 'fr') ?>"><?= t('nav.sur_place') ?></a></li>
                <li><a href="<?= navUrl('contact', $lang ?? 'fr') ?>" class="nav-cta"><?= t('nav.contact') ?></a></li>
            </ul>
        </nav>

        <div class="lang-switcher">
            <a href="/" class="<?= ($lang ?? 'fr') === 'fr' ? 'active' : '' ?>">FR</a>
            <a href="/en/" class="<?= ($lang ?? 'fr') === 'en' ? 'active' : '' ?>">EN</a>
        </div>
    </div>
</header>

<main id="main-content">
    <?= $content ?? '' ?>
</main>

<footer class="site-footer">
    <div class="footer-inner">
        <div>
            <p class="footer-brand">Villa Plaisance</p>
            <p class="footer-tagline">Maison d'hôtes · Bédarrides, Vaucluse</p>
        </div>
        <ul class="footer-links">
            <li><a href="<?= navUrl('chambres', $lang ?? 'fr') ?>">Chambres d'hôtes</a></li>
            <li><a href="<?= navUrl('villa', $lang ?? 'fr') ?>">Villa entière</a></li>
            <li><a href="<?= navUrl('journal', $lang ?? 'fr') ?>">Journal</a></li>
            <li><a href="<?= navUrl('sur-place', $lang ?? 'fr') ?>">Sur place</a></li>
            <li><a href="<?= navUrl('contact', $lang ?? 'fr') ?>">Contact</a></li>
        </ul>
    </div>
    <div class="footer-bottom">
        <span>&copy; <?= date('Y') ?> Villa Plaisance</span>
        <span>
            <a href="/mentions-legales">Mentions légales</a>
            &nbsp;·&nbsp;
            <a href="/politique-confidentialite">Confidentialité</a>
        </span>
    </div>
</footer>

<script src="/assets/js/app.js"></script>
</body>
</html>
