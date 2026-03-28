<?php
declare(strict_types=1);

/**
 * Seed 002 — Création du compte admin initial
 * Exécuter : cd ~/villaplaisance-v6 && php seeds/002_seed_admin.php
 */

require_once __DIR__ . '/../config.php';

$pdo = Database::getInstance();

$name     = 'Jorge';
$email    = 'contact@villaplaisance.fr';
$password = 'VillaP@2026!!';
$hash     = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

$stmt = $pdo->prepare("
    INSERT INTO vp_users (name, email, password, role, active)
    VALUES (?, ?, ?, 'admin', 1)
    ON DUPLICATE KEY UPDATE password = VALUES(password), active = 1
");
$stmt->execute([$name, $email, $hash]);

echo "✓ Utilisateur admin créé : {$email}\n";
echo "  Mot de passe : {$password}\n";
echo "\n⚠  Changez ce mot de passe après la première connexion.\n";
