<?php

return [
    'page_title_suffix' => 'SAELT-PRO',
    'operation' => [
        'successed' => 'Opération réussie',
        'failed' => 'L\'opération a échoué',
        'not_allowed' => 'Opération non autorisée',
        'publish_now' => 'Publier maintenant',
        'unpublish_now' => 'Annuler la publication maintenant',
        'publish_later' => 'Publier plus tard',
    ],
    'dialogs' => [
        'duplicateDialog' => [
            'title' => 'Attention!',
            'text' => 'Voulez-vous vraiment dupliquer cet élément?',
            'yes' => 'Oui, dupliquer.',
            'no' => 'Non, annuler.',
            'success_title' => 'Succès!',
            'success' => 'Élément dupliqué avec succès.',
            'error_title' => 'Erreur!',
            'error' => 'Une erreur est survenue.',
        ],
        'deleteDialog' => [
            'title' => 'Attention!',
            'text' => 'Voulez-vous vraiment supprimer cet élément?',
            'yes' => 'Oui, supprimez.',
            'no' => 'Non, annuler.',
            'success_title' => 'Succès!',
            'success' => 'Élément supprimé avec succès.',
            'error_title' => 'Erreur!',
            'error' => 'Une erreur est survenue.',
        ],
        'publishNowDialog' => [
            'title' => 'Attention!',
            'text' => 'Voulez-vous vraiment publier cet élément maintenant?',
            'yes' => 'Oui, publiez maintenant.',
            'no' => 'Non, annuler.',
            'success_title' => 'Succès!',
            'success' => 'Élément publié avec succès.',
            'error_title' => 'Erreur!',
            'error' => 'Une erreur est survenue.',
        ],
        'unpublishNowDialog' => [
            'title' => 'Attention!',
            'text' => 'Voulez-vous vraiment annuler la publication de cet élément maintenant?',
            'yes' => 'Oui, annuler la publication maintenant.',
            'no' => 'Non, annuler.',
            'success_title' => 'Succès!',
            'success' => 'Élément publié avec succès.',
            'error_title' => 'Erreur!',
            'error' => 'Une erreur est survenue.',
        ],
        'publishLaterDialog' => [
            'text' => 'Veuillez choisir la date à laquelle l \' article doit être publié: ',
            'yes' => 'Enregistrer',
            'no' => 'Annuler',
            'success_title' => 'Succès!',
            'success' => 'L\'élément a été enregistré avec succès.',
            'error_title' => 'Erreur!',
            'error' => 'Une erreur est survenue.',
        ],
    ],
    'btn' => [
        'save' => 'Enregistrer',
        'cancel' => 'Annuler',
        'edit' => 'Modifier',
        'delete' => 'Supprimer',
        'search' => 'Rechercher',
        'new' => 'Nouveau',
        'create' => 'Ajouter',
        'saved' => 'Enregistré',
        'next' => 'Suivant',
        'prev' => 'Précedent',
        'close' => 'Fermer',
        'exit' => 'Quitter',
        'edit_single' => 'Modifier cet élément'
    ],
    'index' => [
        'no_items' => 'Aucun élément n\'a été trouvé',
        'try_changing_items' => 'Essayez de changer les filtres ou en ajouter un nouveau',
    ],
    'listing' => [
        'selected_items' => 'Éléments sélectionnés',
        'uncheck_all_items' => 'Décocher tous les éléments',
        'check_all_items' => 'Vérifier tous les éléments',
    ],
    'forms' => [
        'select_a_date' => 'Sélectionnez la date',
        'select_a_time' => 'Sélectionnez l\'heure',
        'select_date_and_time' => 'Sélectionnez la date et l\'heure',
        'choose_translation_to_edit' => 'Choisissez la traduction à modifier:',
        'manage_translations' => 'Gérer les traductions',
        'more_can_be_managed' => '({{otherLocales.length}} plus peut être géré)',
        'currently_editing_translation' => 'En cours de modification de la traduction de {{this.defaultLocale.toUpperCase ()}} (par défaut)',
        'hide' => 'Masquer les traductions',
        'select_an_option' => 'Sélectionnez une option',
        'select_options' => 'Sélectionner des options',
        'publish' => 'Publier',
        'history' => 'Histoire',
        'created_by' => 'Créé par',
        'updated_by' => 'Mis à jour par',
        'created_on' => 'Créé le',
        'updated_on' => 'Mis à jour le'
    ],
    'placeholder' => [
        'search' => 'Rechercher'
    ],
    'pagination' => [
        'overview' => 'Affichage des éléments de {{pagination.state.from}} à {{pagination.state.to}} du total {{pagination.state.total}} éléments.'
    ],
    'logo' => [
        'title' => 'Fabriquer',
    ],
    'profile_dropdown' => [
        'account' => 'Compte',
        'profile' => 'Profil',
        'password' => 'Mot de passe',
        'logout' => 'Déconnexion'
    ],
    'sidebar' => [
        'content' => 'Contenu',
        'settings' => 'Paramètres',
    ],
    'media_uploader' => [
        'max_number_of_files' => '(nombre max. de fichiers :maxNumberOfFiles files)',
        'max_size_pre_file' => '(taille max par fichier :maxFileSize Mo)',
        'private_title' => 'Les fichiers ne sont pas accessibles au public',
    ],
    'footer' => [
        'powered_by' => 'Propulsé par',
    ],
    'actions' => [
        'duplicate' => 'Dupliquer',
    ],
    'filter' => [
        'all' => 'Tout(e)s',
        'all_ile' => 'Tous les îles',
        'with' => 'Filtre par',
        'item_selectionner' => 'Eléments sélectionnés'
    ],
    'action' => 'Actions',
    'detail' => 'Détail',
    'any' => [
        'month' => 'Mois',
        'year' => 'Année',
        'on' => 'Sur',
        'car' => 'Véhicule',
        'categorie' => 'Catégorie'
    ],
    'notification' => [
        'title' => 'Notifications'
    ]
];
