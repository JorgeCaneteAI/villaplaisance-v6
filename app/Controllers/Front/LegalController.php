<?php
declare(strict_types=1);

namespace Controllers\Front;

class LegalController extends BaseFrontController
{
    public function mentions(): void
    {
        $this->renderPage('mentions-legales');
    }

    public function confidentialite(): void
    {
        $this->renderPage('politique-confidentialite');
    }
}
