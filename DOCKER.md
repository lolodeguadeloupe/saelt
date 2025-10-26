# Configuration Docker pour SAELT

Cette configuration Docker vous permet de lancer l'application SAELT localement avec PHP 8.0, MySQL 8.0 et Nginx.

## Prérequis

- Docker Desktop installé sur votre machine
- Docker Compose (inclus avec Docker Desktop)
- Au minimum 4GB de RAM disponible pour Docker

## Structure des fichiers Docker

```
.
├── Dockerfile                      # Image PHP 8.0-FPM personnalisée
├── docker-compose.yml              # Orchestration des services
├── docker-init.sh                  # Script d'initialisation automatique
├── .dockerignore                   # Fichiers à exclure de l'image Docker
└── docker/
    ├── nginx/
    │   └── conf.d/
    │       └── app.conf            # Configuration Nginx
    ├── php/
    │   └── local.ini               # Configuration PHP
    └── mysql/
        └── my.cnf                  # Configuration MySQL
```

## Services inclus

| Service | Port | Description |
|---------|------|-------------|
| **app** | 9000 | PHP 8.0-FPM (application Laravel) |
| **nginx** | 8000 | Serveur web Nginx |
| **db** | 3307 | MySQL 8.0 (base de données) |
| **phpmyadmin** | 8080 | Interface de gestion MySQL |

## Installation rapide

### Option 1 : Avec le script d'initialisation (Linux/Mac)

```bash
./docker-init.sh
```

### Option 2 : Avec le script d'initialisation (Windows - Git Bash)

```bash
bash docker-init.sh
```

### Option 3 : Installation manuelle

1. **Copier le fichier d'environnement**
   ```bash
   cp .env .env.backup
   ```

2. **Mettre à jour les variables de base de données dans .env**
   ```env
   DB_HOST=db
   DB_DATABASE=saelt
   DB_USERNAME=saelt
   DB_PASSWORD=root
   ```

3. **Construire et démarrer les conteneurs**
   ```bash
   docker-compose up -d --build
   ```

4. **Installer les dépendances PHP**
   ```bash
   docker-compose exec app composer install
   ```

5. **Générer la clé d'application**
   ```bash
   docker-compose exec app php artisan key:generate
   ```

6. **Créer le lien de stockage**
   ```bash
   docker-compose exec app php artisan storage:link
   ```

7. **Configurer les permissions**
   ```bash
   docker-compose exec app chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
   ```

8. **Installer les dépendances NPM et compiler les assets**
   ```bash
   docker-compose exec app npm install
   docker-compose exec app npm run dev
   ```

9. **Exécuter les migrations**
   ```bash
   docker-compose exec app php artisan migrate
   ```

## Accès à l'application

- **Application frontend** : http://localhost:8000
- **Panel admin** : http://localhost:8000/admin/login
- **PhpMyAdmin** : http://localhost:8080
  - Serveur : `db`
  - Utilisateur : `saelt`
  - Mot de passe : `root`

## Commandes utiles

### Gestion des conteneurs

```bash
# Démarrer les conteneurs
docker-compose up -d

# Arrêter les conteneurs
docker-compose down

# Redémarrer les conteneurs
docker-compose restart

# Voir les logs
docker-compose logs -f

# Voir les logs d'un service spécifique
docker-compose logs -f app
docker-compose logs -f nginx
docker-compose logs -f db
```

### Accéder aux conteneurs

```bash
# Accéder au conteneur PHP
docker-compose exec app bash

# Accéder au conteneur MySQL
docker-compose exec db mysql -u saelt -p
```

### Commandes Laravel via Docker

```bash
# Artisan
docker-compose exec app php artisan [commande]

# Exemples
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear

# Composer
docker-compose exec app composer [commande]

# NPM
docker-compose exec app npm [commande]
docker-compose exec app npm run watch
```

### Gestion de la base de données

```bash
# Exporter la base de données
docker-compose exec db mysqldump -u saelt -proot saelt > backup.sql

# Importer une base de données
docker-compose exec -T db mysql -u saelt -proot saelt < backup.sql

# Accéder à MySQL CLI
docker-compose exec db mysql -u saelt -proot saelt
```

## Résolution des problèmes

### Les conteneurs ne démarrent pas

```bash
# Vérifier les logs
docker-compose logs

# Nettoyer et reconstruire
docker-compose down -v
docker-compose up -d --build
```

### Problèmes de permissions

```bash
docker-compose exec app chown -R www-data:www-data /var/www/storage
docker-compose exec app chown -R www-data:www-data /var/www/bootstrap/cache
docker-compose exec app chmod -R 775 /var/www/storage
docker-compose exec app chmod -R 775 /var/www/bootstrap/cache
```

### Erreur de connexion MySQL

Vérifiez que les variables d'environnement dans `.env` correspondent :
```env
DB_HOST=db          # Important : "db" est le nom du service dans docker-compose
DB_PORT=3306        # Port interne (pas 3307)
DB_DATABASE=saelt
DB_USERNAME=saelt
DB_PASSWORD=root
```

### NPM/Assets non compilés

```bash
docker-compose exec app npm install
docker-compose exec app npm run dev
# Ou pour le mode watch
docker-compose exec app npm run watch
```

### Reconstruire l'image Docker

```bash
docker-compose down
docker-compose build --no-cache
docker-compose up -d
```

## Personnalisation

### Changer les ports

Modifiez le fichier `docker-compose.yml` :

```yaml
nginx:
  ports:
    - "VOTRE_PORT:80"  # Changez le premier port

db:
  ports:
    - "VOTRE_PORT:3306"

phpmyadmin:
  ports:
    - "VOTRE_PORT:80"
```

### Modifier la configuration PHP

Éditez le fichier `docker/php/local.ini` puis redémarrez :

```bash
docker-compose restart app
```

### Modifier la configuration Nginx

Éditez le fichier `docker/nginx/conf.d/app.conf` puis redémarrez :

```bash
docker-compose restart nginx
```

## Nettoyage

```bash
# Arrêter et supprimer les conteneurs
docker-compose down

# Arrêter et supprimer les conteneurs + volumes (ATTENTION: supprime la base de données)
docker-compose down -v

# Supprimer les images
docker-compose down --rmi all
```

## Support

Pour toute question ou problème, consultez :
- Documentation Docker : https://docs.docker.com/
- Documentation Laravel : https://laravel.com/docs/8.x
- Documentation Docker Compose : https://docs.docker.com/compose/
