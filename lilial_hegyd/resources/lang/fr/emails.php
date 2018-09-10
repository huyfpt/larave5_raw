<?php

return [
    'global' => [
        'prefix_subject' => '[' . env('APP_NAME') . ']',
        'welcome'        => 'Bonjour :fullname',
        'footer'         => '<br><br>A bientôt sur <a href=":site_domain">:site_name</a>.',
    ],

    'contact-requests'  => [
        'admin' => [
            'subject' => 'Demande de contact sur :site_name',
            'message' => 'Une demande de contact est arrivée sur <a href=":site_domain">:site_name</a>.<br>
                Voici le détail :
                <ul>
                    <li>Nom : :lastname,</li>
                    <li>Prénom : :firstname,</li>
                    <li>Email : :email,</li>
                    <li>Téléphone : :phone,</li>
                    <li>Mobile : :mobile,</li>
                    <li>Sujet : :subject,</li>
                    <li>Message : :message,</li>
                </ul>
                Veuillez <a href=":admin_link">cliquer ici</a> pour pouvoir consulter cette demande.',
        ],
        'user'  => [
            'subject' => 'Votre demande de contact sur :site_name',
            'message' => 'Nous avons bien reçu votre demande de contact depuis <a href=":site_domain">:site_name</a>.<br>
                Voici le détail de votre demande :
                <ul>
                    <li>Nom : :lastname,</li>
                    <li>Prénom : :firstname,</li>
                    <li>Email : :email,</li>
                    <li>Téléphone : :phone,</li>
                    <li>Mobile : :mobile,</li>
                    <li>Sujet : :subject,</li>
                    <li>Message : :message,</li>
                </ul>
                Nous vous contacterons dans les plus brefs délais.',
        ],
    ],
    'users'             => [
        'created_by_admin'     => [
            'subject' => 'Création de compte sur :site_name.',
            'message' => 'Bienvenue sur le site :site_name <br>
                Nous avons le plaisir de vous confirmer votre inscription sur le site <a href=":site_domain">:site_name</a>. 
                <br><br>
                Voici le détail : <br>
                <ul>
                    <li><b>Identifiant :</b> :email</li>
                    <li><b>Mot de passe : </b> :password</li>
                </ul>',
        ],
        'sign_on'              => [
            'subject' => 'Création de votre compte sur :site_name.',
            'message' => 'Bienvenue sur le site :site_name <br>
                Nous avons le plaisir de vous confirmer votre inscription sur le site <a href=":site_domain">:site_name</a>. 
                <br><br>
                Voici le détail : <br>
                <ul>
                    <li><b>Identifiant :</b> :email</li>
                    <li><b>Mot de passe : </b> :password</li>
                </ul>',
        ],
        'reset_password'       => [
            'subject' => 'Mot de passe oublié.',
            'message' => '
                Vous venez de faire une demande pour réinitialiser votre mot de passe sur <a href=":site_domain">:site_name</a>. <br><br>
                Veuillez <a href=":link">cliquer ici</a> ou bien de faire un copier-coller du lien ci-dessous : :link',
        ],
        'force_reset_password' => [
            'subject' => 'Vos accès à la plateforme.',
            'message' => 'Nous avons le plaisir de vous confirmer votre inscription sur le site <a href=":site_domain">:site_name</a>. 
                <br><br>
                Voici le détail de vos accès : <br>
                <ul>
                    <li><b>Identifiant :</b> :username</li>
                    <li><b>Mot de passe : </b> :password</li>
                </ul>
                <br>
                Vous pourrez changer votre mot de passe une fois connecté à la plateforme, dans la rubrique "Mon profil".',
        ],
    ],
    'tickets'           => [
        'created'        => [
            'subject' => 'Création de votre ticket sur :site_name.',
            'message' => 'Votre ticket vient d\'être envoyé à notre équipe. <br>
                Il sera pris en compte dès que possible.<br><br>
                Vous pouvez suivre l\'avancement sur l\'extranet.<br><br>
                Voici le détail : <br>
                <ul>
                    <li><b>:typeLabel :</b> :typeName</li>
                    <li><b>:statusLabel :</b> :statusName</li>
                    <li><b>Sujet :</b> :subject</li>
                    <li><b>Message : </b> :message</li>
                </ul>',
        ],
        'updatedByAdmin' => [
            'subject' => 'Mise à jour de votre ticket sur :site_name.',
            'message' => 'Votre ticket vient d\'être mis à jour par notre équipe. <br><br>
                Vous pouvez suivre l\'avancement sur l\'extranet.<br><br>
                Rappel du ticket : <br>
                <ul>
                    <li><b>:typeLabel :</b> :typeName</li>
                    <li><b>Sujet :</b> :subject</li>
                    <li><b>Message : </b> :message</li>
                </ul>
                <br>
                Mise à jour : <br>
                <ul>
                    <li><b>:statusLabel :</b> :statusName</li>
                    <li><b>Traité par :</b> :adminFullname</li>
                    <li><b>Message : </b> :adminMessage</li>
                </ul>
                ',
        ],
    ],
    'commissions'       => [
        'unlock' => [
            'subject' => 'Débloquage de commission sur :site_name.',
            'message' => 'Le mandataire :user a demandé le débloquage de ses commissons de parrainage. <br><br>
                Le montant demandé est de :price&nbsp;€.<br><br>
                Merci de faire votre facturation.',
        ],
    ],
    'sale_agreements'   => [
        'created'           => [
            'subject' => 'Un compromis vient d\'être créé sur :site_name',
            'message' => ':user vient de créer un nouveau compromis de vente n°:mandate_number.<br/><br/>
            Vous pouvez voir le détail <a href=":href">ici</a>.',
        ],
        'deed'              => [
            'subject' => 'Un compromis vient d\'être acté sur :site_name',
            'message' => ':user vient d\'acter le compromis de vente n°:mandate_number.<br/><br/>
            Vous pouvez voir le détail <a href=":href">ici</a>.',
        ],
        'cancelled'         => [
            'subject' => 'Un compromis vient d\'être annulé sur :site_name',
            'message' => ':user vient d\'annuler le compromis de vente n°:mandate_number.<br/><br/>
            Vous pouvez voir le détail <a href=":href">ici</a>.',
        ],
        'done'              => [
            'subject' => 'Un compromis vient d\'être finalisé sur :site_name',
            'message' => ':user vient de finaliser le compromis de vente n°:mandate_number.<br/><br/>
            Vous pouvez voir le détail <a href=":href">ici</a>.',
        ],
        'sale_confirmed_at' => [
            'subject' => 'Une date de vente confirmée a été ajoutée sur :site_name',
            'message' => ':user vient d\'ajouter la date de vente confirmée au :date sur le compromis de vente n°:mandate_number.<br/><br/>
            Vous pouvez voir le détail <a href=":href">ici</a>.',
        ],
        'invoice_notary'    => [
            'subject' => 'Une facture notaire a été ajoutée sur :site_name',
            'message' => 'Nous vous informons que la facture pour la vente du mandat n°:mandate_number est disponible à l\'emplacement prévu à cet effet.<br><br>
            Vous pouvez voir le détail <a href=":href">ici</a>. <br><br>
            En vous souhaitant une bonne signature.<br><br>',
        ],
    ],
    'rental_agreements' => [
        'created'   => [
            'subject' => 'Un contrat de location vient d\'être créé sur :site_name',
            'message' => ':user vient de créer un nouveau contrat de location n°:mandate_number.<br/><br/>
            Vous pouvez voir le détail <a href=":href">ici</a>.',
        ],
        'deed'      => [
            'subject' => 'Un contrat de location vient d\'être validé sur :site_name',
            'message' => ':user vient d\'acter le contrat de location n°:mandate_number.<br/><br/>
            Vous pouvez voir le détail <a href=":href">ici</a>.',
        ],
        'cancelled' => [
            'subject' => 'Un contrat de location vient d\'être annulé sur :site_name',
            'message' => ':user vient d\'annuler le contrat de location n°:mandate_number.<br/><br/>
            Vous pouvez voir le détail <a href=":href">ici</a>.',
        ],
        'done'      => [
            'subject' => 'Un contrat de location vient d\'être finalisé sur :site_name',
            'message' => ':user vient de finaliser le contrat de location n°:mandate_number.<br/><br/>
            Vous pouvez voir le détail <a href=":href">ici</a>.',
        ],
        'rental_confirmed_at' => [
            'subject' => 'Une date de location confirmée a été ajoutée sur :site_name',
            'message' => ':user vient d\'ajouter la date de location confirmée au :date sur le contrat de location n°:mandate_number.<br/><br/>
            Vous pouvez voir le détail <a href=":href">ici</a>.',
        ],
    ],
];