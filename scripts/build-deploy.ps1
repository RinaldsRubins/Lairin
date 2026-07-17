# Izveidot produkcijas arhīvu cPanel augšupielādei
# Palaidiet PowerShell projekta mapē

$ErrorActionPreference = "Stop"
$projectRoot = $PSScriptRoot + "\.."
Set-Location $projectRoot

Write-Host "==> Composer (bez dev pakotnem)..." -ForegroundColor Cyan
composer install --no-dev --optimize-autoloader --no-interaction

Write-Host "==> NPM build..." -ForegroundColor Cyan
npm ci
npm run build

Write-Host "==> Notirit cache..." -ForegroundColor Cyan
php artisan config:clear
php artisan view:clear

$archiveName = "lairin-deploy-$(Get-Date -Format 'yyyyMMdd-HHmm').zip"
$tempDir = Join-Path $env:TEMP "lairin-deploy"
if (Test-Path $tempDir) { Remove-Item $tempDir -Recurse -Force }
New-Item -ItemType Directory -Path $tempDir | Out-Null

Write-Host "==> Kopet failus..." -ForegroundColor Cyan
$exclude = @('node_modules', '.git', 'tests', '.env', 'database\database.sqlite', 'storage\logs\*', 'storage\framework\cache\data\*')
robocopy $projectRoot $tempDir /E /XD node_modules .git tests /XF .env database.sqlite /NFL /NDL /NJH /NJS /nc /ns /np | Out-Null

# Izveidot tuksus storage cache
New-Item -ItemType Directory -Force -Path "$tempDir\storage\logs" | Out-Null
New-Item -ItemType File -Force -Path "$tempDir\storage\logs\.gitkeep" | Out-Null

Compress-Archive -Path "$tempDir\*" -DestinationPath (Join-Path $projectRoot "deploy\$archiveName") -Force
Remove-Item $tempDir -Recurse -Force

Write-Host ""
Write-Host "Gatavs: deploy\$archiveName" -ForegroundColor Green
Write-Host "Skatiet docs/CPANEL-DEPLOY.md par talakso solu instrukcijam." -ForegroundColor Yellow
