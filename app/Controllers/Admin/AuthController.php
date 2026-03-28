<?php
declare(strict_types=1);

namespace Controllers\Admin;

class AuthController extends AdminBaseController
{
    public function login(): void
    {
        if (!empty($_SESSION['admin_authenticated'])) {
            $this->redirect('/admin');
        }

        $error = null;

        if ($this->method() === 'POST') {
            if (!$this->verifyCsrf()) {
                $error = 'Token invalide, veuillez réessayer.';
            } else {
                $email    = trim($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';

                $user = Database::fetchOne(
                    "SELECT * FROM vp_users WHERE email = ? AND active = 1",
                    [$email]
                );

                if ($user && password_verify($password, $user['password'])) {
                    session_regenerate_id(true);
                    $_SESSION['admin_authenticated'] = true;
                    $_SESSION['admin_user_id']       = $user['id'];
                    $_SESSION['admin_user_name']     = $user['name'];
                    $this->redirect('/admin');
                }

                $error = 'Identifiants incorrects.';
            }
        }

        $this->renderLogin($error);
    }

    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
        $this->redirect('/admin/login');
    }

    private function renderLogin(?string $error): void
    {
        $csrf = $this->csrfToken();
        require ROOT . '/app/Views/admin/login.php';
    }
}
