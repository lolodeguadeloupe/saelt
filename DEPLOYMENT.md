# Déploiement sur Coolify

## 📋 Prérequis

- Un serveur avec Coolify installé
- Un domaine pointant vers votre serveur
- Accès au repository GitHub : `https://github.com/lolodeguadeloupe/saelt.git`

## 🚀 Étapes de déploiement

### 1. Créer un nouveau projet dans Coolify

1. Connectez-vous à votre interface Coolify
2. Cliquez sur **"New Resource"**
3. Sélectionnez **"Docker Compose"**
4. Configurez :
   - **Repository** : `https://github.com/lolodeguadeloupe/saelt.git`
   - **Branch** : `main`
   - **Docker Compose File** : `docker-compose.prod.yml`

### 2. Configurer les variables d'environnement

Dans Coolify, ajoutez les variables d'environnement suivantes :

```env
# Application
APP_NAME=SAELT-PRO
APP_ENV=production
APP_KEY=                         # Sera généré automatiquement
APP_DEBUG=false
APP_URL=https://votre-domaine.com
ASSET_URL=https://votre-domaine.com/public

# Database
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=saelt
DB_USERNAME=saelt
DB_PASSWORD=VOTRE_MOT_DE_PASSE_SECURE

# Mail
MAIL_MAILER=smtp
MAIL_HOST=votre-smtp.com
MAIL_PORT=587
MAIL_USERNAME=votre-email@example.com
MAIL_PASSWORD=votre-mot-de-passe-email
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@votre-domaine.com

# Alma Payment (Production)
alma_key=votre-clé-alma-production
alma_base_url=https://api.getalma.eu
alma_api_ver=v1
alma_auth=Alma-Auth

# Session
SESSION_LIFETIME=120
CACHE_DRIVER=file
```

### 3. Script de démarrage (Build Command)

Coolify exécutera automatiquement le build Docker. Ajoutez ce script post-déploiement :

```bash
php artisan key:generate --force
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

### 4. Créer un utilisateur admin

Après le premier déploiement, exécutez via le terminal Coolify :

```bash
php artisan tinker --execute="
\$user = new \Brackets\AdminAuth\Models\AdminUser();
\$user->email = 'admin@saelt-voyages.com';
\$user->password = bcrypt('votre-mot-de-passe-secure');
\$user->first_name = 'Admin';
\$user->last_name = 'SAELT';
\$user->activated = true;
\$user->save();
"
```

### 5. Configuration du domaine

1. Dans Coolify, ajoutez votre domaine
2. Activez le SSL (Let's Encrypt)
3. Configurez le proxy inverse

## 🔧 Commandes utiles

### Voir les logs
```bash
docker-compose -f docker-compose.prod.yml logs -f
```

### Redémarrer l'application
```bash
docker-compose -f docker-compose.prod.yml restart
```

### Exécuter des commandes artisan
```bash
docker-compose -f docker-compose.prod.yml exec app php artisan [commande]
```

### Accéder au conteneur
```bash
docker-compose -f docker-compose.prod.yml exec app bash
```

## 📊 Accès

- **Application frontend** : https://votre-domaine.com
- **Panel admin** : https://votre-domaine.com/admin/login

## 🔒 Sécurité

**IMPORTANT** : Après le déploiement, changez :
- Le mot de passe de la base de données
- Le mot de passe admin
- La clé Alma (passez en production)
- Désactivez `APP_DEBUG=false`

## 🐛 Dépannage

### Erreur "Table not found"
```bash
php artisan migrate:fresh --force
```

### Erreur de permissions
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Cache qui pose problème
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```
