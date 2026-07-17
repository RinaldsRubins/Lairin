# Sagatavo izmaiņas Git push (pirms git push)
$ErrorActionPreference = "Stop"
Set-Location $PSScriptRoot + "\.."

Write-Host "==> NPM build (CSS/JS)..." -ForegroundColor Cyan
npm run build

Write-Host ""
Write-Host "Gatavs push!" -ForegroundColor Green
Write-Host "  git add ." -ForegroundColor Yellow
Write-Host "  git commit -m `"Jusu apraksts`"" -ForegroundColor Yellow
Write-Host "  git push" -ForegroundColor Yellow
Write-Host ""
Write-Host "Tad cPanel -> Git -> Deploy HEAD Commit" -ForegroundColor Cyan
