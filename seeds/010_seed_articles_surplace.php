<?php
declare(strict_types=1);

/**
 * Seed 010 — Articles Sur Place (9 articles, format fiche pratique, infos vérifiées)
 * Exécuter : cd ~/villaplaisance-v6 && php seeds/010_seed_articles_surplace.php
 */

require_once __DIR__ . '/../config.php';

$pdo = Database::getInstance();

// ── Nettoyage des articles Sur Place existants ────────────────────────────────
$pdo->exec("DELETE FROM vp_articles WHERE type = 'sur-place' AND lang = 'fr'");
echo "✓ Articles Sur Place supprimés\n\n";

function art(PDO $pdo, array $d): void
{
    $cols = implode(', ', array_keys($d));
    $vals = implode(', ', array_fill(0, count($d), '?'));
    $pdo->prepare("INSERT INTO vp_articles ({$cols}) VALUES ({$vals})")->execute(array_values($d));
}

// ══════════════════════════════════════════════════════════════════════════════
// COMMERCES
// ══════════════════════════════════════════════════════════════════════════════

// ─── 01 — Commerces ───────────────────────────────────────────────────────────
$body01 = <<<HTML
<p class="article-lead">Faire ses courses à Bédarrides et dans les environs directs, c'est simple — à condition de savoir où aller. Voici les adresses qu'on donne à tous nos hôtes dès leur arrivée.</p>

<h2>Le Jardin des 3 Frères — le primeur du village</h2>
<p>C'est l'adresse incontournable à deux pas de Villa Plaisance. Fruits et légumes de saison, produits locaux, herbes aromatiques. Un vrai primeur de village, avec du choix et des prix cohérents.</p>

<div class="fiche-pratique">
    <h3>Infos pratiques</h3>
    <ul>
        <li><strong>Adresse :</strong> 47 avenue de Rascassa, 84370 Bédarrides</li>
        <li><strong>Tél :</strong> 04 90 88 14 54</li>
        <li><strong>Horaires :</strong> Lun–Jeu 8h30–12h30 / 14h–19h · Ven–Sam 8h30–19h (continu) · Dim fermé</li>
    </ul>
</div>

<h2>Intermarché SUPER Sorgues — la grande surface de référence</h2>
<p>À 5 km, c'est la grande surface la plus proche pour les courses complètes : alimentaire, hygiène, boissons, cave. Le rayon vins locaux est bien fourni — vins des Côtes-du-Rhône et quelques Châteauneuf-du-Pape à prix directs.</p>

<div class="fiche-pratique">
    <h3>Infos pratiques</h3>
    <ul>
        <li><strong>Adresse :</strong> 1258 Route d'Orange, Quai Avaux, 84700 Sorgues</li>
        <li><strong>Tél :</strong> 04 90 39 33 50</li>
        <li><strong>Horaires :</strong> Lun–Sam 8h30–19h30 · Dim 8h45–12h30</li>
        <li><strong>Distance :</strong> ~5 km de Villa Plaisance (~7 min)</li>
    </ul>
</div>

<h2>Le marché du mercredi — Bédarrides</h2>
<p>Chaque mercredi matin, le marché s'installe sur la place du village. Producteurs locaux, fruits et légumes de saison, fromages, olives. Ambiance village, sans les foules des marchés touristiques. C'est l'une des premières choses qu'on conseille à nos hôtes.</p>

<div class="fiche-pratique">
    <h3>Infos pratiques</h3>
    <ul>
        <li><strong>Lieu :</strong> Place du village, 84370 Bédarrides</li>
        <li><strong>Jour :</strong> Mercredi matin</li>
        <li><strong>Horaires :</strong> Dès 8h — termine vers 12h30</li>
    </ul>
</div>

<h2>Le marché du dimanche — Sorgues</h2>
<p>Plus grand, plus animé. Environ 150 étals sur le cours de la République. Marché partiellement couvert, avec producteurs et commercants non-alimentaires. Idéal si vous arrivez en week-end.</p>

<div class="fiche-pratique">
    <h3>Infos pratiques</h3>
    <ul>
        <li><strong>Lieu :</strong> Cours de la République (Place du Général de Gaulle), 84700 Sorgues</li>
        <li><strong>Jour :</strong> Dimanche matin</li>
        <li><strong>Horaires :</strong> 8h–13h</li>
        <li><strong>Distance :</strong> ~5 km de Villa Plaisance</li>
    </ul>
</div>

<div class="article-conseil">
    <strong>Notre conseil :</strong> En juillet–août, le marché de Sorgues le dimanche est plus fréquenté — arrivez avant 9h pour avoir le choix des producteurs et éviter la chaleur.
</div>

<section class="article-faq">
<h2>Questions fréquentes</h2>
<dl>
<dt>Y a-t-il une boulangerie à Bédarrides ?</dt>
<dd>Oui, le village dispose de sa propre boulangerie. Demandez l'adresse précise à votre arrivée — elle évolue selon les saisons.</dd>
<dt>Peut-on faire ses courses sans voiture ?</dt>
<dd>Le Jardin des 3 Frères est à pied depuis Villa Plaisance. Pour l'Intermarché, une voiture est nécessaire.</dd>
</dl>
</section>
HTML;

art($pdo, [
    'type'         => 'sur-place',
    'category'     => 'Commerces',
    'slug'         => 'courses-bedarrides-sorgues',
    'lang'         => 'fr',
    'title'        => 'Faire ses courses à Bédarrides et Sorgues : les adresses qu\'on donne à nos hôtes',
    'excerpt'      => 'Primeur, supermarché, marchés du mercredi et du dimanche. Les adresses vérifiées autour de Villa Plaisance pour faire ses courses sans chercher.',
    'content'      => json_encode(['body' => $body01], JSON_UNESCAPED_UNICODE),
    'meta_title'   => 'Courses à Bédarrides et Sorgues : marchés, primeur, supermarché',
    'meta_desc'    => 'Toutes les adresses pour faire ses courses à Bédarrides et Sorgues : Le Jardin des 3 Frères (primeur), Intermarché Sorgues, marchés du mercredi et du dimanche.',
    'meta_keywords'=> 'courses Bédarrides, marché Bédarrides mercredi, marché Sorgues dimanche, primeur Bédarrides, Intermarché Sorgues',
    'gso_desc'     => 'Guide pratique des commerces alimentaires à Bédarrides (84370) et Sorgues (84700) : primeur Le Jardin des 3 Frères, Intermarché, marché du mercredi à Bédarrides et marché du dimanche à Sorgues avec adresses et horaires vérifiés.',
    'og_image'     => '',
    'cover_image'  => '',
    'status'       => 'published',
    'published_at' => '2025-09-10 08:00:00',
]);

// ─── 02 — Commerces ───────────────────────────────────────────────────────────
$body02 = <<<HTML
<p class="article-lead">Deux adresses artisanales à moins de 20 minutes de Bédarrides. La première : une savonnerie depuis 1990. La seconde : la chocolaterie de Châteauneuf-du-Pape, avec ateliers pour petits et grands.</p>

<h2>Provence Azur — savonnerie artisanale depuis 1990</h2>
<p>À Entraigues-sur-la-Sorgue, Provence Azur fabrique savons, huiles essentielles et cosmétiques naturels depuis plus de trente ans. Boutique en direct, gamme complète, produits faits sur place. C'est le genre d'adresse qu'on ne trouve pas dans les circuits touristiques — et c'est exactement pour ça qu'elle vaut le détour.</p>

<div class="fiche-pratique">
    <h3>Infos pratiques</h3>
    <ul>
        <li><strong>Adresse :</strong> 1866 avenue des Valayans, 84320 Entraigues-sur-la-Sorgue</li>
        <li><strong>Tél :</strong> 04 90 12 18 45 · Port. : 06 60 82 22 48</li>
        <li><strong>Horaires :</strong><br>
            Lundi : Fermé<br>
            Mardi : 9h–12h<br>
            Mercredi–Vendredi : 9h–12h / 14h–19h<br>
            Samedi : 9h–12h / 14h–19h<br>
            Dimanche : Fermé
        </li>
        <li><strong>Distance :</strong> ~8 km de Villa Plaisance (~10 min)</li>
    </ul>
</div>

<h2>Chocolaterie Castelain — Châteauneuf-du-Pape</h2>
<p>À Châteauneuf-du-Pape, la Chocolaterie Castelain propose des chocolats artisanaux et des ateliers de fabrication ouverts à tous, dès 3 ans. Boutique sur place avec dégustation. Un détour facile à combiner avec une visite des vignobles — les deux sont sur la même route.</p>

<div class="fiche-pratique">
    <h3>Infos pratiques</h3>
    <ul>
        <li><strong>Adresse :</strong> 1745 route de Sorgues, 84230 Châteauneuf-du-Pape</li>
        <li><strong>Tél :</strong> 04 90 83 54 71</li>
        <li><strong>Email :</strong> boutiquegourmande@castelain.fr</li>
        <li><strong>Site :</strong> chocolat-castelain.fr</li>
        <li><strong>Horaires boutique :</strong> Lun–Sam 9h–12h30 / 13h30–18h</li>
        <li><strong>Ateliers :</strong> À partir de 15 € · Réservation via wineactivities.net</li>
        <li><strong>Distance :</strong> ~8 km de Villa Plaisance (~10 min)</li>
    </ul>
</div>

<div class="article-conseil">
    <strong>Notre conseil :</strong> Combinez Provence Azur et le marché de Sorgues le dimanche matin — les deux sont dans la même direction depuis Bédarrides.
</div>

<section class="article-faq">
<h2>Questions fréquentes</h2>
<dl>
<dt>Faut-il réserver pour les ateliers Castelain ?</dt>
<dd>Oui, la réservation est obligatoire via wineactivities.net. Les créneaux partent vite en haute saison — réservez en amont si vous avez des enfants.</dd>
<dt>Provence Azur vend-elle en ligne ?</dt>
<dd>Renseignez-vous directement par téléphone. La boutique physique est l'adresse principale.</dd>
</dl>
</section>
HTML;

art($pdo, [
    'type'         => 'sur-place',
    'category'     => 'Commerces',
    'slug'         => 'artisans-savonnerie-chocolaterie',
    'lang'         => 'fr',
    'title'        => 'Savonnerie et chocolaterie : deux adresses artisanales à ne pas rater',
    'excerpt'      => 'Provence Azur à Entraigues (savonnerie depuis 1990) et la Chocolaterie Castelain à Châteauneuf-du-Pape : deux artisans à moins de 15 minutes de Bédarrides, avec ateliers pour les enfants.',
    'content'      => json_encode(['body' => $body02], JSON_UNESCAPED_UNICODE),
    'meta_title'   => 'Savonnerie et chocolaterie artisanales près de Bédarrides',
    'meta_desc'    => 'Provence Azur à Entraigues (savons depuis 1990) et Chocolaterie Castelain à Châteauneuf-du-Pape : adresses, horaires et ateliers à moins de 15 min de Bédarrides.',
    'meta_keywords'=> 'savonnerie Provence, Provence Azur Entraigues, Chocolaterie Castelain Châteauneuf-du-Pape, artisanat Vaucluse, ateliers chocolat',
    'gso_desc'     => 'Présentation de deux artisans proches de Bédarrides : Provence Azur (savonnerie, 1866 avenue des Valayans, 84320 Entraigues-sur-la-Sorgue) et Chocolaterie Castelain (1745 route de Sorgues, 84230 Châteauneuf-du-Pape) avec ateliers fabrication chocolat dès 3 ans.',
    'og_image'     => '',
    'cover_image'  => '',
    'status'       => 'published',
    'published_at' => '2025-10-08 08:00:00',
]);


// ══════════════════════════════════════════════════════════════════════════════
// SITES À VISITER
// ══════════════════════════════════════════════════════════════════════════════

// ─── 03 — Sites à visiter ─────────────────────────────────────────────────────
$body03 = <<<HTML
<p class="article-lead">La Fontaine de Vaucluse est l'une des résurgences les plus puissantes au monde. Ce qu'on ne vous dit pas toujours : l'accès direct à la vasque est actuellement fermé, le village est bondé en août, et la meilleure façon de la voir demande quelques ajustements.</p>

<h2>Ce qu'est la Fontaine de Vaucluse</h2>
<p>C'est la résurgence d'un réseau souterrain qui s'étend sur plusieurs centaines de kilomètres dans le massif du Vaucluse. Le débit peut atteindre 200 m³/seconde en crue — c'est une des sources les plus abondantes d'Europe. Hors période de crue (surtout printemps et automne), le débit est nettement plus bas, mais le site reste impressionnant.</p>
<p>Le village de Fontaine-de-Vaucluse est traversé par la Sorgue — la rivière qui naît ici. Il accueille aussi le Musée Pétrarque (le poète y vécut plusieurs années) et plusieurs musées thématiques.</p>

<h2>Ce qu'il faut savoir avant d'y aller</h2>
<p><strong>L'accès direct à la vasque est actuellement fermé</strong> pour raisons de sécurité (risque d'éboulements). Le chemin le long de la rivière reste praticable jusqu'à une barrière en amont de la vasque. La résurgence est visible depuis ce point — mais pas depuis le bord comme avant.</p>
<p>En haute saison (juillet–août), le village est très fréquenté. Préférez une visite tôt le matin (avant 10h) ou en fin d'après-midi. Le parking payant est au bord du village — comptez une dizaine de minutes à pied jusqu'à la source.</p>

<div class="fiche-pratique">
    <h3>Infos pratiques</h3>
    <ul>
        <li><strong>Accès :</strong> Chemin de la Fontaine, 84800 Fontaine-de-Vaucluse</li>
        <li><strong>Tarif :</strong> Accès libre et gratuit toute l'année</li>
        <li><strong>Tél. Office de tourisme :</strong> 04 90 20 32 22</li>
        <li><strong>Distance depuis Bédarrides :</strong> ~27 km (~30 min)</li>
        <li><strong>Parkings :</strong> Payants en entrée de village</li>
    </ul>
</div>

<div class="article-conseil">
    <strong>Notre conseil :</strong> Combinez la visite avec l'Isle-sur-la-Sorgue (15 min de route) — les deux sont sur la même rivière. Le dimanche, les antiquaires de l'Isle-sur-la-Sorgue valent à eux seuls le déplacement.
</div>

<section class="article-faq">
<h2>Questions fréquentes</h2>
<dl>
<dt>Quelle est la meilleure période pour voir la Fontaine en crue ?</dt>
<dd>Fin mars–avril, après les pluies hivernales et la fonte des neiges. C'est quand le débit est le plus spectaculaire. En été, la source est souvent à débit bas — le site reste beau, mais moins impressionnant.</dd>
<dt>Y a-t-il des restaurants sur place ?</dt>
<dd>Oui, plusieurs restaurants et terrasses le long de la rivière dans le village. En haute saison, réservez ou arrivez tôt — ils affichent complet rapidement.</dd>
<dt>Le site est-il accessible avec un bébé en poussette ?</dt>
<dd>Le chemin jusqu'à la source est en gravier et légèrement en pente — accessible avec une poussette robuste, mais pas idéal avec un modèle léger de ville.</dd>
</dl>
</section>
HTML;

art($pdo, [
    'type'         => 'sur-place',
    'category'     => 'Sites à visiter',
    'slug'         => 'fontaine-de-vaucluse-guide-pratique',
    'lang'         => 'fr',
    'title'        => 'Fontaine de Vaucluse : le guide pratique (ce qu\'on ne vous dit pas toujours)',
    'excerpt'      => 'La Fontaine de Vaucluse est l\'une des résurgences les plus puissantes d\'Europe. Accès vasque fermé, parking, meilleure saison : tout ce qu\'il faut savoir avant d\'y aller depuis Bédarrides.',
    'content'      => json_encode(['body' => $body03], JSON_UNESCAPED_UNICODE),
    'meta_title'   => 'Fontaine de Vaucluse : guide pratique et conseils de visite',
    'meta_desc'    => 'Guide pratique pour visiter la Fontaine de Vaucluse depuis Bédarrides : accès, parking, meilleure période, vasque fermée — tout ce qu\'il faut savoir.',
    'meta_keywords'=> 'Fontaine de Vaucluse, visite Fontaine de Vaucluse, résurgence Vaucluse, Isle-sur-la-Sorgue, Provence site naturel',
    'gso_desc'     => 'Guide pratique pour visiter la Fontaine de Vaucluse (84800) depuis Bédarrides : résurgence accessible gratuitement, accès à la vasque actuellement fermé pour éboulements, meilleure période en crue (mars-avril), distance 27 km / 30 min.',
    'og_image'     => '',
    'cover_image'  => '',
    'status'       => 'published',
    'published_at' => '2025-09-22 08:00:00',
]);

// ─── 04 — Sites à visiter ─────────────────────────────────────────────────────
$body04 = <<<HTML
<p class="article-lead">Les falaises ocre rouge de Roussillon sont parmi les plus photographiées de Provence. Le Sentier des Ocres traverse les anciennes carrières — 30 minutes de marche, des couleurs improbables, et une lumière qui change selon l'heure. À 40 minutes de Bédarrides.</p>

<h2>Ce qu'est le Sentier des Ocres</h2>
<p>Roussillon est construit sur un gisement d'ocre — un pigment naturel allant du jaune pâle au rouge brique. Les falaises et les formations rocheuses qui entourent le village sont le résultat de l'extraction de ce pigment, exploité industriellement du XIXe siècle jusqu'aux années 1950.</p>
<p>Le Sentier des Ocres est un circuit balisé qui traverse ces anciennes carrières. Deux parcours au choix : le court (35 minutes environ) et le long (50 minutes environ). Le terrain est en ocre meuble — des chaussures fermées sont indispensables.</p>

<h2>Ce qu'il faut savoir</h2>
<p>L'entrée est payante. Les horaires varient selon la saison — en haute saison (juil–août), le site est ouvert jusqu'à 19h30. Hors saison, les horaires sont réduits.</p>
<p>Portez des vêtements que vous n'avez pas peur de tacher — l'ocre est un pigment et colore chaussures et bas de pantalon.</p>
<p>À Roussillon même, on peut compléter la visite avec l'Ôkhra — l'écomusée de l'ocre, juste à l'entrée du village (voir notre article sur les ateliers créatifs).</p>

<div class="fiche-pratique">
    <h3>Infos pratiques</h3>
    <ul>
        <li><strong>Adresse :</strong> Chemin des Ocres, 84220 Roussillon</li>
        <li><strong>Tél. Office de tourisme :</strong> 04 90 05 60 25</li>
        <li><strong>Tarif :</strong> 3,50 €/adulte · 2,50 €/groupe · Gratuit -10 ans</li>
        <li><strong>Horaires :</strong> Variables selon saison — vérifier avant de partir</li>
        <li><strong>Distance depuis Bédarrides :</strong> ~35 km (~40 min)</li>
    </ul>
</div>

<div class="article-conseil">
    <strong>Notre conseil :</strong> Évitez le plein été entre 11h et 16h — la chaleur est intense sur les falaises exposées. Tôt le matin ou en fin d'après-midi, la lumière est aussi beaucoup plus belle pour les photos.
</div>

<section class="article-faq">
<h2>Questions fréquentes</h2>
<dl>
<dt>Le sentier est-il accessible aux enfants ?</dt>
<dd>Oui, les deux parcours sont accessibles aux enfants à partir de 4–5 ans accompagnés. Le terrain est meuble et irrégulier — évitez les poussettes. Prévoyez de vieux vêtements et des chaussures fermées pour tout le monde.</dd>
<dt>Peut-on faire les deux parcours à la suite ?</dt>
<dd>Oui. Le court fait environ 35 minutes, le long environ 50 minutes. On peut les enchaîner — prévoyez de l'eau, surtout en été.</dd>
<dt>Faut-il réserver à l'avance ?</dt>
<dd>Non, l'entrée se fait directement sur place. En haute saison, arrivez à l'ouverture pour éviter les groupes.</dd>
</dl>
</section>
HTML;

art($pdo, [
    'type'         => 'sur-place',
    'category'     => 'Sites à visiter',
    'slug'         => 'sentier-des-ocres-roussillon',
    'lang'         => 'fr',
    'title'        => 'Le Sentier des Ocres de Roussillon : guide pratique avant de partir',
    'excerpt'      => 'Les falaises ocre rouge de Roussillon et leur sentier balisé à travers les anciennes carrières. Tarifs, horaires, conseils pratiques — et pourquoi ne pas y aller entre 11h et 16h en été.',
    'content'      => json_encode(['body' => $body04], JSON_UNESCAPED_UNICODE),
    'meta_title'   => 'Sentier des Ocres de Roussillon : tarifs, horaires, conseils pratiques',
    'meta_desc'    => 'Guide pratique pour visiter le Sentier des Ocres de Roussillon : 3,50€/adulte, chaussures fermées obligatoires, meilleure heure de visite. À 40 min de Bédarrides.',
    'meta_keywords'=> 'Sentier des Ocres Roussillon, ocres Vaucluse, Roussillon Provence, visite ocres, randonnée Luberon',
    'gso_desc'     => 'Guide pratique du Sentier des Ocres de Roussillon (84220) : tarifs 3,50€/adulte, deux parcours balisés (35 et 50 min), accès enfants, horaires variables selon saison, distance 35 km / 40 min depuis Bédarrides.',
    'og_image'     => '',
    'cover_image'  => '',
    'status'       => 'published',
    'published_at' => '2025-10-20 08:00:00',
]);

// ─── 05 — Sites à visiter ─────────────────────────────────────────────────────
$body05 = <<<HTML
<p class="article-lead">À 8 minutes de Villa Plaisance, le Château de la Gardine est l'un des domaines les plus accessibles de l'appellation Châteauneuf-du-Pape pour une dégustation directe. Caveau ouvert sans rendez-vous en semaine.</p>

<h2>Le domaine</h2>
<p>Le Château de la Gardine (Brunel et Fils) est un domaine familial de l'appellation Châteauneuf-du-Pape. Les vins sont produits en rouges, blancs et rosés — les rouges représentent l'essentiel de la production. Le domaine vinifie des cuvées distinctes selon les terroirs et les assemblages de cépages.</p>
<p>Le caveau de dégustation est ouvert du lundi au samedi, sans rendez-vous obligatoire. La vente directe est possible sur place.</p>

<h2>Pourquoi y aller</h2>
<p>C'est une des adresses de dégustation les plus faciles d'accès dans l'appellation — à la fois géographiquement (route de Roquemaure, signalée depuis Châteauneuf) et dans la relation avec les visiteurs. Pas de circuit formaté, pas de groupe imposé. Une dégustation directe, à votre rythme.</p>
<p>Pour nos hôtes qui n'ont jamais visité un domaine viticole, c'est un bon point d'entrée. Pour ceux qui connaissent l'appellation, c'est une adresse sérieuse avec des vins de garde.</p>

<div class="fiche-pratique">
    <h3>Infos pratiques</h3>
    <ul>
        <li><strong>Adresse :</strong> Route de Roquemaure, 84230 Châteauneuf-du-Pape</li>
        <li><strong>Tél :</strong> 04 90 83 73 20</li>
        <li><strong>Email :</strong> caveau@gardine.com</li>
        <li><strong>Site :</strong> gardine.com</li>
        <li><strong>Horaires :</strong> Lun–Ven 9h–18h · Sam et jours fériés 10h–18h · Dim fermé</li>
        <li><strong>Tarif dégustation :</strong> À renseigner directement au domaine</li>
        <li><strong>Distance depuis Bédarrides :</strong> ~8 km (~10 min)</li>
    </ul>
</div>

<div class="article-conseil">
    <strong>Notre conseil :</strong> Si vous voulez voir plusieurs domaines, appelez avant — certains préfèrent un rendez-vous même s'ils ne l'imposent pas. Ça évite les mauvaises surprises si une vendange ou une mise en bouteille mobilise toute l'équipe.
</div>

<section class="article-faq">
<h2>Questions fréquentes</h2>
<dl>
<dt>Peut-on visiter les vignes ou seulement le caveau ?</dt>
<dd>Renseignez-vous directement au domaine — les visites guidées des vignes ou du chai dépendent de la disponibilité et de la saison. Le caveau de dégustation est la formule standard sans réservation.</dd>
<dt>Les vins sont-ils bio ?</dt>
<dd>Le Château de la Gardine pratique une viticulture raisonnée. Pour les détails des pratiques parcellaires, posez la question directement lors de la visite.</dd>
<dt>Peut-on rapporter du vin en avion ?</dt>
<dd>En bagage en soute uniquement, emballé correctement. Le domaine peut souvent vous aider avec du papier bulle ou des cartons de transport. Renseignez-vous aussi auprès du domaine pour une livraison directe en France.</dd>
</dl>
</section>
HTML;

art($pdo, [
    'type'         => 'sur-place',
    'category'     => 'Sites à visiter',
    'slug'         => 'chateau-la-gardine-chateauneuf-du-pape',
    'lang'         => 'fr',
    'title'        => 'Château de la Gardine : dégustation à Châteauneuf-du-Pape à 8 minutes de Bédarrides',
    'excerpt'      => 'Le Château de la Gardine est l\'une des adresses de dégustation les plus accessibles de l\'appellation Châteauneuf-du-Pape. Caveau ouvert du lundi au samedi, vente directe, à 8 minutes de Villa Plaisance.',
    'content'      => json_encode(['body' => $body05], JSON_UNESCAPED_UNICODE),
    'meta_title'   => 'Château de la Gardine : dégustation Châteauneuf-du-Pape sans rendez-vous',
    'meta_desc'    => 'Domaine Château de la Gardine à Châteauneuf-du-Pape : dégustation directe sans rendez-vous, lun-sam 9h-18h, à 8 km de Bédarrides. Adresse, horaires, conseils.',
    'meta_keywords'=> 'Château de la Gardine, dégustation Châteauneuf-du-Pape, domaine viticole Vaucluse, vin Châteauneuf, caveau dégustation',
    'gso_desc'     => 'Présentation du Château de la Gardine (Route de Roquemaure, 84230 Châteauneuf-du-Pape, tél. 04 90 83 73 20), domaine viticole familial avec caveau de dégustation ouvert sans rendez-vous du lundi au samedi, à 8 km de Bédarrides.',
    'og_image'     => '',
    'cover_image'  => '',
    'status'       => 'published',
    'published_at' => '2025-11-10 08:00:00',
]);


// ══════════════════════════════════════════════════════════════════════════════
// ENFANTS
// ══════════════════════════════════════════════════════════════════════════════

// ─── 06 — Enfants ─────────────────────────────────────────────────────────────
$body06 = <<<HTML
<p class="article-lead">Le Parc Spirou Provence est le parc d'attractions le plus proche de Bédarrides — 22 minutes de route. Thématique bande dessinée (Spirou, Lucky Luke, Les Schtroumpfs), 40 attractions, adapté aux 3–12 ans. Ce qu'il faut savoir avant d'y aller.</p>

<h2>Ce qu'il y a dans le parc</h2>
<p>Le Parc Spirou Provence à Monteux est basé sur les personnages des éditions Dupuis : Spirou, Fantasio, Les Schtroumpfs, Lucky Luke, Boule et Bill. Les attractions mêlent manèges, spectacles et zones de jeux adaptés selon l'âge. Le parc est particulièrement adapté aux enfants de 3 à 12 ans. Pour les plus grands ou les adultes seuls, l'offre est plus limitée.</p>

<h2>Informations pratiques</h2>
<p>Le parc n'est pas ouvert toute l'année — la saison s'étend d'avril à novembre. Vérifiez le calendrier exact sur le site officiel avant de planifier, notamment pour les ouvertures en basse saison (certains jours seulement hors vacances scolaires).</p>
<p>Prévoyez la journée complète. En haute saison, les files d'attente peuvent être longues — arrivez à l'ouverture si possible.</p>

<div class="fiche-pratique">
    <h3>Infos pratiques</h3>
    <ul>
        <li><strong>Adresse :</strong> 1 Rue Jean-Henri Fabre, 84170 Monteux</li>
        <li><strong>Tél :</strong> 04 58 55 50 00</li>
        <li><strong>Site :</strong> parc-spirou.com</li>
        <li><strong>Saison 2026 :</strong> Du 4 avril au 11 novembre — vérifier le calendrier pour les dates d'ouverture précises</li>
        <li><strong>Horaires :</strong> 10h–18h (vacances scolaires et week-ends)</li>
        <li><strong>Tarifs :</strong> ~34 €/adulte · ~29 €/enfant · Gratuit sous 1 mètre</li>
        <li><strong>Distance depuis Bédarrides :</strong> ~20 km (~22 min)</li>
    </ul>
</div>

<div class="article-conseil">
    <strong>Notre conseil :</strong> Achetez les billets en ligne avant de partir — c'est souvent moins cher et ça évite la file à l'entrée. Vérifiez aussi les spectacles programmés à l'heure de votre arrivée sur le site du parc.
</div>

<section class="article-faq">
<h2>Questions fréquentes</h2>
<dl>
<dt>À partir de quel âge le parc est-il adapté ?</dt>
<dd>Dès 3 ans pour les premières attractions. La majorité des attractions est destinée aux 5–12 ans. Les tout-petits (moins de 3 ans) trouveront moins à faire — le parc reste néanmoins accessible avec un bébé.</dd>
<dt>Y a-t-il de la restauration sur place ?</dt>
<dd>Oui, plusieurs points de restauration sont disponibles dans le parc. En haute saison, les files d'attente pour la restauration peuvent être longues — prévoir de pique-niquer en dehors du parc à l'heure du déjeuner est une option (parking autorisé pour la pause midi sur présentation du billet).</dd>
<dt>Le parc est-il ouvert les jours de pluie ?</dt>
<dd>En général oui, sauf conditions météo extrêmes. Une partie des attractions est couverte. Vérifiez les annulations éventuelles sur le site ou les réseaux sociaux du parc avant de partir.</dd>
</dl>
</section>
HTML;

art($pdo, [
    'type'         => 'sur-place',
    'category'     => 'Que faire avec des enfants',
    'slug'         => 'parc-spirou-provence-monteux',
    'lang'         => 'fr',
    'title'        => 'Parc Spirou Provence : tout savoir avant d\'y aller avec des enfants',
    'excerpt'      => 'Le parc d\'attractions le plus proche de Bédarrides — 22 minutes de route. Thématique BD (Spirou, Schtroumpfs, Lucky Luke), adapté aux 3–12 ans. Tarifs, horaires, saison 2026 et conseils pratiques.',
    'content'      => json_encode(['body' => $body06], JSON_UNESCAPED_UNICODE),
    'meta_title'   => 'Parc Spirou Provence : guide pratique pour une visite en famille',
    'meta_desc'    => 'Parc Spirou Provence à Monteux : tarifs, horaires, saison 2026, âges recommandés. À 22 min de Bédarrides — tout ce qu\'il faut savoir avant d\'y aller.',
    'meta_keywords'=> 'Parc Spirou Provence, Monteux, parc attractions Vaucluse, sortie enfants Provence, Spirou famille',
    'gso_desc'     => 'Guide pratique du Parc Spirou Provence (1 Rue Jean-Henri Fabre, 84170 Monteux) : saison du 4 avril au 11 novembre 2026, tarifs ~34€ adulte / ~29€ enfant, adapté aux 3–12 ans, à 20 km / 22 min de Bédarrides.',
    'og_image'     => '',
    'cover_image'  => '',
    'status'       => 'published',
    'published_at' => '2025-09-05 08:00:00',
]);

// ─── 07 — Enfants ─────────────────────────────────────────────────────────────
$body07 = <<<HTML
<p class="article-lead">La Provence propose une dizaine d'ateliers créatifs pour enfants, disséminés dans un rayon de 50 km autour de Bédarrides. Chocolat, ocre, sculpture sur bois, pâtisserie, arts plastiques : voici notre sélection vérifiée, avec tarifs et infos de réservation.</p>

<h2>Ôkhra — ateliers ocre à Roussillon</h2>
<p>L'écomusée de l'ocre à Roussillon propose des ateliers créatifs en vacances scolaires, où les participants travaillent avec les pigments naturels du site. Tous publics, dès 6 ans. À combiner avec le Sentier des Ocres à deux pas.</p>
<div class="fiche-pratique">
    <ul>
        <li><strong>Adresse :</strong> 570 route d'Apt, 84220 Roussillon</li>
        <li><strong>Tél :</strong> 04 90 05 66 69 · Site : okhra.com</li>
        <li><strong>Ateliers :</strong> Vacances scolaires, l'après-midi lun–ven, 1h30 · 12–15 € · Réservation recommandée</li>
        <li><strong>Distance :</strong> ~35 km (~40 min)</li>
    </ul>
</div>

<h2>Chocolaterie Castelain — ateliers chocolat à Châteauneuf-du-Pape</h2>
<p>Ateliers de fabrication de chocolat dès 3 ans, à réserver via wineactivities.net. Différentes formules selon l'âge et la durée.</p>
<div class="fiche-pratique">
    <ul>
        <li><strong>Adresse :</strong> 1745 route de Sorgues, 84230 Châteauneuf-du-Pape</li>
        <li><strong>Tél :</strong> 04 90 83 54 71 · Site : chocolat-castelain.fr</li>
        <li><strong>Ateliers :</strong> Dès 3 ans · De 15 € à 75 € selon formule · Réservation : wineactivities.net</li>
        <li><strong>Distance :</strong> ~8 km (~10 min)</li>
    </ul>
</div>

<h2>Fondation Blachère — ateliers parents/enfants à Bonnieux</h2>
<p>Ateliers arts plastiques en famille, animés par Sylvette Ardoino. Pendant les vacances scolaires, lundi, mercredi et vendredi matin. Dès 5 ans accompagné.</p>
<div class="fiche-pratique">
    <ul>
        <li><strong>Adresse :</strong> 121 chemin de Coucourdon, 84480 Bonnieux</li>
        <li><strong>Tél :</strong> 04 32 52 06 15 · Site : fondationblachere.org</li>
        <li><strong>Ateliers :</strong> Vacances scolaires · Lun, Mer, Ven 10h–12h30 · 10 €/pers. · Dès 5 ans</li>
        <li><strong>Distance :</strong> ~50 km (~50 min)</li>
    </ul>
</div>

<h2>Musée Angladon — ateliers du mercredi à Avignon</h2>
<p>Ateliers hebdomadaires le mercredi après-midi pour les 6–12 ans, autour des collections du musée. Tarif à la séance ou trimestriel.</p>
<div class="fiche-pratique">
    <ul>
        <li><strong>Adresse :</strong> 5 rue du Laboureur, 84000 Avignon</li>
        <li><strong>Tél :</strong> 04 90 82 29 03 · Email : a.siffredi@angladon.com · Site : angladon.com</li>
        <li><strong>Ateliers :</strong> Mercredi 14h–16h · 6–12 ans · 7 €/séance ou 80 €/trimestre</li>
        <li><strong>Distance :</strong> ~18 km (~20 min)</li>
    </ul>
</div>

<h2>Jelena's Cake — ateliers pâtisserie à Vedène</h2>
<p>Ateliers cupcakes, donuts ou cookies pour enfants. 4 créations par enfant, décoration personnalisée, durée 1h30.</p>
<div class="fiche-pratique">
    <ul>
        <li><strong>Adresse :</strong> 123 route de Morières, 84270 Vedène</li>
        <li><strong>Tél :</strong> 04 90 25 33 42 · Site : jelenas-cake.fr</li>
        <li><strong>Ateliers :</strong> 1h30 · ~30 €/enfant · Max 12 enfants · Réservation obligatoire</li>
        <li><strong>Distance :</strong> ~12 km (~15 min)</li>
    </ul>
</div>

<div class="article-conseil">
    <strong>Notre conseil :</strong> Réservez tous ces ateliers à l'avance — les créneaux en vacances scolaires partent vite, surtout en été. Appelez directement si le site web ne montre pas les disponibilités en temps réel.
</div>

<section class="article-faq">
<h2>Questions fréquentes</h2>
<dl>
<dt>Ces ateliers sont-ils ouverts toute l'année ?</dt>
<dd>Pas tous. Ôkhra et la Fondation Blachère fonctionnent principalement pendant les vacances scolaires. La Chocolaterie Castelain et Jelena's Cake proposent des ateliers plus régulièrement — contactez-les pour les disponibilités exactes.</dd>
<dt>Faut-il réserver longtemps à l'avance ?</dt>
<dd>Pour les vacances d'été et de Pâques : oui, plusieurs semaines à l'avance. Pour les petites vacances (Toussaint, Noël, février) : une semaine suffit généralement.</dd>
</dl>
</section>
HTML;

art($pdo, [
    'type'         => 'sur-place',
    'category'     => 'Que faire avec des enfants',
    'slug'         => 'ateliers-creatifs-enfants-provence',
    'lang'         => 'fr',
    'title'        => 'Ateliers créatifs pour enfants en Provence : notre sélection vérifiée',
    'excerpt'      => 'Chocolat à Châteauneuf-du-Pape, ocre à Roussillon, pâtisserie à Vedène, arts plastiques à Avignon et Bonnieux : cinq ateliers créatifs pour enfants à moins d\'une heure de Bédarrides, avec tarifs et infos de réservation.',
    'content'      => json_encode(['body' => $body07], JSON_UNESCAPED_UNICODE),
    'meta_title'   => 'Ateliers créatifs enfants en Provence : 5 adresses vérifiées',
    'meta_desc'    => 'Ôkhra, Chocolaterie Castelain, Fondation Blachère, Musée Angladon, Jelena\'s Cake : 5 ateliers créatifs pour enfants près de Bédarrides. Tarifs, horaires, réservation.',
    'meta_keywords'=> 'ateliers enfants Provence, activités créatives enfants Vaucluse, atelier chocolat Châteauneuf, Okhra Roussillon, Fondation Blachère Bonnieux',
    'gso_desc'     => 'Sélection de 5 ateliers créatifs pour enfants dans le Vaucluse : Ôkhra Roussillon (pigments ocre, 12–15€), Chocolaterie Castelain Châteauneuf-du-Pape (chocolat, dès 15€), Fondation Blachère Bonnieux (arts plastiques, 10€), Musée Angladon Avignon (mercredi, 7€), Jelena\'s Cake Vedène (pâtisserie, 30€).',
    'og_image'     => '',
    'cover_image'  => '',
    'status'       => 'published',
    'published_at' => '2025-10-05 08:00:00',
]);


// ══════════════════════════════════════════════════════════════════════════════
// RESTAURANTS
// ══════════════════════════════════════════════════════════════════════════════

// ─── 08 — Restaurants ─────────────────────────────────────────────────────────
$body08 = <<<HTML
<p class="article-lead">Un bus américain transformé en restaurant de burgers, à deux pas de Villa Plaisance. L'Impérial Bus Diner est l'adresse la plus simple et la plus conviviale de Bédarrides — 4,5/5 sur plus de 340 avis Google. Ouvert le soir, 7 jours sur 7.</p>

<h2>Ce que c'est</h2>
<p>L'Impérial Bus Diner est installé dans un vrai bus américain réaménagé en salle de restaurant, dans le centre de Bédarrides. Cuisine de burgers, frites, et plats simples. Ambiance décontractée, service rapide, prix accessibles. Ce n'est pas une table gastronomique — c'est l'adresse parfaite pour un dîner sans chichi après une journée de visite.</p>

<h2>Ce qu'on sait</h2>
<p>Plus de 340 avis Google avec une note de 4,5/5 — c'est l'adresse la mieux notée de Bédarrides. Le service du soir est ouvert 7 jours sur 7, ce qui est rare dans un village de cette taille. Le midi est ouvert du lundi au samedi.</p>

<div class="fiche-pratique">
    <h3>Infos pratiques</h3>
    <ul>
        <li><strong>Adresse :</strong> 49 avenue de Rascassa, 84370 Bédarrides</li>
        <li><strong>Tél :</strong> 06 29 20 54 44</li>
        <li><strong>Horaires :</strong> Lun–Sam 11h30–14h / 19h–22h · Dim 19h–22h</li>
        <li><strong>Note Google :</strong> 4,5/5 (340+ avis)</li>
        <li><strong>Facebook :</strong> Imperial Bus Diner Bédarrides</li>
    </ul>
</div>

<div class="article-conseil">
    <strong>Notre conseil :</strong> En haute saison, les tables du soir partent vite. Appelez dans l'après-midi pour réserver ou arriver à l'ouverture (19h).
</div>

<section class="article-faq">
<h2>Questions fréquentes</h2>
<dl>
<dt>Y a-t-il des options végétariennes ?</dt>
<dd>Renseignez-vous directement par téléphone — la carte évolue régulièrement.</dd>
<dt>Peut-on y aller avec des enfants ?</dt>
<dd>Oui, l'ambiance est familiale et décontractée. Le format burger convient bien aux enfants.</dd>
</dl>
</section>
HTML;

art($pdo, [
    'type'         => 'sur-place',
    'category'     => 'Restaurants & tables',
    'slug'         => 'imperial-bus-diner-bedarrides',
    'lang'         => 'fr',
    'title'        => 'Impérial Bus Diner : le burger de Bédarrides, 4,5/5 sur 340 avis',
    'excerpt'      => 'Un bus américain transformé en restaurant, à deux pas de Villa Plaisance. L\'adresse la plus conviviale de Bédarrides — burgers, ouvert 7 soirs sur 7, 4,5/5 sur plus de 340 avis Google.',
    'content'      => json_encode(['body' => $body08], JSON_UNESCAPED_UNICODE),
    'meta_title'   => 'Impérial Bus Diner Bédarrides : burgers, horaires et avis',
    'meta_desc'    => 'L\'Impérial Bus Diner à Bédarrides : restaurant de burgers dans un bus américain, 4,5/5 sur 340 avis, ouvert 7 soirs/7. Adresse, horaires, conseils.',
    'meta_keywords'=> 'restaurant Bédarrides, Impérial Bus Diner, burgers Bédarrides, où manger Bédarrides, restaurant Vaucluse',
    'gso_desc'     => 'Restaurant Impérial Bus Diner à Bédarrides (49 avenue de Rascassa, 84370) : burgers dans un bus américain aménagé, noté 4,5/5 sur 340+ avis Google, ouvert lun–sam 11h30–14h/19h–22h et dim 19h–22h.',
    'og_image'     => '',
    'cover_image'  => '',
    'status'       => 'published',
    'published_at' => '2025-09-18 08:00:00',
]);

// ─── 09 — Restaurants ─────────────────────────────────────────────────────────
$body09 = <<<HTML
<p class="article-lead">Le Numéro 3 est le bistrot de Bédarrides. Cuisine française, carte renouvelée chaque mois, vue sur l'Ouvèze. L'adresse pour un déjeuner ou un dîner soigné à deux pas de la villa — sans sortir du village.</p>

<h2>Ce que c'est</h2>
<p>Le Numéro 3 est installé quai de l'Ouvèze, en bord de rivière, dans le centre de Bédarrides. Cuisine de bistrot française, produits locaux, carte courte et renouvelée mensuellement. Classé #2 des restaurants de Bédarrides sur TripAdvisor avec une note de 4,5/5.</p>
<p>C'est l'adresse qu'on recommande à nos hôtes pour un repas assis, soigné, sans faire de route. Pour les soirées en tête-à-tête ou en petit groupe.</p>

<h2>Ce qu'il faut savoir</h2>
<p>Le dimanche, le restaurant est fermé. Le lundi et mardi, il n'est ouvert qu'au déjeuner. Pour un dîner, préférez du mercredi au samedi. La réservation est fortement recommandée en saison.</p>

<div class="fiche-pratique">
    <h3>Infos pratiques</h3>
    <ul>
        <li><strong>Adresse :</strong> 13 Quai de l'Ouvèze, 84370 Bédarrides</li>
        <li><strong>Tél :</strong> 04 90 39 17 88</li>
        <li><strong>Horaires :</strong> Lun–Mar 12h–14h uniquement · Mer–Sam 12h–14h / 19h–21h30 · Dim fermé</li>
        <li><strong>Note TripAdvisor :</strong> 4,5/5 · #2 restaurants à Bédarrides</li>
    </ul>
</div>

<div class="article-conseil">
    <strong>Notre conseil :</strong> Réservez, surtout pour les vendredi et samedi soirs. La terrasse quai de l'Ouvèze est agréable en soirée de mai à septembre.
</div>

<section class="article-faq">
<h2>Questions fréquentes</h2>
<dl>
<dt>Le Numéro 3 est-il ouvert le dimanche soir ?</dt>
<dd>Non, le dimanche est fermé. Pour un dîner du dimanche, l'Impérial Bus Diner (ouvert le dimanche soir) est l'alternative à Bédarrides.</dd>
<dt>Faut-il absolument réserver ?</dt>
<dd>En haute saison (juillet–août) et le week-end, oui. Hors saison en semaine, c'est plus souple — appelez quand même pour confirmer.</dd>
</dl>
</section>
HTML;

art($pdo, [
    'type'         => 'sur-place',
    'category'     => 'Restaurants & tables',
    'slug'         => 'le-numero-3-bedarrides',
    'lang'         => 'fr',
    'title'        => 'Le Numéro 3 : le bistrot de Bédarrides, en bord d\'Ouvèze',
    'excerpt'      => 'Cuisine française, carte mensuelle, terrasse sur l\'Ouvèze. Le Numéro 3 est l\'adresse bistrot de Bédarrides — pour un déjeuner ou un dîner soigné sans sortir du village. Fermé dimanche, réservation recommandée.',
    'content'      => json_encode(['body' => $body09], JSON_UNESCAPED_UNICODE),
    'meta_title'   => 'Le Numéro 3 à Bédarrides : bistrot français, quai de l\'Ouvèze',
    'meta_desc'    => 'Le Numéro 3 à Bédarrides : bistrot français en bord d\'Ouvèze, carte mensuelle, 4,5/5 TripAdvisor. Mer–Sam midi et soir. Adresse, horaires, réservation.',
    'meta_keywords'=> 'restaurant Bédarrides, Le Numéro 3, bistrot Bédarrides, où dîner Vaucluse, restaurant bord de rivière Provence',
    'gso_desc'     => 'Restaurant Le Numéro 3 à Bédarrides (13 Quai de l\'Ouvèze, 84370, tél. 04 90 39 17 88) : bistrot français noté 4,5/5 TripAdvisor, ouvert mercredi–samedi midi et soir, lundi–mardi midi uniquement, fermé dimanche.',
    'og_image'     => '',
    'cover_image'  => '',
    'status'       => 'published',
    'published_at' => '2025-10-12 08:00:00',
]);

// ── Résumé ─────────────────────────────────────────────────────────────────────
echo "\n════════════════════════════════════════\n";
echo "✅  Seed 010 terminé — 9 articles Sur Place insérés\n";
echo "    Commerces (2) · Sites à visiter (3)\n";
echo "    Enfants (2) · Restaurants (2)\n";
echo "    Hors normes : à venir\n";
echo "════════════════════════════════════════\n";
