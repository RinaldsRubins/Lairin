<?php

/**
 * Vienreizējs cPanel instalators (bez Terminal).
 * Apmeklējiet: https://lairin.lv/setup.php
 * Pēc instalācijas izdzēsiet šo failu!
 */

declare(strict_types=1);

$lockFile = dirname(__DIR__).'/storage/installed.lock';
$vendorAutoload = dirname(__DIR__).'/vendor/autoload.php';

if (! is_file($vendorAutoload)) {
    http_response_code(503);
    echo '<!DOCTYPE html><html lang="lv"><head><meta charset="utf-8"><title>Lairin — gaida deploy</title></head><body style="font-family:system-ui;background:#0F172A;color:#e2e8f0;padding:40px;text-align:center"><h1>Projekts vēl nav pilnībā izvietots</h1><p>cPanel → Git Version Control → <strong>Deploy HEAD Commit</strong></p><p>Tas palaidīs composer install automātiski (.cpanel.yml).</p><p style="color:#94a3b8;margin-top:24px">Skat. docs/GIT-DEPLOY.md</p></body></html>';
    exit;
}

if (is_file($lockFile)) {
    header('Location: /');
    exit;
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbHost = trim($_POST['db_host'] ?? 'localhost');
    $dbName = trim($_POST['db_name'] ?? '');
    $dbUser = trim($_POST['db_user'] ?? '');
    $dbPass = $_POST['db_pass'] ?? '';
    $appUrl = rtrim(trim($_POST['app_url'] ?? 'https://lairin.lv'), '/');

    if ($dbName === '' || $dbUser === '') {
        $errors[] = 'Aizpildiet datubāzes nosaukumu un lietotāju.';
    } else {
        try {
            $key = 'base64:'.base64_encode(random_bytes(32));

            $env = <<<ENV
APP_NAME=Lairin
APP_ENV=production
APP_KEY={$key}
APP_DEBUG=false
APP_TIMEZONE=Europe/Riga
APP_URL={$appUrl}
APP_LOCALE=lv
APP_FALLBACK_LOCALE=lv

DB_CONNECTION=mysql
DB_HOST={$dbHost}
DB_PORT=3306
DB_DATABASE={$dbName}
DB_USERNAME={$dbUser}
DB_PASSWORD={$dbPass}

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database

MAIL_MAILER=smtp
MAIL_HOST=mail.lairin.lv
MAIL_PORT=465
MAIL_USERNAME=info@lairin.lv
MAIL_PASSWORD=
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=info@lairin.lv
MAIL_FROM_NAME=Lairin

GOOGLE_REDIRECT_URI={$appUrl}/admin/google/callback
ENV;

            file_put_contents(dirname(__DIR__).'/.env', $env);

            require __DIR__.'/../vendor/autoload.php';
            $app = require_once __DIR__.'/../bootstrap/app.php';
            $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
            $kernel->bootstrap();

            Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\LairinSeeder', '--force' => true]);
            Illuminate\Support\Facades\Artisan::call('storage:link', ['--force' => true]);
            Illuminate\Support\Facades\Artisan::call('config:cache');
            Illuminate\Support\Facades\Artisan::call('route:cache');
            Illuminate\Support\Facades\Artisan::call('view:cache');

            file_put_contents($lockFile, date('c'));
            $success = true;
        } catch (Throwable $e) {
            $errors[] = $e->getMessage();
            @unlink(dirname(__DIR__).'/.env');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lairin — Instalācija</title>
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:system-ui,sans-serif;background:#0F172A;color:#e2e8f0;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px}
        .card{background:#1e293b;border-radius:16px;padding:32px;max-width:480px;width:100%;box-shadow:0 20px 60px rgba(0,0,0,.4)}
        h1{font-size:1.5rem;margin-bottom:8px;color:#fff}
        p{color:#94a3b8;margin-bottom:24px;font-size:.9rem}
        label{display:block;font-size:.85rem;margin-bottom:4px;color:#cbd5e1}
        input{width:100%;padding:10px 14px;border-radius:8px;border:1px solid #334155;background:#0f172a;color:#fff;margin-bottom:16px;font-size:.95rem}
        button{width:100%;padding:12px;background:#2563EB;color:#fff;border:none;border-radius:8px;font-size:1rem;font-weight:600;cursor:pointer}
        button:hover{background:#1d4ed8}
        .err{background:#7f1d1d;color:#fecaca;padding:12px;border-radius:8px;margin-bottom:16px;font-size:.85rem}
        .ok{background:#14532d;color:#bbf7d0;padding:20px;border-radius:8px;text-align:center}
        .ok a{color:#60a5fa}
    </style>
</head>
<body>
<div class="card">
    <?php if ($success): ?>
        <div class="ok">
            <h1>✓ Instalācija pabeigta!</h1>
            <p style="margin-top:12px">Mājaslapa ir gatava.</p>
            <p style="margin-top:16px"><a href="/">Atvērt lairin.lv →</a></p>
            <p style="margin-top:12px;font-size:.8rem;color:#86efac">Dzēsiet failu public/setup.php drošībai!</p>
        </div>
    <?php else: ?>
        <h1>Lairin instalācija</h1>
        <p>Ievadiet cPanel MySQL datus. Terminal nav nepieciešams.</p>
        <?php foreach ($errors as $err): ?>
            <div class="err"><?= htmlspecialchars($err) ?></div>
        <?php endforeach; ?>
        <form method="post">
            <label>Datubāzes host</label>
            <input name="db_host" value="localhost" required>
            <label>Datubāzes nosaukums</label>
            <input name="db_name" placeholder="jusu_lietotajs_lairin" required>
            <label>Datubāzes lietotājs</label>
            <input name="db_user" placeholder="jusu_lietotajs_dbuser" required>
            <label>Datubāzes parole</label>
            <input name="db_pass" type="password">
            <label>Vietnes adrese</label>
            <input name="app_url" value="https://lairin.lv" required>
            <button type="submit">Instalēt →</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
