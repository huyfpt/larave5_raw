<?php

return [
    'title' => [
        'management'      => 'Commandes',
        'archived'        => 'Commandes archivées',
        'edit'            => 'Détail commande n°:name',
        'show'            => 'Détail commande n°:reference',
        'add_line'        => 'Ajout d\'un produit',
        'edit_line'       => 'Édition d\'un produit',
        'update_status'   => 'Changement du statut',
        'payment_success' => 'Confirmation de votre commande',
        'payment_failed'  => 'Paiement annulé',
        'my_orders'       => 'Mes commandes',
    ],

    'fields' => [
        'date'              => 'Date',
        'product_name'      => 'Produit',
        'product_reference' => 'Référence',
        'quantity'          => 'Quantité',
        'unit_price_ht'     => 'Prix HT',
        'unit_price_ttc'    => 'Prix TTC',
        'total_line_ht'     => 'Total HT',
        'total_line_ttc'    => 'Total TTC',
        'reference'         => 'Référence',
        'vat'               => 'TVA',
        'total_ht'          => 'Total HT',
        'total_vat'         => 'Total TVA',
        'total_ttc'         => 'Total TTC',
        'delivery_price'    => 'Frais de port',
        'payment_means'     => 'Mode de paiement',
        'status'            => 'État',
        'created_at'        => 'Date de commande',
        'comment'           => 'Commentaire',
        'nb_products'       => 'Nombre de produits',
        'site'              => 'Site',
        'user'              => 'Utilisateur',
        'commercial'        => 'Commercial',
        'histories'         => [
            'text'       => 'Détail',
            'user'       => 'Par',
            'created_at' => 'Date',
        ],
        'company'           => 'Client',
        'store'             => 'Dépôt',
    ],

    'labels' => [
        'all_total'        => 'Totaux',
        'invoice_address'  => 'Adresse de facturation',
        'delivery_address' => 'Adresse de livraison',
        'histories'        => 'Historique de la commande',
        'no_product'       => 'Aucun produit',
        'no_history'       => 'Aucun historique',
        'no_order'         => 'Aucune commande',
        'payment_success'  => 'Votre commande à bien été validée sous la référence <a href=":route">:reference</a>',
        'payment_failed'   => 'Le paiement n\'a pas été pris en compte.<br>Vous pouvez retourner sur <a href=":route">votre panier</a> pour relancer le paiement.',
        'invoice'          => 'Facture',
        'invoice_euro'     => 'Facture en euros',
        'transmitter'      => 'Émetteur',
        'receiver'         => 'Destinataire',
        'invoice_name'     => 'Facture n°:reference',
        'updated'          => 'La commande a été mise à jour.',
    ],

    'buttons' => [
        'add_product'      => 'Ajouter un produit',
        'generate_pdf'     => 'Générer le PDF',
        'print_invoice'    => 'Imprimer la facture',
        'update_status'    => 'Changer le statut',
        'download_invoice' => 'Télécharger la facture',
        'show_detail'      => 'Voir le détail',
        're_order'         => 'Recommander',
        'archived'         => 'Commandes archivées',
        'not-archived'     => 'Commandes non archivées',
    ],

    'status' => [
        'error'               => 'Erreur',
        'waiting_for_payment' => 'En attente de paiement',
        'cancelled'           => 'Annulée',
        'paid'                => 'Payée',
        'refund'              => 'Remboursée',
        'in_preparation'      => 'En préparation',
        'treated'             => 'Traitée',
        'shipped'             => 'Expédiée',
        'delivered'           => 'Livrée',
        'archived'            => 'Archivée',
    ],

    'payment_means' => [
        'credit_card'        => 'Carte de crédit',
        'according_contract' => 'Voir modalité du contrat',
        'paypal'             => 'Paypal',
    ],

    'histories' => [
        'created'       => 'Création de commande : <b>:status</b>',
        'update_status' => 'Changement de statut : <b>:status</b>',
    ],

    'messages' => [
        'paid_at' => 'Facture acquitée le :date par :provider'
    ]
];