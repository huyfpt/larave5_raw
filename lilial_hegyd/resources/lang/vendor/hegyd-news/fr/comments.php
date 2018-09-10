<?php

return [
    'title'   => [
        'index'      => 'Commentaires',
        'new'        => 'Création d\'un commentaire',
        'show'       => 'Actualité :name',
        'edit'       => 'Édition de l\'actualité :name',
        'management' => 'Administration actualités',
        'list'       => 'Derniers commentaires publiés',
    ],
    'fields'   => [
        'name'              => 'Nom',
        'active'            => 'Active',
        'category'          => 'Catégorie',
        'category_id'       => 'Catégorie',
        'content'           => 'Contenu',
        'author'            => 'Auteur',
        'display_on_slider' => 'Affichable sur le slider',
        'start_at'          => 'Date de début de publication',
        'end_at'            => 'Date de fin de publication',
        'visual_slider'     => 'Visuel du slider',
        'roles'             => 'Role(s) autorisé(s)',
        'comment_enable'    => 'Autoriser les commentaires sur l\'article ?',
    ],
    'labels'   => [
        'start_at' => 'Si la date n\'est pas renseignée, elle sera publiée si le champs \'active\' est coché.',
        'end_at'   => 'Si la date n\'est pas renseignée, elle sera publiée si le champs \'active\' est coché.',

        'not_found'     => 'Actualité introuvable.',
        'updated'       => 'Actualité mise à jour.',
        'cannot_save'   => 'Une erreur s\'est produite pendant l\'enregistrement.',
        'cannot_delete' => 'Vous ne pouvez pas supprimer cette actualité.',
        'new_created'   => 'Nouvelle actualité créée',
        'news_inactive' => 'Cette actualité n\'est pas active, seul les personnes ayant les droits peuvent la visualiser.',

        'publish_at'    => 'Publié le ',
        'empty'         => 'Aucun commentaire publié',
        'removed'       => 'Le commentaire a été supprimé',

        'count_comments'=> 'Il y a :count_comment commentaire(s)',
        'empty'         => 'Aucun commentaire',
    ],
    'buttons'  => [
        'add-comment'=> 'Ajouter un commentaire',
        'edit'       => 'Modifier le commentaire',
        'categories' => 'Voir les catégories',
        'show_page'  => 'Voir la page',
        'comment'    => 'Commenter',
    ],
    'messages' => [
        'access_denied'     => 'Accès refusé',
        'publish'           => 'Votre commentaire a été publié',
        'publish_update'    => 'Votre commentaire a été modifié',
        'signalement_sent'  => 'Le commentaire a bien été signalé.'
    ],
];