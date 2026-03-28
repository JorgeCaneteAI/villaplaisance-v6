<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau mot de passe — Villa Plaisance Admin</title>
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
        .pw-wrap { position: relative; }
        .pw-wrap input { width: 100%; padding: .75rem 2.75rem .75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: .95rem; color: #1a2332; background: #fafafa; transition: border-color .2s; }
        .pw-wrap input:focus { outline: none; border-color: #8a9ab0; background: #fff; }
        .toggle { position: absolute; right: .75rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #8a9ab0; display: flex; align-items: center; }
        .toggle:hover { color: #1a2332; }
        .btn { width: 100%; padding: .85rem; background: #1a2332; color: #fff; border: none; border-radius: 8px; font-size: .95rem; font-weight: 600; cursor: pointer; transition: background .2s; margin-top: .5rem; }
        .btn:hover { background: #2d3f55; }
        .success { background: #f0fdf4; border: 1px solid #86efac; color: #166534; padding: .75rem 1rem; border-radius: 8px; font-size: .875rem; margin-bottom: 1.25rem; }
        .error { background: #fef2f2; border: 1px solid #fca5a5; color: #b91c1c; padding: .75rem 1rem; border-radius: 8px; font-size: .875rem; margin-bottom: 1.25rem; }
        .back { display: block; text-align: center; margin-top: 1.25rem; font-size: .8rem; color: #8a9ab0; text-decoration: none; transition: color .2s; }
        .back:hover { color: #1a2332; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="card">
            <div class="logo">
                <h1>Villa Plaisance</h1>
                <p>Nouveau mot de passe</p>
            </div>

            <?php if ($error): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <?php if ($done): ?>
                <div class="success">Mot de passe mis à jour. Vous pouvez vous connecter.</div>
                <a href="/admin/login" class="back">&larr; Se connecter</a>

            <?php elseif (!$user && !$error): ?>
                <div class="error">Ce lien est invalide ou a expiré.</div>
                <a href="/admin/mot-de-passe-oublie" class="back">Demander un nouveau lien</a>

            <?php else: ?>
                <form method="POST" action="/admin/reinitialiser-mot-de-passe?token=<?= htmlspecialchars($token) ?>">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

                    <div class="form-group">
                        <label for="password">Nouveau mot de passe</label>
                        <div class="pw-wrap">
                            <input type="password" id="password" name="password" minlength="8" required>
                            <button type="button" class="toggle" onclick="toggle('password','eye1','eyeoff1')">
                                <svg id="eye1" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg id="eyeoff1" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirm">Confirmer le mot de passe</label>
                        <div class="pw-wrap">
                            <input type="password" id="password_confirm" name="password_confirm" minlength="8" required>
                            <button type="button" class="toggle" onclick="toggle('password_confirm','eye2','eyeoff2')">
                                <svg id="eye2" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg id="eyeoff2" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn">Enregistrer le mot de passe</button>
                </form>

                <a href="/admin/login" class="back">&larr; Retour à la connexion</a>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function toggle(inputId, eyeId, eyeOffId) {
            const input  = document.getElementById(inputId);
            const eye    = document.getElementById(eyeId);
            const eyeOff = document.getElementById(eyeOffId);
            const show   = input.type === 'password';
            input.type        = show ? 'text' : 'password';
            eye.style.display    = show ? 'none' : '';
            eyeOff.style.display = show ? '' : 'none';
        }
    </script>
</body>
</html>
