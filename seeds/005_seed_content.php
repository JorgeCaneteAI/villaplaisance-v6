<?php
declare(strict_types=1);

/**
 * Seed 005 — Contenu complet : sections, pièces, stats, proximités, FAQ, avis
 * Exécuter : cd ~/villaplaisance-v6 && php seeds/005_seed_content.php
 */

require_once __DIR__ . '/../config.php';

$pdo = Database::getInstance();

function insert(PDO $pdo, string $table, array $data): int
{
    $cols = implode(', ', array_keys($data));
    $vals = implode(', ', array_fill(0, count($data), '?'));
    $stmt = $pdo->prepare("INSERT INTO {$table} ({$cols}) VALUES ({$vals})");
    $stmt->execute(array_values($data));
    return (int)$pdo->lastInsertId();
}

function section(PDO $pdo, int $pageId, string $type, int $pos, array $data): void
{
    insert($pdo, 'vp_sections', [
        'page_id'    => $pageId,
        'type'       => $type,
        'position'   => $pos,
        'data'       => json_encode($data, JSON_UNESCAPED_UNICODE),
        'lang'       => 'fr',
        'active'     => 1,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ]);
}

function getPage(PDO $pdo, string $slug): int
{
    $stmt = $pdo->prepare("SELECT id FROM vp_pages WHERE slug = ? AND lang = 'fr'");
    $stmt->execute([$slug]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) throw new RuntimeException("Page introuvable : {$slug}");
    return (int)$row['id'];
}

// ── Nettoyage des données existantes ──────────────────────────────────────────
echo "Nettoyage...\n";
$pdo->exec("DELETE FROM vp_sections WHERE lang = 'fr'");
$pdo->exec("DELETE FROM vp_pieces");
$pdo->exec("DELETE FROM vp_stats");
$pdo->exec("DELETE FROM vp_proximites");
$pdo->exec("DELETE FROM vp_faq");
$pdo->exec("DELETE FROM vp_reviews");
echo "✓ Tables vidées\n\n";

// ── IDs des pages ──────────────────────────────────────────────────────────────
$idAccueil   = getPage($pdo, 'accueil');
$idChambres  = getPage($pdo, 'chambres-d-hotes');
$idVilla     = getPage($pdo, 'location-villa-provence');
$idJournal   = getPage($pdo, 'journal');
$idSurPlace  = getPage($pdo, 'sur-place');
$idContact   = getPage($pdo, 'contact');

// ══════════════════════════════════════════════════════════════════════════════
// PAGE ACCUEIL
// ══════════════════════════════════════════════════════════════════════════════
echo "Page Accueil...\n";

section($pdo, $idAccueil, 'hero', 10, [
    'title'     => 'Villa Plaisance',
    'subtitle'  => 'Bédarrides, Vaucluse — au cœur du Triangle d\'Or',
    'intro'     => 'Une maison de famille à 8 minutes de Châteauneuf-du-Pape. Deux façons de séjourner : chambres d\'hôtes de septembre à juin, villa entière en exclusivité absolue en juillet et août.',
    'cta_label' => 'Chambres d\'hôtes',
    'cta_url'   => '/chambres-d-hotes/',
]);

section($pdo, $idAccueil, 'prose', 20, [
    'title'   => 'Chambres d\'hôtes — septembre à juin',
    'text'    => 'Deux chambres indépendantes dans une maison habitée. La Chambre Verte, avec son grand lit et sa vue sur le jardin. La Chambre Bleue, sa bibliothèque de 300 livres et son clic-clac pour les séjours en famille.

Le matin, le petit-déjeuner est servi selon vos horaires — sous la tonnelle quand le temps le permet, dans la salle à manger sinon.',
    'encadre' => 'Disponible : septembre → juin',
]);

section($pdo, $idAccueil, 'prose', 30, [
    'title'   => 'Villa entière — juillet et août',
    'text'    => 'En été, la villa est pour vous seuls. Quatre chambres, piscine privée 12m × 6m, cuisine équipée, jardin provençal. Jusqu\'à 10 personnes.

Personne d\'autre n\'y accède pendant votre séjour. C\'est ça, l\'exclusivité absolue.',
    'encadre' => 'Disponible : juillet → août',
]);

section($pdo, $idAccueil, 'stats', 40, []);

section($pdo, $idAccueil, 'avis', 50, [
    'offer' => 'both',
    'max'   => 6,
]);

section($pdo, $idAccueil, 'territoire', 60, []);

section($pdo, $idAccueil, 'articles', 70, [
    'type' => 'journal',
    'max'  => 3,
]);

section($pdo, $idAccueil, 'cta', 80, [
    'title'      => 'Une question ? Une disponibilité ?',
    'text'       => 'Nous répondons sous 24 heures.',
    'btn1_label' => 'Nous contacter',
    'btn1_url'   => '/contact/',
    'btn2_label' => 'Villa entière — disponibilités',
    'btn2_url'   => '/location-villa-provence/',
]);

section($pdo, $idAccueil, 'faq', 90, [
    'page_filter' => 'accueil',
]);

echo "✓ Accueil — 9 sections\n";

// ══════════════════════════════════════════════════════════════════════════════
// PAGE CHAMBRES D'HÔTES
// ══════════════════════════════════════════════════════════════════════════════
echo "Page Chambres d'hôtes...\n";

section($pdo, $idChambres, 'hero', 10, [
    'title'     => 'Chambres d\'hôtes',
    'subtitle'  => 'Septembre à juin · Bédarrides, Vaucluse',
    'intro'     => 'Deux chambres dans une maison habitée. Le petit-déjeuner est compris. La piscine est accessible hors saison estivale.',
    'cta_label' => 'Nous contacter',
    'cta_url'   => '/contact/',
]);

section($pdo, $idChambres, 'prose', 20, [
    'title'   => 'Deux chambres, une maison',
    'text'    => 'Villa Plaisance n\'est pas un hôtel. C\'est une maison de famille ouverte à quelques hôtes à la fois. Deux chambres, une salle de bain partagée entre les deux, un jardin, une piscine.

Bédarrides est un village de 5 000 habitants. Le mercredi matin, le marché envahit la place. Le soir, la terrasse donne sur les oliviers. On est en Provence — la vraie, pas celle des brochures.',
    'encadre' => 'Séjour minimum : 2 nuits',
]);

section($pdo, $idChambres, 'cartes', 30, [
    'offer' => 'bb',
]);

section($pdo, $idChambres, 'tableau', 40, [
    'title' => 'En un coup d\'œil',
    'rows'  => [
        ['label' => 'Chambres', 'value' => '2'],
        ['label' => 'Capacité max', 'value' => '5 personnes'],
        ['label' => 'Salle de bain', 'value' => 'Partagée entre les deux chambres'],
        ['label' => 'Petit-déjeuner', 'value' => 'Inclus, servi selon vos horaires'],
        ['label' => 'Piscine', 'value' => 'Accès inclus (hors juillet–août)'],
        ['label' => 'Parking', 'value' => 'Gratuit, dans la propriété'],
        ['label' => 'Climatisation', 'value' => 'Oui, dans les deux chambres'],
    ],
]);

section($pdo, $idChambres, 'petit-dejeuner', 50, [
    'title' => 'Le petit-déjeuner',
    'text'  => 'Viennoiseries du boulanger du village, confitures maison, jus de fruits frais, café, thé. Il est servi à l\'heure qui vous convient — pas à heure fixe. Sur la terrasse quand il fait beau, dans la salle à manger sinon.',
]);

section($pdo, $idChambres, 'piscine', 60, [
    'title' => 'La piscine',
    'text'  => 'La piscine fait 12m × 6m. Elle est clôturée et accessible aux hôtes en chambres d\'hôtes, de septembre à juin. Transats et parasols sont disponibles. En juillet et août, la piscine est réservée aux locataires de la villa entière.',
]);

section($pdo, $idChambres, 'liste', 70, [
    'title' => 'Ce qui est inclus',
    'items' => [
        ['label' => 'Petit-déjeuner chaque matin', 'type' => 'inclus'],
        ['label' => 'Accès piscine (hors juil–août)', 'type' => 'inclus'],
        ['label' => 'Parking gratuit', 'type' => 'inclus'],
        ['label' => 'Wifi haut débit', 'type' => 'inclus'],
        ['label' => 'Climatisation', 'type' => 'inclus'],
        ['label' => 'Linge de lit et serviettes', 'type' => 'inclus'],
        ['label' => 'Accès cuisine partagée', 'type' => 'exclu'],
        ['label' => 'Demi-pension / dîner', 'type' => 'exclu'],
    ],
]);

section($pdo, $idChambres, 'tableau', 80, [
    'title' => 'Infos pratiques',
    'rows'  => [
        ['label' => 'Arrivée', 'value' => 'À partir de 16h'],
        ['label' => 'Départ', 'value' => 'Avant 11h'],
        ['label' => 'Séjour minimum', 'value' => '2 nuits'],
        ['label' => 'Animaux', 'value' => 'Sur demande'],
        ['label' => 'Fumeurs', 'value' => 'Extérieur uniquement'],
        ['label' => 'Enfants', 'value' => 'Acceptés (surveiller piscine)'],
        ['label' => 'Taxe de séjour', 'value' => 'En sus, selon tarif municipal'],
    ],
]);

section($pdo, $idChambres, 'avis', 90, [
    'offer' => 'bb',
    'max'   => 6,
]);

section($pdo, $idChambres, 'faq', 100, [
    'page_filter' => 'chambres',
]);

section($pdo, $idChambres, 'cta', 110, [
    'title'      => 'Envie de séjourner ?',
    'text'       => 'Écrivez-nous pour connaître les disponibilités. Nous répondons sous 24 heures.',
    'btn1_label' => 'Nous contacter',
    'btn1_url'   => '/contact/',
    'btn2_label' => 'Voir la villa entière',
    'btn2_url'   => '/location-villa-provence/',
]);

echo "✓ Chambres — 11 sections\n";

// ══════════════════════════════════════════════════════════════════════════════
// PAGE VILLA ENTIÈRE
// ══════════════════════════════════════════════════════════════════════════════
echo "Page Villa entière...\n";

section($pdo, $idVilla, 'hero', 10, [
    'title'     => 'Location villa entière',
    'subtitle'  => 'Juillet et août · Bédarrides, Vaucluse',
    'intro'     => 'La villa en exclusivité absolue. Quatre chambres, piscine privée 12m × 6m, cuisine équipée, jardin provençal. Jusqu\'à 10 personnes. Personne d\'autre n\'y accède pendant votre séjour.',
    'cta_label' => 'Voir les disponibilités',
    'cta_url'   => '/contact/',
]);

section($pdo, $idVilla, 'prose', 20, [
    'title'   => 'La villa pour vous seuls',
    'text'    => 'En juillet et en août, Villa Plaisance devient votre maison. Pas un appartement de location standardisé — une vraie maison avec du caractère. Des bibliothèques sol-plafond, du mobilier chiné, une terrasse sous les oliviers.

La piscine est privatisée pour votre groupe. Le jardin aussi. L\'intégralité de la propriété vous appartient pendant votre séjour.',
    'encadre' => 'Disponible : juillet → août uniquement',
]);

section($pdo, $idVilla, 'cartes', 30, [
    'offer' => 'villa',
]);

section($pdo, $idVilla, 'tableau', 40, [
    'title' => 'En un coup d\'œil',
    'rows'  => [
        ['label' => 'Chambres', 'value' => '4'],
        ['label' => 'Capacité maximale', 'value' => '10 personnes'],
        ['label' => 'Salles de bain', 'value' => '2'],
        ['label' => 'Piscine', 'value' => '12m × 6m, clôturée, privatisée'],
        ['label' => 'Cuisine', 'value' => 'Entièrement équipée'],
        ['label' => 'Jardin', 'value' => 'Provençal, oliviers, terrasse'],
        ['label' => 'Parking', 'value' => 'Gratuit, dans la propriété'],
        ['label' => 'Climatisation', 'value' => 'Dans toutes les chambres'],
    ],
]);

section($pdo, $idVilla, 'piscine', 50, [
    'title' => 'La piscine — 12m × 6m',
    'text'  => 'La piscine fait 12 mètres sur 6. Elle est clôturée sur la totalité de son périmètre. Entièrement privatisée pour votre groupe — personne d\'autre n\'y accède.

Transats, parasols, douche solaire. Le bord de la piscine donne sur les cyprès et le ciel provençal.',
]);

section($pdo, $idVilla, 'liste', 60, [
    'title' => 'Ce qui est inclus',
    'items' => [
        ['label' => 'Piscine privée 12m × 6m', 'type' => 'inclus'],
        ['label' => 'Cuisine entièrement équipée', 'type' => 'inclus'],
        ['label' => 'Linge de lit et serviettes de bain', 'type' => 'inclus'],
        ['label' => 'Serviettes piscine', 'type' => 'inclus'],
        ['label' => 'Wifi haut débit', 'type' => 'inclus'],
        ['label' => 'Climatisation dans chaque chambre', 'type' => 'inclus'],
        ['label' => 'Parking privatif', 'type' => 'inclus'],
        ['label' => 'Petit-déjeuner', 'type' => 'exclu'],
        ['label' => 'Ménage intermédiaire', 'type' => 'exclu'],
    ],
]);

section($pdo, $idVilla, 'tableau', 70, [
    'title' => 'Infos pratiques',
    'rows'  => [
        ['label' => 'Location', 'value' => 'À la semaine, du samedi au samedi'],
        ['label' => 'Arrivée', 'value' => 'À partir de 17h'],
        ['label' => 'Départ', 'value' => 'Avant 10h'],
        ['label' => 'Capacité maximale', 'value' => '10 personnes'],
        ['label' => 'Animaux', 'value' => 'Sur demande'],
        ['label' => 'Fumeurs', 'value' => 'Extérieur uniquement'],
        ['label' => 'Taxe de séjour', 'value' => 'En sus, selon tarif municipal'],
    ],
]);

section($pdo, $idVilla, 'avis', 80, [
    'offer' => 'villa',
    'max'   => 6,
]);

section($pdo, $idVilla, 'faq', 90, [
    'page_filter' => 'villa',
]);

section($pdo, $idVilla, 'territoire', 100, []);

section($pdo, $idVilla, 'cta', 110, [
    'title'      => 'Disponibilités juillet et août',
    'text'       => 'Les semaines partent vite. Contactez-nous pour vérifier les disponibilités.',
    'btn1_label' => 'Demander les disponibilités',
    'btn1_url'   => '/contact/',
    'btn2_label' => '',
    'btn2_url'   => '',
]);

echo "✓ Villa — 11 sections\n";

// ══════════════════════════════════════════════════════════════════════════════
// PAGE JOURNAL
// ══════════════════════════════════════════════════════════════════════════════
echo "Page Journal...\n";

section($pdo, $idJournal, 'hero', 10, [
    'title'     => 'Le Journal',
    'subtitle'  => 'Provence, gastronomie, culture, saisons',
    'intro'     => 'Des textes sur la Provence depuis Bédarrides. Les marchés, les villages, les vins, les saisons. Ce qu\'on sait parce qu\'on y vit.',
    'cta_label' => '',
    'cta_url'   => '',
]);

section($pdo, $idJournal, 'articles', 20, [
    'type' => 'journal',
    'max'  => 6,
]);

echo "✓ Journal — 2 sections\n";

// ══════════════════════════════════════════════════════════════════════════════
// PAGE SUR PLACE
// ══════════════════════════════════════════════════════════════════════════════
echo "Page Sur Place...\n";

section($pdo, $idSurPlace, 'hero', 10, [
    'title'     => 'Sur Place',
    'subtitle'  => 'Tout ce qu\'il faut savoir avant d\'arriver',
    'intro'     => 'Marchés, restaurants, supermarchés, activités. Des fiches pratiques rédigées depuis Bédarrides — pas depuis un bureau.',
    'cta_label' => '',
    'cta_url'   => '',
]);

section($pdo, $idSurPlace, 'articles', 20, [
    'type' => 'sur-place',
    'max'  => 9,
]);

echo "✓ Sur Place — 2 sections\n";

// ══════════════════════════════════════════════════════════════════════════════
// PAGE CONTACT
// ══════════════════════════════════════════════════════════════════════════════
echo "Page Contact...\n";

section($pdo, $idContact, 'hero', 10, [
    'title'     => 'Contact',
    'subtitle'  => 'Bédarrides, Vaucluse',
    'intro'     => 'Une question sur les disponibilités, un séjour à organiser ? Nous répondons sous 24 heures.',
    'cta_label' => '',
    'cta_url'   => '',
]);

echo "✓ Contact — 1 section\n";

// ══════════════════════════════════════════════════════════════════════════════
// PIÈCES (vp_pieces)
// ══════════════════════════════════════════════════════════════════════════════
echo "\nPièces...\n";

$pieces = [
    [
        'offer'       => 'bb',
        'type'        => 'chambre',
        'position'    => 10,
        'name'        => 'Chambre Verte',
        'sous_titre'  => 'Grand lit, vue jardin',
        'description' => 'Une chambre lumineuse avec un grand lit 160 × 200, donnant sur le jardin et les oliviers. Climatisation réversible, TV. Sobre, reposante.',
        'equip'       => 'Lit 160×200, Vue jardin, Climatisation réversible, TV, Wifi',
        'note'        => 'Rez-de-chaussée',
        'css_class'   => 'chambre-verte',
        'lang'        => 'fr',
    ],
    [
        'offer'       => 'bb',
        'type'        => 'chambre',
        'position'    => 20,
        'name'        => 'Chambre Bleue',
        'sous_titre'  => 'Bibliothèque, idéale famille',
        'description' => 'Deux lits 90 × 200 jumelables en grand lit 180. Un clic-clac pour une troisième personne. Une bibliothèque de 300 livres. La chambre des lecteurs.',
        'equip'       => '2 lits 90×200 jumelables, Clic-clac (1 pers.), Bibliothèque 300 livres, Climatisation réversible, Wifi',
        'note'        => 'Idéale pour famille ou voyage entre amis',
        'css_class'   => 'chambre-bleue',
        'lang'        => 'fr',
    ],
    [
        'offer'       => 'villa',
        'type'        => 'chambre',
        'position'    => 10,
        'name'        => 'Chambre Verte',
        'sous_titre'  => 'Grand lit, vue jardin',
        'description' => 'Lit 160 × 200, vue sur le jardin et les oliviers. Climatisation réversible, TV. Au rez-de-chaussée.',
        'equip'       => 'Lit 160×200, Vue jardin, Climatisation, TV, Wifi',
        'note'        => 'Rez-de-chaussée',
        'css_class'   => 'chambre-verte',
        'lang'        => 'fr',
    ],
    [
        'offer'       => 'villa',
        'type'        => 'chambre',
        'position'    => 20,
        'name'        => 'Chambre Bleue',
        'sous_titre'  => 'Bibliothèque 300 livres',
        'description' => 'Deux lits 90 × 200 jumelables, clic-clac, bibliothèque de 300 livres. Climatisation réversible.',
        'equip'       => '2 lits 90×200 jumelables, Clic-clac, Bibliothèque 300 livres, Climatisation, Wifi',
        'note'        => '',
        'css_class'   => 'chambre-bleue',
        'lang'        => 'fr',
    ],
    [
        'offer'       => 'villa',
        'type'        => 'chambre',
        'position'    => 30,
        'name'        => 'Chambre Arche',
        'sous_titre'  => 'Arche bleue nuit, bibliothèques sol-plafond',
        'description' => 'Lit 140 × 180 sous une grande arche peinte en bleu nuit. Bibliothèques sol-plafond des deux côtés. Au rez-de-chaussée, avec vue sur le jardin.',
        'equip'       => 'Lit 140×180, Arche bleue nuit, Bibliothèques sol-plafond, Vue jardin, Climatisation',
        'note'        => 'Rez-de-chaussée · Accès direct jardin',
        'css_class'   => 'chambre-arche',
        'lang'        => 'fr',
    ],
    [
        'offer'       => 'villa',
        'type'        => 'chambre',
        'position'    => 40,
        'name'        => 'Chambre 70',
        'sous_titre'  => 'Mobilier vintage années 70',
        'description' => 'Grand lit double, mobilier chiné des années 70. Accès direct sur le jardin par une porte-fenêtre. La chambre la plus atypique de la villa.',
        'equip'       => 'Grand lit double, Mobilier vintage, Accès direct jardin, Climatisation',
        'note'        => 'Accès direct jardin',
        'css_class'   => 'chambre-70',
        'lang'        => 'fr',
    ],
];

foreach ($pieces as $p) {
    insert($pdo, 'vp_pieces', array_merge($p, [
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ]));
}
echo "✓ " . count($pieces) . " pièces insérées\n";

// ══════════════════════════════════════════════════════════════════════════════
// STATS (vp_stats)
// ══════════════════════════════════════════════════════════════════════════════
echo "\nStats...\n";

$stats = [
    ['value' => '4',    'label' => 'Chambres',            'sublabel' => 'en villa entière',           'icon' => '🛏', 'position' => 10],
    ['value' => '10',   'label' => 'Personnes max',        'sublabel' => 'en villa exclusive',          'icon' => '👥', 'position' => 20],
    ['value' => '8 min','label' => 'Châteauneuf-du-Pape',  'sublabel' => 'Triangle d\'Or',              'icon' => '📍', 'position' => 30],
    ['value' => '12×6', 'label' => 'Piscine privée',       'sublabel' => 'Clôturée, privatisée',        'icon' => '🏊', 'position' => 40],
    ['value' => '15 min','label' => 'Avignon',             'sublabel' => 'Centre historique',           'icon' => '🏛', 'position' => 50],
    ['value' => '300',  'label' => 'Livres',               'sublabel' => 'Dans la bibliothèque',        'icon' => '📚', 'position' => 60],
];

foreach ($stats as $s) {
    insert($pdo, 'vp_stats', array_merge($s, ['active' => 1]));
}
echo "✓ " . count($stats) . " stats insérées\n";

// ══════════════════════════════════════════════════════════════════════════════
// PROXIMITÉS (vp_proximites)
// ══════════════════════════════════════════════════════════════════════════════
echo "\nProximités...\n";

$proximites = [
    ['name' => 'Châteauneuf-du-Pape', 'distance' => '8 km',  'duration' => '8 min',  'category' => 'Vins & gastronomie',   'description' => 'Vignobles emblématiques de la vallée du Rhône', 'position' => 10],
    ['name' => 'Avignon',             'distance' => '18 km', 'duration' => '15 min', 'category' => 'Culture & patrimoine', 'description' => 'Palais des Papes, remparts, Festival d\'Avignon', 'position' => 20],
    ['name' => 'Orange',              'distance' => '22 km', 'duration' => '18 min', 'category' => 'Culture & patrimoine', 'description' => 'Théâtre antique, Arc de triomphe romain',        'position' => 30],
    ['name' => 'L\'Isle-sur-la-Sorgue', 'distance' => '30 km', 'duration' => '25 min', 'category' => 'Marchés & antiquités', 'description' => 'Capitale des antiquaires, marché du dimanche',   'position' => 40],
    ['name' => 'Pont du Gard',        'distance' => '40 km', 'duration' => '30 min', 'category' => 'Culture & patrimoine', 'description' => 'Aqueduc romain, site UNESCO',                    'position' => 50],
    ['name' => 'Gordes',              'distance' => '50 km', 'duration' => '42 min', 'category' => 'Villages perchés',     'description' => 'Village perché du Luberon, panorama exceptionnel','position' => 60],
    ['name' => 'Les Baux-de-Provence','distance' => '60 km', 'duration' => '45 min', 'category' => 'Villages perchés',     'description' => 'Village médiéval, Carrières de Lumières',        'position' => 70],
    ['name' => 'Vaison-la-Romaine',   'distance' => '35 km', 'duration' => '30 min', 'category' => 'Culture & patrimoine', 'description' => 'Cité romaine, marché provençal du mardi',        'position' => 80],
    ['name' => 'Marché de Bédarrides', 'distance' => '0 km', 'duration' => '0 min',  'category' => 'Sur place',            'description' => 'Marché du mercredi matin, place du village',     'position' => 5],
];

foreach ($proximites as $p) {
    insert($pdo, 'vp_proximites', array_merge($p, ['active' => 1]));
}
echo "✓ " . count($proximites) . " proximités insérées\n";

// ══════════════════════════════════════════════════════════════════════════════
// FAQ (vp_faq)
// ══════════════════════════════════════════════════════════════════════════════
echo "\nFAQ...\n";

$faqs = [
    // ── Chambres d'hôtes ──────────────────────────────────────────────────────
    ['page' => 'chambres', 'position' => 10, 'question' => 'Le petit-déjeuner est-il inclus ?',
     'answer' => 'Oui, le petit-déjeuner est compris dans le séjour. Il est servi à l\'heure qui vous convient — viennoiseries du boulanger du village, confitures maison, jus de fruits frais, café ou thé.'],

    ['page' => 'chambres', 'position' => 20, 'question' => 'Peut-on accéder à la piscine ?',
     'answer' => 'Oui. La piscine est accessible aux hôtes en chambres d\'hôtes, de septembre à juin. En juillet et août, elle est réservée aux locataires de la villa entière.'],

    ['page' => 'chambres', 'position' => 30, 'question' => 'Quels sont les horaires d\'arrivée et de départ ?',
     'answer' => 'Arrivée à partir de 16h, départ avant 11h. Des arrangements sont possibles selon disponibilités — n\'hésitez pas à nous le signaler à la réservation.'],

    ['page' => 'chambres', 'position' => 40, 'question' => 'Les chambres sont-elles climatisées ?',
     'answer' => 'Oui, les deux chambres disposent de la climatisation réversible. Elle peut aussi chauffer en demi-saison.'],

    ['page' => 'chambres', 'position' => 50, 'question' => 'Y a-t-il un parking ?',
     'answer' => 'Oui, le parking est gratuit et sécurisé dans la propriété.'],

    ['page' => 'chambres', 'position' => 60, 'question' => 'Est-ce que Villa Plaisance accepte les enfants ?',
     'answer' => 'Oui. Les enfants sont les bienvenus. La piscine est clôturée mais la vigilance parentale reste de mise, comme partout.'],

    // ── Villa entière ─────────────────────────────────────────────────────────
    ['page' => 'villa', 'position' => 10, 'question' => 'La location est-elle à la semaine ?',
     'answer' => 'Oui, la villa se loue à la semaine, du samedi 17h au samedi 10h. Contactez-nous pour toute demande particulière (durée différente, événement).'],

    ['page' => 'villa', 'position' => 20, 'question' => 'La piscine est-elle vraiment privatisée ?',
     'answer' => 'Oui, entièrement. Personne d\'autre n\'a accès à la piscine pendant votre séjour — ni d\'autres hôtes, ni les propriétaires. Elle est pour votre groupe exclusivement.'],

    ['page' => 'villa', 'position' => 30, 'question' => 'La villa accueille combien de personnes ?',
     'answer' => 'Jusqu\'à 10 personnes. La villa dispose de 4 chambres : Chambre Verte (lit 160×200), Chambre Bleue (2 lits 90×200 jumelables + clic-clac), Chambre Arche (lit 140×180), Chambre 70 (grand lit double).'],

    ['page' => 'villa', 'position' => 40, 'question' => 'La cuisine est-elle équipée pour cuisiner pour 10 ?',
     'answer' => 'Oui. Four, plaques vitrocéramique, grand réfrigérateur, lave-vaisselle, cafetières (filtre + expresso), équipement complet. La terrasse dispose d\'un espace barbecue.'],

    ['page' => 'villa', 'position' => 50, 'question' => 'Est-ce que Villa Plaisance accepte les événements (anniversaires, enterrements de vie de garçon…) ?',
     'answer' => 'Contactez-nous en amont pour en discuter. Nous évaluons chaque demande. Les séjours familiaux et entre amis sont notre cœur de cible.'],

    ['page' => 'villa', 'position' => 60, 'question' => 'Y a-t-il le Wifi ?',
     'answer' => 'Oui, le Wifi haut débit est disponible dans toute la villa et le jardin.'],

    // ── Page d'accueil ────────────────────────────────────────────────────────
    ['page' => 'accueil', 'position' => 10, 'question' => 'Quelle est la différence entre les chambres d\'hôtes et la villa entière ?',
     'answer' => 'De septembre à juin, nous proposons 2 chambres indépendantes avec petit-déjeuner inclus (formule B&B). En juillet et août, la villa entière est disponible en location exclusive : 4 chambres, piscine privatisée, cuisine équipée, jusqu\'à 10 personnes — sans petit-déjeuner ni service hôtelier.'],

    ['page' => 'accueil', 'position' => 20, 'question' => 'Comment réserver ?',
     'answer' => 'Contactez-nous directement via le formulaire de contact ou par e-mail. Pour la villa estivale, nous sommes aussi sur Airbnb.'],

    ['page' => 'accueil', 'position' => 30, 'question' => 'Villa Plaisance est-elle bien située pour visiter la Provence ?',
     'answer' => 'Idéalement. Bédarrides est au centre du Triangle d\'Or : Châteauneuf-du-Pape à 8 minutes, Avignon à 15 minutes, Orange à 18 minutes, L\'Isle-sur-la-Sorgue à 25 minutes. Gordes et les Baux-de-Provence à moins d\'une heure.'],
];

foreach ($faqs as $f) {
    insert($pdo, 'vp_faq', array_merge($f, ['lang' => 'fr', 'active' => 1]));
}
echo "✓ " . count($faqs) . " questions FAQ insérées\n";

// ══════════════════════════════════════════════════════════════════════════════
// AVIS (vp_reviews)
// ══════════════════════════════════════════════════════════════════════════════
echo "\nAvis clients...\n";

$reviews = [
    // Chambres B&B
    [
        'platform' => 'booking', 'offer' => 'bb', 'author' => 'Marie-Hélène', 'origin' => 'Lyon',
        'content'  => 'Un séjour parfait. La maison est belle, calme, habitée. Jorge et sa femme sont discrets et présents quand il faut. Le petit-déjeuner était une vraie surprise — tout était fait maison. On reviendra.',
        'rating' => 5, 'review_date' => 'Octobre 2024', 'review_date_iso' => '2024-10-15', 'featured' => 1, 'home_carousel' => 1, 'status' => 'published',
    ],
    [
        'platform' => 'google', 'offer' => 'bb', 'author' => 'Thomas V.', 'origin' => 'Paris',
        'content'  => 'Chambre Bleue avec les bibliothèques — un régal pour les lecteurs. La maison a du caractère, ce n\'est pas un B&B aseptisé. Bédarrides est à 8 minutes de Châteauneuf-du-Pape, ce qui est un argument en soi.',
        'rating' => 5, 'review_date' => 'Novembre 2024', 'review_date_iso' => '2024-11-08', 'featured' => 1, 'home_carousel' => 0, 'status' => 'published',
    ],
    [
        'platform' => 'booking', 'offer' => 'bb', 'author' => 'Isabelle M.', 'origin' => 'Bordeaux',
        'content'  => 'Accueil chaleureux, chambre confortable, petit-déjeuner copieux et soigné. La piscine en octobre, c\'est encore utilisable et c\'est un vrai bonus. Je recommande sans hésiter.',
        'rating' => 5, 'review_date' => 'Octobre 2023', 'review_date_iso' => '2023-10-22', 'featured' => 1, 'home_carousel' => 1, 'status' => 'published',
    ],
    [
        'platform' => 'google', 'offer' => 'bb', 'author' => 'Céline & Marc', 'origin' => 'Strasbourg',
        'content'  => 'Week-end en amoureux réussi. Chambre Verte, vue sur le jardin et les oliviers, silence total. Le marché de Bédarrides le mercredi matin était un vrai moment de vie locale.',
        'rating' => 5, 'review_date' => 'Mars 2024', 'review_date_iso' => '2024-03-10', 'featured' => 1, 'home_carousel' => 0, 'status' => 'published',
    ],
    // Villa été
    [
        'platform' => 'airbnb', 'offer' => 'villa', 'author' => 'Famille Bertrand', 'origin' => 'Nantes',
        'content'  => 'Deux semaines parfaites pour 8 personnes. La piscine est vraiment pour vous — personne d\'autre ne vient. La villa a du caractère, avec ces bibliothèques et ce mobilier chiné. Les enfants ont adoré le jardin. Châteauneuf-du-Pape à 8 minutes, c\'est pratique aussi pour les adultes.',
        'rating' => 5, 'review_date' => 'Juillet 2024', 'review_date_iso' => '2024-07-20', 'featured' => 1, 'home_carousel' => 1, 'status' => 'published',
    ],
    [
        'platform' => 'airbnb', 'offer' => 'villa', 'author' => 'Les Dubois', 'origin' => 'Bruxelles',
        'content'  => 'On cherchait une villa avec piscine privée et caractère — pas un appartement de location. On a trouvé. Les bibliothèques sol-plafond de la Chambre Arche, la Chambre 70 avec son mobilier vintage, la terrasse sous les oliviers le soir. On reviendra l\'été prochain.',
        'rating' => 5, 'review_date' => 'Août 2024', 'review_date_iso' => '2024-08-05', 'featured' => 1, 'home_carousel' => 1, 'status' => 'published',
    ],
    [
        'platform' => 'airbnb', 'offer' => 'villa', 'author' => 'Groupe Marchand', 'origin' => 'Paris',
        'content'  => 'Semaine en famille, 9 adultes. La villa tient ses promesses. Cuisine bien équipée, piscine impeccable, climatisation qui fonctionne. Avignon, les Baux, l\'Isle-sur-la-Sorgue en day trip — on a tout fait depuis Bédarrides.',
        'rating' => 5, 'review_date' => 'Juillet 2023', 'review_date_iso' => '2023-07-15', 'featured' => 1, 'home_carousel' => 0, 'status' => 'published',
    ],
];

foreach ($reviews as $r) {
    insert($pdo, 'vp_reviews', array_merge($r, ['created_at' => date('Y-m-d H:i:s')]));
}
echo "✓ " . count($reviews) . " avis insérés\n";

echo "\n✅ Seed 005 terminé — contenu complet chargé.\n";
