<?php
declare(strict_types=1);

namespace Controllers\Admin;

class PageController extends AdminBaseController
{
    public function index(): void
    {
        $this->requireAuth();
        $pages = \Database::fetchAll("SELECT * FROM vp_pages ORDER BY lang, slug");
        $this->render('admin/pages/index', [
            'pageTitle' => 'Pages & blocs',
            'pages'     => $pages,
            'flash'     => $this->getFlash(),
        ]);
    }

    public function edit(string $slug): void
    {
        $this->requireAuth();
        $page = \BlockService::getPage($slug, 'fr');
        if (!$page) {
            $this->flash('error', 'Page introuvable.');
            $this->redirect('/admin/pages');
        }
        $sections = \BlockService::getAllSections((int)$page['id'], 'fr');
        $this->render('admin/pages/edit', [
            'pageTitle' => htmlspecialchars($page['title'] ?: $slug),
            'page'      => $page,
            'sections'  => $sections,
            'flash'     => $this->getFlash(),
        ]);
    }

    public function editSeo(string $slug): void
    {
        $this->requireAuth();
        $page = \BlockService::getPage($slug, 'fr');
        if (!$page) {
            $this->redirect('/admin/pages');
        }
        $this->render('admin/pages/seo', [
            'pageTitle' => 'SEO — ' . $slug,
            'page'      => $page,
            'csrf'      => $this->csrfToken(),
            'flash'     => $this->getFlash(),
        ]);
    }

    public function saveSeo(string $slug): void
    {
        $this->requireAuth();
        if (!$this->verifyCsrf()) {
            $this->flash('error', 'Token invalide.');
            $this->redirect('/admin/pages/' . $slug . '/seo');
        }
        $page = \BlockService::getPage($slug, 'fr');
        if (!$page) {
            $this->redirect('/admin/pages');
        }
        \Database::update('vp_pages', [
            'title'         => trim($_POST['title']         ?? ''),
            'meta_title'    => trim($_POST['meta_title']    ?? ''),
            'meta_desc'     => trim($_POST['meta_desc']     ?? ''),
            'meta_keywords' => trim($_POST['meta_keywords'] ?? ''),
            'gso_desc'      => trim($_POST['gso_desc']      ?? ''),
        ], 'id = ?', [$page['id']]);

        $this->flash('success', 'SEO mis à jour.');
        $this->redirect('/admin/pages/' . $slug);
    }
}
