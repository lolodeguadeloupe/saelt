# 🚀 Démarrage Rapide avec Docker

## Installation en 3 étapes

### Windows (PowerShell)
```powershell
# Étape 1 : Exécuter le script d'initialisation
.\docker-init.ps1

# C'est tout ! L'application sera disponible sur http://localhost:8000
```

### Linux/Mac
```bash
# Étape 1 : Rendre le script exécutable
chmod +x docker-init.sh

# Étape 2 : Exécuter le script
./docker-init.sh

# C'est tout ! L'application sera disponible sur http://localhost:8000
```

### Windows (Git Bash / WSL)
```bash
# Étape 1 : Exécuter le script
bash docker-init.sh

# C'est tout ! L'application sera disponible sur http://localhost:8000
```

---

## Accès rapide

| Service | URL | Identifiants |
|---------|-----|--------------|
| **Application** | http://localhost:8000 | - |
| **Admin** | http://localhost:8000/admin/login | À créer |
| **PhpMyAdmin** | http://localhost:8080 | user: `saelt` / pass: `root` |

---

## Commandes essentielles

```bash
# Démarrer
docker-compose up -d

# Arrêter
docker-compose down

# Voir les logs
docker-compose logs -f app

# Accéder au conteneur
docker-compose exec app bash

# Artisan
docker-compose exec app php artisan [commande]

# Compiler les assets
docker-compose exec app npm run dev
```

---

## Besoin d'aide ?

Consultez le fichier [DOCKER.md](DOCKER.md) pour la documentation complète.
