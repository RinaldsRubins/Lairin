# Lairin.lv — cPanel izvietošanas ceļvedis

> **Ieteicamais veids:** Git push + cPanel automātiskais deploy. Skat. **[GIT-DEPLOY.md](GIT-DEPLOY.md)**.

Šis ceļvedis palīdzēs palaist mājaslapu uz **lairin.lv** cPanel hostingā.

---

## 0. Git izvietošana (ieteicams)

Skat. **`docs/GIT-DEPLOY.md`** — pilna instrukcija bez ZIP augšupielādes.

---

## 1. sagatavošana lokāli

Pirms augšupielādes izpildiet:

```bash
cd C:\Users\rinci\Projects\lairin
composer install --no-dev --optimize-autoloader
npm ci && npm run build
```

Izveidojiet `.env` produkcijai (skat. `.env.production.example`).

---

## 2. cPanel — izveidot MySQL datubāzi

1. **cPanel → MySQL® Database Wizard**
2. Izveidojiet datubāzi: `lairin_db` (vai hostinga piešķirtais prefikss)
3. Izveidojiet lietotāju ar spēcīgu paroli
4. Piešķiriet lietotājam **ALL PRIVILEGES** uz datubāzi
5. Pierakstiet: `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`

> Parasti `DB_HOST=localhost`

---

## 3. Augšupielāde (File Manager vai FTP)

### Variants A — ieteicamais (projekts ārpus public_html)

```
/home/jūsu-lietotājs/
├── lairin/              ← viss Laravel projekts (app, config, public, vendor...)
└── public_html/         ← tikai simboliskā saite vai .htaccess
```

**File Manager:**
1. Augšupielādējiet projektu mapē `/home/jūsu-lietotājs/lairin/`
2. **Domains → lairin.lv → Document Root** → mainiet uz:
   ```
   /home/jūsu-lietotājs/lairin/public
   ```

### Variants B — ja nevar mainīt document root

Augšupielādējiet visu projektu **ārpus** `public_html`, piemēram `/home/jūsu-lietotājs/lairin/`.

`public_html` mapē ievietojiet `.htaccess`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ /home/jūsu-lietotājs/lairin/public/$1 [L]
</IfModule>
```

*(Aizstājiet `jūsu-lietotājs` ar savu cPanel lietotājvārdu)*

---

## 4. .env konfigurācija serverī

Izveidojiet `/home/jūsu-lietotājs/lairin/.env`:

```env
APP_NAME=Lairin
APP_ENV=production
APP_KEY=base64:...          # ģenerējiet: php artisan key:generate --show
APP_DEBUG=false
APP_TIMEZONE=Europe/Riga
APP_URL=https://lairin.lv
APP_LOCALE=lv

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=jusu_lietotajs_lairin
DB_USERNAME=jusu_lietotajs_dbuser
DB_PASSWORD=spēcīga_parole

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database

MAIL_MAILER=smtp
MAIL_HOST=mail.lairin.lv
MAIL_PORT=465
MAIL_USERNAME=info@lairin.lv
MAIL_PASSWORD=epasta_parole
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=info@lairin.lv
MAIL_FROM_NAME=Lairin

GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=https://lairin.lv/admin/google/callback
GOOGLE_CALENDAR_ID=primary
GOOGLE_MAPS_KEY=
GA4_MEASUREMENT_ID=G-XXXXXXXX
GOOGLE_SEARCH_CONSOLE_VERIFICATION=xxxxxxxxxxxx
```

---

## 5. SSH komandas (Terminal cPanel)

Ja hostingā ir SSH piekļuve:

```bash
cd ~/lairin
php artisan migrate --force
php artisan db:seed --class=LairinSeeder --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
chmod -R 775 storage bootstrap/cache
```

**Ja nav SSH** — izmantojiet cPanel **Terminal** vai lūdziet hosterim palīdzību.

---

## 6. Cron Job (Scheduler)

**cPanel → Cron Jobs** → pievienojiet:

```
* * * * * cd /home/jūsu-lietotājs/lairin && /usr/local/bin/php artisan schedule:run >> /dev/null 2>&1
```

*(PHP ceļu pārbaudiet: `which php` Terminal)*

---

## 7. Queue Worker (rezervācijas e-pasti)

Ja hostingā nav Supervisor, izmantojiet cron katras minūtes:

```
* * * * * cd /home/jūsu-lietotājs/lairin && /usr/local/bin/php artisan queue:work --stop-when-empty >> /dev/null 2>&1
```

---

## 8. SSL (HTTPS)

**cPanel → SSL/TLS Status → Run AutoSSL** vai ieslēdziet Let's Encrypt domēnam `lairin.lv`.

Pārliecinieties, ka `.env` ir `APP_URL=https://lairin.lv`.

---

## 9. PHP versija

**cPanel → Select PHP Version** → izvēlieties **PHP 8.3+**

Ieslēdziet paplašinājumus:
- `pdo_mysql`, `mbstring`, `openssl`, `curl`, `fileinfo`, `gd`, `zip`, `exif`

---

## 10. SEO — Google Search Console

1. Atveriet [Google Search Console](https://search.google.com/search-console)
2. Pievienojiet īpašumu: `https://lairin.lv`
3. Verificējiet ar **HTML tag** metodi
4. Ielieciet kodu `.env`:
   ```
   GOOGLE_SEARCH_CONSOLE_VERIFICATION=xxxxxxxxxxxx
   ```
5. Iesniedziet sitemap: `https://lairin.lv/sitemap.xml`

---

## 11. Google Analytics 4

1. [analytics.google.com](https://analytics.google.com) → izveidojiet īpašumu **lairin.lv**
2. Mērīšanas ID: `G-XXXXXXXX`
3. `.env`: `GA4_MEASUREMENT_ID=G-XXXXXXXX`

---

## 12. E-pasts info@lairin.lv

**cPanel → Email Accounts** → izveidojiet `info@lairin.lv`

Izmantojiet šos SMTP datus `.env` failā (parasti):
- Host: `mail.lairin.lv`
- Port: `465` (SSL) vai `587` (TLS)

---

## 13. Pārbaude pēc palaišanas

- [ ] https://lairin.lv — sākumlapa atveras
- [ ] Favicon redzams pārlūka cilnē
- [ ] Facebook/LinkedIn link preview rāda logo (og-image)
- [ ] https://lairin.lv/sitemap.xml
- [ ] https://lairin.lv/robots.txt
- [ ] Admin: https://lairin.lv/login
- [ ] Rezervācijas forma: https://lairin.lv/konsultacija
- [ ] Google Calendar OAuth: https://lairin.lv/admin/google/redirect

---

## Problēmu risināšana

| Problēma | Risinājums |
|----------|------------|
| 500 kļūda | Pārbaudiet `storage/logs/laravel.log`, tiesības `storage/` |
| CSS/JS nav | `npm run build`, pārbaudiet `public/build/` |
| `.env` nav lasīts | `php artisan config:clear` |
| Maršruti nestrādā | Pārbaudiet `.htaccess`, mod_rewrite |
| Datubāze | Pārbaudiet `.env` DB_* vērtības |

---

**Kontakts atbalstam:** info@lairin.lv | +371 26447608
