# Bootstrap script to create a Laravel project in theater_full, copy current workspace app files, install deps and run migrations

param()

$projectDir = Join-Path $PSScriptRoot "..\theater_full"
if (-Not (Test-Path $projectDir)) {
    Write-Output "Creating project directory: $projectDir"
    New-Item -ItemType Directory -Path $projectDir | Out-Null
}

Push-Location $projectDir

Write-Output "Creating Laravel project (composer create-project laravel/laravel .)"
composer create-project laravel/laravel .

Write-Output "Copying workspace code into project (migrations, app, resources views, database seeders)"
$src = Join-Path $PSScriptRoot ".."
# copy migrations
Copy-Item -Path (Join-Path $src "database\migrations\*") -Destination (Join-Path $projectDir "database\migrations") -Recurse -Force -ErrorAction SilentlyContinue
Copy-Item -Path (Join-Path $src "database\seeders\*") -Destination (Join-Path $projectDir "database\seeders") -Recurse -Force -ErrorAction SilentlyContinue
Copy-Item -Path (Join-Path $src "app\Models\*") -Destination (Join-Path $projectDir "app\Models") -Recurse -Force -ErrorAction SilentlyContinue
Copy-Item -Path (Join-Path $src "app\Http\Controllers\*") -Destination (Join-Path $projectDir "app\Http\Controllers") -Recurse -Force -ErrorAction SilentlyContinue
Copy-Item -Path (Join-Path $src "app\Http\Requests\*") -Destination (Join-Path $projectDir "app\Http\Requests") -Recurse -Force -ErrorAction SilentlyContinue
Copy-Item -Path (Join-Path $src "app\Exceptions\*") -Destination (Join-Path $projectDir "app\Exceptions") -Recurse -Force -ErrorAction SilentlyContinue
Copy-Item -Path (Join-Path $src "app\Policies\*") -Destination (Join-Path $projectDir "app\Policies") -Recurse -Force -ErrorAction SilentlyContinue
Copy-Item -Path (Join-Path $src "resources\views\*") -Destination (Join-Path $projectDir "resources\views") -Recurse -Force -ErrorAction SilentlyContinue
Copy-Item -Path (Join-Path $src "routes\web.php") -Destination (Join-Path $projectDir "routes\web.php") -Force -ErrorAction SilentlyContinue
Copy-Item -Path (Join-Path $src ".env.example") -Destination (Join-Path $projectDir ".env.example") -Force -ErrorAction SilentlyContinue
Copy-Item -Path (Join-Path $src "package.json") -Destination (Join-Path $projectDir "package.json") -Force -ErrorAction SilentlyContinue

Write-Output "Installing composer dependencies inside new project"
composer install

Write-Output "Generating app key"
php artisan key:generate

Write-Output "Running migrations and seeders (make sure DB config in .env points to running Postgres)"
php artisan migrate --seed --force

Write-Output "Installing npm dependencies and building assets (optional)"
npm install
npm run dev

Pop-Location
Write-Output "Bootstrap complete. Open theater_full in your editor or visit http://localhost:8080 if using Docker."