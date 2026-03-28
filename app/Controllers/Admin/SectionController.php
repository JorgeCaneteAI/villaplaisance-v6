<?php
declare(strict_types=1);

namespace Controllers\Admin;

class SectionController extends AdminBaseController
{
    // Types de blocs disponibles et leurs libellés
    private const TYPES = [
        'hero'           => 'Hero (titre de page)',
        'prose'          => 'Prose (texte + encadré)',
        'cartes'         => 'Cartes (pièces)',
        'liste'          => 'Liste (inclus / exclus)',
        'tableau'        => 'Tableau (récapitulatif)',
        'cta'            => 'Appel à l\'action',
        'avis'           => 'Avis clients',
        'faq'            => 'FAQ',
        'stats'          => 'Chiffres clés',
        'territoire'     => 'Triangle d\'Or',
        'galerie'        => 'Galerie photos',
        'articles'       => 'Articles',
        'petit-dejeuner' => 'Petit-déjeuner',
        'piscine'        => 'Piscine',
    ];

    public function create(string $slug): void
    {
        $this->requireAuth();
        $page = \BlockService::getPage($slug, 'fr');
        if (!$page) $this->redirect('/admin/pages');

        $this->render('admin/sections/create', [
            'pageTitle' => 'Ajouter un bloc',
            'page'      => $page,
            'types'     => self::TYPES,
            'csrf'      => $this->csrfToken(),
            'flash'     => $this->getFlash(),
        ]);
    }

    public function store(string $slug): void
    {
        $this->requireAuth();
        if (!$this->verifyCsrf()) $this->redirect('/admin/pages/' . $slug);

        $page = \BlockService::getPage($slug, 'fr');
        if (!$page) $this->redirect('/admin/pages');

        $type = $_POST['type'] ?? '';
        if (!array_key_exists($type, self::TYPES)) {
            $this->flash('error', 'Type de bloc invalide.');
            $this->redirect('/admin/pages/' . $slug . '/sections/nouveau');
        }

        $maxPos = \Database::fetchOne(
            "SELECT MAX(position) AS m FROM vp_sections WHERE page_id = ? AND lang = 'fr'",
            [$page['id']]
        );
        $position = ((int)($maxPos['m'] ?? 0)) + 10;

        $id = \BlockService::createSection((int)$page['id'], $type, $position, 'fr');

        $this->flash('success', 'Bloc ajouté. Remplissez son contenu.');
        $this->redirect('/admin/sections/' . $id . '/modifier');
    }

    public function edit(int $id): void
    {
        $this->requireAuth();
        $section = $this->getSection($id);

        $page = \Database::fetchOne("SELECT * FROM vp_pages WHERE id = ?", [$section['page_id']]);

        $this->render('admin/sections/edit', [
            'pageTitle' => 'Éditer bloc — ' . (self::TYPES[$section['type']] ?? $section['type']),
            'section'   => $section,
            'page'      => $page,
            'types'     => self::TYPES,
            'csrf'      => $this->csrfToken(),
            'flash'     => $this->getFlash(),
        ]);
    }

    public function update(int $id): void
    {
        $this->requireAuth();
        if (!$this->verifyCsrf()) $this->redirect('/admin/sections/' . $id . '/modifier');

        $section = $this->getSection($id);
        $data    = $this->buildData($section['type']);

        \BlockService::saveSection($id, $data);

        $page = \Database::fetchOne("SELECT slug FROM vp_pages WHERE id = ?", [$section['page_id']]);
        $this->flash('success', 'Bloc enregistré.');
        $this->redirect('/admin/pages/' . ($page['slug'] ?? ''));
    }

    public function delete(int $id): void
    {
        $this->requireAuth();
        if (!$this->verifyCsrf()) $this->redirect('/admin');

        $section = $this->getSection($id);
        $page    = \Database::fetchOne("SELECT slug FROM vp_pages WHERE id = ?", [$section['page_id']]);

        \Database::delete('vp_sections', 'id = ?', [$id]);

        $this->flash('success', 'Bloc supprimé.');
        $this->redirect('/admin/pages/' . ($page['slug'] ?? ''));
    }

    public function toggle(int $id): void
    {
        $this->requireAuth();
        if (!$this->verifyCsrf()) $this->redirect('/admin');

        $section = $this->getSection($id);
        $page    = \Database::fetchOne("SELECT slug FROM vp_pages WHERE id = ?", [$section['page_id']]);

        \Database::update('vp_sections', ['active' => $section['active'] ? 0 : 1], 'id = ?', [$id]);

        $this->redirect('/admin/pages/' . ($page['slug'] ?? ''));
    }

    public function move(int $id, string $dir): void
    {
        $this->requireAuth();
        if (!$this->verifyCsrf()) $this->redirect('/admin');

        $section  = $this->getSection($id);
        $page     = \Database::fetchOne("SELECT slug FROM vp_pages WHERE id = ?", [$section['page_id']]);
        $sections = \Database::fetchAll(
            "SELECT id, position FROM vp_sections WHERE page_id = ? AND lang = 'fr' ORDER BY position ASC",
            [$section['page_id']]
        );

        // Réindexer proprement
        foreach ($sections as $i => $s) {
            \Database::update('vp_sections', ['position' => ($i + 1) * 10], 'id = ?', [$s['id']]);
        }

        $sections = \Database::fetchAll(
            "SELECT id, position FROM vp_sections WHERE page_id = ? AND lang = 'fr' ORDER BY position ASC",
            [$section['page_id']]
        );

        foreach ($sections as $i => $s) {
            if ((int)$s['id'] !== $id) continue;
            $swapIdx = $dir === 'up' ? $i - 1 : $i + 1;
            if (!isset($sections[$swapIdx])) break;

            $posA = $sections[$i]['position'];
            $posB = $sections[$swapIdx]['position'];
            \Database::update('vp_sections', ['position' => $posB], 'id = ?', [$id]);
            \Database::update('vp_sections', ['position' => $posA], 'id = ?', [$sections[$swapIdx]['id']]);
            break;
        }

        $this->redirect('/admin/pages/' . ($page['slug'] ?? ''));
    }

    // ── Helpers privés ────────────────────────────────────────────────────────

    private function getSection(int $id): array
    {
        $section = \Database::fetchOne("SELECT * FROM vp_sections WHERE id = ?", [$id]);
        if (!$section) {
            $this->flash('error', 'Bloc introuvable.');
            $this->redirect('/admin/pages');
        }
        $section['data'] = json_decode($section['data'] ?? '{}', true) ?? [];
        return $section;
    }

    private function buildData(string $type): array
    {
        $p = $_POST;

        return match($type) {
            'hero' => [
                'title'     => trim($p['title']     ?? ''),
                'subtitle'  => trim($p['subtitle']  ?? ''),
                'intro'     => trim($p['intro']      ?? ''),
                'cta_label' => trim($p['cta_label'] ?? ''),
                'cta_url'   => trim($p['cta_url']   ?? ''),
            ],
            'prose' => [
                'title'    => trim($p['title']    ?? ''),
                'text'     => trim($p['text']     ?? ''),
                'encadre'  => trim($p['encadre']  ?? ''),
            ],
            'cartes' => [
                'offer' => $p['offer'] ?? 'both',
            ],
            'liste' => [
                'title' => trim($p['title'] ?? ''),
                'items' => $this->buildRows(['label', 'type'], $p['items'] ?? []),
            ],
            'tableau' => [
                'title' => trim($p['title'] ?? ''),
                'rows'  => $this->buildRows(['label', 'value'], $p['rows'] ?? []),
            ],
            'cta' => [
                'title'      => trim($p['title']      ?? ''),
                'text'       => trim($p['text']       ?? ''),
                'btn1_label' => trim($p['btn1_label'] ?? ''),
                'btn1_url'   => trim($p['btn1_url']   ?? ''),
                'btn2_label' => trim($p['btn2_label'] ?? ''),
                'btn2_url'   => trim($p['btn2_url']   ?? ''),
            ],
            'avis' => [
                'offer' => $p['offer'] ?? 'both',
                'max'   => (int)($p['max'] ?? 6),
            ],
            'faq' => [
                'page_filter' => trim($p['page_filter'] ?? ''),
            ],
            'stats'      => [],
            'territoire' => [],
            'galerie' => [
                'title'  => trim($p['title']  ?? ''),
                'images' => array_filter(array_map('trim', explode("\n", $p['images'] ?? ''))),
            ],
            'articles' => [
                'type' => $p['article_type'] ?? 'journal',
                'max'  => (int)($p['max'] ?? 3),
            ],
            'petit-dejeuner' => [
                'title' => trim($p['title'] ?? ''),
                'text'  => trim($p['text']  ?? ''),
            ],
            'piscine' => [
                'title' => trim($p['title'] ?? ''),
                'text'  => trim($p['text']  ?? ''),
            ],
            default => [],
        };
    }

    private function buildRows(array $fields, array $rawItems): array
    {
        $rows = [];
        $count = count($rawItems[$fields[0]] ?? []);
        for ($i = 0; $i < $count; $i++) {
            $row = [];
            foreach ($fields as $f) {
                $row[$f] = trim($rawItems[$f][$i] ?? '');
            }
            if (array_filter($row)) $rows[] = $row;
        }
        return $rows;
    }
}
