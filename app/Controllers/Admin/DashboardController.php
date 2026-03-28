<?php
declare(strict_types=1);

namespace Controllers\Admin;

class DashboardController extends AdminBaseController
{
    public function index(): void
    {
        $this->requireAuth();

        $stats = [
            'pages'    => $this->count('vp_pages'),
            'sections' => $this->count('vp_sections'),
            'pieces'   => $this->count('vp_pieces'),
            'avis'     => $this->count('vp_reviews'),
            'articles' => $this->count('vp_articles'),
            'medias'   => $this->count('vp_media'),
        ];

        $pages = \Database::fetchAll("SELECT slug, title, lang, updated_at FROM vp_pages ORDER BY lang, slug");

        $this->render('admin/dashboard/index', [
            'stats'    => $stats,
            'pages'    => $pages,
            'userName' => $_SESSION['admin_user_name'] ?? 'Admin',
            'flash'    => $this->getFlash(),
        ]);
    }

    private function count(string $table): int
    {
        $row = \Database::fetchOne("SELECT COUNT(*) AS n FROM {$table}");
        return (int)($row['n'] ?? 0);
    }
}
