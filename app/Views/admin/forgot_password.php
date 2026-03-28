<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié — Villa Plaisance Admin</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', system-ui, sans-serif; background: #f1f0ed; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .wrap { width: 100%; max-width: 400px; padding: 1rem; }
        .card { background: #fff; border-radius: 12px; padding: 2.5rem 2rem; box-shadow: 0 4px 24px rgba(0,0,0,.08); }
        .logo { text-align: center; margin-bottom: 2rem; }
        .logo h1 { font-family: 'Cormorant Garamond', Georgia, serif; font-size: 1.75rem; font-weight: 600; color: #1a2332; }
        .logo p { font-size: .8rem; color: #8a9ab0; margin-top: .25rem; text-transform: uppercase; letter-spacing: .1em; }
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; font-size: .8rem; font-weight: 600; color: #4a5568; margin-bottom: .4rem; text-transform: uppercase; letter-spacing: .05em; }
        input[type="email"] { width: 100%; padding: .75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: .95rem; color: #1a2332; background: #fafafa; transition: border-color .2s; }
        input:focus { outline: none; border-color: #8a9ab0; background: #fff; }
        .btn { width: 100%; padding: .85rem; background: #1a2332; color: #fff; border: none; border-radius: 8px; font-size: .95rem; font-weight: 600; cursor: pointer; transition: background .2s; margin-top: .5rem; }
        .btn:hover { background: #2d3f55; }
        .success { background: #f0fdf4; border: 1px solid #86efac; color: #166534; padding: .75rem 1rem; border-radius: 8px; font-size: .875rem; margin-bottom: 1.25rem; }
        .error { background: #fef2f2; border: 1px solid #fca5a5; color: #b91c1c; padding: .75rem 1rem; border-radius: 8px; font-size: .875rem; margin-bottom: 1.25rem; }
        .hint { font-size: .8rem; color: #6b7280; margin-top: .5rem; line-height: 1.5; }
        .back { display: block; text-align: center; margin-top: 1.25rem; font-size: .8rem; color: #8a9ab0; text-decoration: none; transition: color .2s; }
        .back:hover { color: #1a2332; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="card">
            <div class="logo">
                <h1>Villa Plaisance</h1>
                <p>Réinitialisation</p>
            </div>

            <?php if ($error): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <?php if ($sent): ?>
                <div class="success">
                    Si un compte correspond à cet email, un lien de réinitialisation vient d'être envoyé. Vérifiez votre boîte mail.
                </div>
                <a href="/admin/login" class="back">&larr; Retour à la connexion</a>
            <?php else: ?>
                <form method="POST" action="/admin/mot-de-passe-oublie">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

                    <div class="form-group">
                        <label for="email">Adresse e-mail</label>
                        <input type="email" id="email" name="email" autocomplete="email" required>
                        <p class="hint">Le lien sera envoyé à jorge@canete.fr et valable 1 heure.</p>
                    </div>

                    <button type="submit" class="btn">Envoyer le lien</button>
                </form>

                <a href="/admin/login" class="back">&larr; Retour à la connexion</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
