<?php
declare(strict_types=1);

namespace Controllers\Admin;

class AuthController extends AdminBaseController
{
    private const RESET_EMAIL = 'jorge@canete.fr';

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

                $user = \Database::fetchOne(
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

        $csrf = $this->csrfToken();
        require ROOT . '/app/Views/admin/login.php';
    }

    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
        $this->redirect('/admin/login');
    }

    public function forgotPassword(): void
    {
        $sent  = false;
        $error = null;

        if ($this->method() === 'POST') {
            if (!$this->verifyCsrf()) {
                $error = 'Token invalide.';
            } else {
                $email = trim($_POST['email'] ?? '');
                $user  = \Database::fetchOne(
                    "SELECT * FROM vp_users WHERE email = ? AND active = 1",
                    [$email]
                );

                // On envoie toujours le même message pour ne pas révéler si l'email existe
                if ($user) {
                    $token   = bin2hex(random_bytes(32));
                    $expires = date('Y-m-d H:i:s', time() + 3600); // 1 heure

                    \Database::update('vp_users', [
                        'reset_token'         => $token,
                        'reset_token_expires' => $expires,
                    ], 'id = ?', [$user['id']]);

                    $resetUrl = (APP_URL ?: 'https://vp.villaplaisance.fr') . '/admin/reinitialiser-mot-de-passe?token=' . $token;

                    $subject = 'Réinitialisation de votre mot de passe — Villa Plaisance';
                    $message = "Bonjour,\n\nCliquez sur le lien ci-dessous pour réinitialiser votre mot de passe (valable 1 heure) :\n\n{$resetUrl}\n\nSi vous n'avez pas demandé cette réinitialisation, ignorez cet email.\n\nVilla Plaisance Admin";
                    $headers = "From: noreply@vp.villaplaisance.fr\r\nContent-Type: text/plain; charset=UTF-8";

                    mail(self::RESET_EMAIL, $subject, $message, $headers);
                }

                $sent = true;
            }
        }

        $csrf = $this->csrfToken();
        require ROOT . '/app/Views/admin/forgot_password.php';
    }

    public function resetPassword(): void
    {
        $token = trim($_GET['token'] ?? '');
        $error = null;
        $done  = false;

        $user = $token ? \Database::fetchOne(
            "SELECT * FROM vp_users WHERE reset_token = ? AND reset_token_expires > NOW() AND active = 1",
            [$token]
        ) : false;

        if (!$user && $this->method() !== 'POST') {
            $error = 'Ce lien est invalide ou a expiré.';
        }

        if ($this->method() === 'POST' && $user) {
            if (!$this->verifyCsrf()) {
                $error = 'Token invalide.';
            } else {
                $password = $_POST['password'] ?? '';
                $confirm  = $_POST['password_confirm'] ?? '';

                if (strlen($password) < 8) {
                    $error = 'Le mot de passe doit contenir au moins 8 caractères.';
                } elseif ($password !== $confirm) {
                    $error = 'Les mots de passe ne correspondent pas.';
                } else {
                    \Database::update('vp_users', [
                        'password'            => password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]),
                        'reset_token'         => null,
                        'reset_token_expires' => null,
                    ], 'id = ?', [$user['id']]);

                    $done = true;
                }
            }
        }

        $csrf = $this->csrfToken();
        require ROOT . '/app/Views/admin/reset_password.php';
    }
}
