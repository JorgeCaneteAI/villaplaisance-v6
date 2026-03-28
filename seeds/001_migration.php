<?php
declare(strict_types=1);

/**
 * Migration 001 — Création de toutes les tables
 * Exécuter : cd ~/villaplaisance-v6 && php seeds/001_migration.php
 */

require_once __DIR__ . '/../config.php';

$pdo = Database::getInstance();

$tables = [

// ── Pages ─────────────────────────────────────────────────────────────────────
"CREATE TABLE IF NOT EXISTS vp_pages (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    slug          VARCHAR(100) NOT NULL,
    lang          VARCHAR(5)   NOT NULL DEFAULT 'fr',
    title         VARCHAR(255) NOT NULL DEFAULT '',
    meta_title    VARCHAR(255) NOT NULL DEFAULT '',
    meta_desc     TEXT         NOT NULL,
    meta_keywords VARCHAR(500) NOT NULL DEFAULT '',
    gso_desc      TEXT         NOT NULL,
    og_image      VARCHAR(255) NOT NULL DEFAULT '',
    created_at    TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at    TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_slug_lang (slug, lang)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

// ── Sections CMS ──────────────────────────────────────────────────────────────
"CREATE TABLE IF NOT EXISTS vp_sections (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    page_id    INT UNSIGNED NOT NULL,
    type       VARCHAR(50)  NOT NULL,
    position   SMALLINT     NOT NULL DEFAULT 0,
    data       LONGTEXT     NOT NULL DEFAULT '{}',
    lang       VARCHAR(5)   NOT NULL DEFAULT 'fr',
    active     TINYINT(1)   NOT NULL DEFAULT 1,
    created_at TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (page_id) REFERENCES vp_pages(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

// ── Pièces ────────────────────────────────────────────────────────────────────
"CREATE TABLE IF NOT EXISTS vp_pieces (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    offer       ENUM('bb','villa','both') NOT NULL DEFAULT 'bb',
    type        ENUM('chambre','espace')  NOT NULL DEFAULT 'chambre',
    position    SMALLINT     NOT NULL DEFAULT 0,
    name        VARCHAR(255) NOT NULL DEFAULT '',
    sous_titre  VARCHAR(255) NOT NULL DEFAULT '',
    description TEXT         NOT NULL,
    equip       TEXT         NOT NULL,
    note        VARCHAR(500) NOT NULL DEFAULT '',
    css_class   VARCHAR(100) NOT NULL DEFAULT '',
    lang        VARCHAR(5)   NOT NULL DEFAULT 'fr',
    created_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

// ── Avis clients ──────────────────────────────────────────────────────────────
"CREATE TABLE IF NOT EXISTS vp_reviews (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    platform        ENUM('airbnb','booking','google','direct') NOT NULL,
    offer           ENUM('bb','villa','both') NOT NULL DEFAULT 'bb',
    author          VARCHAR(255) NOT NULL DEFAULT '',
    origin          VARCHAR(255) NOT NULL DEFAULT '',
    content         TEXT         NOT NULL,
    rating          TINYINT UNSIGNED NOT NULL DEFAULT 5,
    review_date     VARCHAR(20)  NOT NULL DEFAULT '',
    review_date_iso DATE         DEFAULT NULL,
    featured        TINYINT(1)   NOT NULL DEFAULT 0,
    home_carousel   TINYINT(1)   NOT NULL DEFAULT 0,
    status          ENUM('published','hidden') NOT NULL DEFAULT 'published',
    created_at      TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

// ── Articles ──────────────────────────────────────────────────────────────────
"CREATE TABLE IF NOT EXISTS vp_articles (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    type          ENUM('journal','sur-place') NOT NULL DEFAULT 'journal',
    category      VARCHAR(100) NOT NULL DEFAULT '',
    slug          VARCHAR(255) NOT NULL,
    lang          VARCHAR(5)   NOT NULL DEFAULT 'fr',
    title         VARCHAR(255) NOT NULL DEFAULT '',
    excerpt       TEXT         NOT NULL,
    content       LONGTEXT     NOT NULL DEFAULT '{}',
    meta_title    VARCHAR(255) NOT NULL DEFAULT '',
    meta_desc     TEXT         NOT NULL,
    meta_keywords VARCHAR(500) NOT NULL DEFAULT '',
    gso_desc      TEXT         NOT NULL,
    og_image      VARCHAR(255) NOT NULL DEFAULT '',
    status        ENUM('published','draft') NOT NULL DEFAULT 'draft',
    published_at  DATETIME     DEFAULT NULL,
    created_at    TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at    TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_slug_lang (slug, lang)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

// ── FAQ ───────────────────────────────────────────────────────────────────────
"CREATE TABLE IF NOT EXISTS vp_faq (
    id       INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    page     VARCHAR(50)  NOT NULL DEFAULT 'accueil',
    question TEXT         NOT NULL,
    answer   TEXT         NOT NULL,
    position SMALLINT     NOT NULL DEFAULT 0,
    lang     VARCHAR(5)   NOT NULL DEFAULT 'fr',
    active   TINYINT(1)   NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

// ── Stats / Chiffres clés ─────────────────────────────────────────────────────
"CREATE TABLE IF NOT EXISTS vp_stats (
    id        INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    value     VARCHAR(50)  NOT NULL DEFAULT '',
    label     VARCHAR(255) NOT NULL DEFAULT '',
    sublabel  VARCHAR(255) NOT NULL DEFAULT '',
    icon      VARCHAR(50)  NOT NULL DEFAULT '',
    position  SMALLINT     NOT NULL DEFAULT 0,
    active    TINYINT(1)   NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

// ── Proximités / Triangle d'Or ────────────────────────────────────────────────
"CREATE TABLE IF NOT EXISTS vp_proximites (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(255) NOT NULL DEFAULT '',
    distance    VARCHAR(50)  NOT NULL DEFAULT '',
    duration    VARCHAR(50)  NOT NULL DEFAULT '',
    category    VARCHAR(100) NOT NULL DEFAULT '',
    description TEXT         NOT NULL,
    position    SMALLINT     NOT NULL DEFAULT 0,
    active      TINYINT(1)   NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

// ── Médias ────────────────────────────────────────────────────────────────────
"CREATE TABLE IF NOT EXISTS vp_media (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    filename   VARCHAR(255) NOT NULL DEFAULT '',
    alt        VARCHAR(255) NOT NULL DEFAULT '',
    caption    VARCHAR(500) NOT NULL DEFAULT '',
    width      SMALLINT UNSIGNED DEFAULT NULL,
    height     SMALLINT UNSIGNED DEFAULT NULL,
    size       INT UNSIGNED DEFAULT NULL,
    created_at TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

// ── Utilisateurs admin ────────────────────────────────────────────────────────
"CREATE TABLE IF NOT EXISTS vp_users (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(255) NOT NULL DEFAULT '',
    email      VARCHAR(255) NOT NULL,
    password   VARCHAR(255) NOT NULL,
    role       ENUM('admin','editor') NOT NULL DEFAULT 'admin',
    active     TINYINT(1)   NOT NULL DEFAULT 1,
    created_at TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

];

foreach ($tables as $sql) {
    $pdo->exec($sql);
    preg_match('/TABLE IF NOT EXISTS (\w+)/', $sql, $m);
    echo "✓ Table {$m[1]}\n";
}

echo "\nMigration 001 terminée — " . count($tables) . " tables créées.\n";
