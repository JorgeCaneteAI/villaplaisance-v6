<?php
declare(strict_types=1);

class Router
{
    private string $lang;
    private string $path;
    private string $method;

    public function __construct()
    {
        $uri      = strtok($_SERVER['REQUEST_URI'], '?');
        $segments = explode('/', trim($uri, '/'));
        $this->method = strtoupper($_SERVER['REQUEST_METHOD']);

        if (in_array($segments[0], SUPPORTED_LANGS, true)) {
            $this->lang = $segments[0];
            $this->path = implode('/', array_slice($segments, 1));
        } else {
            $this->lang = DEFAULT_LANG;
            $this->path = trim($uri, '/');
        }

        LangService::init($this->lang);
    }

    public function dispatch(): void
    {
        $path = $this->path;

        // ── Admin ────────────────────────────────────────────────────────────
        if (str_starts_with($path, 'admin')) {
            $this->dispatchAdmin($path);
            return;
        }

        // ── Front ─────────────────────────────────────────────────────────────
        match($path) {
            '', 'accueil'               => (new Controllers\Front\HomeController())->index(),
            'chambres-d-hotes'          => (new Controllers\Front\ChambresController())->index(),
            'location-villa-provence'   => (new Controllers\Front\VillaController())->index(),
            'journal'                   => (new Controllers\Front\JournalController())->index(),
            'sur-place'                 => (new Controllers\Front\SurPlaceController())->index(),
            'contact'                   => (new Controllers\Front\ContactController())->index(),
            'contact/envoyer'           => (new Controllers\Front\ContactController())->send(),
            'mentions-legales'          => (new Controllers\Front\LegalController())->mentions(),
            'politique-confidentialite' => (new Controllers\Front\LegalController())->confidentialite(),
            default                     => $this->dispatchDynamic($path),
        };
    }

    private function dispatchDynamic(string $path): void
    {
        // Article journal
        if (preg_match('#^journal/([a-z0-9\-]+)$#', $path, $m)) {
            (new Controllers\Front\JournalController())->show($m[1]);
            return;
        }

        // Article sur place
        if (preg_match('#^sur-place/([a-z0-9\-]+)$#', $path, $m)) {
            (new Controllers\Front\SurPlaceController())->show($m[1]);
            return;
        }

        $this->notFound();
    }

    private function dispatchAdmin(string $path): void
    {
        // Auth publique
        if ($path === 'admin/login') {
            (new Controllers\Admin\AuthController())->login();
            return;
        }
        if ($path === 'admin/deconnexion' && $this->method === 'POST') {
            (new Controllers\Admin\AuthController())->logout();
            return;
        }
        if ($path === 'admin/mot-de-passe-oublie') {
            (new Controllers\Admin\AuthController())->forgotPassword();
            return;
        }
        if ($path === 'admin/reinitialiser-mot-de-passe') {
            (new Controllers\Admin\AuthController())->resetPassword();
            return;
        }

        // Auth requise pour tout le reste
        if (empty($_SESSION['admin_authenticated'])) {
            header('Location: /admin/login');
            exit;
        }

        // Dashboard
        if ($path === 'admin' || $path === 'admin/') {
            (new Controllers\Admin\DashboardController())->index();
            return;
        }

        // Pages CMS
        if ($path === 'admin/pages') {
            (new Controllers\Admin\PageController())->index();
            return;
        }
        if (preg_match('#^admin/pages/([a-z0-9\-]+)$#', $path, $m)) {
            (new Controllers\Admin\PageController())->edit($m[1]);
            return;
        }
        if (preg_match('#^admin/pages/([a-z0-9\-]+)/seo$#', $path, $m)) {
            $this->method === 'POST'
                ? (new Controllers\Admin\PageController())->saveSeo($m[1])
                : (new Controllers\Admin\PageController())->editSeo($m[1]);
            return;
        }

        // Sections CMS
        if (preg_match('#^admin/pages/([a-z0-9\-]+)/sections/nouveau$#', $path, $m)) {
            $this->method === 'POST'
                ? (new Controllers\Admin\SectionController())->store($m[1])
                : (new Controllers\Admin\SectionController())->create($m[1]);
            return;
        }
        if (preg_match('#^admin/sections/(\d+)/(modifier|supprimer|activer|monter|descendre)$#', $path, $m)) {
            $id     = (int)$m[1];
            $action = $m[2];
            $ctrl   = new Controllers\Admin\SectionController();
            match(true) {
                $action === 'modifier'  && $this->method === 'POST' => $ctrl->update($id),
                $action === 'modifier'                              => $ctrl->edit($id),
                $action === 'supprimer' && $this->method === 'POST' => $ctrl->delete($id),
                $action === 'activer'   && $this->method === 'POST' => $ctrl->toggle($id),
                $action === 'monter'    && $this->method === 'POST' => $ctrl->move($id, 'up'),
                $action === 'descendre' && $this->method === 'POST' => $ctrl->move($id, 'down'),
                default => null,
            };
            return;
        }

        // Pièces
        if ($path === 'admin/pieces') {
            (new Controllers\Admin\PieceController())->index();
            return;
        }
        if ($path === 'admin/pieces/nouveau') {
            $this->method === 'POST'
                ? (new Controllers\Admin\PieceController())->store()
                : (new Controllers\Admin\PieceController())->create();
            return;
        }
        if (preg_match('#^admin/pieces/(\d+)/(modifier|supprimer|monter|descendre)$#', $path, $m)) {
            $id     = (int)$m[1];
            $action = $m[2];
            $ctrl   = new Controllers\Admin\PieceController();
            match(true) {
                $action === 'modifier'  && $this->method === 'POST' => $ctrl->update($id),
                $action === 'modifier'                              => $ctrl->edit($id),
                $action === 'supprimer' && $this->method === 'POST' => $ctrl->delete($id),
                $action === 'monter'    && $this->method === 'POST' => $ctrl->move($id, 'up'),
                $action === 'descendre' && $this->method === 'POST' => $ctrl->move($id, 'down'),
                default => null,
            };
            return;
        }

        // Avis
        if ($path === 'admin/avis') {
            (new Controllers\Admin\ReviewController())->index();
            return;
        }
        if (preg_match('#^admin/avis/(\d+)/(featured|carousel|statut|supprimer)$#', $path, $m)) {
            $id   = (int)$m[1];
            $ctrl = new Controllers\Admin\ReviewController();
            if ($this->method === 'POST') {
                match($m[2]) {
                    'featured'  => $ctrl->toggleFeatured($id),
                    'carousel'  => $ctrl->toggleCarousel($id),
                    'statut'    => $ctrl->toggleStatus($id),
                    'supprimer' => $ctrl->delete($id),
                };
            }
            return;
        }

        // Articles
        if ($path === 'admin/articles') {
            (new Controllers\Admin\ArticleController())->index();
            return;
        }
        if ($path === 'admin/articles/nouveau') {
            $this->method === 'POST'
                ? (new Controllers\Admin\ArticleController())->store()
                : (new Controllers\Admin\ArticleController())->create();
            return;
        }
        if (preg_match('#^admin/articles/(\d+)/(modifier|supprimer)$#', $path, $m)) {
            $id   = (int)$m[1];
            $ctrl = new Controllers\Admin\ArticleController();
            match(true) {
                $m[2] === 'modifier'  && $this->method === 'POST' => $ctrl->update($id),
                $m[2] === 'modifier'                              => $ctrl->edit($id),
                $m[2] === 'supprimer' && $this->method === 'POST' => $ctrl->delete($id),
                default => null,
            };
            return;
        }

        // FAQ
        if ($path === 'admin/faq') {
            (new Controllers\Admin\FaqController())->index();
            return;
        }
        if ($path === 'admin/faq/nouveau') {
            $this->method === 'POST'
                ? (new Controllers\Admin\FaqController())->store()
                : (new Controllers\Admin\FaqController())->create();
            return;
        }
        if (preg_match('#^admin/faq/(\d+)/(modifier|supprimer)$#', $path, $m)) {
            $id   = (int)$m[1];
            $ctrl = new Controllers\Admin\FaqController();
            match(true) {
                $m[2] === 'modifier'  && $this->method === 'POST' => $ctrl->update($id),
                $m[2] === 'modifier'                              => $ctrl->edit($id),
                $m[2] === 'supprimer' && $this->method === 'POST' => $ctrl->delete($id),
                default => null,
            };
            return;
        }

        // Médias
        if ($path === 'admin/media') {
            (new Controllers\Admin\MediaController())->index();
            return;
        }
        if ($path === 'admin/media/upload' && $this->method === 'POST') {
            (new Controllers\Admin\MediaController())->upload();
            return;
        }
        if (preg_match('#^admin/media/(\d+)/supprimer$#', $path, $m) && $this->method === 'POST') {
            (new Controllers\Admin\MediaController())->delete((int)$m[1]);
            return;
        }

        $this->notFound();
    }

    private function notFound(): void
    {
        http_response_code(404);
        require ROOT . '/app/Views/front/404.php';
    }
}
