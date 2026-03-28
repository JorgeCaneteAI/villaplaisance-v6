<?php
declare(strict_types=1);

namespace Controllers\Front;

class SurPlaceController extends BaseFrontController
{
    public function index(): void
    {
        $this->renderPage('sur-place');
    }

    public function show(string $slug): void
    {
        $article = \Database::fetchOne(
            "SELECT * FROM vp_articles WHERE slug = ? AND type = 'sur-place' AND status = 'published'",
            [$slug]
        );
        if (!$article) {
            http_response_code(404);
            $this->render('front/404', []);
            return;
        }
        $this->render('front/article', ['article' => $article]);
    }
}
