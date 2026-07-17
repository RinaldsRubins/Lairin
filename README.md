# Lairin — Korporatīvā mājaslapa

Premium klases korporatīvā mājaslapa Latvijas tehnoloģiju uzņēmumam **Lairin** (SIA VENAB).

## Tehnoloģijas

- PHP 8.3+ / Laravel 11
- Blade, Livewire 3, Alpine.js, Tailwind CSS
- MySQL 8 / MariaDB (produkcijā) vai SQLite (lokāli)
- Laravel Breeze, Queues, Scheduler, Mail, Cache
- Google Calendar API, OAuth2, Maps, Analytics 4
- Vite, PHPStan, Laravel Pint

## Ātrā instalācija (lokāli)

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite   # vai konfigurējiet MySQL
php artisan migrate --seed
npm install && npm run build
php artisan serve
```

Atveriet: http://localhost:8000

### Admin piekļuve

- URL: `/login`
- E-pasts: `admin@lairin.lv`
- Parole: `Lairin2026!` (nomainiet pēc instalācijas!)

Admin panelis: `/admin`

## Google Calendar integrācija

1. Izveidojiet projektu [Google Cloud Console](https://console.cloud.google.com/)
2. Iespējojiet **Google Calendar API**
3. Izveidojiet OAuth 2.0 Client ID (Web application)
4. Pievienojiet `.env`:

```env
GOOGLE_CLIENT_ID=your-client-id
GOOGLE_CLIENT_SECRET=your-secret
GOOGLE_REDIRECT_URI=https://lairin.lv/admin/google/callback
GOOGLE_CALENDAR_ID=primary
GOOGLE_CALENDAR_TIMEZONE=Europe/Riga
GOOGLE_ADMIN_EMAIL=info@lairin.lv
```

5. Admin panelī: `/admin/google/redirect` — savienojiet kalendāru

## Produkcijas izvietošana (VPS / cPanel)

### Apache

Document root: `public/`

```apache
<VirtualHost *:443>
    ServerName lairin.lv
    DocumentRoot /var/www/lairin/public
    <Directory /var/www/lairin/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### Nginx

```nginx
root /var/www/lairin/public;
index index.php;
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
location ~ \.php$ {
    fastcgi_pass unix:/run/php/php8.3-fpm.sock;
    fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
    include fastcgi_params;
}
```

### Cron (Scheduler)

```
* * * * * cd /var/www/lairin && php artisan schedule:run >> /dev/null 2>&1
```

### Queue worker

```
php artisan queue:work --sleep=3 --tries=3
```

Vai Supervisor:

```ini
[program:lairin-worker]
command=php /var/www/lairin/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
```

### Produkcijas komandas

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm ci && npm run build
chmod -R 775 storage bootstrap/cache
```

## Koda kvalitāte

```bash
./vendor/bin/pint
./vendor/bin/phpstan analyse
php artisan test
```

## Struktūra

| Ceļš | Apraksts |
|------|----------|
| `/` | Sākumlapa |
| `/pakalpojumi` | Pakalpojumi |
| `/nozares` | Nozares |
| `/projekti` | Portfolio |
| `/blogs` | Blogs |
| `/par-mums` | Par mums |
| `/buj` | BUJ |
| `/kontakti` | Kontakti |
| `/konsultacija` | Rezervācijas forma |
| `/admin` | CMS panelis |
| `/api/v1/bookings` | REST API |

## Kontakti

- **E-pasts:** info@lairin.lv
- **Tālrunis:** +371 26447608
- **Uzņēmums:** SIA VENAB, Reģ. Nr. 40203639381
