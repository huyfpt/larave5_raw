<?php

return [
    'title' => [
        'index' => 'Vos notifications',
    ],

    'buttons' => [
        'read'     => 'Marquer comme lu',
        'read-all' => 'Tout marquer comme lu',
        'unread'   => 'Marquer comme non lu',
        'view-all' => 'Voir toutes les notifications',
        'my'       => 'Mes notifications',
    ],

    'types' => [
        'registration'    => [
            'text'  => 'Inscription',
            'class' => 'label-warning',
        ],
        'sign_on_request' => [
            'text'  => 'Demande d\'inscription',
            'class' => 'label-danger',
        ],
        'estimate'        => [
            'text'  => 'Devis',
            'class' => 'label-warning',
        ],
        'order'           => [
            'text'  => 'Commande',
            'class' => 'label-warning',
        ],
        'product'         => [
            'text'  => 'Produit',
            'class' => 'label-warning',
        ],
        'client'          => [
            'text'  => 'Client',
            'class' => 'label-warning',
        ],
        'provider'        => [
            'text'  => 'Fournisseur',
            'class' => 'label-warning',
        ],
        'store'           => [
            'text'  => 'Dépôt',
            'class' => 'label-warning',
        ],
    ],

    'messages' => [
        'news'                    => [
            'available' => 'L\'actualité :name vient d\'être publiée.',
        ],
        'ticket'                  => [
            'create' => 'Le ticket ":subject" vient d\'être posté.',
            'answer' => 'Le ticket ":subject" a été mis à jour.',
        ],
        'communication_plan'      => [
            'national' => [
                'create' => 'L\'action marketing nationale :name est disponible !',
            ],
            'local'    => [
                'create' => 'Le modèle d\'un plan marketing local :name est disponible !',
            ],
        ],
        'upload'                  => [
            'count' => ':count nouveau(x) documents ont été publiés sur l\'intranet',
        ],
        'commissions'             => [
            'unlock' => 'Le mandataire :user a demandé le débloquage de ses commissions d\'un montant de :price&nbsp;€',
        ],
        'sale_agreements'         => [
            'created'           => ':user vient de créer un nouveau compromis de vente n°:mandate_number.',
            'deed'              => ':user vient d\'acter le compromis de vente n°:mandate_number.',
            'cancelled'         => ':user vient d\'annuler le compromis de vente n°:mandate_number.',
            'done'              => ':user vient de finaliser le compromis de vente n°:mandate_number.',
            'sale_confirmed_at' => ':user vient d\'ajouter la date de vente confirmée au :date sur le compromis de vente :mandate_number.',
            'invoice_notary'    => ':user vient d\'ajouter la facture du notaire sur le compromis de vente :mandate_number.',
        ],
        'rental_agreements'       => [
            'created'             => ':user vient de créer un nouveau contrat de location n°:mandate_number.',
            'deed'                => ':user vient de valider le contrat de location n°:mandate_number.',
            'cancelled'           => ':user vient d\'annuler le contrat de location n°:mandate_number.',
            'done'                => ':user vient de finaliser le contrat de location n°:mandate_number.',
            'rental_confirmed_at' => ':user vient d\'ajouter la date de location confirmée au :date sur le contrat :mandate_number.',
        ],
        'no_unseen_notifications' => 'Vous n\'avez aucune notification non lu pour le moment.',
        'no_notifications'        => 'Vous n\'avez aucune notification.',
    ],
];