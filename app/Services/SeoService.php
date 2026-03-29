<?php
declare(strict_types=1);

class SeoService
{
    private string $title       = '';
    private string $desc        = '';
    private string $keywords    = '';
    private string $gsoDesc     = '';
    private string $ogImage     = '';
    private string $canonical   = '';
    private string $lang        = 'fr';
    private array  $schemas     = [];
    private array  $hreflangs   = [];

    public static function forPage(
        string $pageKey,
        string $lang,
        string $fallbackTitle = '',
        string $fallbackDesc  = ''
    ): self {
        $seo = new self();
        $seo->lang = $lang;

        // Lecture depuis vp_pages
        try {
            $page = Database::fetchOne(
                "SELECT meta_title, meta_desc, meta_keywords, gso_desc, og_image FROM vp_pages WHERE slug = ? AND lang = ?",
                [$pageKey, $lang]
            );
            $seo->title    = $page['meta_title']    ?: $fallbackTitle;
            $seo->desc     = $page['meta_desc']     ?: $fallbackDesc;
            $seo->keywords = $page['meta_keywords'] ?? '';
            $seo->gsoDesc  = $page['gso_desc']      ?? '';
            $seo->ogImage  = $page['og_image']      ?? '';
        } catch (\Throwable $e) {
            $seo->title = $fallbackTitle;
            $seo->desc  = $fallbackDesc;
        }

        $seo->canonical = APP_URL . '/' . ($lang !== DEFAULT_LANG ? $lang . '/' : '');

        return $seo;
    }

    public static function forArticle(array $article, string $lang, string $urlPath): self
    {
        $seo = new self();
        $seo->lang      = $lang;
        $seo->title     = $article['meta_title']    ?: ($article['title'] ?? '');
        $seo->desc      = $article['meta_desc']     ?: ($article['excerpt'] ?? '');
        $seo->keywords  = $article['meta_keywords'] ?? '';
        $seo->gsoDesc   = $article['gso_desc']      ?? '';
        $seo->ogImage   = $article['og_image']      ?? '';
        $seo->canonical = APP_URL . '/' . ($lang !== DEFAULT_LANG ? $lang . '/' : '') . $urlPath;
        return $seo;
    }

    public function addSchema(array $schema): void
    {
        $this->schemas[] = $schema;
    }

    public function renderHead(): string
    {
        $html  = '<title>' . htmlspecialchars($this->title) . ' — Villa Plaisance</title>' . "\n";
        $html .= '<meta name="description" content="' . htmlspecialchars($this->desc) . '">' . "\n";

        if ($this->keywords) {
            $html .= '<meta name="keywords" content="' . htmlspecialchars($this->keywords) . '">' . "\n";
        }

        $html .= '<meta property="og:title" content="' . htmlspecialchars($this->title) . '">' . "\n";
        $html .= '<meta property="og:description" content="' . htmlspecialchars($this->desc) . '">' . "\n";
        $html .= '<meta property="og:type" content="website">' . "\n";

        if ($this->ogImage) {
            $html .= '<meta property="og:image" content="' . htmlspecialchars(APP_URL . '/assets/img/' . $this->ogImage) . '">' . "\n";
        }

        if ($this->canonical) {
            $html .= '<link rel="canonical" href="' . htmlspecialchars($this->canonical) . '">' . "\n";
        }

        foreach ($this->schemas as $schema) {
            $html .= '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
        }

        if ($this->gsoDesc) {
            $html .= '<script type="application/ld+json">' . json_encode([
                '@context'    => 'https://schema.org',
                '@type'       => 'WebPage',
                'description' => $this->gsoDesc,
                'speakable'   => ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', 'h2', '.speakable']],
            ], JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
        }

        return $html;
    }
}
