# Routes de l'application SAELT

## 📋 Table des matières

- [Routes Frontend (Public)](#routes-frontend-public)
- [Routes Admin (Backend)](#routes-admin-backend)
- [Routes API](#routes-api)
- [Routes Authentification](#routes-authentification)

---

## 🌐 Routes Frontend (Public)

### Page d'accueil
```
GET  /                           → Home
```

### Hébergements
```
GET  /hebergements                                    → Liste des hébergements
GET  /hebergements/hebergement-product-avec-vol      → Produits avec vol
GET  /hebergements/hebergement-product-sans-vol      → Produits sans vol
GET  /hebergements/hebergement-host                  → Détails hébergement
GET  /hebergements/hebergement-all-hosts             → Tous les hébergements
POST /hebergements/product-prices                    → Prix des produits
```

### Excursions
```
GET  /excursions                        → Liste des excursions
GET  /excursions/excursion-product      → Détails excursion
GET  /excursions/excursion-all-products → Toutes les excursions
POST /excursions/product-prices         → Prix des excursions
```

### Location de véhicules
```
GET  /locations                  → Liste des locations
GET  /locations/location-product → Détails location
POST /locations/product-prices   → Prix des locations
```

### Billetterie
```
GET  /billetteries → Billetterie maritime/aérienne
```

### Transferts
```
GET  /transferts → Transferts de voyage
```

### Panier & Commande
```
GET  /panier              → Panier d'achat
POST /put-request         → Enregistrer une demande
POST /put-commande        → Créer une commande
POST /get-commande        → Récupérer une commande
POST /all-commande        → Toutes les commandes
POST /delete-commande     → Supprimer une commande
POST /check-commande      → Vérifier timeout commande
```

### Facturation & Paiement
```
GET  /facturation                → Page de facturation
POST /paiement-facturation       → Traiter paiement
GET  /check-facturation          → Vérifier statut facturation
```

### Remerciement
```
GET  /remerciement              → Page de remerciement
GET  /conducteur-info/{id}      → Infos conducteur
```

---

## 🔐 Routes Admin (Backend)

**Préfixe**: `/admin`
**Middleware**: `auth:admin`, `admin`

### Dashboard
```
GET  /admin → Dashboard admin
```

### Gestion des utilisateurs admin
```
GET  /admin/admin-users          → Liste
GET  /admin/admin-users/create   → Créer
POST /admin/admin-users          → Enregistrer
GET  /admin/admin-users/{id}/edit → Éditer
POST /admin/admin-users/{id}     → Mettre à jour
POST /admin/admin-users/bulk-destroy → Supprimer en masse
```

### Hébergements (Admin)

#### Types d'hébergement
```
GET  /admin/type-hebergements          → Liste
GET  /admin/type-hebergements/create   → Créer
POST /admin/type-hebergements          → Enregistrer
GET  /admin/type-hebergements/{id}/edit → Éditer
POST /admin/type-hebergements/{id}     → Mettre à jour
POST /admin/type-hebergements/bulk-destroy → Supprimer en masse
```

#### Types de chambre
```
GET  /admin/type-chambres          → Liste
GET  /admin/type-chambres/create   → Créer
POST /admin/type-chambres          → Enregistrer
GET  /admin/type-chambres/{id}/edit → Éditer
POST /admin/type-chambres/{id}     → Mettre à jour
POST /admin/type-chambres/{id}/calendar → Calendrier
POST /admin/type-chambres/bulk-destroy → Supprimer en masse
```

#### Hébergements
```
GET  /admin/hebergements                    → Liste
GET  /admin/hebergements/create             → Créer
POST /admin/hebergements                    → Enregistrer
POST /admin/hebergements/prestataire        → Avec prestataire
GET  /admin/hebergements/{id}/edit          → Éditer
GET  /admin/hebergements/{id}               → Voir détails
POST /admin/hebergements/{id}               → Mettre à jour
POST /admin/hebergements/{id}/prestataire/{pid} → MAJ prestataire
POST /admin/hebergements/{id}/calendar      → Calendrier
POST /admin/hebergements/bulk-destroy       → Supprimer en masse
```

#### Tarifs hébergement
```
GET  /admin/tarifs              → Liste
GET  /admin/tarifs/create       → Créer
POST /admin/tarifs              → Enregistrer
POST /admin/tarifs/vol          → Avec vol
GET  /admin/tarifs/{id}/edit    → Éditer
GET  /admin/tarifs/{id}         → Voir détails
POST /admin/tarifs/{id}         → Mettre à jour
POST /admin/tarifs/vol/{id}     → MAJ avec vol
POST /admin/tarifs/bulk-destroy → Supprimer en masse
```

#### Suppléments hébergement
```
Pension:
  /admin/supplement-pensions/*

Activités:
  /admin/supplement-activites/*

Vue:
  /admin/supplement-vues/*

Tarifs suppléments:
  /admin/tarif-supplement-pensions/*
  /admin/tarif-supplement-activites/*
  /admin/tarif-supplement-vues/*
```

#### Allotements
```
GET  /admin/allotements          → Liste
POST /admin/allotements          → Créer
GET  /admin/allotements/{id}/edit → Éditer
POST /admin/allotements/{id}     → Mettre à jour
```

### Excursions (Admin)

#### Excursions
```
GET  /admin/excursions                    → Liste
GET  /admin/excursions/create             → Créer
POST /admin/excursions                    → Enregistrer
POST /admin/excursions/prestataire        → Avec prestataire
GET  /admin/excursions/{id}/edit          → Éditer
GET  /admin/excursions/{id}               → Voir détails
POST /admin/excursions/{id}               → Mettre à jour
POST /admin/excursions/bulk-destroy       → Supprimer en masse
```

#### Tarifs excursion
```
GET  /admin/tarif-excursions         → Liste
POST /admin/tarif-excursions         → Créer
GET  /admin/tarif-excursions/{id}/edit → Éditer
POST /admin/tarif-excursions/{id}    → Mettre à jour
POST /admin/tarif-excursions/update-all → MAJ globale
```

#### Suppléments excursion
```
GET  /admin/supplement-excursions         → Liste
POST /admin/supplement-excursions         → Créer
GET  /admin/supplement-excursions/{id}/edit → Éditer
POST /admin/supplement-excursions/{id}    → Mettre à jour
```

#### Itinéraires
```
GET  /admin/itineraire-excursions → Itinéraires
POST /admin/itineraire-excursions → Créer
GET  /admin/itineraire-excursions/{id}/edit → Éditer
POST /admin/itineraire-excursions/{id} → Mettre à jour
```

#### Compagnies liaison
```
GET  /admin/compagnie-liaison-excursions → Liste
POST /admin/compagnie-liaison-excursions → Créer
```

### Location de véhicules (Admin)

#### Véhicules
```
GET  /admin/vehicule-locations         → Liste
GET  /admin/vehicule-locations/create  → Créer
POST /admin/vehicule-locations         → Enregistrer
GET  /admin/vehicule-locations/{id}/edit → Éditer
POST /admin/vehicule-locations/{id}    → Mettre à jour
```

#### Catégories & Familles
```
Catégories:
  /admin/categorie-vehicules/*

Familles:
  /admin/famille-vehicules/*

Marques:
  /admin/marque-vehicules/*

Modèles:
  /admin/modele-vehicules/*
```

#### Agences de location
```
GET  /admin/agence-locations         → Liste
POST /admin/agence-locations         → Créer
GET  /admin/agence-locations/{id}/edit → Éditer
POST /admin/agence-locations/{id}    → Mettre à jour
```

#### Tarifs location
```
GET  /admin/tarif-tranche-saison-locations → Tarifs saisonniers
POST /admin/tarif-tranche-saison-locations → Créer
```

#### Suppléments location
```
Jeune conducteur:
  /admin/supplement-jeune-conducteur-location-vehicules/*

Conducteur supplémentaire:
  /admin/conducteur-supplemetaire-location-vehicules/*

Retard restitution:
  /admin/interet-retard-restitution-vehicules/*
```

#### Planning véhicules
```
GET  /admin/planing-vehicules → Planning
POST /admin/planing-vehicules → Gérer
```

### Transferts de voyage (Admin)

```
Types:
  /admin/type-transfert-voyages/*

Véhicules:
  /admin/vehicule-transfert-voyages/*

Trajets:
  /admin/trajet-transfert-voyages/*

Tarifs:
  /admin/tarif-transfert-voyages/*

Lieux:
  /admin/lieu-transferts/*
```

### Billetterie maritime (Admin)

```
GET  /admin/billeterie-maritimes         → Liste
POST /admin/billeterie-maritimes         → Créer
GET  /admin/billeterie-maritimes/{id}/edit → Éditer
POST /admin/billeterie-maritimes/{id}    → Mettre à jour

Tarifs:
  /admin/tarif-billeterie-maritimes/*
```

### Commandes (Admin)

```
GET  /admin/commandes              → Liste des commandes
GET  /admin/commandes/create       → Créer commande
POST /admin/commandes              → Enregistrer
GET  /admin/commandes/{id}/edit    → Éditer
POST /admin/commandes/{id}         → Mettre à jour
POST /admin/commandes/bulk-destroy → Supprimer en masse

Lignes de commande:
  /admin/ligne-commandes/*
  /admin/ligne-commande-chambres/*
  /admin/ligne-commande-excursions/*
  /admin/ligne-commande-locations/*
  /admin/ligne-commande-billeteries/*
  /admin/ligne-commande-transferts/*
  /admin/ligne-commande-supplements/*
```

### Facturation (Admin)

```
GET  /admin/facturation-commandes → Liste factures
POST /admin/facturation-commandes → Créer facture
GET  /admin/facturation-commandes/{id}/edit → Éditer
POST /admin/facturation-commandes/{id} → Mettre à jour
```

### Configuration générale (Admin)

#### Pays, Villes, Îles
```
Pays:
  /admin/pays/*

Villes:
  /admin/villes/*

Îles:
  /admin/iles/*
```

#### Compagnies de transport
```
GET  /admin/compagnie-transports → Liste
POST /admin/compagnie-transports → Créer
```

#### Services
```
Services aéroport:
  /admin/service-aeroports/*

Services port:
  /admin/service-ports/*
```

#### Types de personne
```
GET  /admin/type-personnes → Types (adulte, enfant, bébé)
POST /admin/type-personnes → Créer
```

#### Devises
```
GET  /admin/devises → Liste devises
POST /admin/devises → Créer
```

#### Taxes
```
GET  /admin/taxes    → Liste taxes
POST /admin/taxes    → Créer
GET  /admin/taxes/{id}/edit → Éditer
POST /admin/taxes/{id} → Mettre à jour
```

#### Modes de paiement
```
GET  /admin/mode-payements → Liste
POST /admin/mode-payements → Créer
```

#### Frais de dossier
```
GET  /admin/frais-dossiers → Liste
POST /admin/frais-dossiers → Créer
```

#### Saisons
```
GET  /admin/saisons → Saisons touristiques
POST /admin/saisons → Créer
```

#### Configuration app
```
GET  /admin/app-configs → Configuration
POST /admin/app-configs → Mettre à jour
```

#### Prestataires
```
GET  /admin/prestataires → Liste prestataires
POST /admin/prestataires → Créer
```

#### Produits (Coup de cœur)
```
GET  /admin/produits → Produits phares
POST /admin/produits → Créer

GET  /admin/coup-coeur-produits → Coups de cœur
POST /admin/coup-coeur-produits → Gérer
```

#### Upload média
```
POST /admin/upload → Upload images
```

---

## 🔌 Routes API

```
GET /api/user → Utilisateur connecté (auth:api)
```

---

## 🔐 Routes Authentification

### Frontend
```
GET  /login           → Page de connexion
POST /login           → Se connecter
POST /logout          → Se déconnecter
GET  /register        → Page d'inscription
POST /register        → S'inscrire
POST /forgot-password → Mot de passe oublié
POST /reset-password  → Réinitialiser mot de passe
GET  /verify-email    → Vérifier email
POST /email/verification-notification → Renvoyer email
```

### Admin
```
GET  /admin/login           → Connexion admin
POST /admin/login           → Se connecter (admin)
POST /admin/logout          → Se déconnecter (admin)
POST /admin/password/email  → Mot de passe oublié
POST /admin/password/reset  → Réinitialiser
```

---

## 🔍 Routes Autocomplétion (Ajax)

```
POST /admin/iles/autocomplete                   → Îles
POST /admin/billeterie-maritimes/autocomplete   → Billetterie
POST /admin/villes/autocomplete                 → Villes
```

---

## 💳 Routes Paiement

```
POST /payement/check/{id}  → Vérifier paiement
GET  /payement/return      → Retour paiement
POST /payement/notify      → Notification paiement (webhook)
```

---

## 📊 Résumé

- **Frontend** : ~30 routes publiques
- **Admin** : ~400+ routes pour la gestion complète
- **API** : Routes minimales (extensible)
- **Total** : Plus de 450 routes

### Contrôleurs principaux

**Frontend :**
- HomeController
- HebergementController
- ExcursionController
- LocationController
- BilletterieController
- TransfertController
- PanierController
- FacturationController
- RemerciementController

**Admin :**
- Hébergement (10+ contrôleurs)
- Excursion (8+ contrôleurs)
- Location véhicule (15+ contrôleurs)
- Transfert (7+ contrôleurs)
- Commande & Facturation
- Configuration générale

---

**Note** : Toutes les routes admin nécessitent une authentification et les permissions appropriées.
