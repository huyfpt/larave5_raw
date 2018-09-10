<?php

return [
    'title'    => [
        'management'    => 'Clients',
        'index'         => 'Clients',
        'edit'          => 'Edition de :name',
        'show'          => ':name',
        'new'           => 'Création d\'un Client',
        'edit-password' => 'Changer votre mot de passe',
    ],
    'subtitle' => [
        'address'     => 'Adresse',
        'mentor'      => 'Parrainage',
        'security'    => 'Sécurité',
        'commissions' => 'Commissions',
        'bank'        => 'Infos bancaire',
        'newsletter'  => 'Bulletin',
    ],
    'buttons'  => [
        'add'                       => 'Créer un nouvel client',
        'history'                   => 'Historique',
        'saveAndForceResetPassword' => 'Enregistrer & Envoyer un nouveau mot de passe',
        'forceResetPassword'        => 'Envoyer un nouveau mot de passe',
        'loginAs'                   => 'Se connecter en tant que',
    ],
    'fields'   => [
        'club_lilial'   => 'Club',
        'ambassador'    => 'Ambassadeur',
        'status'        => 'Statut',
        'type'          => 'Type'
    ],

    'cannot_delete' => 'Impossible de supprimer l\'client',

    'labels'   => [
        'bad_old_password' => 'L\'ancien mot de passe ne correspond pas.',

        'profile_updated' => 'Votre profil a été mis à jour',

        'not_found'     => 'Client introuvable.',
        'updated'       => 'Client mis à jour.',
        'cannot_save'   => 'Une erreur s\'est produite pendant l\'enregistrement.',
        'cannot_delete' => 'Vous ne pouvez pas supprimer cet client.',
        'new_created'   => 'Nouvel client créé',

        'forceResetPassword' => 'Client mis à jour & envoi du nouveau mot de passe.',
        'imported'      => 'Succès excellent importé!',
        'import_failed' => 'Excel importé a échoué!',
        'import_user_failed'  => 'Le nom d\'utilisateur ou l\'email était identique. S\'il vous plaît vérifier!',
        'import_user_null'  => 'Aucune donnée à importer',
        'tab_reference' => 'Référence',
        'tab_images'    => 'Image',
    ],
    'confirms' => [
        'bulk' => [
            'forceResetPassword' => [
                'title' => 'Attention !',
                'text'  => 'Êtes-vous sûr de vouloir réinitialiser le mot de passe des clients sélectionnés.',
            ],
        ],
    ],

    'commission_types' => [
        'percent' => 'Pourcentage',
        'steps'   => 'Paliers',
    ],

    'mentor_types' => [
        'percent' => 'Pourcentage',
        'steps'   => 'Paliers',
    ],

    'type' => [
        'user'          => 'Usager',
        'professional'  => 'Professionnel',
    ],

    'import'  => [
        'excel'   => 'Importer Excel',
        'submit'  => 'Importer',
        'cancel'  => 'Annuler',
    ]
];
