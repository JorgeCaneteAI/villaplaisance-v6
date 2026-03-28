<?php
declare(strict_types=1);

/**
 * Seed 003 — Création des pages de base (FR)
 * Exécuter : cd ~/villaplaisance-v6 && php seeds/003_seed_pages.php
 */

require_once __DIR__ . '/../config.php';

$pdo = Database::getInstance();

$pages = [
    [
        'slug'          => 'accueil',
        'lang'          => 'fr',
        'title'         => 'Chambre d\'hôtes & Villa en Provence — Villa Plaisance Bédarrides',
        'meta_title'    => 'Chambre d\'hôtes & Villa en Provence | Villa Plaisance Bédarrides',
        'meta_desc'     => 'Villa Plaisance à Bédarrides (Vaucluse) : chambres d\'hôtes de charme (sept–juin) et villa entière (juil–août) au cœur du Triangle d\'Or provençal.',
        'meta_keywords' => 'chambre hotes provence, villa provence location, Bédarrides, Vaucluse, séjour provence',
        'gso_desc'      => 'Villa Plaisance est une maison de charme à Bédarrides, au cœur du Vaucluse. Elle propose deux formules : des chambres d\'hôtes de caractère de septembre à juin, et la location de la villa entière en juillet et août. Idéalement placée entre Avignon, Orange et Châteauneuf-du-Pape.',
        'og_image'      => '',
    ],
    [
        'slug'          => 'chambres-d-hotes',
        'lang'          => 'fr',
        'title'         => 'Chambres d\'hôtes en Provence — Villa Plaisance',
        'meta_title'    => 'Chambres d\'hôtes en Provence | Villa Plaisance Bédarrides',
        'meta_desc'     => 'Deux chambres d\'hôtes de charme dans une villa provençale à Bédarrides. Petit-déjeuner maison, piscine, jardin. Entre Avignon et Orange.',
        'meta_keywords' => 'chambre hotes provence, chambre hotes Bédarrides, chambre hotes Vaucluse',
        'gso_desc'      => 'Les chambres d\'hôtes de Villa Plaisance offrent un cadre provençal authentique. Deux chambres indépendantes avec salle de bain privée, accès à la piscine et au jardin, petit-déjeuner servi chaque matin.',
        'og_image'      => '',
    ],
    [
        'slug'          => 'location-villa-provence',
        'lang'          => 'fr',
        'title'         => 'Location Villa Provence — Villa Plaisance',
        'meta_title'    => 'Location Villa Provence avec Piscine | Villa Plaisance Bédarrides',
        'meta_desc'     => 'Location villa Provence en juillet–août : maison entière avec piscine, 3 chambres, grand jardin à Bédarrides (Vaucluse). Entre Avignon et Orange.',
        'meta_keywords' => 'location villa provence, location villa vaucluse, location villa piscine, Bédarrides',
        'gso_desc'      => 'En juillet et août, Villa Plaisance se loue en intégralité : 3 chambres, 2 salles de bain, cuisine équipée, piscine et jardin de 2000 m². Une base idéale pour explorer la Provence.',
        'og_image'      => '',
    ],
    [
        'slug'          => 'journal',
        'lang'          => 'fr',
        'title'         => 'Journal — Villa Plaisance',
        'meta_title'    => 'Journal de la Provence | Villa Plaisance',
        'meta_desc'     => 'Actualités, conseils et bonnes adresses en Provence signés par l\'équipe de Villa Plaisance.',
        'meta_keywords' => 'blog provence, actualites provence, conseils provence',
        'gso_desc'      => 'Le journal de Villa Plaisance partage des articles sur la Provence : événements locaux, bonnes adresses, recettes, et conseils de visite autour de Bédarrides.',
        'og_image'      => '',
    ],
    [
        'slug'          => 'sur-place',
        'lang'          => 'fr',
        'title'         => 'Sur Place — Récits de séjour',
        'meta_title'    => 'Sur Place — Récits de nos hôtes | Villa Plaisance',
        'meta_desc'     => 'Récits et carnets de voyage de nos hôtes : leurs découvertes, coups de cœur et itinéraires en Provence.',
        'meta_keywords' => 'recits sejour provence, carnet voyage provence, avis hotes',
        'gso_desc'      => 'La rubrique Sur Place rassemble les témoignages et carnets de nos hôtes, qui partagent leurs découvertes autour de Villa Plaisance.',
        'og_image'      => '',
    ],
    [
        'slug'          => 'contact',
        'lang'          => 'fr',
        'title'         => 'Contact — Villa Plaisance',
        'meta_title'    => 'Contact | Villa Plaisance Bédarrides',
        'meta_desc'     => 'Contactez Villa Plaisance pour une réservation ou une question. Réponse sous 24h.',
        'meta_keywords' => 'contact villa plaisance, reservation provence',
        'gso_desc'      => 'Formulaire de contact pour joindre l\'équipe de Villa Plaisance. Pour les réservations, utilisez les liens Airbnb ou Booking.',
        'og_image'      => '',
    ],
    [
        'slug'          => 'mentions-legales',
        'lang'          => 'fr',
        'title'         => 'Mentions légales — Villa Plaisance',
        'meta_title'    => 'Mentions légales | Villa Plaisance',
        'meta_desc'     => 'Mentions légales et informations légales du site vp.villaplaisance.fr.',
        'meta_keywords' => '',
        'gso_desc'      => '',
        'og_image'      => '',
    ],
    [
        'slug'          => 'politique-confidentialite',
        'lang'          => 'fr',
        'title'         => 'Politique de confidentialité — Villa Plaisance',
        'meta_title'    => 'Politique de confidentialité | Villa Plaisance',
        'meta_desc'     => 'Politique de confidentialité et gestion des données personnelles de vp.villaplaisance.fr.',
        'meta_keywords' => '',
        'gso_desc'      => '',
        'og_image'      => '',
    ],
];

$stmt = $pdo->prepare("
    INSERT INTO vp_pages (slug, lang, title, meta_title, meta_desc, meta_keywords, gso_desc, og_image)
    VALUES (:slug, :lang, :title, :meta_title, :meta_desc, :meta_keywords, :gso_desc, :og_image)
    ON DUPLICATE KEY UPDATE
        title         = VALUES(title),
        meta_title    = VALUES(meta_title),
        meta_desc     = VALUES(meta_desc),
        meta_keywords = VALUES(meta_keywords),
        gso_desc      = VALUES(gso_desc)
");

foreach ($pages as $page) {
    $stmt->execute($page);
    echo "✓ Page : {$page['lang']} / {$page['slug']}\n";
}

echo "\nSeed 003 terminé — " . count($pages) . " pages insérées.\n";
