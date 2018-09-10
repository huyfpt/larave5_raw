<?php

return [
    'global'               => [
        'prefix_subject' => '[' . env('APP_NAME') . ']',
        'welcome_short'  => 'Bonjour',
        'welcome'        => 'Bonjour :fullname',
        'footer'         => '<br><br>A bientôt sur <a href=":site_domain">:site_name</a>.',
    ],

    'report' => [
        'admin' => [
            'subject' => 'Signalement d\'un commentaire',
            'message' => 'Bonjour administrateur, <br>
                          Un commentaire a été signalé par un utilisateur, vous pouvez retrouver le détail <a href=":link_report">ici</a>.',
        ],

        'user' => [
            'subject' => ':reason',
            'message' => ':details',
        ],
    ],

];