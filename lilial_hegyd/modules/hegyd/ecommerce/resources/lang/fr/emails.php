<?php

return [
    'global' => [
        'prefix_subject' => '[' . config('app.name') . '] ',
    ],

    'orders'   => [
        'created'   => [
            'subject'  => 'Confirmation de votre commande',
            'message'  => 'Vous venez de valider une commande sur <a href=":site_domain" target="_blank">:site_name</a> sous la référence :order_reference.<br><br>
                    Récapitulatif de la commande :',
            'message2' => 'Vous trouverez votre facture ci-joint.',
        ],
        'on_going'  => [
            'user' => [
                'subject' => 'Votre commande :order_reference évolue',
                'message' => 'Votre commande :order_reference évolue.<br>
                            Le statut de cette commande est : <b>En cours de traitement</b>.',
            ],
        ],
        'validated' => [
            'user' => [
                'subject' => 'Votre commande :order_reference évolue',
                'message' => 'Votre commande :order_reference évolue.<br>
                            Le statut de cette commande est : <b>Traitée</b>.',
            ],
        ]
    ],
    'products' => [
        'stock-alert' => [
            'subject' => 'Stock alerte - Des produits bientôt épuisés',
            'message' => 'Voici la liste des produits bientôt épuisés :',
        ]
    ]
];