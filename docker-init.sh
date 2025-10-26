#!/bin/bash

echo "🚀 Initialisation de l'application SAELT..."

# Vérifier si .env existe
if [ ! -f .env ]; then
    echo "📝 Copie du fichier .env.example vers .env..."
    cp .env.example .env
fi

# Mettre à jour les variables d'environnement pour Docker
echo "🔧 Configuration de l'environnement Docker..."
sed -i 's/DB_HOST=.*/DB_HOST=db/' .env
sed -i 's/DB_DATABASE=.*/DB_DATABASE=saelt/' .env
sed -i 's/DB_USERNAME=.*/DB_USERNAME=saelt/' .env
sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=root/' .env

# Démarrer les conteneurs
echo "🐳 Démarrage des conteneurs Docker..."
docker-compose up -d

# Attendre que MySQL soit prêt
echo "⏳ Attente du démarrage de MySQL..."
sleep 10

# Installer les dépendances Composer
echo "📦 Installation des dépendances PHP..."
docker-compose exec -T app composer install

# Générer la clé d'application
echo "🔑 Génération de la clé d'application..."
docker-compose exec -T app php artisan key:generate

# Créer le lien de stockage
echo "🔗 Création du lien de stockage..."
docker-compose exec -T app php artisan storage:link

# Donner les permissions
echo "🔐 Configuration des permissions..."
docker-compose exec -T app chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Installer les dépendances NPM
echo "📦 Installation des dépendances NPM..."
docker-compose exec -T app npm install

# Compiler les assets
echo "🎨 Compilation des assets..."
docker-compose exec -T app npm run dev

# Exécuter les migrations
echo "📊 Exécution des migrations..."
docker-compose exec -T app php artisan migrate --force

echo ""
echo "✅ Installation terminée!"
echo ""
echo "🌐 Application disponible sur : http://localhost:8000"
echo "🔧 Admin disponible sur : http://localhost:8000/admin/login"
echo "💾 PhpMyAdmin disponible sur : http://localhost:8080"
echo ""
echo "📝 Commandes utiles:"
echo "  - Voir les logs : docker-compose logs -f"
echo "  - Arrêter : docker-compose down"
echo "  - Redémarrer : docker-compose restart"
echo "  - Accéder au conteneur : docker-compose exec app bash"
echo ""
