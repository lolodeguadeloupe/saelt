# Configuration Coolify pour SAELT

## 🔧 Configuration du Projet

### 1. Type de déploiement
- **Type** : Docker Compose
- **Repository** : `https://github.com/lolodeguadeloupe/saelt.git`
- **Branch** : `main`
- **Compose File** : `docker-compose.prod.yml`

### 2. Service à exposer
**IMPORTANT** : Configurez le service principal comme suit :
- **Service** : `nginx`
- **Port** : `80`
- **Domaine** : `saelt.guadajobservices.fr`

### 3. Variables d'environnement essentielles

```env
APP_NAME=SAELT-PRO
APP_ENV=production
APP_DEBUG=false
APP_URL=https://saelt.guadajobservices.fr
ASSET_URL=https://saelt.guadajobservices.fr/public

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=saelt
DB_USERNAME=saelt
DB_PASSWORD=GENEREZ_UN_MOT_DE_PASSE_SECURE

MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@saelt-voyages.com
MAIL_FROM_NAME=SAELT-PRO

SESSION_LIFETIME=120
CACHE_DRIVER=file
QUEUE_CONNECTION=sync

alma_key=
alma_base_url=https://api.getalma.eu
alma_api_ver=v1
alma_auth=Alma-Auth
```

### 4. Post-Deployment Commands

Après le premier déploiement réussi, exécutez via le terminal du conteneur `app` :

```bash
# Générer la clé d'application
php artisan key:generate --force

# Exécuter les migrations
php artisan migrate --force

# Créer le lien symbolique pour le storage
php artisan storage:link

# Optimiser l'application
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Installer les dépendances npm et compiler les assets
npm install
npm run production
```

### 5. Créer l'utilisateur admin

```bash
php artisan tinker --execute="
\$user = new \Brackets\AdminAuth\Models\AdminUser();
\$user->email = 'admin@saelt-voyages.com';
\$user->password = bcrypt('VotreMotDePasseSecure123!');
\$user->first_name = 'Admin';
\$user->last_name = 'SAELT';
\$user->activated = true;
\$user->save();
echo 'Admin créé avec succès!';
"
```

## 🐛 Résolution des problèmes

### Bad Gateway (502)
Si vous obtenez une erreur 502 :

1. **Vérifiez que tous les services sont running** :
   - `app` doit être "healthy"
   - `nginx` doit être "healthy"
   - `db` doit être "healthy"

2. **Vérifiez les logs** :
   - Logs du conteneur `app` : Erreurs PHP/Laravel
   - Logs du conteneur `nginx` : Erreurs de connexion
   - Logs du conteneur `db` : Problèmes de base de données

3. **Variables d'environnement** :
   - `APP_KEY` doit être généré
   - `DB_PASSWORD` doit être défini
   - `DB_HOST=db` (nom du service Docker)

### Les assets (CSS/JS) ne se chargent pas

```bash
php artisan storage:link
npm run production
php artisan optimize
```

### Erreurs de permissions

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Base de données : Table not found

```bash
php artisan migrate:fresh --force --seed
```

## 📊 URLs d'accès

- **Frontend** : https://saelt.guadajobservices.fr
- **Admin Panel** : https://saelt.guadajobservices.fr/admin/login

## 🔐 Sécurité

- ✅ Changez le mot de passe DB par défaut
- ✅ Utilisez un mot de passe admin fort
- ✅ `APP_DEBUG=false` en production
- ✅ Activez SSL (Let's Encrypt dans Coolify)
- ✅ Configurez des sauvegardes régulières de la DB

## 🔄 Mise à jour de l'application

Pour déployer une nouvelle version :

1. Poussez vos changements sur GitHub
2. Dans Coolify, cliquez sur **"Redeploy"**
3. Attendez que le build se termine
4. Vérifiez que l'application fonctionne

Si nécessaire, exécutez après le redéploiement :
```bash
php artisan migrate --force
php artisan optimize
```
