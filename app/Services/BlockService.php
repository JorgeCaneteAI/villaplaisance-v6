<?php
declare(strict_types=1);

/**
 * BlockService — lecture et écriture des sections CMS
 *
 * Chaque section = une ligne dans vp_sections avec un champ `data` JSON.
 * Ce service fournit des helpers pour lire/écrire facilement les données.
 */
class BlockService
{
    /**
     * Récupère toutes les sections actives d'une page, ordonnées par position.
     */
    public static function getSections(int $pageId, string $lang = DEFAULT_LANG): array
    {
        try {
            $rows = Database::fetchAll(
                "SELECT * FROM vp_sections WHERE page_id = ? AND lang = ? AND active = 1 ORDER BY position ASC",
                [$pageId, $lang]
            );
            return array_map(function (array $row): array {
                $row['data'] = json_decode($row['data'] ?? '{}', true) ?? [];
                return $row;
            }, $rows);
        } catch (\Throwable $e) {
            return [];
        }
    }

    /**
     * Récupère toutes les sections d'une page (y compris inactives) pour l'admin.
     */
    public static function getAllSections(int $pageId, string $lang = DEFAULT_LANG): array
    {
        try {
            $rows = Database::fetchAll(
                "SELECT * FROM vp_sections WHERE page_id = ? AND lang = ? ORDER BY position ASC",
                [$pageId, $lang]
            );
            return array_map(function (array $row): array {
                $row['data'] = json_decode($row['data'] ?? '{}', true) ?? [];
                return $row;
            }, $rows);
        } catch (\Throwable $e) {
            return [];
        }
    }

    /**
     * Sauvegarde les données d'une section.
     */
    public static function saveSection(int $sectionId, array $data): void
    {
        Database::update('vp_sections', [
            'data'       => json_encode($data, JSON_UNESCAPED_UNICODE),
            'updated_at' => date('Y-m-d H:i:s'),
        ], 'id = ?', [$sectionId]);
    }

    /**
     * Crée une nouvelle section.
     */
    public static function createSection(int $pageId, string $type, int $position, string $lang = DEFAULT_LANG): int
    {
        return Database::insert('vp_sections', [
            'page_id'    => $pageId,
            'type'       => $type,
            'position'   => $position,
            'data'       => '{}',
            'lang'       => $lang,
            'active'     => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Retourne la page par son slug.
     */
    public static function getPage(string $slug, string $lang = DEFAULT_LANG): array|false
    {
        try {
            return Database::fetchOne(
                "SELECT * FROM vp_pages WHERE slug = ? AND lang = ?",
                [$slug, $lang]
            );
        } catch (\Throwable $e) {
            return false;
        }
    }
}
