$ini='D:\php\php.ini'
if (-not (Test-Path $ini)) { Write-Error "php.ini not found at $ini"; exit 1 }
Copy-Item $ini "$ini.bak" -Force
(Get-Content $ini) | ForEach-Object {
    if ($_ -match '^\s*;\s*extension\s*=\s*(php_)?fileinfo(\.dll)?\s*$') {
        ($_ -replace '^\s*;','')
    } else {
        $_
    }
} | Set-Content $ini
Write-Host 'Uncommented fileinfo extension lines (if any) in' $ini
Write-Host '--- php --ini ---'
php --ini
Write-Host '--- php -m (search fileinfo) ---'
php -m | Select-String fileinfo
php --ri fileinfo 2>$null
if ($LASTEXITCODE -eq 0) { Write-Host 'fileinfo appears enabled' } else { Write-Host 'fileinfo not enabled' }