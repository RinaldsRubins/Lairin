# Lairin.lv — Git izvietošana cPanel (bez ZIP)

Projekts ir paredzēts **Git push** izvietošanai. Repozitorijs ir ~5 MB; serverī pēc `composer install` — **~40–45 MB** (zem 50 MB).

---

## Kā tas strādā

```
Jūsu dators                    GitHub/GitLab              cPanel serveris
─────────────                  ─────────────              ───────────────
npm run build        ──push──►  lairin repo    ◄──pull──  Git Version Control
git push                        (bez vendor/)              .cpanel.yml → composer
                                                           setup.php (1. reize)
```

**Git repozitorijā NAV:**
- `vendor/` — uzstāda serverī automātiski
- `node_modules/` — nav vajadzīgs serverī
- `.env` — izveido `setup.php` vai manuāli

**Git repozitorijā IR:**
- `public/build/` — jau sasbuildētie CSS/JS (pirms push palaidiet `npm run build`)

---

## 1. solis — GitHub repozitorijs (vienreiz)

1. Izveidojiet **privātu** repozitoriju GitHub: `lairin` (vai `lairin-lv`)
2. Lokāli pievienojiet remote un push:

```powershell
cd C:\Users\rinci\Projects\lairin
git add .
git commit -m "Initial Lairin.lv site"
git branch -M main
git remote add origin https://github.com/JUSU_KONTS/lairin.git
git push -u origin main
```

*(Aizstājiet ar savu GitHub URL)*

**Privāts repozitorijs:** cPanel clone URL formāts:
`https://GITHUB_LIETOTĀJS:ghp_JUSU_TOKEN@github.com/JUSU_KONTS/lairin.git`

Token izveidojiet: GitHub → Settings → Developer settings → Personal access tokens.

---

## 2. solis — cPanel Git (vienreiz)

1. **cPanel → Git™ Version Control → Create**
2. **Clone a Repository**
3. **Clone URL:** `https://github.com/JUSU_KONTS/lairin.git`
4. **Repository Path:** `/home/JUSU_LIETOTAJS/lairin`
5. **Repository Name:** `lairin`
6. Create

### Document Root (SVARĪGI)

**cPanel → Domains → lairin.lv → Manage**
- Document Root: `/home/JUSU_LIETOTAJS/lairin/public`

Ja nevar mainīt — skat. `deploy/public_html.htaccess`.

### Tiesības

File Manager → `lairin/storage` un `lairin/bootstrap/cache` → **775**

### PHP

**cPanel → Select PHP Version → 8.3+**

Ieslēgt: `pdo_mysql`, `mbstring`, `openssl`, `curl`, `fileinfo`, `gd`, `zip`

---

## 3. solis — Pirmā izvietošana

1. **Git Version Control** → atveriet `lairin` repozitoriju
2. Nospiediet **Manage** → **Pull or Deploy** → **Deploy HEAD Commit**
   - Palaidīs `.cpanel.yml` → `composer install` + migrācijas (ja `.env` jau ir)
3. Izveidojiet MySQL datubāzi (**MySQL Database Wizard**)
4. Atveriet pārlūkā: **https://lairin.lv/setup.php**
5. Ievadiet DB datus → Instalēt
6. **Dzēsiet** `public/setup.php`

---

## 4. solis — Izmaiņu publicēšana (ikreiz)

### Jūsu datorā

```powershell
cd C:\Users\rinci\Projects\lairin

# Ja mainījāt CSS/JS/dizainu:
npm run build

git add .
git commit -m "Apraksts par izmaiņām"
git push
```

### cPanel

1. **Git Version Control → lairin → Manage**
2. **Pull or Deploy** → **Update from Remote** (lejupielādē jaunāko kodu)
3. **Deploy HEAD Commit** (palaid composer + migrācijas)

> Dažos hostingos pietiek ar vienu pogu **Pull or Deploy** — tā dara abus soļus.

---

## Automātiskais deploy (.cpanel.yml)

Projektā ir `.cpanel.yml`, kas pēc deploy automātiski:

1. `composer install --no-dev --optimize-autoloader`
2. `php artisan migrate --force` (ja `.env` eksistē)
3. Kešatmiņas atjaunošana (config, routes, views)

Skripts: `scripts/cpanel-deploy.sh`

---

## Cron (rezervācijas, e-pasti)

**cPanel → Cron Jobs:**

```
* * * * * cd /home/JUSU_LIETOTAJS/lairin && /usr/local/bin/ea-php83 artisan schedule:run >> /dev/null 2>&1
* * * * * cd /home/JUSU_LIETOTAJS/lairin && /usr/local/bin/ea-php83 artisan queue:work --stop-when-empty >> /dev/null 2>&1
```

*(PHP ceļu pārbaudiet cPanel → Select PHP Version)*

---

## Problēmas

| Problēma | Risinājums |
|----------|------------|
| Balta lapa / 500 | Document Root = `lairin/public`; `storage/` tiesības 775 |
| CSS nav | Lokāli `npm run build`, commit `public/build/`, push |
| Composer kļūda deploy | cPanel → Software → Composer; vai hostera atbalsts |
| vendor/ nav | Deploy HEAD Commit vēlreiz |
| DB kļūda | Pārbaudiet `.env` vai palaidiet `setup.php` |

---

## Izmērs

| Kas | Izmērs |
|-----|--------|
| Git repo (push) | ~5 MB |
| Serverī pēc composer | ~40–45 MB |
| Google API | Tikai Calendar (ne viss Google pakalpojumu klāsts) |

---

Papildu: `docs/CPANEL-DEPLOY.md` (SEO, Google Analytics, e-pasts)
