<?php
declare(strict_types=1);

namespace Controllers;

abstract class BaseController
{
    protected function render(string $view, array $data = []): void
    {
        extract($data);
        $file = ROOT . '/app/Views/' . $view . '.php';
        if (!file_exists($file)) {
            throw new \RuntimeException("Vue introuvable : {$view}");
        }
        require $file;
    }

    protected function redirect(string $url): never
    {
        header('Location: ' . $url);
        exit;
    }

    protected function json(mixed $data, int $status = 200): never
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    protected function csrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    protected function verifyCsrf(): bool
    {
        $token = $_POST['csrf_token'] ?? '';
        return hash_equals($_SESSION['csrf_token'] ?? '', $token);
    }
}
