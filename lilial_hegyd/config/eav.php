<?php

return [
    /*'routes' => [
        'prefix' => env('EAV_ROUTES_PREFIX', 'attributs'),
    ],*/
    'lang'   => [
        'fr' => [

            // ADMIN MANAGER
            'fields'   => [
                'value' => 'Valeur',
                'initial_position' => 'Position',
                'users' => 'Utilisateurs',
                'roles' => 'Rôles',
                'color' => 'Couleur',
            ],
            'buttons'  => [
                'add' => 'Ajouter une valeur',
                'edit' => 'Editer la valeur',
                'delete' => 'Supprimer la valeur',
            ],
            'title'   => [
                'management'    => 'Attributs',
                'edit'          => 'Modification de la valeur : :name',
                'new'           => 'Ajouter une valeur à l\'attribut :name',
                'values_tab'    => 'Valeurs pour l\'attribut ":name" :',
            ],
            'labels' => [
                'updated'       => 'Valeur modifiée avec succès',
                'added'         => 'Valeur ajoutée avec succès',
                'deleted'       => 'Valeur supprimée avec succès',
                'moved'         => 'Valeur déplacée avec succès',
            ],
            'messages' => [
                'no_values'     => 'Aucune valeur pour cet attribut',
            ],
            'options' => [
                'position' => [
                    'first' => 'Première position',
                    'after_value' => 'Après la valeur ":value"',
                ],
                'users' => [
                    'choose' => 'Choisissez un à plusieurs utilisateurs',
                ],
                'roles' => [
                    'choose' => 'Choisissez un à plusieurs roles',
                ],
            ],

            ///// ATTRIBUTES /////

            'datas' => [

                // TICKETS
                'ticket'    => [
                    'entity'    => [
                        'label' => env('EAV_LANG_FR_TICKET_ENTITY_LABEL', 'Tickets')
                    ],
                    'attributes'    => [
                        'status' => [
                            'label' => env('EAV_LANG_FR_TICKET_ATTRIBUTES_STATUS_LABEL', 'Statut'),
                        ],
                        'type' => [
                            'label' => env('EAV_LANG_FR_TICKET_ATTRIBUTES_TYPE_LABEL', 'Type'),
                            'null_option_label' => env('EAV_LANG_FR_TICKET_ATTRIBUTES_TYPË_NULL_OPTION_LABEL', 'Choisissez un type de demande'),
                        ],
                    ],
                ],

                // CONTACTS
                'contact'    => [
                    'entity'    => [
                        'label' => env('EAV_LANG_FR_CONTACT_ENTITY_LABEL', 'Contacts')
                    ],
                    'attributes'    => [
                        'origin' => [
                            'label' => env('EAV_LANG_FR_CONTACT_ATTRIBUTES_ORIGIN_LABEL', 'Origine'),
                        ],
                        'company_type' => [
                            'label' => env('EAV_LANG_FR_CONTACT_ATTRIBUTES_COMPANY_TYPE_LABEL', 'Type personne morale'),
                        ],
                    ],
                ],

                // COMMUNICATION PLAN
                'com_plan'    => [
                    'entity'    => [
                        'label' => env('EAV_LANG_FR_COMPLAN_ENTITY_LABEL', 'Plan de communication')
                    ],
                    'attributes'    => [
                        'category' => [
                            'label' => env('EAV_LANG_FR_COMPLAN_ATTRIBUTES_CATEGORY_LABEL', 'Catégorie'),
                        ],
                        'typology' => [
                            'label' => env('EAV_LANG_FR_COMPLAN_ATTRIBUTES_TYPOLOGY_LABEL', 'Typologie'),
                        ],
                    ],
                ],

                // CRM/Candidature
                'candidature'    => [
                    'entity'    => [
                        'label' => env('EAV_LANG_FR_CANDIDATURE_ENTITY_LABEL', 'Candidatures')
                    ],
                    'attributes'    => [
                        'status' => [
                            'label' => env('EAV_LANG_FR_CANDIDATURE_ATTRIBUTES_STATUS_LABEL', 'Status'),
                        ],
                    ],
                ],

            ],



        ],
    ],
];