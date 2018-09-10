<?php

return [
    'title'    => [
        'index'                  => 'Modération des commentaires',
        'management'             => 'Modération des commentaires',
        'edit'                   => 'Edition du signalement :name',
        'new'                    => 'Signaler un commentaire',
        'contact_concerned_user' => 'Contacter l\'utilisateur signalé',
    ],
    'fields'   => [
        'name'        => 'Raison du signalement',
        'content'     => 'Détails du signalement',
        'user_report' => 'Utilisateur(s) ayant signalé(s) le contenu',
        'comment'     => 'Commentaire signalé',
        'author'      => 'Auteur du commentaire signalé',
        'active'      => 'Traité',
        'identifiant' => 'Identifiant',
        'news_name'   => 'Nom de l\'actualité concernée',
    ],
    'labels'   => [
        'not_found'     => 'Actualité introuvable.',
        'updated'       => 'Actualité mise à jour.',
        'cannot_save'   => 'Une erreur s\'est produite pendant l\'enregistrement.',
        'cannot_delete' => 'Vous ne pouvez pas supprimer cette actualité.',
        'new_created'   => 'Nouvelle actualité créée',
        'news_inactive' => 'Cette actualité n\'est pas active, seules les personnes ayant les droits peuvent la visualiser.',

        'publish_at'     => 'Publié le ',
        'empty'          => 'Aucun commentaire publié',
        'already_report' => 'Commentaire signalé',
    ],
    'buttons'  => [
        'report'                 => 'Signaler le commentaire',
        'show_page'              => 'Voir la page',
        'delete_comment'         => 'Supprimer le commentaire signalé',
        'contact_concerned_user' => 'Contacter l\'utilisateur signalé',
        'send'                   => 'Envoyer le message',
        'news'                   => 'Liste des actualités',
    ],
    'messages' => [
        'access_denied' => 'Accès refusé',
        'report'        => 'Votre signalement a bien été envoyé à l\'administrateur',
    ],

    'status' => [
        'treated' => 'Traité',
        'wait'    => 'A traiter',
    ],

    'label' => [
        'start_at' => 'Si la date n\'est pas renseignée, elle sera publiée si le champ \'active\' est coché.',
        'end_at'   => 'Si la date n\'est pas renseignée, elle sera publiée si le champ \'active\' est coché.',

        'not_found' => 'Actualité introuvable.',
        'updated'   => 'Signalement mis à jour.',
    ],
];