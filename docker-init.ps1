# Script d'initialisation Docker pour Windows PowerShell

Write-Host "Initialisation de l'application SAELT..." -ForegroundColor Green

# Verifier si .env existe
if (-Not (Test-Path .env)) {
    Write-Host "Copie du fichier .env.example vers .env..." -ForegroundColor Yellow
    Copy-Item .env.example .env
}

# Creer une copie de sauvegarde de .env
if (Test-Path .env) {
    Write-Host "Sauvegarde du fichier .env actuel..." -ForegroundColor Yellow
    Copy-Item .env .env.backup -Force
}

# Mettre a jour les variables d'environnement pour Docker
Write-Host "Configuration de l'environnement Docker..." -ForegroundColor Yellow

$envContent = Get-Content .env
$envContent = $envContent -replace 'DB_HOST=.*', 'DB_HOST=db'
$envContent = $envContent -replace 'DB_DATABASE=.*', 'DB_DATABASE=saelt'
$envContent = $envContent -replace 'DB_USERNAME=.*', 'DB_USERNAME=saelt'
$envContent = $envContent -replace 'DB_PASSWORD=.*', 'DB_PASSWORD=root'
$envContent | Set-Content .env

# Demarrer les conteneurs
Write-Host "Demarrage des conteneurs Docker..." -ForegroundColor Green
docker-compose up -d

# Attendre que MySQL soit pret
Write-Host "Attente du demarrage de MySQL..." -ForegroundColor Yellow
Start-Sleep -Seconds 15

# Installer les dependances Composer
Write-Host "Installation des dependances PHP..." -ForegroundColor Green
docker-compose exec -T app composer install

# Generer la cle d'application
Write-Host "Generation de la cle d'application..." -ForegroundColor Green
docker-compose exec -T app php artisan key:generate

# Creer le lien de stockage
Write-Host "Creation du lien de stockage..." -ForegroundColor Green
docker-compose exec -T app php artisan storage:link

# Donner les permissions
Write-Host "Configuration des permissions..." -ForegroundColor Green
docker-compose exec -T app chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Installer les dependances NPM
Write-Host "Installation des dependances NPM..." -ForegroundColor Green
docker-compose exec -T app npm install

# Compiler les assets
Write-Host "Compilation des assets..." -ForegroundColor Green
docker-compose exec -T app npm run dev

# Executer les migrations
Write-Host "Execution des migrations..." -ForegroundColor Green
docker-compose exec -T app php artisan migrate --force

Write-Host ""
Write-Host "Installation terminee!" -ForegroundColor Green
Write-Host ""
Write-Host "Application disponible sur : http://localhost:8000" -ForegroundColor Cyan
Write-Host "Admin disponible sur : http://localhost:8000/admin/login" -ForegroundColor Cyan
Write-Host "PhpMyAdmin disponible sur : http://localhost:8080" -ForegroundColor Cyan
Write-Host ""
Write-Host "Commandes utiles:" -ForegroundColor Yellow
Write-Host "  - Voir les logs : docker-compose logs -f"
Write-Host "  - Arreter : docker-compose down"
Write-Host "  - Redemarrer : docker-compose restart"
Write-Host "  - Acceder au conteneur : docker-compose exec app bash"
Write-Host ""
