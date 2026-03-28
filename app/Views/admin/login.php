<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Villa Plaisance Admin</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: #f1f0ed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-wrap {
            width: 100%;
            max-width: 400px;
            padding: 1rem;
        }

        .login-card {
            background: #fff;
            border-radius: 12px;
            padding: 2.5rem 2rem;
            box-shadow: 0 4px 24px rgba(0,0,0,.08);
        }

        .login-logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-logo h1 {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: 1.75rem;
            font-weight: 600;
            color: #1a2332;
            letter-spacing: .02em;
        }

        .login-logo p {
            font-size: .8rem;
            color: #8a9ab0;
            margin-top: .25rem;
            text-transform: uppercase;
            letter-spacing: .1em;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;
            font-size: .8rem;
            font-weight: 600;
            color: #4a5568;
            margin-bottom: .4rem;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: .75rem 1rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: .95rem;
            color: #1a2332;
            transition: border-color .2s;
            background: #fafafa;
        }

        input:focus {
            outline: none;
            border-color: #8a9ab0;
            background: #fff;
        }

        .btn-login {
            width: 100%;
            padding: .85rem;
            background: #1a2332;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: .95rem;
            font-weight: 600;
            cursor: pointer;
            letter-spacing: .03em;
            transition: background .2s;
            margin-top: .5rem;
        }

        .btn-login:hover { background: #2d3f55; }

        .error-msg {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            color: #b91c1c;
            padding: .75rem 1rem;
            border-radius: 8px;
            font-size: .875rem;
            margin-bottom: 1.25rem;
        }
    </style>
</head>
<body>
    <div class="login-wrap">
        <div class="login-card">
            <div class="login-logo">
                <h1>Villa Plaisance</h1>
                <p>Administration</p>
            </div>

            <?php if ($error): ?>
                <div class="error-msg"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="/admin/login">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

                <div class="form-group">
                    <label for="email">Adresse e-mail</label>
                    <input type="email" id="email" name="email"
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                           autocomplete="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password"
                           autocomplete="current-password" required>
                </div>

                <button type="submit" class="btn-login">Se connecter</button>
            </form>
        </div>
    </div>
</body>
</html>
