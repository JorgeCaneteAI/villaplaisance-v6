<?php
declare(strict_types=1);

namespace Controllers\Front;

class ChambresController extends BaseFrontController
{
    public function index(): void
    {
        $this->renderPage('chambres-d-hotes');
    }
}
