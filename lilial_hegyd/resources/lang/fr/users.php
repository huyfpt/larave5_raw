<?php

return [
    'title'    => [
        'management'    => 'Utilisateurs',
        'index'         => 'Utilisateurs',
        'edit'          => 'Edition de :name',
        'show'          => ':name',
        'new'           => 'Création d\'un utilisateur',
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
        'add'                       => 'Créer un nouvel utilisateur',
        'history'                   => 'Historique',
        'saveAndForceResetPassword' => 'Enregistrer & Envoyer un nouveau mot de passe',
        'forceResetPassword'        => 'Envoyer un nouveau mot de passe',
        'loginAs'                   => 'Se connecter en tant que',
    ],
    'fields'   => [
        'active'             => 'Statut',
        'agencies'           => 'Ses agences',
        'ambassador'         => 'Ambassadeur',
        'avatar'             => 'Avatar',
        'created_at'         => 'Créé le',
        'crm_id'             => 'Identifiant CRM',
        'civility'           => 'Civilité',
        'display_directory'  => 'Visible dans l\'annuaire',
        'email'              => 'Email',
        'firstname'          => 'Prénom',
        'function'           => 'Poste',
        'lastname'           => 'Nom',
        'mobile'             => 'Mobile',
        'password'           => 'Mot de passe',
        'password_confirm'   => 'Confirmation de mot de passe',
        'phone'              => 'Téléphone',
        'roles'              => 'Rôle',
        'shops'              => 'Agence',
        'user_head_office'   => 'Utilisateur siège',
        'username'           => 'Nom d\'utilisateur',
        'role'               => 'Rôle',
        'newsletter'         => 'S’abonner et recevoir la newsletter par email ? (oui/non)',
    ],

    'cannot_delete' => 'Impossible de supprimer l\'utilisateur',

    'labels'   => [
        'bad_old_password' => 'L\'ancien mot de passe ne correspond pas.',

        'profile_updated' => 'Votre profil a été mis à jour',

        'not_found'     => 'Utilisateur introuvable.',
        'updated'       => 'Utilisateur mis à jour.',
        'cannot_save'   => 'Une erreur s\'est produite pendant l\'enregistrement.',
        'cannot_delete' => 'Vous ne pouvez pas supprimer cet utilisateur.',
        'new_created'   => 'Nouvel utilisateur créé',

        'forceResetPassword' => 'Utilisateur mis à jour & envoi du nouveau mot de passe.',
    ],
    'confirms' => [
        'bulk' => [
            'forceResetPassword' => [
                'title' => 'Attention !',
                'text'  => 'Êtes-vous sûr de vouloir réinitialiser le mot de passe des utilisateurs sélectionnés.',
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
    ]
];
