<?php
declare(strict_types=1);

namespace Controllers\Front;

class JournalController extends BaseFrontController
{
    public function index(): void
    {
        $this->renderPage('journal');
    }

    public function show(string $slug): void
    {
        $article = \Database::fetchOne(
            "SELECT * FROM vp_articles WHERE slug = ? AND type = 'journal' AND status = 'published'",
            [$slug]
        );
        if (!$article) {
            http_response_code(404);
            $this->render('front/404', []);
            return;
        }
        $lang = \LangService::get();
        $seo  = \SeoService::forArticle($article, $lang, 'journal/' . $slug);
        $this->render('front/article', [
            'article' => $article,
            'lang'    => $lang,
            'seo'     => $seo,
        ]);
    }
}
