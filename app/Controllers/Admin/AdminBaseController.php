<?php
declare(strict_types=1);

namespace Controllers\Admin;

use Controllers\BaseController;

abstract class AdminBaseController extends BaseController
{
    protected function render(string $view, array $data = []): void
    {
        extract($data);
        $__file = ROOT . '/app/Views/' . $view . '.php';
        if (!file_exists($__file)) {
            throw new \RuntimeException("Vue admin introuvable : {$view}");
        }
        ob_start();
        require $__file;
        $pageContent = ob_get_clean();
        require ROOT . '/app/Views/admin/layout.php';
    }

    protected function requireAuth(): void
    {
        if (empty($_SESSION['admin_authenticated'])) {
            $this->redirect('/admin/login');
        }
    }

    protected function method(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    protected function flash(string $type, string $message): void
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }

    protected function getFlash(): ?array
    {
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        return $flash;
    }

    protected function slugify(string $text): string
    {
        $text = mb_strtolower($text, 'UTF-8');
        $text = strtr($text, [
            'à'=>'a','â'=>'a','ä'=>'a','é'=>'e','è'=>'e','ê'=>'e','ë'=>'e',
            'î'=>'i','ï'=>'i','ô'=>'o','ö'=>'o','ù'=>'u','û'=>'u','ü'=>'u',
            'ç'=>'c','ñ'=>'n',
        ]);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        return trim($text, '-');
    }
}
