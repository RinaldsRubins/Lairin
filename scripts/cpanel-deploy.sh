#!/bin/bash
# cPanel Git deploy — palaižas automātiski pēc "Deploy HEAD Commit"
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT"

PHP="${PHP_BIN:-$(command -v ea-php83 2>/dev/null || command -v php83 2>/dev/null || command -v php)}"
COMPOSER_BIN="${COMPOSER_BIN:-/opt/cpanel/composer/bin/composer}"

if [ ! -x "$PHP" ] && ! command -v "$PHP" >/dev/null 2>&1; then
    echo "Kļūda: PHP nav atrasts. cPanel → Select PHP Version → 8.3+"
    exit 1
fi

if [ -f "$COMPOSER_BIN" ]; then
    "$PHP" "$COMPOSER_BIN" install --no-dev --optimize-autoloader --no-interaction
elif command -v composer >/dev/null 2>&1; then
    "$PHP" "$(command -v composer)" install --no-dev --optimize-autoloader --no-interaction
else
    echo "Kļūda: Composer nav atrasts. cPanel → Software → Composer"
    exit 1
fi

if [ -f .env ]; then
    "$PHP" artisan migrate --force
    "$PHP" artisan storage:link --force 2>/dev/null || true
    "$PHP" artisan config:cache
    "$PHP" artisan route:cache
    "$PHP" artisan view:cache
else
    echo "Piezīme: .env nav — pirmā reize: atveriet /setup.php"
fi

chmod -R ug+rwx storage bootstrap/cache 2>/dev/null || true

echo "Deploy pabeigts."
