<?php
declare(strict_types=1);

namespace Controllers\Front;

abstract class BaseFrontController extends \Controllers\BaseController
{
    protected function renderPage(string $slug, array $extra = []): void
    {
        $lang     = \LangService::get();
        $page     = \BlockService::getPage($slug, $lang);

        if (!$page) {
            http_response_code(404);
            $this->render('front/404', []);
            return;
        }

        $sections = \BlockService::getSections((int)$page['id'], $lang);
        $seo      = \SeoService::forPage($slug, $lang, $page['title'] ?? '', $page['meta_desc'] ?? '');

        $this->render('front/page', array_merge([
            'page'     => $page,
            'sections' => $sections,
            'seo'      => $seo,
            'lang'     => $lang,
        ], $extra));
    }
}
