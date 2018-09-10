<?php

return [
    'title'   => [
        'index'      => 'Catégories',
        'show'       => 'Catégorie :name',
        'show_faqs'  => 'Actualités catégorie :name',
        'management' => 'Administration catégories',
        'faq'        => 'Création d\'une catégorie',
        'edit'       => 'Édition de la catégorie :name',
    ],
    'field'   => [
        'name'   => 'Nom',
        'id' => 'ID',
        'label' => 'Nom',
        'introduction'   => 'Introduction',
        'image' => 'Image',
        'status'   => 'Statut',
        'parent_id' => 'Catégorie parente'
    ],
    'button'  => [
        'read-more'     => 'Lire la suite',
        'add'           => 'Ajouter une catégorie',
        'edit'          => 'Modifier la catégorie',
        'faqs'          => 'Voir les faq',
        'categories'    => 'Voir les catégories',
        'show_page'     => 'Voir la faq',
        'discover_news' => 'Découvrir les faq',
    ],
    'label'   => [
        'no_faqs'           => 'Aucune actualité disponible.',
        'not_found'         => 'Catégorie introuvable.',
        'updated'           => 'Catégorie mise à jour.',
        'cannot_save'       => 'Une erreur s\'est produite pendant l\'enregistrement.',
        'cannot_delete'     => 'Vous ne pouvez pas supprimer cette catégorie.',
        'new_created'       => 'Nouvelle catégorie créée',
        'category_inactive' => 'Cette catégorie n\'est pas active, seul les personnes ayant les droits peuvent la visualiser.',
        'faq_created' => 'Nouvelle catégorie créée'
    ],
    'message' => [
        'access_denied' => 'Accès refusé',
    ],
    'cannot_delete' => 'Cannot delete this Category. You must delete it child category first.'
];