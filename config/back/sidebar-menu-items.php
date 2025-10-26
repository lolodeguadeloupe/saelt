<?php

return [

    'dashboard' => [
        'icon' => 'fas fa-tachometer-alt',
        'label' => 'back.menu.sidebar.dashboard.label',
        //'route' => 'dashboard'
    ],

    'islands' => [
        'treeview' => true,
        'items' => [
            [
                'label' => 'Tous les îles',
               // 'route' => 'islands.index'
            ],
            [
                'icon' => 'fas fa-plus',
                'label' => 'Ajouter',
                //'route' => 'islands.create'
            ]
        ],
        'icon' => 'fas fa-map-marker-alt',
        'label' => 'Les îles'
    ],

    'hebergements' => [
        'treeview' => true,
        'items' => [
            [
                'label' => 'Tout les hébergements',
                'route' => 'hebergements.index'
            ],
            [
                'icon' => 'fas fa-plus',
                'label' => 'Ajouter',
                'route' => 'hebergements.create'
            ],
            [
                'icon' => 'fas fa-tags',
                'label' => "Types hébergement",
                'route' => 'hebergement-types.index'
            ],
            [
                'icon' => 'fas fa-bed',
                'label' => "Types chambre",
               // 'route' => 'room-types.index'
            ]
        ],
        'icon' => 'fas fa-building',
        'label' => 'Hebergements'
    ]

];
