<?php
declare(strict_types=1);

namespace Controllers\Front;

class VillaController extends BaseFrontController
{
    public function index(): void
    {
        $this->renderPage('location-villa-provence');
    }
}
