<?php
declare(strict_types=1);

namespace Controllers\Front;

class ContactController extends BaseFrontController
{
    public function index(): void
    {
        $this->renderPage('contact', [
            'sent' => isset($_GET['sent']),
            'csrf' => $this->csrfToken(),
        ]);
    }

    public function send(): void
    {
        if (!$this->verifyCsrf()) {
            $this->redirect('/contact');
        }

        $name    = trim($_POST['name']    ?? '');
        $email   = trim($_POST['email']   ?? '');
        $message = trim($_POST['message'] ?? '');

        if ($name && $email && $message && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $subject = "Message de {$name} — Villa Plaisance";
            $body    = "De : {$name} <{$email}>\n\n{$message}";
            $headers = "From: noreply@vp.villaplaisance.fr\r\nReply-To: {$email}";
            mail($_ENV['ADMIN_EMAIL'] ?? 'contact@villaplaisance.fr', $subject, $body, $headers);
        }

        $this->redirect('/contact?sent=1');
    }
}
