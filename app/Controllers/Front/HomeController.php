<?php
declare(strict_types=1);

namespace Controllers\Front;

class HomeController extends BaseFrontController
{
    public function index(): void
    {
        $this->renderPage('accueil');
    }
}
