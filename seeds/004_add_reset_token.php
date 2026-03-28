<?php
declare(strict_types=1);

/**
 * Migration 004 — Ajout colonnes reset_token sur vp_users
 * Exécuter : cd ~/villaplaisance-v6 && php seeds/004_add_reset_token.php
 */

require_once __DIR__ . '/../config.php';

$pdo = Database::getInstance();

$pdo->exec("
    ALTER TABLE vp_users
        ADD COLUMN IF NOT EXISTS reset_token         VARCHAR(64)  DEFAULT NULL,
        ADD COLUMN IF NOT EXISTS reset_token_expires DATETIME     DEFAULT NULL
");

echo "✓ Colonnes reset_token ajoutées à vp_users\n";
