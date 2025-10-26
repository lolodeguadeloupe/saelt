<?php

return [
    'admin-user' => [
        'title' => 'Users',
        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],
        'columns' => [
            'id' => 'ID',
            'last_login_at' => 'Last login',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',
            // Belongs to many relations
            'roles' => 'Roles',
        ],
    ],
    'type-hebergement' => [
        'title' => 'Type of accommodation',
        'actions' => [
            'index' => 'Type of accommodation',
            'create' => 'New Type Hebergement',
            'edit' => 'Edit',
        ],
        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
        ],
    ],
    'type-chambre' => [
        'title' => 'Room type',
        'actions' => [
            'index' => 'Room type',
            'create' => 'New Type Room',
            'edit' => 'Edit :name',
        ],
        'columns' => [
            'id' => 'ID',
        ],
    ],
    'type-chambre' => [
        'title' => 'Room type',
        'actions' => [
            'index' => 'Room type',
            'create' => 'New Type Room',
            'edit' => 'Edit',
        ],
        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
        ],
    ],
    'island' => [
        'title' => 'Islands',
        'actions' => [
            'index' => 'Islands',
            'create' => 'New Island',
            'edit' => 'Edit',
        ],
        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
        ],
    ],
    'ville' => [
        'title' => 'Cities',
        'actions' => [
            'index' => 'Cities',
            'create' => 'New Town',
            'edit' => 'Edit',
        ],
        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'pays_id' => 'Country',
            'code_postal' => 'Postal code'
        ],
    ],
    'chambre' => [
        'title' => 'Room',
        'actions' => [
            'index' => 'Room',
            'create' => 'New Room',
            'edit' => 'Edit',
        ],
        'columns' => [
            'id' => 'ID',
            'capacite' => 'Capacite',
            'description' => 'Description',
            'status' => 'Status'
        ],
    ],
    'saison' => [
        'title' => 'Seasons',
        'actions' => [
            'index' => 'Seasons',
            'create' => 'New Season',
            'edit' => 'Edit :name',
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Title',
            'debut' => 'Debut',
            'fin' => 'End',
        ],
    ],
    'hebergement' => [
        'title' => 'Accommodation',
        'actions' => [
            'index' => 'Accommodation',
            'create' => 'New Hebergement',
            'edit' => 'Edit',
            'uploadImage' => 'Change image',
            'removeImage' => 'Delete'
        ],
        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'nombre' => 'Number',
            'type_hebergement' => 'Type accommodation',
            'image' => 'Image',
            'devises_id' => 'Currencies',
            'ville_id' => 'City',
            'adresse' => 'Address',
            'status' => 'Status',
            'prestataire' => 'Provider',
            'heure_fermeture' => 'Closing time',
            'heure_ouverture' => 'Opening time',
            'ouverte' => 'Open',
            'fermet' => 'Close',
            'calendar' => 'Dates exclusive',
            'taxe' => 'Taxe de séjour',
            'duration_min' => 'Duration min',
        ],
    ],
    'hebergement-vol' => [
        'title' => 'Transport',
        'actions' => [
            'index' => 'Transport',
            'create' => 'flight info',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'depart' => 'Date of departure',
            'arrive' => 'Arrival date',
            'nombre_jour' => 'Number of days',
            'nombre_nuit' => 'Number of nights',
            'lien_depart' => 'Starting link',
            'lien_arrive' => 'Arrival link',
            'condition-transport' => "", //Condition transport
            'avec-vol' => 'Accommodation without flight',
            'sans-vol' => 'Accommodation without flight',
            'heure' => 'Time',
            'heure_depart' => 'Starting time',
            'heure_arrive' => 'Arrived time',
            'allotement_id' => 'Allotment'
        ],
    ],
    'chambre' => [
        'title' => 'Rooms',
        'actions' => [
            'index' => 'Rooms',
            'create' => 'New Room',
            'edit' => 'Edit',
            'uploadImage' => 'Change image',
            'removeImage' => 'Delete'
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Title',
            'base_type_id' => 'Base type',
            'nombre_personne' => 'Number person',
            'description' => 'Description',
            'capacite' => 'Max capacity',
            'type_chambre_id' => 'Room type',
            'hebergement_id' => 'Hebergement',
            'image' => 'Image',
            'status' => 'Status',
            'ouverte' => 'Open',
            'fermet' => 'Close',
            'calendar' => 'Dates exclusive',
            'duration_min' => 'Durée minimale',
        ],
    ],
    'type-personne' => [
        'title' => 'Type Person',
        'actions' => [
            'index' => 'Type Person',
            'create' => 'New Type Person',
            'edit' => 'Edit',
        ],
        'columns' => [
            'id' => 'ID',
            'type' => 'Type',
            'age' => 'Age',
            'description' => 'Description',
        ],
    ],
    'tarif' => [
        'title' => 'Prices',
        'actions' => [
            'index' => 'Rate',
            'create' => 'New Rate',
            'edit' => 'Edit',
            'detail' => 'Information'
        ],
        'columns' => [
            'id' => 'ID',
            'montant' => 'Purchase price',
            'devises' => 'Currency',
            'chambre_id' => 'Room',
            'type_personne_id' => 'Person type',
            'saison_id' => 'Seasonality',
            'description' => 'Description',
            'marge_value' => 'Margin',
            'marge' => 'Margin',
            'marge_prix' => 'Margin price',
            'prix_vente' => 'Sale price',
            'taxe' => 'Taxe de séjour',
            'taxe_active' => 'Display tax',
            'marge_applique' => 'Apply margin',
            'marge_applique_pourcent' => 'Value in %',
            'marge_applique_prix' => 'value in price',
        ],
    ],
    'nav' => [
        'info' => [
            'title' => 'Info'
        ],
        'chambre' => [
            'title' => 'Room',
            'childre' => [
                'tous' => 'All room',
                'type' => 'Room type',
                'base_type' => 'Base type'
            ]
        ],
        'hebergement' => [
            'title' => 'Accommodation',
            'childre' => [
                'tous' => 'All accommodation',
                'type' => 'Room type',
                'marque_blanche' => 'Marque blanch'
            ]
        ],
        'prestataire' => [
            'title' => 'Prestataires',
            'childre' => []
        ],
        'saison' => [
            'title' => 'Seasonality',
            'childre' => [
                'tous' => 'All seasonality',
                'type' => 'Room type'
            ]
        ],
        'tarif' => [
            'title' => 'Rate',
            'childre' => [
                'tous' => 'All Rate',
                'type' => 'Room type'
            ]
        ],
        'personne' => [
            'title' => 'Person type',
            'childre' => [
                'tous' => 'All room',
                'type' => 'Room type'
            ]
        ],
        'supplement' => [
            'title' => 'Supplement',
            'childre' => [
                'pension' => 'Pension',
                'activite' => 'Activite',
                'vue' => 'View'
            ]
        ],
        'allotement' => [
            'title' => 'Allotment',
            'childre' => [
                'tous' => 'All allotments',
                'compagnie' => 'All company'
            ]
        ],
        'excursion' => [
            'title' => 'Excursion',
            'childre' => [
                'tous' => '',
            ]
        ],
        'supplement_excursion' => [
            'title' => 'Supplement',
            'childre' => [
                'tous' => '',
            ]
        ],
        'billeterie-maritime' => [
            'title' => 'Billeteries maritimes',
            'childre' => [
                'tous' => 'All tickets maritimes',
                'compagnie' => 'All company'
            ]
        ],
        'compagnie-transport' => [
            'title' => 'Compagnie de tranport',
            'childre' => [
                'tous' => 'all company',
                'maritime' => 'Trasports maritimes',
                'aerien' => 'Transports aèriens'
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
                'famille-vehicule' => 'Familles véhicules',
                'categorie-vehicule' => 'Catégories véhicules',
                'vehicule-location' => 'Véhicules',
                'saisonnalite' => 'Saisons',
                'tranche-saisonnalite' => 'Tranches de durée',
                'tarif' => 'Tarifs',
            ]
        ],
    ],
    'base-type' => [
        'title' => 'Base type',
        'actions' => [
            'index' => 'Base type',
            'create' => 'New base type',
            'edit' => 'Edit',
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Title',
            'description' => 'Description',
            'nombre' => 'Amount person'
        ],
    ],
    'devises' => [
        'title' => 'Currencies',
        'actions' => [
            'index' => 'Currencies',
            'create' => 'New Currencies',
            'edit' => 'Edit',
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Title',
            'symbole' => 'Symbol',
        ],
    ],
    'pays' => [
        'title' => 'Country',
        'actions' => [
            'index' => 'Country',
            'create' => 'New country',
            'edit' => 'Edit',
        ],
        'columns' => [
            'id' => 'ID',
            'name' => 'name',
        ],
    ],
    'prestataire' => [
        'title' => 'Provider',
        'actions' => [
            'index' => 'Provider',
            'create' => 'New provider',
            'edit' => 'Edit',
        ],
        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'adresse' => 'Address',
            'phone' => 'Phone number',
            'email' => 'Email',
            'ville' => 'City',
            'pays' => 'Country',
        ],
    ],
    'supplement-vue' => [
        'title' => 'Provider',
        'actions' => [
            'index' => 'Provider',
            'create' => 'New supplement view',
            'edit' => 'Edit',
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'TIle',
            'description' => 'Description',
            'tarif' => 'Rate',
            'regle_tarif' => 'Apply',
            'chambre_id' => 'Room'
        ],
    ],
    'supplement-activite' => [
        'title' => 'Provider',
        'actions' => [
            'index' => 'Provider',
            'create' => 'New supplement activity',
            'edit' => 'Edit',
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'TIle',
            'description' => 'Description',
            'tarif' => 'Rate',
            'regle_tarif' => 'Apply',
            'chambre_id' => 'Room'
        ],
    ],
    'supplement-pension' => [
        'title' => 'Provider',
        'actions' => [
            'index' => 'Provider',
            'create' => 'New supplement pension',
            'edit' => 'Edit',
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'TIle',
            'description' => 'Description',
            'tarif' => 'Rate',
            'regle_tarif' => 'Apply',
            'chambre_id' => 'Room'
        ],
    ],
    'hebergement-marque-blanche' => [
        'title' => 'White label',
        'actions' => [
            'index' => 'White label',
            'create' => 'New white label',
            'edit' => 'Edit',
            'uploadImage' => 'Change image',
            'removeImage' => 'Delete'
        ],
        'columns' => [
            'id' => 'ID',
            'liens' => 'Link',
            'description' => 'Description',
            'type_hebergement_id' => 'Type hebergement',
            'image' => 'Image',
        ],
    ],
    'allotement' => [
        'title' => 'Allotment',
        'actions' => [
            'index' => 'Alotment',
            'create' => 'New allotment',
            'edit' => 'Edit',
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Title',
            'quantite' => 'Amount',
            'date_depart' => 'Date of departure',
            'date_arrive' => 'Date of arrived',
            'date_limite' => 'Date limit',
            'date_acquisition' => 'Date of acquisition',
            'compagnie_transport_id' => 'Comgany flight',
            'heure_depart' => 'Time of departure',
            'heure_arrive' => 'Time of arrived',
            'heure' => 'Heure',
        ],
    ],
    'compagnie-transport' => [
        'title' => 'Company transport',
        'actions' => [
            'index' => 'Company tansport',
            'create' => 'New company',
            'edit' => 'Edit',
        ],
        'columns' => [
            'id' => 'ID',
            'nom' => 'Name',
            'adresse' => 'Adress',
            'email' => 'Email',
            'phone' => 'Phone',
            'type_transport' => 'Type transport',
        ],
    ],
    'event-date-heure' => [
        'title' => 'Calendar',
        'actions' => [
            'index' => 'Calendar',
            'create' => 'Create',
            'edit' => 'Edit',
            'btn_edit' => 'Modifier',
            'btn_add' => 'Ajouter'
        ],
        'columns' => [
            'id' => 'ID',
            'time_end' => 'Start time',
            'time_start' => 'End time',
            'date' => 'Date',
            'description' => 'Description',
            'status' => 'Status',
            'active' => 'Active',
            'desactive' => 'Desactive',
            'style' => 'Color and form'
        ],
    ],
    'excursion' => [
        'title' => 'Excursion',
        'actions' => [
            'index' => 'Excursions',
            'create' => 'New excursion',
            'edit' => 'Edit',
            'uploadImage' => 'Change image',
            'uploadCard' => 'Change card',
            'removeImage' => 'Delete'
        ],
        'columns' => [
            'id' => 'ID',
            'title' => 'Title',
            'duration' => 'Duration',
            'heure_depart' => 'Heure de départ',
            'availability' => 'Availability',
            'participant_min' => 'Participant min',
            'card' => 'Card',
            'lunch' => 'Lunch included',
            'ticket' => 'Boat ticket included',
            'devises_id' => 'Currency',
            'ville_id' => 'City',
            'prestataire' => 'Prestataire',
            'description' => 'Description',
            'status' => 'Status',
            'taxe' => 'Taxe de séjour',
            'options_included' => [
                'title' => 'Included',
                'lunch' => 'Lunch',
                'ticket' => 'Boat ticket'
            ],
            'ouverte' => 'Open',
            'fermet' => 'Close',
            'calendar' => 'Dates exclusive',
            'image' => 'Image'
        ],
        'options' => [
            'no' => 'No',
            'yes' => 'Yes'
        ],
    ],
    'supplement-excursion' => [
        'title' => 'Supplements excurions',
        'actions' => [
            'index' => 'Supplement',
            'create' => 'Create',
            'edit' => 'Edit',
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Title',
            'type_personne_id' => 'Type person',
            'tarif' => 'Price',
            'supplement_excursion_id' => 'Supplement'
        ],
    ],
    'billeterie-maritime' => [
        'title' => 'Billeteries maritimes',
        'actions' => [
            'index' => 'Billeterie maritime',
            'create' => 'Create',
            'edit' => 'Edit',
            'gerer' => 'Manager',
            'uploadImage' => 'Change image',
            'removeImage' => 'Delete'
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Title',
            'type_personne_id' => 'Type person',
            'tarif' => 'Price',
            'quantite' => 'Numbre ticket',
            'compagnie_transport_id' => 'Company transport',
            'planing_time' => 'Schedule',
            'heure-debut' => 'Heure de depart',
            'heure-fin' => 'Heure d\'arrivée',
            'date_depart' => 'Date de départ',
            'date_arrive' => 'Date d\'arrivée',
            'lieu_depart' => 'Lieu de départ',
            'lieu_arrive' => 'Lieu d\'arrivé',
            'date_acquisition' => 'Date d\'acquisition',
            'date_limite' => 'Date limite',
            'image' => 'Image',
        ],
    ],
    'tarif-excursion' => [
        'title' => 'Tarifs excursions',
        'actions' => [
            'index' => 'Tarifs excursions',
            'create' => 'Create',
            'edit' => 'Edit',
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Saisonnalité',
            'type_personne_id' => 'Type person',
            'taxe' => 'Taxe de séjour',
            'supplement' => 'Supplement options',
            'saison' => 'Saisonnalité',
            'montant' => 'Price',
            'excursion' => 'Excursion'
        ],
    ],
    'taxe' => [
        'title' => 'Taxes',
        'actions' => [
            'index' => 'Taxes',
            'create' => 'New taxe',
            'edit' => 'Edit',
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Title',
            'valeur_pourcent' => 'Taxe en pourcent',
            'valeur_devises' => 'Taxe en valeur',
            'description' => 'Description',
            'taxe_applique' => 'Calcule de taxe',
            'taxe_applique_pourcent' => 'Taxe en pourcent',
            'taxe_applique_prix' => 'Taxe en valeur',
        ],
    ],
    'compagnie-liaison-excursion' => [
        'title' => 'Compagnies liaisons',
        'actions' => [
            'index' => 'Compagnie liaison',
            'create' => 'Ajouter compagnie',
            'edit' => 'Modifier',
        ],
        'columns' => [
            'id' => 'ID',
            'excursion_id' => 'Excursion',
            'compagnie_transport_id' => 'Compagnie',
            'type_transport' => 'Type de transport',
            'quantite_billet' => 'Billes disponibles',
        ],
    ],
    'planing-time' => [
        'title' => 'Schedule',
        'actions' => [
            'index' => 'Schedule',
            'create' => 'Add',
            'edit' => 'Edit',
        ],
        'columns' => [
            'id' => 'ID',
            'debut' => 'Start',
            'fin' => 'End',
        ],
    ],
    'famille-vehicule' => [
        'title' => 'Famille véhicule',
        'actions' => [
            'index' => 'Familles véhicules',
            'create' => 'Add',
            'edit' => 'Edit',
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
            'create' => 'Add',
            'edit' => 'Edit',
        ],
        'columns' => [
            'id' => 'ID',
            'titre' => 'Titre',
            'famille_vehicule_id' => 'Famille vehicule',
            'description' => 'Description',
            'franchise' => 'Franchise',
            'franchise_non_rachatable' => 'Franchise non rachatable',
            'caution' => 'Caution'
        ],
    ],
    'vehicule-location' => [
        'title' => 'Véhicule',
        'actions' => [
            'index' => 'Véhicules',
            'create' => 'Add',
            'edit' => 'Edit',
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
            'calendar' => 'Dates exclusives',
            'image' => 'Image',
            'prestataire' => 'Prestataire',
            'famille_vehicule_id' => 'Famille vehicule',
            'categorie_vehicule_id' => 'Catégorie véhicule',
            'ville_id' => 'Ville',
            'pays_id' => 'Pays'
        ],
    ],
    'ile' => [
        'title' => 'Iles',

        'actions' => [
            'index' => 'Iles',
            'create' => 'New Ile',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',

        ],
    ],

    'frais-dossier' => [
        'title' => 'Frais Dossier',

        'actions' => [
            'index' => 'Frais Dossier',
            'create' => 'New Frais Dossier',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'saison_id' => 'Saison',
            'prix' => 'Prix',

        ],
    ],

    'mode-payement' => [
        'title' => 'Mode Payement',

        'actions' => [
            'index' => 'Mode Payement',
            'create' => 'New Mode Payement',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'titre' => 'Titre',

        ],
    ],

    'app-config' => [
        'title' => 'App Config',

        'actions' => [
            'index' => 'App Config',
            'create' => 'New App Config',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'email' => 'Email',
            'nom' => 'Nom',
            'adresse' => 'Adresse',
            'site_web' => 'Site web',
            'telephone' => 'Telephone',
            'ville_id' => 'Ville',

        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];
