<?php

return [
    'title'    => [
        'login'   => 'Connexion',
        'request' => 'Mot de passe oublié',
        'reset'   => 'Réinitialiser votre mot de passe',
    ],
    'subtitle' => [
        'request' => 'Merci d\'entrer votre login, un e-mail vous sera envoyé afin de réinitialiser votre mot de passe.',
        'reset'   => 'Veuillez saisir votre login et votre nouveau mot de passe.',
    ],
    'fields'   => [
        'username'              => 'Nom de I\'utilisateur',
        'password'              => 'Mot de passe',
        'password_confirmation' => 'Confirmation mot de passe',
    ],
    'buttons'  => [
        'forgot_password'       => 'Mot de passe oublié ?',
        'sign_in'               => 'Se connecter',
        'request'               => 'Réinitialiser mon mot de passe',
        'reset'                 => 'Réinitialiser mon mot de passe',
        'logout'                => 'Se déconnecter',
        'logout_impersonate_to' => 'Quitter le mode connecté en tant que',
    ],

    'users' => [
        'not_active' => 'Votre compte n\'est plus actif.',
        'not_email'  => 'Votre compte n\'est associé à aucune adresse email.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed'   => 'Nous n\'avons pas reconnu votre compte, veuillez vérifier les informations saisies.',
    'throttle' => 'Trop de tentative de connexion. Merci de réésayer dans :seconds secondes.',

];