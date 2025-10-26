<?php

return [
    'admin-user' => [
        'title' => 'Utilisateurs',
        'actions' => [
            'index' => 'Utilisateurs',
            'create' => 'Nouvel utilisateur',
            'edit' => 'Modifier :name',
            'edit_profile' => 'Modifier le profil',
            'edit_password' => 'Modifier le mot de passe',
        ],
        'columns' => [
            'id' => 'ID',
            'last_login_at' => 'Dernière connexion',
            'first_name' => 'Prénom',
            'last_name' => 'Nom de famille',
            'email' => 'E-mail',
            'password' => 'Mot de passe',
            'password_repeat' => 'Confirmation du mot de passe',
            'enabled' => 'Activé',
            'interdit' => 'Interdit',
            'language' => 'Langue',
            // Appartient à de nombreuses relations
            'roles' => 'Rôles',
        ],
    ],
    'type-hebergement' => [
        'title' => 'Type d\'hébergement',
        'actions' => [
            'index' => 'Type d\'hébergement',
            'create' => 'Nouveau type d\'hébergement',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'name' => 'Nom',
            'description' => 'Description',
        ],
    ],
    'type-chambre' => [
        'title' => 'Type de Chambre',
        'actions' => [
            'index' => 'Type de Chambre',
            'create' => 'Nouveau type de chambre',
            'edit' => 'Modifier',
            'edit' => 'Modifier',
            'uploadImage' => 'Ajouter image',
            'removeImage' => 'Supprimer'
        ],
        'columns' => [
            'id' => 'ID',
            'name' => 'Nom',
            'nombre_chambre' => 'Nombre de chambre',
            'base_type_id' => 'Base',
            'nombre_personne' => 'Nombre personne',
            'nombre_adulte_max' => 'Nombre adulte max',
            'description' => 'Description',
            'capacite' => 'Capacite max',
            'type_chambre_id' => 'Type de chambre',
            'hebergement_id' => 'Hébergement',
            'type_chambre' => 'Type de chambre',
            'image' => 'Image',
            'status' => 'Disposition',
            'ouverte' => 'Ouverte',
            'fermet' => 'Fermée',
            'calendar' => 'Dates d\'indisponibilité',
            'duration_min' => 'Durée minimale',
            'formule' => 'Formule',
            'cout_supplementaire' => 'Coût supplémentaire'
        ],
    ],
    'island' => [
        'title' => 'Îles',
        'actions' => [
            'index' => 'Îles',
            'create' => 'Nouvelle île',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'name' => 'Nom',
        ],
    ],
    'ville' => [
        'title' => 'Villes',
        'actions' => [
            'index' => 'Villes',
            'create' => 'Nouvelle ville',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'name' => 'Nom',
            'pays_id' => 'Pays',
            'code_postal' => 'Code postal'
        ],
    ],
    'ile' => [
        'title' => 'Île',
        'actions' => [
            'index' => 'Îles',
            'create' => 'Nouvelle île',
            'edit' => 'Modifier',
            'uploadCard' => 'Ajouter carte',
            'removeImage' => 'Supprimer',
            'uploadBackgroundCard' => 'Ajouter background'
        ],
        'columns' => [
            'id' => 'ID',
            'name' => 'Nom',
            'pays_id' => 'Pays',
            'background_image' => 'Background image',
            'card' => 'Carte'
        ],
    ],
    'saison' => [
        'title' => 'Saisonnalité',
        'actions' => [
            'index' => 'Saisonnalité',
            'create' => 'Nouvelle saisonnalité',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Titre',
            'debut' => 'Début',
            'fin' => 'Fin',
        ],
    ],
    'tarif' => [
        'title' => 'Tarifs',
        'actions' => [
            'index' => 'Tarifs',
            'create' => 'Nouveau tarif',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'montant' => 'Montant',
            'devise' => 'Concevoir',
            'type_chambre_id' => 'Tapez chambre',
        ],
    ],
    'hebergement' => [
        'title' => 'Hebergement',
        'actions' => [
            'index' => 'Hebergement',
            'create' => 'Nouvel hébergement',
            'edit' => 'Modifier',
            'uploadFondImage' => 'Ajouter fond image',
            'uploadImage' => 'Ajouter image',
            'removeImage' => 'Supprimer'
        ],
        'columns' => [
            'id' => 'ID',
            'name' => 'Nom',
            'description' => 'Description',
            'nombre' => 'Nombre',
            'type_hebergement' => 'Type hebergement',
            'image' => 'Image',
            'devises_id' => 'Devises',
            'ville_id' => 'Ville',
            'adresse' => 'Adresse',
            'status' => 'Statut',
            'prestataire' => 'Prestataire',
            'heure_fermeture' => 'Heure fermeture',
            'heure_ouverture' => 'Heure ouverture',
            'ouverte' => 'Ouvert',
            'fermet' => 'Fermé',
            'calendar' => 'Dates d\'indisponibilité',
            'taxe' => 'Taxe de séjour',
            'duration_min' => 'Durée minimale',
            'caution' => 'Caution',
            'ile_id' => 'Île',
            'etoil' => 'Nombre etoil',
            'fond_image' => 'Fond image'
        ],
    ],
    'hebergement-vol' => [
        'title' => 'Vol',
        'actions' => [
            'index' => 'Vol',
            'create' => 'info vol',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'depart' => 'Date de départ',
            'arrive' => 'Date d\'arrivée',
            'nombre_jour' => 'Nombre de jour',
            'nombre_nuit' => 'Nombre de nuit',
            'lien_depart' => 'Lieu de départ',
            'lien_arrive' => 'Lieu d\'arrivée',
            'lieu_depart' => 'Aéroport de départ',
            'lieu_arrive' => 'Aéroport d\'arrivée',
            'condition-transport' => "Vol", //Condition transport
            'avec-vol' => 'Hebergement avec vol',
            'sans-vol' => 'Hebergement sans vol',
            'heure' => 'Heure',
            'heure_depart' => 'Heure de depart',
            'heure_arrive' => 'Heure d\'arrivée',
            'allotement_id' => 'Allotement'
        ],
    ],
    'chambre' => [
        'title' => 'Chambres',
        'actions' => [
            'index' => 'Chambres',
            'create' => 'Nouvelle chambre',
            'edit' => 'Modifier',
            'uploadImage' => 'Ajouter image',
            'removeImage' => 'Supprimer'
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Titre',
            'nombre_chambre' => 'Nombre de chambre',
            'base_type_id' => 'Base',
            'nombre_personne' => 'Nombre personne',
            'description' => 'Description',
            'capacite' => 'Capacite max',
            'type_chambre_id' => 'Type de chambre',
            'hebergement_id' => 'Hébergement',
            'type_chambre' => 'Type de chambre',
            'image' => 'Image',
            'status' => 'Disposition',
            'ouverte' => 'Ouverte',
            'fermet' => 'Fermée',
            'calendar' => 'Dates d\'indisponibilité',
            'duration_min' => 'Durée minimale',
        ],
    ],
    'type-personne' => [
        'title' => 'Types de Personne',
        'actions' => [
            'index' => 'Types de Personne',
            'create' => 'Nouveau type de Personne',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'type' => 'Type',
            'age' => 'Âge',
            'description' => 'Description',
        ],
    ],
    'tarif' => [
        'title' => 'Tarifs',
        'actions' => [
            'index' => 'Tarifs',
            'create' => 'Nouveau tarif',
            'edit' => 'Modifier',
            'detail' => 'Informations'
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Titre',
            'montant' => 'Prix d\'achat',
            'devise' => 'Devise',
            'chambre_id' => 'Type chambre',
            'base_type_id' => 'Base',
            'type_personne_id' => 'Type de personne',
            'saison_id' => 'Saisonnalité',
            'description' => 'Description',
            'tarif' => 'Tarif',
            'taxe' => 'Taxe de séjour',
            'taxe_active' => 'Afficher tax',
            'marge_applique' => 'Marge possible',
            'marge_applique_pourcent' => 'Valeur en %',
            'marge_applique_prix' => 'Valeur en prix',
            'vol' => 'Vol',
            'with_vol' => 'Avec vol',
            'duration_min' => 'Durée minimale',
            'type_personne' => 'Type de personne',
            'marge' => 'Marge',
            'prix_achat' => 'Prix d\'achat',
            'prix_vente' => 'Prix de vente',
            'jour_min' => 'Jour min',
            'jour_max' => 'Jour max',
            'nuit_min' => 'Nuit min',
            'nuit_max' => 'Nuit max',
            'tarif_supp' => 'Tarif supplémentaire',
        ],
    ],
    'nav' => [
        'info' => [
            'title' => 'Infos'
        ],
        'type-chambre' => [
            'title' => 'Types de chambre',
            'childre' => [
                'tous' => 'Tous les types',
                'base_type' => 'Bases'
            ]
        ],
        'hebergement' => [
            'title' => 'Hebergements',
            'childre' => [
                'tous' => 'Tous les hébergements',
                'type' => 'Types d\'hébergement',
                'marque_blanche' => 'Marques blanches'
            ]
        ],
        'prestataire' => [
            'title' => 'Prestataires',
            'childre' => []
        ],
        'ile' => [
            'title' => 'Îles',
            'childre' => []
        ],
        'ville' => [
            'title' => 'Villes',
            'childre' => []
        ],
        'pay' => [
            'title' => 'Pays',
            'childre' => []
        ],
        'saison' => [
            'title' => 'Saisonnalités',
            'childre' => [
                'tous' => 'Toutes les saisonnalités',
            ]
        ],
        'tarif' => [
            'title' => 'Tarifs',
            'childre' => [
                'tous' => 'Tous les tarifs',
            ]
        ],
        'personne' => [
            'title' => 'Types de personne',
            'childre' => []
        ],
        'supplement' => [
            'title' => 'Suppléments',
            'childre' => [
                'pension' => 'Formules',
                'activite' => 'Activites',
                'vue' => 'Vues'
            ]
        ],
        'allotement' => [
            'title' => 'Allotements',
            'childre' => [
                'tous' => 'Tous les allotements',
                'compagnie' => 'Toutes les compagnies'
            ]
        ],
        'excursion' => [
            'title' => 'Excursions',
            'childre' => [
                'tous' => 'Toutes les excursions',
            ]
        ],
        'supplement_excursion' => [
            'title' => 'Supplément',
            'childre' => [
                'tous' => '',
            ]
        ],
        'billeterie-maritime' => [
            'title' => 'Billetteries maritimes',
            'childre' => [
                'tous' => 'Tous les billets',
                'compagnie' => 'Compagnies maritimes'
            ]
        ],
        'allotement' => [
            'title' => 'Allotements',
            'childre' => [
                'tous' => 'Tous les allotements',
                'compagnie' => 'Compagnies aérins'
            ]
        ],
        'tarif-excursion' => [
            'title' => 'Tarifs excursions',
            'childre' => [
                'tous' => '',
            ]
        ],
        'compagnie-transport' => [
            'title' => 'Compagnies de tranport',
            'childre' => [
                'tous' => 'Toutes les compagnies',
                'maritime' => 'Trasports maritimes',
                'aerien' => 'Transports aériens'
            ],
        ],
        'taxe' => [
            'title' => 'Taxes',
            'childre' => [
                'tous' => 'Tous les taxes'
            ],
        ],
        'compagnie-liaison-excursion' => [
            'title' => 'Compagnies de liaison',
            'childre' => [
                'tous' => 'Compagnies de liaison',
            ],
        ],
        'location-voiture' => [
            'title' => 'Locations voitures',
            'childre' => [
                'marque-vehicule' => 'Marque vehicule',
                'modele-vehicule' => 'Modele vehicule',
                'famille-vehicule' => 'Familles véhicules',
                'categorie-vehicule' => 'Catégories véhicules',
                'vehicule-location' => 'Véhicules',
                'saisonnalite' => 'Saisonnalité',
                'tranche-saisonnalite' => 'Tranches de durée',
                'tarif' => 'Tarifs',
                'agence-location' => 'Agence location',
                'restriction-trajet-vehicule' => 'Trajet restriction',
                'supplement_location' => 'Suppléments location',
            ]
        ],
        'service-transport' => [
            'title' => 'Aéroports / Ports',
            'childre' => [
                'service-aeroport' => 'Aéroports',
                'service-port' => 'Ports',
            ],
        ],
        'transfert-voyage' => [
            'title' => 'Transfert',
            'childre' => [
                'lieu-transfert' => 'Lieu transfert',
                'trajet' => 'Trajet',
                'type' => 'Type',
                'tarif' => 'Tarif',
                'tranche' => 'Tranche personne',
            ],
        ],
        'produit-descriptif' => [
            'title' => 'Déscriptif',
            'childre' => []
        ],
        'produit-condition-tarifaire' => [
            'title' => 'Condition tarifaire',
            'childre' => []
        ],
        'produit-info-pratique' => [
            'title' => 'Info pratique',
            'childre' => []
        ],
        'itineraire-excursion' => [
            'title' => 'Itinéraire',
            'childre' => []
        ],
        'itineraire-description-excursion' => [
            'title' => 'Itinéraire',
            'childre' => []
        ],
        'commande' => [
            'title' => 'Commande',
            'childre' => []
        ],
        'frais-dossier' => [
            'title' => 'Frais de dossier',
            'childre' => []
        ],
        'mode-payement' => [
            'title' => 'Mode paiement',
            'childre' => []
        ],
        'parametre' => [
            'title' => 'Parametres',
            'childre' => [
                'generale' => 'Générale',
                'supplementaire' => 'Paramétre du module'
            ]
        ],
        'planing-vehicule' => [
            'title' => 'Planing vehicule',
            'childre' => []
        ],
        'coup-coeur-produit' => [
            'title' => 'coups de cœur',
            'childre' => []
        ]
    ],
    'base-type' => [
        'title' => 'Base',
        'actions' => [
            'index' => 'Base',
            'create' => 'Nouvelle base',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Titre',
            'description' => 'Description',
            'nombre' => 'Nombre de personne'
        ],
    ],
    'devises' => [
        'title' => 'Devises',
        'actions' => [
            'index' => 'Devises',
            'create' => 'Nouveau Devises',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Titre',
            'symbole' => 'Symbole',
        ],
    ],
    'pays' => [
        'title' => 'Pays',
        'actions' => [
            'index' => 'Pays',
            'create' => 'Nouveau pays',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'nom' => 'Nom',
        ],
    ],
    'prestataire' => [
        'title' => 'Prestataire',
        'actions' => [
            'index' => 'Prestataire',
            'create' => 'Nouveau prestataire',
            'edit' => 'Modifier',
            'uploadLogo' => 'Ajouter logo',
            'removeImage' => 'Supprimer'
        ],
        'columns' => [
            'id' => 'ID',
            'name' => 'Nom',
            'adresse' => 'Adresse',
            'phone' => 'Numéro téléphone',
            'email' => 'E-mail',
            'second_email' => 'Deuxième adresse e-mail',
            'ville' => 'Ville',
            'ville_id' => 'Ville',
            'pays' => 'Pays',
            'logo' => 'Logo',
            'heure_ouverture' => 'Heure d\'ouverture',
            'heure_fermeture' => 'Heure de fermeture'
        ],
    ],
    'supplement-vue' => [
        'title' => 'Suppléments vues',
        'actions' => [
            'index' => 'Suppléments vues',
            'create' => 'Nouveau supp. vue',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Titre',
            'description' => 'Description',
            'tarif' => 'Tarif',
            'regle_tarif' => 'Appliquer',
            'chambre_id' => 'Chambre',
            'chambre' => 'Chambre',
            'type_personne' => 'Type de personne',
            'marge' => 'Marge',
            'prix_achat' => 'Prix d\'achat',
            'prix_vente' => 'Prix de vente',
            'icon' => 'Icon'
        ],
    ],
    'supplement-activite' => [
        'title' => 'Suppléments activités',
        'actions' => [
            'index' => 'Suppléments activités',
            'create' => 'Nouveau supp. activité',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'TITRE',
            'description' => 'Description',
            'tarif' => 'Tarif',
            'regle_tarif' => 'Appliquer',
            'chambre_id' => 'Chambre',
            'type_personne' => 'Type de personne',
            'marge' => 'Marge',
            'prix_achat' => 'Prix d\'achat',
            'prix_vente' => 'Prix de vente',
            'icon' => 'Icon'
        ],
    ],
    'supplement-pension' => [
        'title' => 'Suppléments formules',
        'actions' => [
            'index' => 'Suppléments formules',
            'create' => 'Nouveau supp. formule',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'TITRE',
            'description' => 'Description',
            'tarif' => 'Tarif',
            'regle_tarif' => 'Appliquer',
            'chambre_id' => 'Chambre',
            'type_personne' => 'Type de personne',
            'marge' => 'Marge',
            'prix_achat' => 'Prix d\'achat',
            'prix_vente' => 'Prix de vente',
            'icon' => 'Icon'
        ],
    ],
    'hebergement-marque-blanche' => [
        'title' => 'Marque blanche',
        'actions' => [
            'index' => 'Marque blanche',
            'create' => 'Nouvelle marque blanche',
            'edit' => 'Modifier',
            'uploadImage' => 'Ajouter image',
            'removeImage' => 'Supprimer'
        ],
        'columns' => [
            'id' => 'ID',
            'liens' => 'Lien',
            'description' => 'Description',
            'type_hebergement_id' => 'Type hebergement',
            'image' => 'Image',
        ],
    ],
    'allotement' => [
        'title' => 'Allotement',
        'actions' => [
            'index' => 'Allotement',
            'create' => 'Nouveau allotement',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Titre',
            'quantite' => 'Quantité',
            'date_depart' => 'Date de départ',
            'date_arrive' => 'Date d\'arrivée',
            'date_limite' => 'Date limite',
            'date_acquisition' => 'Date d\'acquisition',
            'compagnie_transport_id' => 'Compagnie transport',
            'heure_depart' => 'Heure de depart',
            'heure_arrive' => 'Heure d\'arrivée',
            'heure' => 'Heure',
            'lieu_depart' => 'Aéroport de départ',
            'lieu_arrive' => 'Aéroport d\'arrivée',
        ],
    ],
    'compagnie-transport' => [
        'title' => 'Compagnie transport',
        'actions' => [
            'index' => 'Compagnie transport',
            'create' => 'Nouvelle compagnie',
            'edit' => 'Modifier',
            'uploadImage' => 'Ajouter image',
            'uploadLogo' => 'Ajouter logo',
            'removeImage' => 'Supprimer'
        ],
        'columns' => [
            'id' => 'ID',
            'nom' => 'Nom',
            'adresse' => 'Adresse',
            'email' => 'Email',
            'phone' => 'Tél',
            'type_transport' => 'Type transport',
            'ville_id' => 'Ville',
            'ville' => 'Ville',
            'logo' => 'Logo',
            'code_compagnie' => 'Code compagnie',
            'heure_ouverture' => 'Heure d\'ouverture',
            'heure_fermeture' => 'Heure de fermeture'
        ],
    ],
    'event-date-heure' => [
        'title' => 'Calendrier',
        'actions' => [
            'index' => 'Calendrier',
            'create' => 'Créer',
            'edit' => 'Modifier',
            'btn_edit' => 'Modifier',
            'btn_add' => 'Ajouter'
        ],
        'columns' => [
            'id' => 'ID',
            'time_end' => 'Heure de début',
            'time_start' => 'Heure de fin',
            'date' => 'Date',
            'description' => 'Description',
            'status' => 'Status',
            'active' => 'Activé',
            'desactive' => 'Desactivé',
            'style' => 'Color et forme'
        ],
    ],
    'excursion' => [
        'title' => 'Excursion',
        'actions' => [
            'index' => 'Excursions',
            'create' => 'Nouvelle excursion',
            'edit' => 'Modifier',
            'uploadFondImage' => 'Ajouter fond image',
            'uploadImage' => 'Ajouter image',
            'uploadCard' => 'Ajouter carte',
            'removeImage' => 'Supprimer'
        ],
        'columns' => [
            'id' => 'ID',
            'title' => 'Titre',
            'duration' => 'Durée',
            'heure_depart' => 'Heure de départ',
            'heure_arrive' => 'Heure d\'arrivée',
            'availability' => 'Disponibilité',
            'participant_min' => 'Participant min',
            'card' => 'Carte',
            'lunch' => 'Déjeuner inclus',
            'ticket' => 'Billet de bateau inclus',
            'devises_id' => 'Devises',
            'ville_id' => 'Ville',
            'prestataire' => 'Prestataire',
            'description' => 'Description',
            'status' => 'Status',
            'taxe' => 'Taxe de séjour',
            'options_included' => [
                'title' => 'Inclus',
                'lunch' => 'Déjeuner',
                'ticket' => 'Billet de bateau'
            ],
            'ouverte' => 'Ouvert',
            'fermet' => 'Fermé',
            'calendar' => 'Dates d\'indisponibilité',
            'image' => 'Image',
            'lieu_depart' => 'Port de départ',
            'lieu_arrive' => 'Port d\'arrivée',
            'ile_id' => 'Île',
            'adresse_depart' => 'Lieu de départ',
            'adresse_arrive' => 'Lieu d\'arrivée',
            'fond_image' => 'Fond image',
            'lunch_prestataire' => 'Restaurants',
            'ticket_billeterie' => 'Billetteries',
        ],
        'options' => [
            'no' => 'Non',
            'yes' => 'Oui'
        ],
    ],
    'supplement-excursion' => [
        'title' => 'Suppléments',
        'actions' => [
            'index' => 'Supplément',
            'create' => 'Nouveau supplément',
            'edit' => 'Modifier',
        ],
        'type' => [
            'dejeneur' => 'Formule',
            'activite' => 'Activité',
            'autres' => 'Autres'
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Titre',
            'type' => 'Type',
            'type_personne_id' => 'Type personne',
            'tarif' => 'Tarif',
            'supplement_excursion_id' => 'Supplément',
            'icon' => 'Icon'
        ],
    ],
    'billeterie-maritime' => [
        'title' => 'Billetteries maritimes',
        'actions' => [
            'index' => 'Billetterie maritime',
            'create' => 'Nouveau billet',
            'edit' => 'Modifier',
            'gerer' => 'Gérer',
            'uploadImage' => 'Ajouter image',
            'removeImage' => 'Supprimer'
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Titre',
            'type_personne_id' => 'Type personne',
            'tarif' => 'Tarif',
            'tarif_aller' => 'Tarif aller simple',
            'tarif_aller_retour' => 'Tarif aller et retour',
            'prix_achat_aller' => 'Prix d\'achat aller simple',
            'marge_aller' => 'Marge aller simple',
            'prix_vente_aller' => 'Prix de vente aller simple',
            'prix_achat_aller_retour' => 'Prix d\'achat aller et retour',
            'marge_aller_retour' => 'Marge aller et retour',
            'prix_vente_aller_retour' => 'Prix de vente aller et retour',
            'quantite' => 'Nombre billet',
            'compagnie_transport_id' => 'Compagnie transport',
            'planing_time' => 'Horaires',
            'heure-debut' => 'Heure de depart',
            'heure-fin' => 'Heure de retour',
            'date_depart' => 'Date de départ',
            'date_arrive' => 'Date de retour',
            'lieu_depart' => 'Port de départ',
            'lieu_arrive' => 'Port d\'arrivé',
            'date_acquisition' => 'Date d\'acquisition',
            'date_limite' => 'Date limite',
            'image' => 'Image',
            'availability' => 'Disponibilité',
            'duree_trajet' => 'Durée trajet',
            'parcours' => 'Parcours '
        ],
    ],
    'tarif-excursion' => [
        'title' => 'Tarifs excursions',
        'actions' => [
            'index' => 'Tarifs excursions',
            'create' => 'Nouveau tarif',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Saisonnalité',
            'type_personne_id' => 'Type personne',
            'type_personne' => 'Type personne',
            'taxe' => 'Taxe de séjour',
            'supplement' => 'Supplément options',
            'saison' => 'Saisonnalité',
            'montant' => 'Tarif',
            'excursion' => 'Excursion',
            'marge' => 'Marge',
            'prix_achat' => 'Prix d\'achat',
            'prix_vente' => 'Prix de vente',
        ],
    ],
    'taxe' => [
        'title' => 'Taxe',
        'actions' => [
            'index' => 'Taxes',
            'create' => 'Nouveau taxe',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Titre',
            'frais_applique' => 'Taxes appliqués',
            'valeur_pourcent' => 'Taxe en pourcent',
            'valeur_devises' => 'Taxe en valeur',
            'description' => 'Description',
            'taxe_applique' => 'Calcule de taxe',
            'taxe_applique_pourcent' => 'Taxe en pourcent',
            'taxe_applique_prix' => 'Taxe en valeur',
            'TVA' => 'TVA',
            'tva_transfert' => 'TVA sur les Transferts',
            'tva_excursion' => 'TVA sur les excursions',
            'tva_hebergement_pack' => 'TVA sur les hebergements et package',
            'tva_location' => 'TVA sur la location',
            'tva_billetterie' => 'TVA sur la billetterie',
            'tva_autre' => 'Autre'
        ],
    ],
    'compagnie-liaison-excursion' => [
        'title' => 'Compagnies liaisons',
        'tous_compagnie' => 'Tous les compagnies',
        'actions' => [
            'index' => 'Compagnie liaison',
            'create' => 'Ajouter compagnie',
            'edit' => 'Modifier'
        ],
        'columns' => [
            'id' => 'ID',
            'excursion_id' => 'Excursion',
            'compagnie_transport_id' => 'Compagnie',
            'type_transport' => 'Type de transport',
            'quantite_billet' => 'Billes disponibles',
            'billeterie_titre' => 'Billet',
            'billeterie_date_limite' => 'Date limite',
            'billeterie_nombre' => 'Nombre billet',
        ],
    ],
    'planing-time' => [
        'title' => 'Horaire',
        'actions' => [
            'index' => 'Horaire',
            'create' => 'Ajouter',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'debut' => 'Début',
            'fin' => 'Fin',
        ],
    ],
    'famille-vehicule' => [
        'title' => 'Famille véhicule',
        'actions' => [
            'index' => 'Familles véhicules',
            'create' => 'Ajouter',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Titre',
            'description' => 'Description',
        ],
    ],
    'categorie-vehicule' => [
        'title' => 'Categorie véhicule',
        'actions' => [
            'index' => 'Categories véhicules',
            'create' => 'Ajouter',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Titre',
            'famille_vehicule_id' => 'Famille vehicule',
            'description' => 'Description',
            'supplement' => 'Supplément',
        ],
    ],
    'vehicule-location' => [
        'title' => 'Véhicule',
        'actions' => [
            'index' => 'Véhicules',
            'create' => 'Ajouter',
            'edit' => 'Modifier',
            'uploadImage' => 'Ajouter image',
            'removeImage' => 'Supprimer',
            'edition_tarif' => 'Editer tarif'
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Titre',
            'immatriculation' => 'Immatriculation',
            'marque' => 'Marque',
            'modele' => 'Modèle',
            'status' => 'Status',
            'description' => 'Description',
            'date_ouverture' => 'Date d\'ouverture',
            'duration_min' => 'Durée minimale',
            'prestataire_id' => 'Prestataire',
            'categorie_vehicule' => 'Catégorie',
            'famille_vehicule' => 'Famille vehicule',
            'ouverte' => 'Disponible',
            'fermet' => 'Non disponible',
            'calendar' => 'Dates d\'indisponibilité',
            'image' => 'Image',
            'prestataire' => 'Prestataire',
            'famille_vehicule_id' => 'Famille vehicule',
            'categorie_vehicule_id' => 'Catégorie véhicule',
            'ville_id' => 'Ville',
            'pays_id' => 'Pays',
            //
            'franchise' => 'Franchise assurance tous risques',
            'franchise_non_rachatable' => 'Franchise non rachetable',
            'caution' => 'Caution',
        ],
    ],
    'tranche-saison' => [
        'title' => 'Tranche de durée',
        'actions' => [
            'index' => 'Tranches de durée',
            'create' => 'Ajouter',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Tranches',
            'nombre_min' => 'De',
            'nombre_max' => 'à',
            'saison_id' => 'Saisonnalité',
        ],
    ],
    'tarif-tranche-saison-location' => [
        'title' => 'Tarif vehicule location',
        'actions' => [
            'index' => 'Tarif vehicule location',
            'create' => 'Ajouter',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'marge' => 'Marge',
            'prix_achat' => 'Prix d\'achat',
            'prix_vente' => 'Prix de vente',
            'saison_id' => 'Saisonnalité',
            'saison' => 'Saisonnalité',
            'tranche_saison_id' => 'Tranche de durée',
            'tranche_saison' => 'Tranche de durée',
            'tarif' => 'Tarif'
        ],
    ],
    'service-aeroport' => [
        'title' => 'Aéroport',
        'actions' => [
            'index' => 'Aéroport',
            'create' => 'Ajouter',
            'edit' => 'Modifier',
            'uploadImage' => 'Ajouter image',
            'uploadLogo' => 'Ajouter logo',
            'removeImage' => 'Supprimer'
        ],
        'columns' => [
            'id' => 'ID',
            'name' => 'Nom',
            'adresse' => 'Adresse',
            'email' => 'Email',
            'phone' => 'Téléphone',
            'ville_id' => 'Ville',
            'ville' => 'Ville',
            'logo' => 'Logo',
            'calendar' => 'Calendrier',
            'code_service' => 'Code aéroport'
        ],
    ],
    'service-port' => [
        'title' => 'Port',
        'actions' => [
            'index' => 'Port',
            'create' => 'Ajouter',
            'edit' => 'Modifier',
            'uploadImage' => 'Ajouter image',
            'uploadLogo' => 'Ajouter logo',
            'removeImage' => 'Supprimer'
        ],
        'columns' => [
            'id' => 'ID',
            'name' => 'Nom',
            'adresse' => 'Adresse',
            'email' => 'Email',
            'phone' => 'Téléphone',
            'ville_id' => 'Ville',
            'ville' => 'Ville',
            'logo' => 'Logo',
            'calendar' => 'Calendrier',
            'code_service' => 'Code port'
        ],
    ],
    'trajet-transfert-voyage' => [
        'title' => 'Trajet transfert',
        'actions' => [
            'index' => 'Trajets transferts',
            'create' => 'Ajouter',
            'edit' => 'Modifier',
            'uploadCard' => 'Ajouter cart',
            'removeImage' => 'Supprimer'
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Titre',
            'point_depart' => 'Lieu de départ',
            'point_arrive' => 'Lieu d\'arrivée',
            'description' => 'Description',
            'card' => 'Carte',
            'tarif' => 'Tarif'
        ],
    ],
    'type-transfert-voyage' => [
        'title' => 'Type transfert',
        'actions' => [
            'index' => 'Types transferts',
            'create' => 'Ajouter',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Titre',
            'nombre_min' => 'Nombre personne min',
            'nombre_max' => 'Nombre personne max',
            'description' => 'Description',
            'tranche-personne' => 'Tranche personne',
            'vehicule' => 'Vehicule',
            'prestataire_id' => 'Prestataire',
            'prestataire' => 'Prestataire'
        ],
    ],
    'tranche-personne-transfert-voyage' => [
        'title' => 'Tranche de personnes',
        'actions' => [
            'index' => 'Tranches de personnes',
            'create' => 'Ajouter',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Tranches',
            'nombre_min' => 'Nb min',
            'nombre_max' => 'Nb max',
            'type_transfert_id' => 'Type transfert',
            'tarif-trajet' => 'Tarif de trajet'
        ],
    ],
    'tarif-transfert-voyage' => [
        'title' => 'Tarif de trajet',
        'actions' => [
            'index' => 'Tarif de trajet',
            'create' => 'Nouveau tarif',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'type_personne_id' => 'Type personne',
            'type_personne' => 'Type personne',
            'tarif' => 'Tarif',
            'tarif_aller' => 'Tarif aller simple',
            'tarif_aller_retour' => 'Tarif aller et retour',
            'prix_achat_aller' => 'Prix d\'achat aller simple',
            'marge_aller' => 'Marge aller simple',
            'prix_vente_aller' => 'Prix de vente aller simple',
            'prix_achat_aller_retour' => 'Prix d\'achat aller et retour',
            'marge_aller_retour' => 'Marge aller et retour',
            'prix_vente_aller_retour' => 'Prix de vente aller et retour',
            'type_transfert_voyage' => 'Type transfert',
            'tranche_personne_transfert_voyage' => 'Tranche personne',
            'tranche_transfert_voyage_id' => 'Tranche personne',
            'tranche_personne_transfert_voyage_unite' => 'pers.',
            'tranche_personne_transfert_voyage_interval' => 'à',
            'trajet_transfert_voyage' => 'Trajet transfert',
            'trajet_transfert_voyage_id' => 'Trajet transfert',
            'trajet_transfert_voyage_interval' => 'vers',
            'prime_nuit' => 'Prime nuit',
            'marge' => 'Marge',
            'prix_achat' => 'Prix d\'acaht',
            'prix_vente' => 'Prix de vente',
        ],
    ],
    'modele-vehicule' => [
        'title' => 'Modèle vehicule',
        'actions' => [
            'index' => 'Modèles vehicules',
            'create' => 'Ajouter',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Titre',
            'description' => 'Description',
        ],
    ],
    'marque-vehicule' => [
        'title' => 'Marque vehicule',
        'actions' => [
            'index' => 'Marques vehicules',
            'create' => 'Ajouter',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Titre',
            'description' => 'Description',
        ],
    ],
    'lieu-transfert' => [
        'title' => 'Lieu de transfert',
        'actions' => [
            'index' => 'Lieux de transfert',
            'create' => 'Ajouter',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Lieu transfert',
            'adresse' => 'Adresse',
            'ville' => 'Ville',
            'ville_id' => 'Ville',
        ],
    ],
    'agence-location' => [
        'title' => 'Agence location',
        'actions' => [
            'index' => 'Agences locations',
            'create' => 'Ajouter',
            'edit' => 'Modifier',
            'uploadImage' => 'Ajouter image',
            'uploadLogo' => 'Ajouter logo',
            'removeImage' => 'Supprimer'
        ],
        'columns' => [
            'id' => 'ID',
            'name' => 'Nom',
            'adresse' => 'Adresse',
            'email' => 'Email',
            'phone' => 'Téléphone',
            'ville_id' => 'Ville',
            'ville' => 'Ville',
            'logo' => 'Logo',
            'calendar' => 'Calendrier',
            'code_agence' => 'Code d\'agence',
            'heure_ouverture' => 'Heure d\'ouverture',
            'heure_fermeture' => 'Heure de fermeture'
        ],
    ],
    'vehicule-transfert-voyage' => [
        'title' => 'Véhicule',
        'actions' => [
            'index' => 'Véhicules',
            'create' => 'Ajouter',
            'edit' => 'Modifier',
            'uploadImage' => 'Ajouter image',
            'removeImage' => 'Supprimer'
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Titre',
            'immatriculation' => 'Immatriculation',
            'marque' => 'Marque',
            'modele' => 'Modèle',
            'status' => 'Status',
            'description' => 'Description',
            'date_ouverture' => 'Date d\'ouverture',
            'duration_min' => 'Durée minimale',
            'prestataire_id' => 'Prestataire',
            'categorie_vehicule' => 'Catégorie',
            'famille_vehicule' => 'Famille vehicule',
            'ouverte' => 'Disponible',
            'fermet' => 'Non disponible',
            'calendar' => 'Dates d\'indisponibilité',
            'image' => 'Image',
            'prestataire' => 'Prestataire',
            'famille_vehicule_id' => 'Famille vehicule',
            'categorie_vehicule_id' => 'Catégorie véhicule',
            'ville_id' => 'Ville',
            'pays_id' => 'Pays'
        ],
    ],
    'vehicule-location-info-tech' => [
        'title' => 'Info technique',
        'actions' => [
            'index' => 'Info technique',
            'create' => 'Ajouter',
            'edit' => 'Modifier',
            'uploadFile' => 'Ajouter fichier',
            'removeFile' => 'Supprimer'
        ],
        'columns' => [
            'id' => 'ID',
            'nombre_place' => 'Nombre de places',
            'nombre_porte' => 'Nombre de portes',
            'type_carburant' => 'Type de carburant',
            'nombre_vitesse' => 'Nombre de vitesse',
            'vitesse_maxi' => 'Vitesse max',
            'boite_vitesse' => 'Boite de vitesse',
            'fiche_technique' => 'Fiche technique',
            'kilometrage' => 'Kilométrage'
        ],
        'options-boite_vitesse' => [
            'auto' => 'Automatique',
            'manuelle' => 'Manuelle'
        ],
        'options-carburant' => [
            'essence' => 'Essence',
            'diesel' => 'Diesel',
            'electrique' => 'Eléctrique'
        ]
    ],
    'vehicule-categorie-supplement' => [
        'title' => 'Supplément categorie vehicule',
        'actions' => [
            'index' => 'Suppléments de categorie vehicule',
            'create' => 'Ajouter',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'trajet' => 'Trajet inter-agence',
            'categorie' => 'Categorie vehicule',
            'categorie_vehicule_id' => 'Categorie vehicule',
            'tarif' => 'Tarif'
        ],
    ],
    'restriction-trajet-vehicule' => [
        'title' => 'Trajet inter-agence',
        'actions' => [
            'index' => 'Trajets inter-agences',
            'create' => 'Ajouter',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Titre',
            'caution' => 'Caution',
            'agence_location_arrive' => 'Agence arrivé',
            'agence_location_depart' => 'Agence départ',
        ],
    ],
    'produit-descriptif' => [
        'title' => 'Descriptiif',
        'actions' => [
            'index' => 'Descriptif détaillé',
            'edit' => 'Modifier',
        ],
        'columns' => [],
    ],
    'produit-condition-tarifaire' => [
        'title' => 'Condition tarifaire',
        'actions' => [
            'index' => 'Conditions tarifaires',
            'edit' => 'Modifier',
        ],
        'columns' => [],
    ],
    'produit-info-pratique' => [
        'title' => 'Info pratique',
        'actions' => [
            'index' => 'Info pratique',
            'edit' => 'Modifier',
        ],
        'columns' => [],
    ],
    'itineraire-excursion' => [
        'title' => 'Itinéraire',
        'actions' => [
            'index' => 'Itinéraire',
            'edit' => 'Modifier',
            'create' => 'Ajouter',
            'uploadImage' => 'Ajouter image',
            'removeImage' => 'Supprimer'
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Titre',
            'description' => 'Description',
            'rang' => 'Rang',
            'image' => 'Image',
        ],
    ],
    'itineraire-description-excursion' => [
        'title' => 'Itinéraire',
        'actions' => [
            'index' => 'Itinéraire',
            'edit' => 'Modifier',
            'create' => 'Ajouter',
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Titre',
            'description' => 'Description',
            'rang' => 'Rang',
            'image' => 'Image',
        ],
    ],
    'commande' => [
        'title' => 'Liste commande',
        'actions' => [
            'index' => 'Liste des commandes',
            'edit' => 'Modifier',
            'create' => 'Ajouter'
        ],
        'columns' => [
            'id' => 'ID',
            'nom' => 'Nom',
            'prenom' => 'Prénom',
            'ville' => 'Ville',
            'code_postal' => 'Code postal',
            'date' => 'Date commande',
            'status' => 'Status commande',
            'prix' => 'Prix',
            'tva' => 'TVA',
            'frais_dossier' => 'Frais de dossier',
            'prix_total' => 'Prix',
            'mode_payement' => 'Mode payement'
        ],
    ],
    'frais-dossier' => [
        'title' => 'Frais de dossier',
        'actions' => [
            'index' => 'Frais de dossiers',
            'edit' => 'Modifier',
            'create' => 'Ajouter'
        ],
        'options' => [
            'no' => 'Non',
            'yes' =>  'Oui'
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Titre',
            'debut' => 'Début',
            'fin' => 'Fin',
            'prix' => 'Prix',
            'saison' => 'Saisonnalité'
        ],
    ],
    'produit' => [
        'title' => 'Produit',
        'actions' => [
            'index' => 'Produits',
            'edit' => 'Modifier',
            'create' => 'Ajouter'
        ],
        'options' => [
            'on' => 'Actif',
            'of' =>  'Inactif'
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Titre',
        ],
    ],
    'mode-payement' => [
        'title' => 'Mode paiement',
        'actions' => [
            'index' => 'Mode paiements',
            'edit' => 'Modifier',
            'create' => 'Ajouter'
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Titre',
            'icon' => 'Icon',
            'config' => [
                'key_test' => 'Api key test',
                'key_prod' => 'Api key production',
                'base_url_test' => 'Base url test',
                'base_url_prod' => 'Base url production',
                'mode' => 'Mode',
                'api_version' => 'Api version'
            ]
        ],
    ],
    'app-config' => [
        'title' => 'Générale',
        'actions' => [
            'index' => 'Générale',
            'edit' => 'Modifier',
            'uploadLogo' => 'Ajouter logo',
            'removeImage' => 'Supprimer'
        ],
        'columns' => [
            'id' => 'ID',
            'email' => 'email',
            'nom' => 'Nom',
            'adresse' => 'Adresse',
            'site_web' => 'Site web',
            'telephone' => 'Téléphone',
            'ville_id' => 'Ville',
            'ville' => 'Ville'
        ],
    ],
    'app-module' => [
        'frais_internet' => 'Frais de dossier en ligne',
        'frais_agence' => 'Frais de dossier à l\'agence',
        'options' => [
            'on' => 'Actif',
            'of' =>  'Inactif'
        ],
        'hebergement' => 'Hébergement',
        'excursion' => 'Excursion',
        'transfert' => 'Transfert',
        'location' => 'Location',
        'billetterie' => 'Billetterie'
    ],
    'planing-vehicule' => [
        'title' => 'Planing véhicule',
        'actions' => [
            'index' => 'Planing véhicule',
            'create' => 'Nouveau planing',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Titre',
            'symbole' => 'Symbole',
        ],
    ],
    'coup-coeur-produit' => [
        'title' => 'coups de cœur',
        'search' => "Rechercher par <i>Titre, référence, île, ville</i>",
        'actions' => [
            'index' => 'coups de cœur',
            'create' => 'Nouveau planing',
            'edit' => 'Modifier',
            'ajouter' => 'Ajouter',
            'delete' => 'Enlever',
            'all_coup_coeur' => 'Tous les coûps de coeur',
        ],
        'columns' => [
            'id' => 'ID',
            'produit' => 'Produit',
            'reference' => 'Référence',
            'titre' => 'Titre',
            'ile' => 'Île',
            'ville' => 'Ville',
        ],
    ],
    'supplement-location-vehicule' => [
        'title' => 'Supplément location vehicule',
        'supplement_jeune_conducteur_location_vehicule' => 'Supplément de jeune conducteur',
        'supplement_conducteur_supplementaire_location_vehicule' => 'Conducteur supplémentaire',
        'columns' => [
            'min_age' => 'Âge  minimum compris',
            'max_age' => 'Âge  miximum compris',
            'valeur_pourcent' => 'Prix en pourcent',
            'valeur_devises' => 'Prix en valeur',
            'valeur_appliquer' => 'Mode de calcule',
            /** */
            'valeur_pourcent' => 'Prix en pourcent',
            'valeur_devises' => 'Prix en valeur',
            'valeur_appliquer' => 'Mode de calcule',
        ]
    ],
    // Do not delete me :) I'm used for auto-generation
];
